<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\Locator\Locator;

use Dynamic\Locator\LocatorController;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;

/**
 * Class LocatorTest
 */
class LocatorTest extends SapphireTest
{

    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $locator = Injector::inst()->get(Locator::class);
        $fields = $locator->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     *
     */
    public function testGetRadii()
    {
        $locator = Injector::inst()->get(Locator::class);

        // no config options
        Config::modify()->remove(Locator::class, 'radius_array');
        $radii = $locator->getRadii();
        $this->assertInstanceOf(ArrayList::class, $radii);

        // custom config options
        Config::modify()->set(Locator::class, 'radius_array', array(
            '0' => '100',
            '1' => '500',
            '2' => '1000',
        ));
        $radii = $locator->getRadii();
        $this->assertInstanceOf(ArrayList::class, $radii);
    }

    /**
     *
     */
    public function testGetLimit()
    {
        $locator = Injector::inst()->get(Locator::class);

        // no config options
        $limit = $locator->getLimit();
        $this->assertEquals(-1, $limit);

        // custom config options
        Config::modify()->set(Locator::class, 'limit', 10);
        $limit = $locator->getLimit();
        $this->assertEquals(10, $limit);
    }

    /**
     *
     */
    public function testGetShowRadius()
    {
        $locator = Injector::inst()->get(Locator::class);

        // no config options
        $limit = $locator->getShowRadius();
        $this->assertTrue($limit);

        // custom config options
        Config::modify()->set(Locator::class, 'show_radius', false);
        $limit = $locator->getShowRadius();
        $this->assertFalse($limit);
    }

    /**
     *
     */
    public function testGetCategories()
    {
        $locator = Injector::inst()->get(Locator::class);
        $catNum = count($locator->getCategories());
        $this->assertEquals(0, $catNum);

        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $catNum = count($locator->getCategories());
        $this->assertEquals(1, $catNum);
    }

    /**
     *
     */
    public function testGetInfoWindowTemplate()
    {
        $locator = Injector::inst()->get(Locator::class);
        $template = $locator->getInfoWindowTemplate();
        $this->assertTrue(is_string($template));
    }

    /**
     *
     */
    public function testGetListTemplate()
    {
        $locator = Injector::inst()->get(Locator::class);
        $template = $locator->getListTemplate();
        $this->assertTrue(is_string($template));
    }

    /**
     *
     */
    public function testLocations()
    {
        $filter = Config::inst()->get(LocatorController::class, 'base_filter');
        $filterAny = Config::inst()->get(LocatorController::class, 'base_filter_any');
        $exclude = Config::inst()->get(LocatorController::class, 'base_exclude');
        $locations = Locator::get_locations($filter, $filterAny, $exclude);
        $locations2 = Location::get()->filter($filter)->filterAny($filterAny)->exclude($exclude);
        $this->assertEquals($locations->count(), $locations2->count());
    }
}
