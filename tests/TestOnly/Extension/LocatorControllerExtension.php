<?php

namespace Dynamic\Locator\Tests\TestOnly\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Dev\TestOnly;

class LocatorControllerExtension extends Extension implements TestOnly
{
    /**
     * @var array
     */
    public static $mapSettings = [];

    /**
     * @param array $mapSettings
     */
    public function modifyMapSettings(&$mapSettings)
    {
        self::$mapSettings = $mapSettings;
    }
}
