<?php

namespace Dynamic\Locator\Page;

use Dynamic\Locator\Form\LocatorForm;
use Dynamic\SilverStripeGeocoder\DistanceDataExtension;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use muskie9\DataToArrayList\ORM\DataToArrayListHelper;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Class LocatorController
 *
 * @mixin Locator
 */
class LocatorController extends \PageController
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'xml',
        'json',
    ];

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
        if (!$this->getTrigger($request) && !$this->ShowResultsDefault) {
            return;
        }

        $locations = $this->getLocations();

        // prevent init of map if there are no locations
        if (!$locations) {
            return;
        }

        // google maps api key
        $key = Config::inst()->get(GoogleGeocoder::class, 'map_api_key');
        Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);

        $mapSettings = [
            'fullMapStart' => true,
            'maxDistance' => true,
            'storeLimit' => -1,
            'originMarker' => true,
            'slideMap' => false,
            'distanceAlert' => -1,
            'featuredLocations' => false,
            'defaultLat' => 0,
            'defaultLng' => 0,
            'mapSettings' => [
                'zoom' => 12,
                'mapTypeId' => 'google.maps.MapTypeId.ROADMAP',
                'disableDoubleClickZoom' => true,
                'scrollwheel' => false,
                'navigationControl' => false,
                'draggable' => false,
            ],
        ];

        $mapSettings['listTemplatePath'] = $this->getListTemplate();
        $mapSettings['infowindowTemplatePath'] = $this->getInfoWindowTemplate();
        $mapSettings['lengthUnit'] = $this->data()->Unit == 'km' ? 'km' : 'm';
        $mapSettings['mapID'] = Config::inst()->get(LocatorController::class, 'map_container');
        $mapSettings['locationList'] = Config::inst()->get(LocatorController::class, 'list_container');

        if ($locations->filter('Featured', true)->count() > 0) {
            $mapSettings['featuredLocations'] = true;
        }

        // map config based on user input in Settings tab
        $limit = Config::inst()->get(LocatorController::class, 'limit');
        if (0 < $limit) {
            $mapSettings['storeLimit'] = $limit;
        }

        if ($coords = $this->getAddressSearchCoords()) {
            $mapSettings['defaultLat'] = $coords->getField("Lat");
            $mapSettings['defaultLat'] = $coords->getField("Lng");
        }

        // pass GET variables to xml action
        $vars = $this->request->getVars();
        unset($vars['url']);
        $url = '';
        if (count($vars)) {
            $url .= '?' . http_build_query($vars);
        }
        $mapSettings['dataLocation'] = Controller::join_links($this->Link(), 'xml.xml', $url);

        if ($stylePath = $this->getMapStyleJSONPath()) {
            if ($style = file_get_contents($stylePath)) {
                $mapSettings['mapSettings']['styles'] = json_decode($style);
            }
        }

        if ($imagePath = $this->getMarkerIcon()) {
            $mapSettings['markerImg'] = $imagePath;
        }

        $this->extend('modifyMapSettings', $mapSettings);

        $encoded = json_encode($mapSettings, JSON_UNESCAPED_SLASHES);
        // mapTypeId is a javascript object
        $encoded = preg_replace('/("mapTypeId"\s*:\s*)"(.+?)"/i', '$1$2', $encoded);

        $this->extend('modifyMapSettingsEncoded', $encoded);
        // init map
        Requirements::customScript("
                $(function(){
                    $('#map-container').storeLocator({$encoded});
                });
            ", 'jquery-locator');
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

        $categoryVar = $this->data()->config()->get('category_var');
        if ($request->getVar($categoryVar)) {
            $filter['Categories.ID'] = $request->getVar($categoryVar);
        } else {
            if ($this->getPageCategories()->exists()) {
                foreach ($this->getPageCategories() as $category) {
                    $filter['Categories.ID'][] = $category->ID;
                }
            }
        }

        $this->extend('updateLocatorFilter', $filter, $request);

        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateLocatorFilterAny', $filterAny, $request);

        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateLocatorExclude', $exclude, $request);

        $class = $this->data()->ClassName;
        $locations = $class::get_locations($filter, $filterAny, $exclude);
        $locations = DataToArrayListHelper::to_array_list($locations);

        //allow for adjusting list post possible distance calculation
        $this->extend('updateLocationList', $locations);

        if ($locations->canSortBy('Distance')) {
            $locations = $locations->sort('Distance');
        }

        if ($this->getShowRadius()) {
            $radiusVar = $this->data()->config()->get('radius_var');

            if ($radius = (int)$request->getVar($radiusVar)) {
                $locations = $locations->filterByCallback(function ($location) use (&$radius) {
                    return $location->Distance <= $radius;
                });
            }
        }

        //allow for returning list to be set as
        $this->extend('updateListType', $locations);

        $limit = $this->getLimit();
        if ($limit > 0) {
            $locations = $locations->limit($limit);
        }

        $this->locations = $locations;

        return $this;
    }

    /**
     * @return ArrayData|boolean
     */
    public function getAddressSearchCoords()
    {
        $addressVar = Config::inst()->get(DistanceDataExtension::class, 'address_var');
        if (!$this->request->getVar($addressVar)) {
            return false;
        }
        if (class_exists(GoogleGeocoder::class)) {
            $geocoder = new GoogleGeocoder($this->request->getVar($addressVar));
            $response = $geocoder->getResult();
            $lat = $this->owner->Lat = $response->getCoordinates()->getLatitude();
            $lng = $this->owner->Lng = $response->getCoordinates()->getLongitude();

            return new ArrayData([
                "Lat" => $lat,
                "Lng" => $lng,
            ]);
        }
    }

    /**
     * @param HTTPRequest $request
     *
     * @return \SilverStripe\View\ViewableData_Customised
     */
    public function index(HTTPRequest $request)
    {
        if ($this->getTrigger($request) || $this->ShowResultsDefault) {
            $locations = $this->getLocations();
        } else {
            $locations = ArrayList::create();
        }

        return $this->customise([
            'Locations' => $locations,
        ]);
    }

    /**
     * Renders locations in xml format
     *
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function xml()
    {
        $this->getResponse()->addHeader("Content-Type", "application/xml");
        $data = new ArrayData([
            "Locations" => $this->getLocations(),
            "AddressCoords" => $this->getAddressSearchCoords(),
        ]);

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
        $data = new ArrayData([
            "Locations" => $this->getLocations(),
            "AddressCoords" => $this->getAddressSearchCoords(),
        ]);

        return $data->renderWith('Dynamic/Locator/Data/JSON');
    }

    /**
     * LocationSearch form.
     *
     * Search form for locations, updates map and results list via AJAX
     *
     * @return LocatorForm|null
     */
    public function LocationSearch(): ?LocatorForm
    {
        if (!$this->ShowFormDefault) {
            return null;
        }

        $form = LocatorForm::create($this, 'LocationSearch');

        $this->extend('updateLocationSearch', $form);

        return $form
            ->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());
    }
}
