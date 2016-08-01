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
     * @param null $filterByCallback
     * @param string $locationClass
     * @return ArrayList
     */
    public static function get_locations(
        $filter = [],
        $filterAny = [],
        $exclude = [],
        $filterByCallback = null,
        $locationClass = 'Location'
    )
    {
        $locationsList = ArrayList::create();

        // filter by ShowInLocator
        $filter['ShowInLocator'] = 1;

        $locations = $locationClass::get()->filter($filter);

        if (!empty($filterAny)) {
            $locations = $locations->filterAny($filterAny);
        }
        if (!empty($exclude)) {
            $locations = $locations->exclude($exclude);
        }

        if ($filterByCallback !== null && is_callable($filterByCallback)) {
            $locations = $locations->filterByCallback($filterByCallback);
        }

        if ($locations->exists()) {
            $locationsList->merge($locations);
        }

        return $locationsList;
    }

    /**
     * @return DataList
     */
    public static function getAllCategories()
    {
        return LocationCategory::get();
    }

    /**
     * @param null $id
     * @return bool
     */
    public static function getPageCategories($id = null)
    {
        if ($id) {
            if ($locator = self::get()->byID($id)) {
                return $locator->Categories();
            }

            return false;
        }

        return false;
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
    private static $allowed_actions = [
        'xml',
    ];

    /**
     * @var array
     */
    private static $base_filter = [
        'ShowInLocator' => true,
    ];

    /**
     * @var array
     */
    private static $base_filter_any = [];

    /**
     * @var array
     */
    private static $base_exclude = [
        'Lat' => 0.00000,
        'Lng' => 0.00000,
    ];

    /**
     * @var
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

        Requirements::javascript('framework/thirdparty/jquery/jquery.js');
        if ($locations) {
            Requirements::javascript('http://maps.google.com/maps/api/js?key=' . $key);
            Requirements::javascript('locator/thirdparty/handlebars/handlebars-v1.3.0.js');
            Requirements::javascript('locator/thirdparty/jquery-store-locator/js/jquery.storelocator.js');
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
        $link = $this->Link() . 'xml.xml' . $url;

        // init map
        if ($locations) {
            Requirements::customScript("
                $(function($) {
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
                        formID: 'Form_LocationSearch',
                        inputID: 'Form_LocationSearch_Address',
                        categoryID: 'Form_LocationSearch_category',
                        distanceAlert: -1,
                        " . $kilometer . '
                    });
                });
            ');
        }
    }

    /**
     * @param SS_HTTPRequest $request
     *
     * @return ViewableData_Customised
     */
    public function index(SS_HTTPRequest $request)
    {
        $locations = $this->Items($request);

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
        $this->setLocations($request);
        $locations = $this->getLocations();

        return $this->customise(array(
            'Locations' => $locations,
        ))->renderWith('LocationXML');
    }

    /**
     * @return mixed
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
        if($request === null){
            $request = $this->request;
        }
        $filter = $this->config()->get('base_filter');
        $this->extend('updateLocatorFilter', $filter, $request);

        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateLocatorFilterAny', $filterAny, $request);

        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateLocatorExclude', $exclude, $request);

        $this->locations = Locator::get_locations($filter, $filterAny, $exclude);
        return $this;
    }

    /**
     * @param SS_HTTPRequest $request
     *
     * @return ArrayList
     */
    public function Items(SS_HTTPRequest $request)
    {
        $request = ($request) ? $request : $this->request;

        $filter = $this->config()->get('base_filter');
        $filterAny = [];
        $exclude = $this->config()->get('base_exclude');

        // only show locations marked as ShowInLocator
        $filter['ShowInLocator'] = 1;

        // search across all address related fields
        $address = ($request->getVar('Address')) ? $request->getVar('Address') : false;
        if ($address && $this->data()->AutoGeocode == 0) {
            $filterAny['Address:PartialMatch'] = $address;
            $filterAny['Suburb:PartialMatch'] = $address;
            $filterAny['State:PartialMatch'] = $address;
            $filterAny['Postcode:PartialMatch'] = $address;
            $filterAny['Country:PartialMatch'] = $address;
        } else {
            unset($filter['Address']);
        }

        // search for category from form, else categories from Locator
        $category = ($request->getVar('CategoryID')) ? $request->getVar('CategoryID') : false;
        if ($category) {
            $filter['CategoryID:ExactMatch'] = $category;
        } elseif ($this->Categories()->exists()) {
            $categories = $this->Categories();
            $categoryArray = array();
            foreach ($categories as $category) {
                array_push($categoryArray, $category->ID);
            }
            $filter['CategoryID'] = $categoryArray;
        }

        $locations = Locator::get_locations($filter, $filterAny, $exclude);

        return $locations;
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
