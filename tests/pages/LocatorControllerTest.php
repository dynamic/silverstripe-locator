<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\Locator\LocationCategory;
use Dynamic\Locator\Locator;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\ORM\DataObject;

/**
 * Class LocatorControllerTest
 * @package Dynamic\Locator\Tests
 */
class LocatorControllerTest extends FunctionalTest
{

    protected static $fixture_file = '../fixtures.yml';

    protected static $use_draft_site = true;

    /**
     * Tests the json route
     */
    public function testJson()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');

        $page = $this->get($locator->Link('json'));

        $this->assertEquals(200, $page->getStatusCode());
        $this->assertEquals('application/json', $page->getHeader('Content-Type'));

        $this->assertNotEquals(null, json_decode($page->getBody()));
    }

    /**
     * Tests the settings route
     */
    public function testSettings()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');

        $page = $this->get($locator->Link('settings'));

        $this->assertEquals(200, $page->getStatusCode());
        $this->assertEquals('application/json', $page->getHeader('Content-Type'));

        $this->assertNotEquals(null, json_decode($page->getBody()));
    }
}
