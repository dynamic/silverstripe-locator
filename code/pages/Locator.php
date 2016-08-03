<?php

/**
 * Class Locator
 *
 * @property bool $AutoGeocode
 * @property bool $ModalWindow
 * @property string $Unit
 * @method Categories|ManyManyList $Categories
 */
class Locator extends Page
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
        'Categories' => 'LocationCategory',
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
        $locations = Location::get()->filter($filter)->exclude($exclude);

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
class Locator_Controller extends Page_Controller
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
     * @var DataList|ArrayList
     */
    private $locations;

    /**
     * Set Requirements based on input from CMS
     */
    public function init()
    {
        parent::init();
        $themeDir = SSViewer::get_theme_folder();
        // google maps api key
        $key = Config::inst()->get('GoogleGeocoding', 'google_api_key');
        $locations = $this->getLocations();

        if ($locations) {
            Requirements::javascript('framework/thirdparty/jquery/jquery.js');
            Requirements::javascript('locator/thirdparty/jQuery-Store-Locator-Plugin-2.6.2/libs/handlebars/handlebars-v4.0.5.js');
            Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=' . $key);
            Requirements::javascript('locator/thirdparty/jQuery-Store-Locator-Plugin-2.6.2/src/js/jquery.storelocator.js');
        }
        Requirements::css('locator/css/map.css');

        $featuredInList = ($locations->filter('Featured', true)->count() > 0);
        $featured = $featuredInList
            ? 'featuredLocations: true'
            : 'featuredLocations: false';
        // map config based on user input in Settings tab
        // AutoGeocode or Full Map
        if ($this->data()->AutoGeocode) {
            $load = $featuredInList
                ? 'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,'
                : 'autoGeocode: true, fullMapStart: false,';
        } else {
            $load = 'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,';
        }
        /*$load = ($this->data()->AutoGeocode) ?
            'autoGeocode: true, fullMapStart: false,' :
            'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,';*/
        $base = Director::baseFolder();
        $themePath = $base . '/' . $themeDir;
        $listTemplatePath = (file_exists($themePath . '/templates/location-list-description.html')) ?
            $themeDir . '/templates/location-list-description.html' :
            'locator/templates/location-list-description.html';
        $infowindowTemplatePath = (file_exists($themePath . '/templates/infowindow-description.html')) ?
            $themeDir . '/templates/infowindow-description.html' :
            'locator/templates/infowindow-description.html';
        // in page or modal
        $modal = ($this->data()->ModalWindow) ? 'modalWindow: true' : 'modalWindow: false';
        $kilometer = ($this->data()->Unit == 'km') ? 'lengthUnit: "km"' : 'lengthUnit: "m"';
        // pass GET variables to xml action
        $vars = $this->request->getVars();
        unset($vars['url']);
        unset($vars['action_index']);
        $url = '';
        if (count($vars)) {
            $url .= '?' . http_build_query($vars);
        }
        $link = $this->AbsoluteLink() . 'xml.xml' . $url;

        // init map
        if ($locations) {
            Requirements::customScript("
                $(function() {
					$('#bh-sl-map-container').storeLocator({
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
                        inputID: 'Form_LocationSearch_Address',
                        categoryID: 'Form_LocationSearch_category',
                        distanceAlert: -1,
                        " . $kilometer . "
                    });
                });
            ");
        }
    }

    /**
     * @param SS_HTTPRequest $request
     *
     * @return ViewableData_Customised
     */
    public function index(SS_HTTPRequest $request)
    {
        $locations = $this->getLocations();

        if ($locations->canSortBy('distance')) {
            $locations = $locations->sort('distance');
        }

        return $this->customise(array(
            'Locations' => $locations,
        ));
    }

    /**
     * Return a XML feed of all locations marked "show in locator"
     *
     * @param SS_HTTPRequest $request
     * @return HTMLText
     */
    public function xml(SS_HTTPRequest $request)
    {
        $locations = $this->getLocations();

        if ($locations->canSortBy('distance')) {
            $locations = $locations->sort('distance');
        }

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
     * @param SS_HTTPRequest|null $request
     * @return $this
     */
    public function setLocations(SS_HTTPRequest $request = null)
    {

        if ($request === null) {
            $request = $this->request;
        }
        $filter = $this->config()->get('base_filter');

        if ($request->getVar('CategoryID')) {
            $filter['CategoryID'] = $request->getVar('CategoryID');
        }

        $this->extend('updateLocatorFilter', $filter, $request);

        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateLocatorFilterAny', $filterAny, $request);

        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateLocatorExclude', $exclude, $request);

        $callback = null;
        $this->extend('updateLocatorCallback', $callback, $request);

        $locations = Locator::get_locations($filter, $filterAny, $exclude, $callback);
        $locations = DataToArrayListHelper::to_array_list($locations);

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
        $coords = GoogleGeocoding::address_to_point(Controller::curr()->getRequest()->getVar('Address'));

        $lat = $coords['lat'];
        $lng = $coords['lng'];

        return "defaultLat: {$lat}, defaultLng: {$lng},";
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
        if (class_exists('BootstrapForm')) {
            $form = LocatorBootstrapForm::create($this, 'LocationSearch');
        } else {
            $form = LocatorForm::create($this, 'LocationSearch');
        }

        return $form
            ->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());
    }

}
