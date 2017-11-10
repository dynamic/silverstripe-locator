<?php

namespace Dynamic\Locator;

use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use muskie9\DataToArrayList\ORM\DataToArrayListHelper;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;

/**
 * Class LocatorController
 */
class LocatorController extends \PageController
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'xml',
        'json',
    );

    /**
     * @var array
     */
    private static $base_filter = [];

    /**
     * @var array
     */
    private static $base_exclude = [
        'Lat' => 0,
        'Lng' => 0,
    ];

    /**
     * @var array
     */
    private static $base_filter_any = [];

    /**
     * @var bool
     */
    private static $bootstrapify = true;

    /**
     * ID of map container
     *
     * @var string
     */
    private static $map_container = 'map';

    /**
     * class of location list container
     *
     * @var string
     */
    private static $list_container = 'loc-list';

    /**
     * GET variable which, if isset, will trigger storeLocator init and return XML
     *
     * @var string
     */
    private static $query_trigger = 'action_doFilterLocations';

    /**
     * @var DataList|ArrayList
     */
    protected $locations;

    /**
     * Set Requirements based on input from CMS
     */
    public function init()
    {
        parent::init();

        // prevent init of map if no query
        $request = Controller::curr()->getRequest();

        if ($this->getTrigger($request)) {
            // google maps api key
            $key = Config::inst()->get(GoogleGeocoder::class, 'geocoder_api_key');

            $locations = $this->getLocations();

            if ($locations) {
                Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);

                $featuredInList = ($locations->filter('Featured', true)->count() > 0);
                $defaultCoords = $this->getAddressSearchCoords() ? $this->getAddressSearchCoords() : '';

                $featured = $featuredInList
                    ? 'featuredLocations: true'
                    : 'featuredLocations: false';

                // map config based on user input in Settings tab
                $limit = Config::inst()->get(LocatorController::class, 'limit');
                if ($limit < 1) {
                    $limit = -1;
                }
                $load = 'fullMapStart: true, storeLimit: ' . $limit . ', maxDistance: true,';

                $listTemplatePath = $this->getListTemplate();
                $infowindowTemplatePath = $this->getInfoWindowTemplate();

                $kilometer = ($this->data()->Unit == 'km') ? "lengthUnit: 'km'" : "lengthUnit: 'm'";

                // pass GET variables to xml action
                $vars = $this->request->getVars();
                unset($vars['url']);
                $url = '';
                if (count($vars)) {
                    $url .= '?' . http_build_query($vars);
                }
                $link = Controller::join_links($this->Link(), 'xml.xml', $url);

                // containers
                $map_id = Config::inst()->get(LocatorController::class, 'map_container');
                $list_class = Config::inst()->get(LocatorController::class, 'list_container');

                // init map
                Requirements::customScript("
                $(function(){
                    $('#map-container').storeLocator({
                        " . $load . "
                        dataLocation: '" . $link . "',
                        listTemplatePath: '" . $listTemplatePath . "',
                        infowindowTemplatePath: '" . $infowindowTemplatePath . "',
                        originMarker: true,
                        " . $featured . ",
                        slideMap: false,
                        distanceAlert: -1,
                        " . $kilometer . ",
                        " . $defaultCoords . "
                        mapID: '" . $map_id . "',
                        locationList: '" . $list_class . "',
                        mapSettings: {
							zoom: 12,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							disableDoubleClickZoom: true,
							scrollwheel: false,
							navigationControl: false,
							draggable: false
						}
                    });
                });
            ", 'jquery-locator');
            }
        }
    }

    /**
     * @param HTTPRequest $request
     *
     * @return \SilverStripe\View\ViewableData_Customised
     */
    public function index(HTTPRequest $request)
    {
        if ($this->getTrigger($request)) {
            $locations = $this->getLocations();
        } else {
            $locations = ArrayList::create();
        }

        return $this->customise(array(
            'Locations' => $locations,
        ));
    }

    /**
     * Renders locations in xml format
     *
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function xml()
    {
        $this->getResponse()->addHeader("Content-Type", "application/xml");
        $data = new ArrayData(array(
            "Locations" => $this->getLocations(),
        ));

        return $data->renderWith('Dynamic/Locator/Data/XML');
    }

    /**
     * Renders locations in json format
     *
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function json()
    {
        $this->getResponse()->addHeader("Content-Type", "application/json");
        $data = new ArrayData(array(
            "Locations" => $this->getLocations(),
        ));

        return $data->renderWith('Dynamic/Locator/Data/JSON');
    }

    /**
     * @return ArrayList|DataList
     */
    public function getLocations()
    {
        if (!$this->locations) {
            $this->setLocations($this->request);
        }

        return $this->locations;
    }

    /**
     * @param HTTPRequest|null $request
     *
     * @return $this
     */
    public function setLocations(HTTPRequest $request = null)
    {

        if ($request === null) {
            $request = $this->request;
        }
        $filter = $this->config()->get('base_filter');

        if ($request->getVar('CategoryID')) {
            $filter['CategoryID'] = $request->getVar('CategoryID');
        } else {
            if ($this->getPageCategories()->exists()) {
                foreach ($this->getPageCategories() as $category) {
                    $filter['CategoryID'][] = $category->ID;
                }
            }
        }

        $this->extend('updateLocatorFilter', $filter, $request);

        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateLocatorFilterAny', $filterAny, $request);

        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateLocatorExclude', $exclude, $request);

        $locations = Locator::get_locations($filter, $filterAny, $exclude);
        $locations = DataToArrayListHelper::to_array_list($locations);

        //allow for adjusting list post possible distance calculation
        $this->extend('updateLocationList', $locations);

        if ($locations->canSortBy('Distance')) {
            $locations = $locations->sort('Distance');
        }

        if (Config::inst()->get(LocatorForm::class, 'show_radius')) {
            if ($radius = (int)$request->getVar('Radius')) {
                $locations = $locations->filterByCallback(function ($location) use (&$radius) {
                    return $location->distance <= $radius;
                });
            }
        }

        //allow for returning list to be set as
        $this->extend('updateListType', $locations);

        $limit = Config::inst()->get(LocatorController::class, 'limit');
        if ($limit > 0) {
            $locations = $locations->limit($limit);
        }

        $this->locations = $locations;

        return $this;

    }

    /**
     * @param HTTPRequest $request
     *
     * @return bool
     */
    public function getTrigger(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->getRequest();
        }
        $trigger = $request->getVar(Config::inst()->get(LocatorController::class, 'query_trigger'));

        return isset($trigger);
    }

    /**
     * @return bool|string
     */
    public function getAddressSearchCoords()
    {
        if (!$this->request->getVar('Address')) {
            return false;
        }
        if (class_exists(GoogleGeocoder::class)) {
            $geocoder = new GoogleGeocoder($this->request->getVar('Address'));
            $response = $geocoder->getResult();
            $lat = $response->getLatitude();
            $lng = $response->getLongitude();

            return "defaultLat: {$lat}, defaultLng: {$lng},";
        }

    }

    /**
     * LocationSearch form.
     *
     * Search form for locations, updates map and results list via AJAX
     *
     * @return \SilverStripe\Forms\Form
     */
    public function LocationSearch()
    {

        $form = LocatorForm::create($this, 'LocationSearch');
        if (class_exists(BootstrapForm::class) && $this->config()->get('bootstrapify')) {
            $form->Fields()->bootstrapify();
            $form->Actions()->bootstrapify();
        }

        return $form
            ->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());
    }
}
