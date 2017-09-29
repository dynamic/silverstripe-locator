<?php

namespace Dynamic\Locator;

use \Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

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
     * @var bool
     */
    private static $show_radius = true;

    private static $limit = -1;

    private static $locationClass = Location::class;

    /**
     * @var array
     */
    private static $db = array(
        'Unit' => 'Enum("m,km","m")',
        'Clusters' => 'Enum("false,true","false")',
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
        // so it can easily be extended - concept taken from the blog module
        $this->beforeUpdateCMSFields(function ($fields) {
            // Settings
            $fields->addFieldsToTab('Root.Settings', array(
                HeaderField::create('DisplayOptions', 'Display Options', 3),
                OptionsetField::create('Unit', 'Unit of measure', array(
                    'm' => 'Miles',
                    'km' => 'Kilometers'
                ), 'm'),
                OptionsetField::create('Clusters', 'Use clusters?', array(
                    'false' => 'No',
                    'true' => 'Yes'
                ), 'false'),
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
        });
        return parent::getCMSFields();
    }

    /**
     * Gets the list of radius
     *
     * @return ArrayList
     */
    public function getRadii()
    {
        $radii = [
            '0' => '25',
            '1' => '50',
            '2' => '75',
            '3' => '100',
        ];

        $config_radii = Config::inst()->get(Locator::class, 'radius_array');
        if ($config_radii) {
            $radii = $config_radii;
        }

        $list = [];
        foreach ($radii as $radius) {
            $list[] = new ArrayData(array(
                'Radius' => $radius,
            ));
        }

        return new ArrayList($list);
    }

    /**
     * Gets the limit of locations
     * @return mixed
     */
    public function getLimit()
    {
        return Config::inst()->get(Locator::class, 'limit');
    }

    /**
     * Gets if the radius drop down should be shown
     * @return mixed
     */
    public function getShowRadius()
    {
        return Config::inst()->get(Locator::class, 'show_radius');
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->Categories()->filter(array(
                'Locations.ID:GreaterThan' => 0
            ));
    }

    /**
     * Gets the info window template
     * @return mixed
     */
    public function getInfoWindowTemplate()
    {
        $contents = json_encode(file_get_contents(__DIR__ . '/../../../' . Config::inst()->get(
            Locator::class,
            'infoWindowTemplate'
        )));

        return str_replace('\n', '', $contents);
    }

    /**
     * Gets the template for locations in the list
     * @return string
     */
    public function getListTemplate()
    {
        $contents = json_encode(file_get_contents(__DIR__ . '/../../../' . Config::inst()->get(
            Locator::class,
            'listTemplate'
        )));

        return str_replace('\n', '', $contents);
    }

    /**
     * @param array $filter
     * @param array $filterAny
     * @param array $exclude
     * @param null|callable $callback
     *
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
}
