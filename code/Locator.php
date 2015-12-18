<?php

class Locator extends Page
{
    private static $db = array(
        'AutoGeocode' => 'Boolean',
        'ModalWindow' => 'Boolean',
        'Unit' => 'Enum("m,km","m")',
    );

    private static $defaults = array(
        'AutoGeocode' => true,
    );

    private static $singular_name = 'Locator';
    private static $plural_name = 'Locators';
    private static $description = 'Show locations on a map';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Locations Grid Field
        $config = GridFieldConfig_RecordEditor::create();
        $locations = Location::get();
        $fields->addFieldToTab('Root.Locations', GridField::create('Locations', 'Locations', $locations, $config));

        // Location categories
        $config = GridFieldConfig_RecordEditor::create();
        $fields->addFieldToTab('Root.Categories', GridField::create('Categories', 'Categories', LocationCategory::get(), $config));

        // Settings
        $fields->addFieldsToTab('Root.Settings', array(
            HeaderField::create('DisplayOptions', 'Display Options', 3),
            OptionsetField::create('Unit', 'Unit of measure', array('m' => 'Miles', 'km' => 'Kilometers')),
            CheckboxField::create('AutoGeocode', 'Auto Geocode - Automatically filter map results based on user location')
                ->setDescription('Note: if any locations are set as featured, the auto geocode is automatically disabled.'),
            CheckboxField::create('ModalWindow', 'Modal Window - Show Map results in a modal window'),
        ));

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public static function getLocations($filter = array(), $exclude = array())
    {
        $filter['ShowInLocator'] = true;

        return Location::get()
            ->exclude($exclude)
            ->exclude('Lat', 0)
            ->filter($filter);
    }

    public function getAreLocations()
    {
        return self::getLocations();
    }

    public function getAllCategories()
    {
        return LocationCategory::get();
    }
}

class Locator_Controller extends Page_Controller
{
    // allowed actions
    private static $allowed_actions = array('xml');

    // Set Requirements based on input from CMS
    public function init()
    {
        parent::init();

        $themeDir = SSViewer::get_theme_folder();

        Requirements::javascript('framework/thirdparty/jquery/jquery.js');
        if (Locator::getLocations()) {
            Requirements::javascript('http://maps.google.com/maps/api/js?sensor=false');
            Requirements::javascript('locator/thirdparty/handlebars/handlebars-v1.3.0.js');
            Requirements::javascript('locator/thirdparty/jquery-store-locator/js/jquery.storelocator.js');
        }

        Requirements::css('locator/css/map.css');

        $featured = (Locator::getLocations(array('Featured' => 1))->count() > 0) ?
            'featuredLocations: true' :
            'featuredLocations: false';

        // map config based on user input in Settings tab
        // AutoGeocode or Full Map
        $load = ($this->data()->AutoGeocode) ?
            'autoGeocode: true, fullMapStart: false,' :
            'autoGeocode: false, fullMapStart: true, storeLimit: 1000, maxDistance: true,';

        $base = Director::baseFolder();
        $themePath = $base.'/'.$themeDir;

        $listTemplatePath = (file_exists($themePath.'/templates/location-list-description.html')) ?
            $themeDir.'/templates/location-list-description.html' :
            'locator/templates/location-list-description.html';
        $infowindowTemplatePath = (file_exists($themePath.'/templates/infowindow-description.html')) ?
            $themeDir.'/templates/infowindow-description.html' :
            'locator/templates/infowindow-description.html';

        // in page or modal
        $modal = ($this->data()->ModalWindow) ? 'modalWindow: true' : 'modalWindow: false';

        $kilometer = ($this->data()->Unit == 'km') ? 'lengthUnit: "km"' : 'lengthUnit: "m"';

        $link = $this->Link().'xml.xml';

        // init map
        if (Locator::getLocations()) {
            Requirements::customScript("
                $(function($) {
                    $('#map-container').storeLocator({
                        ".$load."
                        dataLocation: '".$link."',
                        listTemplatePath: '".$listTemplatePath."',
                        infowindowTemplatePath: '".$infowindowTemplatePath."',
                        originMarker: true,
                        ".$modal.',
                        '.$featured.",
                        slideMap: false,
                        zoomLevel: 0,
                        distanceAlert: 120,
                        formID: 'Form_LocationSearch',
                        inputID: 'Form_LocationSearch_address',
                        categoryID: 'Form_LocationSearch_category',
                        distanceAlert: -1,
                        ".$kilometer.'
                    });
                });
            ');
        }
    }

    /**
     * Find all locations for map.
     *
     * Will return a XML feed of all locations marked "show in locator".
     *
     * @return XML file
     *
     * @todo rename/refactor to allow for json/xml
     * @todo allow $filter to run off of getVars key/val pair
     */
    public function xml(SS_HTTPRequest $request)
    {
        $filter = array();
        $Locations = Locator::getLocations($filter);

        return $this->customise(array(
            'Locations' => $Locations,
        ))->renderWith('LocationXML');
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
            $address = TextField::create('address', '')
        );
        $address->setAttribute('placeholder', 'address or zip code');

        if (LocationCategory::get()->Count() > 0) {
            $filter = array();
            $locals = Locator::getLocations($filter, $exclude = array('CategoryID' => 0));
            $categories = ArrayList::create();

            foreach ($locals as $local) {
                $categories->add($local->Category());
            }

            if ($categories->count() > 0) {
                $fields->push(
                    DropdownField::create(
                        'category',
                        '',
                        $categories->map('Title', 'Title')
                    )->setEmptyString('Select Category'));
            }
        }

        $actions = FieldList::create(
            FormAction::create('', 'Search')
        );

        return Form::create($this, 'LocationSearch', $fields, $actions);
    }
}
