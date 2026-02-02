<?php

namespace Dynamic\Locator\Tests\TestOnlyModel;

use Dynamic\Locator\Model\Location;
use Dynamic\Locator\Tests\TestOnly\Extension\LocationExtension;
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
