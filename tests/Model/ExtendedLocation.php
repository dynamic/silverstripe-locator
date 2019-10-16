<?php

namespace Dynamic\Locator\Tests\Model;

use Dynamic\Locator\Location;
use Dynamic\Locator\Tests\Extension\LocationExtension;
use SilverStripe\Dev\TestOnly;

/**
 * Class ExtendedLocation
 * @package Dynamic\Locator\Tests\Model
 */
class ExtendedLocation extends Location implements TestOnly
{
    /**
     * @var array
     */
    private static $extensions = [
        LocationExtension::class,
    ];
}
