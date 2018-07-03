<?php

namespace Dynamic\Locator;

use Dynamic\Locator\Control\APIController;
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
 */
class LocatorController extends \PageController
{

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
     * Set Requirements based on input from CMS
     */
    public function init()
    {
        parent::init();
        // google maps api key
        $key = Config::inst()->get(GoogleGeocoder::class, 'geocoder_api_key');
        Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);

        // prevent init of map if no query
        $request = Controller::curr()->getRequest();

        if ($this->getTrigger($request)) {
            $locations = $this->getLocations();

            if ($locations) {

                $featuredInList = ($locations->filter('Featured', true)->count() > 0);
                $defaultCoords = $this->getAddressSearchCoords() ?
                    $this->getAddressSearchCoords() :
                    new ArrayData([
                        "Lat" => 0,
                        "Lng" => 0,
                    ]);

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
                $link = Controller::join_links(APIController::create()->Link(), 'xml.xml', $url);
                
                // containers
                $map_id = Config::inst()->get(LocatorController::class, 'map_container');
                $list_class = Config::inst()->get(LocatorController::class, 'list_container');

                $mapStyle = '';
                if ($stylePath = $this->getMapStyleJSONPath()) {
                    if ($style = file_get_contents($stylePath)) {
                        $mapStyle = "styles: {$style}";
                    }
                };

                $markerImage = '';
                if ($imagePath = $this->getMarkerIcon()) {
                    $markerImage = "markerImg: '{$imagePath},'";
                }

                // init map
                Requirements::customScript("
                $(function(){
                    $('#map-container').storeLocator({
                        {$load}
                        dataLocation: '{$link}',
                        listTemplatePath: '{$listTemplatePath}',
                        infowindowTemplatePath: '{$infowindowTemplatePath}',
                        {$markerImage},
                        originMarker: true,
                        {$featured},
                        slideMap: false,
                        distanceAlert: -1,
                        {$kilometer},
                        defaultLat: {$defaultCoords->getField("Lat")},
                        defaultLng: {$defaultCoords->getField("Lng")},
                        mapID: '{$map_id}',
                        locationList: '{$list_class}',
                        mapSettings: {
							zoom: 12,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							disableDoubleClickZoom: true,
							scrollwheel: false,
							navigationControl: false,
							draggable: false,
							{$mapStyle}
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
