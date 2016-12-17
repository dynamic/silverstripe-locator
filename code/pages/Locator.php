<?php

namespace Dynamic\Locator;

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Controller;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;
use muskie9\DataToArrayList\ORM\DataToArrayListHelper;
use SilverStripe\Dev\Debug;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;

/**
 * Class Locator
 *
 * @property bool $AutoGeocode
 * @property bool $ModalWindow
 * @property string $Unit
 * @method Categories|ManyManyList $Categories
 */
class Locator extends \Page
{

    /**
     * @var array
     */
    private static $db = array(
        'AutoGeocode' => 'Boolean',
        'ModalWindow' => 'Boolean',
        'Unit' => 'Enum("m,km","m")',
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'Categories' => 'Dynamic\\Locator\\LocationCategory',
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'AutoGeocode' => true,
    );

    /**
     * @var string
     */
    private static $singular_name = 'Locator';
    /**
     * @var string
     */
    private static $plural_name = 'Locators';
    /**
     * @var string
     */
    private static $description = 'Find locations on a map';

    /**
     * @var string
     */
    private static $location_class = 'Dynamic\\Locator\\Location';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Settings
        $fields->addFieldsToTab('Root.Settings', array(
            HeaderField::create('DisplayOptions', 'Display Options', 3),
            OptionsetField::create('Unit', 'Unit of measure', array('m' => 'Miles', 'km' => 'Kilometers')),
            CheckboxField::create('AutoGeocode', 'Auto Geocode - Automatically filter map results based on user location')
                ->setDescription('Note: if any locations are set as featured, the auto geocode is automatically disabled.'),
            CheckboxField::create('ModalWindow', 'Modal Window - Show Map results in a modal window'),
        ));

        // Filter categories
        $config = GridFieldConfig_RelationEditor::create();
        if (class_exists('GridFieldAddExistingSearchButton')) {
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->addComponent(new GridFieldAddExistingSearchButton());
        }
        $categories = $this->Categories();
        $categoriesField = GridField::create('Categories', 'Categories', $categories, $config)
            ->setDescription('only show locations from the selected category');

        // Filter
        $fields->addFieldsToTab('Root.Filter', array(
            HeaderField::create('CategoryOptionsHeader', 'Location Filtering', 3),
            $categoriesField,
        ));

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * @param array $filter
     * @param array $filterAny
     * @param array $exclude
     * @param null|callable $callback
     * @return DataList|ArrayList
     */
    public static function get_locations(
        $filter = [],
        $filterAny = [],
        $exclude = [],
        $callback = null
    )
    {
        $locationClass = Config::inst()->get('Dynamic\\Locator\\Locator', 'location_class');
        $locations = $locationClass::get()->filter($filter)->exclude($exclude);

        if (!empty($filterAny)) {
            $locations = $locations->filterAny($filterAny);
        }
        if (!empty($exclude)) {
            $locations = $locations->exclude($exclude);
        }

        if ($callback !== null && is_callable($callback)) {
            $locations->filterByCallback($callback);
        }

        return $locations;
    }

    /**
     * @return DataList
     */
    public static function get_all_categories()
    {
        return LocationCategory::get();
    }

    /**
     * @return bool
     */
    public function getPageCategories()
    {
        return self::locator_categories_by_locator($this->ID);
    }

    /**
     * @param int $id
     * @return bool|
     */
    public static function locator_categories_by_locator($id = 0)
    {
        if ($id == 0) {
            return false;
        }

        return Locator::get()->byID($id)->Categories();
    }


}

/**
 * Class Locator_Controller
 */
