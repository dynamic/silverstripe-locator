<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class AddressDataExtensionTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'locator/tests/fixtures.yml';

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     *
     */
    public function testGetFullAddress()
    {

    }

    /**
     *
     */
    public function testHasAddress()
    {

    }
}