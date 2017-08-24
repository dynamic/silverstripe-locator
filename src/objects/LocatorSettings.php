<?php

namespace Dynamic\Locator;

use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\DataObject;

/**
 * Class LocatorSettings
 * @package Dynamic\Locator
 */
class LocatorSettings extends DataObject
{
    /**
     * @var array
     */
    private static $has_one = array(
        'Locator' => Locator::class
    );

    /**
     * Gets the fields allowed to be retrieved through Graphql
     *
     * @return mixed
     */
    public function getExposedFields()
    {
        // merges arrays
        return Config::inst()->get(Locator::class, 'fields');
    }

    /**
     * Gets the list of radius
     *
     * @return array
     */
    public function getRadii()
    {
        $radii = [
            '25'  => '25',
            '50'  => '50',
            '75'  => '75',
            '100' => '100',
        ];

        $config_radii = Config::inst()->get(Locator::class, 'radius_array');
        if ($config_radii) {
            $radii = $config_radii;
        }

        return json_encode($radii);
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
     * Gets the info window template
     * @return mixed
     */
    public function getInfoWindowTemplate()
    {
        // TODO - allow a locator class to override this?
        return json_encode(file_get_contents(__DIR__ . '/../../../' . Config::inst()->get(Locator::class,
                'infoWindowTemplate')));
    }

    /**
     * Gets the template for locations in the list
     * @return string
     */
    public function getListTemplate()
    {
        return json_encode(file_get_contents(__DIR__ . '/../../../' . Config::inst()->get(Locator::class,
                'listTemplate')));
    }

    /**
     * Gets the list of categories
     * @return string
     */
    public function getCategories()
    {
        return json_encode(
            $this->Locator()->Categories()->filter(array(
                    'Locations.ID:GreaterThan' => 0
                )
            )->Map('ID', 'Name')->toArray()
        );
    }

    /**
     * Gets the unit of distance
     *
     * @return mixed
     */
    public function getUnit()
    {
        return $this->Locator()->Unit;
    }

}
