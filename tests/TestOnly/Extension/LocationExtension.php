<?php

namespace Dynamic\Locator\Tests\TestOnly\Extension;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataExtension;

/**
 * Class LocationExtension
 * @package Dynamic\Locator\Tests\Extension
 */
class LocationExtension extends DataExtension implements TestOnly
{
    /**
     * @param $url
     */
    public function updateWebsiteURL(&$url)
    {
        $url = 'foo';
    }
}
