<?php

namespace Dynamic\Locator;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

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
    private static $description = 'Display locations on a map';

    /**
     * @var array
     */
    private static $db = array(
        'Unit' => 'Enum("m,km","m")',
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'Categories' => LocationCategory::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'Locator';

    /**
     * @var string
     */
    private static $location_class = Location::class;

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
        ));

        // Filter categories
        $config = GridFieldConfig_RelationEditor::create();
        $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
        $config->addComponent(new GridFieldAddExistingSearchButton());
        $categories = $this->Categories();
        $categoriesField = GridField::create('Categories', 'Categories', $categories, $config)
            ->setDescription('only show locations from the selected category');

        // Filter
        $fields->addFieldsToTab('Root.Filter', array(
            HeaderField::create('CategoryOptionsHeader', 'Location Filtering', 3),
            $categoriesField,
        ));

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
    ) {
        $locationClass = Config::inst()->get(Locator::class, 'location_class');
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

    /**
     * The API URL
     *
     * @return string
     */
    public function ApiUrl()
    {
        return Controller::join_links(Director::baseURL(), 'graphql-locator');
    }

    /**
     * the map defaults to be passed to javascript
     *
     * @return string
     */
    public function MapSettings()
    {
        $limit = Config::inst()->get('Locator_Controller', 'limit');
        if (!$limit) {
            $limit = -1;
        }
        $zoom = 12;

        return $this->minify("{
            'zoom': $zoom,
            'unit': '$this->Unit',
            'limit': $limit,
            'mapSettings': {
                'mapType': 'ROADMAP',
                'disableDoubleClickZoom': true,
                'scrollwheel': false,
                'navigationControl': false,
                'draggable': false
            }
        }");
    }

    /**
     * Replaces single with double quotes (so no escaping) and removes new lines and spaces
     *
     * Regex pattern for replacing spaces from: https://stackoverflow.com/a/23860200
     *
     * @param String $string
     * @return String
     */
    public function minify(String $string) {
        return preg_replace("/\s(?=([^\"]*\"[^\"]*\")*[^\"]*$)/", '',
            str_replace("'", '"', $string)
        );
    }
}