class Locator_Controller extends \Page_Controller
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'xml',
    );

    /**
     * @var array
     */
    private static $base_filter = [
        'ShowInLocator' => true,
    ];

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
     * @var string
     */
    private static $list_template_path = 'locator/templates/location-list-description.html';

    /**
     * @var string
     */
    private static $info_window_template_path = 'locator/templates/infowindow-description.html';

    /**
     * @var bool
     */
    private static $bootstrapify = true;

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

        // google maps api key
        $key = Config::inst()->get('SilverStripeGeocoder', 'geocoder_api_key');

        $locations = $this->getLocations();

        if ($locations) {

            Requirements::css('locator/css/map.css');
            Requirements::javascript('https://code.jquery.com/jquery-2.2.4.min.js');
            Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);
            Requirements::javascript('locator/thirdparty/handlebars/handlebars-v1.3.0.js');
            Requirements::javascript('locator/thirdparty/jquery-store-locator/js/jquery.storelocator.js');

            $featuredInList = ($locations->filter('Featured', true)->count() > 0);
            $defaultCoords = $this->getAddressSearchCoords() ? $this->getAddressSearchCoords() : '';

            $featured = $featuredInList
                ? 'featuredLocations: true'
                : 'featuredLocations: false';

            /*
            // map config based on user input in Settings tab
            // AutoGeocode or Full Map
            if ($this->data()->AutoGeocode) {
                $isChrome = (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE);
                $load = $featuredInList || $defaultCoords != '' || $isChrome
                    ? 'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,'
                    : 'autoGeocode: true, fullMapStart: false,';
            } else {
                $load = 'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,';
            }
            */

            // temporary workaround for autogeocode
            $load = 'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,';

            $listTemplatePath = Config::inst()->get('Dynamic\Locator\Locator_Controller', 'list_template_path');
            $infowindowTemplatePath = Config::inst()->get('Dynamic\Locator\Locator_Controller', 'info_window_template_path');

            // in page or modal
            $modal = ($this->data()->ModalWindow) ? 'modalWindow: true' : 'modalWindow: false';

            $kilometer = ($this->data()->Unit == 'km') ? 'lengthUnit: "km"' : 'lengthUnit: "m"';

            // pass GET variables to xml action
            $vars = $this->request->getVars();
            unset($vars['url']);
            unset($vars['action_doFilterLocations']);
            $url = '';
            if (count($vars)) {
                $url .= '?' . http_build_query($vars);
            }
            $link = $this->Link() . 'xml.xml' . $url;

            // init map
            Requirements::customScript("
            jQuery(document).ready(function($){
                $('#map-container').storeLocator({
                    " . $load . "
                    dataLocation: '" . $link . "',
                    listTemplatePath: '" . $listTemplatePath . "',
                    infowindowTemplatePath: '" . $infowindowTemplatePath . "',
                    originMarker: true,
                    " . $modal . ',
                    ' . $featured . ",
                    slideMap: false,
                    zoomLevel: 0,
                    noForm: true,
                    distanceAlert: -1,
                    " . $kilometer . ',
                    defaultLoc: true,
                    ' . $defaultCoords . '
                });
            });');
        }
    }

    /**
     * @param HTTPRequest $request
     * @return \SilverStripe\View\ViewableData_Customised
     */
    public function index(HTTPRequest $request)
    {
        $locations = $this->getLocations();

        return $this->customise(array(
            'Locations' => $locations,
        ));
    }

    /**
     * @param HTTPRequest $request
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function xml(HTTPRequest $request)
    {
        $locations = $this->getLocations();

        return $this->customise(array(
            'Locations' => $locations,
        ))->renderWith('LocationXML');
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

        if ($locations->canSortBy('distance')) {
            $locations = $locations->sort('distance');
        }

        //allow for returning list to be set as
        $this->extend('updateListType', $locations);

        $this->locations = $locations;
        return $this;

    }

    /**
     * @return bool|string
     */
    public function getAddressSearchCoords()
    {
        if (!$this->request->getVar('Address')) {
            return false;
        }

        if ($address = $this->request->getVar('Address')) {
            $geocoder = new GoogleGeocoder($address);
            $response = $geocoder->getResult();
            $lat = $response->getLatitude();
            $lng = $response->getLongitude();
            $coords = "defaultLat: {$lat}, defaultLng: {$lng},";
            return $coords;
        }
        return false;
    }

    /**
     * LocationSearch form.
     *
     * Search form for locations, updates map and results list via AJAX
     *
     * @return Form
     */
    public function LocationSearch()
    {

        $form = LocatorForm::create($this, 'LocationSearch');
        if (class_exists('BootstrapForm') && $this->config()->get('bootstrapify')) {
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
