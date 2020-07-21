<?php

namespace Dynamic\Locator\Tests\Page;

use Dynamic\Locator\Location;
use Dynamic\Locator\Page\Locator;
use Dynamic\Locator\Page\LocatorController;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;

/**
 * Class LocatorTest
 * @package Dynamic\Locator\Tests\Page
 */
class LocatorTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'locatorfixture.yml';

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        Config::modify()->set(Locator::class, 'location_class', Location::class);
    }

    /**
     *
     */
    public function testGetCMSFields()
    {
        /** @var Locator $locator */
        $locator = Injector::inst()->create(Locator::class);
        $this->assertInstanceOf(FieldList::class, $locator->getCMSFields());
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

    /**
     *
     */
    public function testGetAllCategories()
    {
        $this->assertEquals(Locator::get_all_categories()->count(), 4);
    }

    /**
     *
     */
    public function testGetPageCategories()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $this->assertEquals($locator->getPageCategories()->count(), 1);
    }

    /**
     *
     */
    public function testLocator_categories_by_locator()
    {
        $categories = Locator::locator_categories_by_locator(0);
        $this->assertFalse($categories);
    }

    /**
     *
     */
    public function testLocatorCategoriesByLocator()
    {

        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $this->assertEquals(Locator::locator_categories_by_locator($locator->ID)->count(), 1);

        $newLocator = Locator::create();
        $newLocator->Title = 'Locator 2';
        $newLocator->write();

        $this->assertEquals(Locator::locator_categories_by_locator($newLocator->ID)->count(), 0);
    }

    /**
     *
     */
    public function testGetRadii()
    {
        /** @var Locator $locator */
        $locator = Injector::inst()->create(Locator::class);
        $radii = [
            '0' => '5',
            '1' => '10',
            '2' => '15',
            '3' => '100',
        ];
        Config::modify()->set(Locator::class, 'radii', $radii);
        $this->assertEquals($radii, $locator->getRadii());
    }

    /**
     *
     */
    public function testGetRadiiArrayList()
    {
        /** @var Locator $locator */
        $locator = Injector::inst()->create(Locator::class);
        $this->assertInstanceOf(ArrayList::class, $locator->getRadiiArrayList());
    }

    /**
     *
     */
    public function testGetLimit()
    {
        /** @var Locator $locator */
        $locator = Injector::inst()->create(Locator::class);
        $this->assertEquals(50, $locator->getLimit());
    }

    /**
     *
     */
    public function testGetShowRadius()
    {
        /** @var Locator $locator */
        $locator = Injector::inst()->create(Locator::class);
        $this->assertTrue($locator->getShowRadius());
    }

    /**
     *
     */
    public function testGetUsedCategories()
    {
        /** @var Locator $locator */
        $locator = $this->objFromFixture(Locator::class, 'locator1');

        $categories = $locator->getUsedCategories()->toArray();
        $this->assertEquals(1, count($categories));
    }

    /**
     *
     */
    public function testGetInfoWindowTemplate()
    {
        /** @var Locator $object */
        $object = Injector::inst()->create(Locator::class);
        $template = $object->getInfoWindowTemplate();
        // get rid of cache ending
        $template = preg_replace('/\?.*$/', '', $template);
        $this->assertStringEndsWith('client/infowindow-description.html', $template);
    }

    /**
     *
     */
    public function testGetListTemplate()
    {
        /** @var Locator $object */
        $object = Injector::inst()->create(Locator::class);
        $template = $object->getListTemplate();
        // get rid of cache ending
        $template = preg_replace('/\?.*$/', '', $template);
        $this->assertStringEndsWith('client/location-list-description.html', $template);
    }
}
