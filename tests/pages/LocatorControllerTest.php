<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\Locator\LocationCategory;
use Dynamic\Locator\Locator;
use Dynamic\Locator\LocatorController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\ORM\ArrayList;
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

    /**
     * Tests specific parts of getLocations()
     */
    public function testGetLocations()
    {
        $category = $this->objFromFixture(LocationCategory::class, 'service');

        $loc1 = $this->objFromFixture(Location::class, 'dynamic');
        // generic Sheboygan WI coordinates
        $loc1->Lat = 43.7444081;
        $loc1->Lng = -87.8005188;
        $loc1->write();

        $loc2 = $this->objFromFixture(Location::class, 'silverstripe');
        // generic New Zealand coordinates
        $loc2->Lat = -39.3846249;
        $loc2->Lng = 157.3172296;
        $loc2->write();

        $locator = $this->objFromFixture(Locator::class, 'locator1');

        $controller = Injector::inst()->create(LocatorController::class);

        $request = new HTTPRequest(
            'GET',
            $locator->Link('json'),
            array(
                'address' => '1526+S+12th+St+Sheboygan+WI',
                'radius' => 25,
                'category' => $category->ID,
            )
        );

        $locations = $controller->getLocations($request);

        $this->assertInstanceOf(ArrayList::class, $locations);
        // because address isn't actually used to determine distance here,
        // everything defaults to -1
        $this->assertEquals(2, $locations->Count());

        // radius of -1, everything in the category should be in the list
        $request = new HTTPRequest(
            'GET',
            $locator->Link('json'),
            array(
                'address' => '1526+S+12th+St+Sheboygan+WI',
                'radius' => -1,
                'category' => $category->ID,
            )
        );

        $locations = $controller->getLocations($request);

        $this->assertInstanceOf(ArrayList::class, $locations);
        $this->assertEquals(2, $locations->Count());
    }
}
