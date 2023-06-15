<?php

namespace Dynamic\Locator\Page;

use Dynamic\Locator\Model\LocationCategory;
use Dynamic\SilverStripeGeocoder\AddressDataExtension;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Lumberjack\Model\Lumberjack;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\View\ArrayData;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class Locator
 *
 * @property bool $AutoGeocode
 * @property bool $ModalWindow
 * @property string $Unit
 * @property bool $ShowResultsDefault
 * @property bool $ShowFormDefault
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
    private static $db = [
        'Unit' => 'Enum("m,km","m")',
        'ShowResultsDefault' => 'Boolean',
        'ShowFormDefault' => 'Boolean',
    ];

    /**
     * @var array
     */
    private static $many_many = [
        'Categories' => LocationCategory::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'Locator';

    /**
     * @var string
     */
    private static $location_class = LocationPage::class;

    /**
     * @var string[]
     */
    private static $extensions = [
        Lumberjack::class,
    ];

    /**
     * @var string[]
     */
    private static $allowed_children = [
        LocationPage::class,
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'ShowResultsDefault' => false,
        'ShowFormDefault' => true,
        'ShowInMenus' => false,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            // Settings
            $fields->addFieldsToTab('Root.Settings', [
                HeaderField::create('DisplayOptions', 'Display Options', 3),
                OptionsetField::create('Unit', 'Unit of measure', ['m' => 'Miles', 'km' => 'Kilometers']),
                DropdownField::create('ShowResultsDefault')
                    ->setTitle('Show results by default')
                    ->setDescription('This will display results if no filters are applied to the locator')
                    ->setSource([false => 'No', true => 'Yes']),
                DropdownField::create('ShowFormDefault')
                    ->setTitle('Show filter form by default')
                    ->setDescription('This will display the filter form for the locator')
                    ->setSource([false => 'No', true => 'Yes']),
            ]);

            // Filter categories
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new GridFieldAddExistingSearchButton());
            $categories = $this->Categories();
            $categoriesField = GridField::create('Categories', 'Categories', $categories, $config)
                ->setDescription('only show locations from the selected category');

            // Filter
            $fields->addFieldsToTab('Root.Filter', [
                HeaderField::create('CategoryOptionsHeader', 'Location Filtering', 3),
                $categoriesField,
            ]);
        });

        return parent::getCMSFields();
    }

    /**
     * @param array $filter
     * @param array $filterAny
     * @param array $exclude
     * @param null|callable $callback
     *
     * @return DataList|ArrayList
     */
    public static function get_locations($filter = [], $filterAny = [], $exclude = [], $callback = null)
    {
        $locationClass = Config::inst()->get(static::class, 'location_class');
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
     * @return ArrayList|ManyManyList
     */
    public function getPageCategories(): ArrayList|ManyManyList
    {
        return self::locator_categories_by_locator($this->ID);
    }

    /**
     * @param int $id
     * @return ManyManyList|ArrayList
     */
    public static function locator_categories_by_locator($id = 0): ArrayList|ManyManyList
    {
        if ($id == 0) {
            return ArrayList::create();
        }

        /** @var Locator $locator */
        if ($locator = static::get()->byID($id)) {
            if ($locator->Categories()->exists()) {
                return $locator->Categories();
            }
        }

        return ArrayList::create();
    }

    /**
     * Gets the list of radii
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
        $config_radii = $this->config()->get('radii');
        if ($config_radii) {
            $radii = $config_radii;
        }

        return $radii;
    }

    public function getRadiiArrayList()
    {
        $list = [];

        foreach ($this->getRadii() as $radius) {
            $list[] = new ArrayData([
                'Radius' => $radius,
            ]);
        }

        return new ArrayList($list);
    }

    /**
     * Gets the limit of locations
     * @return mixed
     */
    public function getLimit()
    {
        return $this->config()->get('limit');
    }

    /**
     * Gets if the radius drop down should be shown
     * @return mixed
     */
    public function getShowRadius()
    {
        return $this->config()->get('show_radius');
    }

    /**
     * @return mixed
     *
     * @deprecated call the Categories() relation on the locator instead
     */
    public function getUsedCategories()
    {
        return $this->Categories();
    }

    /**
     * Gets the path of the info window template
     *
     * @return string
     */
    public function getInfoWindowTemplate()
    {
        return ModuleResourceLoader::singleton()->resolveURL(
            Config::inst()->get(
                static::class,
                'infoWindowTemplate'
            )
        );
    }

    /**
     * Gets the path of the list template
     *
     * @return string
     */
    public function getListTemplate()
    {
        return ModuleResourceLoader::singleton()->resolveURL(
            Config::inst()->get(
                static::class,
                'listTemplate'
            )
        );
    }

    /**
     * @return null|string
     */
    public function getMapStyle()
    {
        return AddressDataExtension::getMapStyleJSON();
    }

    public function getMapStyleJSONPath()
    {
        return AddressDataExtension::getMapStyleJSONPath();
    }

    /**
     * @return null|string
     */
    public function getMarkerIcon()
    {
        return AddressDataExtension::getIconImage();
    }

    /**
     * @return string
     */
    public function getLumberjackTitle()
    {
        return _t(__CLASS__ . '.LumberjackTitle', 'Locations');
    }
}
