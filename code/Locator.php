<?php

class Locator extends Page
{
    private static $db = array(
        'AutoGeocode' => 'Boolean',
        'ModalWindow' => 'Boolean',
        'Unit' => 'Enum("m,km","m")',
    );

    private static $many_many = array(
        'Categories' => 'LocationCategory',
    );

    private static $defaults = array(
        'AutoGeocode' => true,
    );

    private static $singular_name = 'Locator';
    private static $plural_name = 'Locators';
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
     * @return ArrayList
     */
    public static function locations(
        $filter = array(),
        $filterAny = array(),
        $exclude = array(),
        $filterByCallback = null
    )
    {
        $locationsList = ArrayList::create();

        // filter by ShowInLocator
        $filter['ShowInLocator'] = 1;

        $locations = Location::get()->filter($filter);

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

class Locator_Controller extends Page_Controller
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'xml',
    );

    /**
     * Set Requirements based on input from CMS
     */
    public function init()
    {
        parent::init();

        $themeDir = SSViewer::get_theme_folder();

        // google maps api key
        $key = Config::inst()->get('GoogleGeocoding', 'google_api_key');

        $locations = $this->Items($this->request);

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
        $locations = $this->Items($request);

        return $this->customise(array(
            'Locations' => $locations,
        ))->renderWith('LocationXML');
    }

    /**
     * @param SS_HTTPRequest $request
     *
     * @return ArrayList
     */
    public function Items(SS_HTTPRequest $request)
    {
        $request = ($request) ? $request : $this->request;

        $filter = array();
        $filterAny = array();
        $exclude = ['Lat' => 0.00000, 'Lng' => 0.00000];

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

        $locations = Locator::locations($filter, $filterAny, $exclude);

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
        $fields = FieldList::create(
            $address = TextField::create('Address', '')
                ->setAttribute('placeholder', 'address or zip code')
        );

        $filterCategories = Locator::getPageCategories($this->ID);
        $allCategories = Locator::getAllCategories();

        if ($allCategories->Count() > 0) {
            $categories = ArrayList::create();
            if ($filterCategories->Count() > 0) {
                if ($filterCategories->Count() != 1) {
                    $categories = $filterCategories;
                }
            } else {
                $categories = $allCategories;
            }

            if ($categories->count() > 0) {
                $fields->push(
                    DropdownField::create(
                        'CategoryID',
                        '',
                        $categories->map()
                    )->setEmptyString('All Categories'));
            }
        }

        $actions = FieldList::create(
            FormAction::create('index', 'Search')
        );

        if (class_exists('BootstrapForm')) {
            $form = BootstrapForm::create($this, 'LocationSearch', $fields, $actions);
        } else {
            $form = Form::create($this, 'LocationSearch', $fields, $actions);
        }

        return $form
            ->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());
    }
}
