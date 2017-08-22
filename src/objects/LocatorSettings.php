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
     * gets the current settings for the locator
     * @return LocatorSettings
     */
    public static function current_locator_settings()
    {
        return Injector::inst()->get(LocatorSettings::class);
    }

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
            '25' => '25',
            '50' => '50',
            '75' => '75',
            '100' => '100',
        ];

        $config_radii = Config::inst()->get(Locator::class, 'radius_array');
        if ($config_radii) {
            $radii = $config_radii;
        }
        return $radii;
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

}
