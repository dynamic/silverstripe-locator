<?php

namespace Dynamic\Locator\Tests;

use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;

/**
 * Class LocatorTest_Base
 * @package Dynamic\Locator\Tests
 */
class LocatorTest_Base extends SapphireTest
{

    protected static $fixture_file = 'fixtures.yml';

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        Config::modify()->set(
            GoogleGeocoder::class,
            'geocoder_api_key',
            getenv('api_key')
        );
        parent::setUp();
    }
}
