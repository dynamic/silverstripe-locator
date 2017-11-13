<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\Locator\LocationCategory;
use Dynamic\Locator\Locator;
use Dynamic\Locator\LocatorController;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ViewableData;

/**
 * Class LocatorTest
 */
class LocatorTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

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
        $this->assertEquals($locator->getPageCategories()->count(), 2);
    }

    /**
     *
     */
    public function testLocatorCategoriesByLocator()
    {

        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $this->assertEquals(Locator::locator_categories_by_locator($locator->ID)->count(), 2);

        $newLocator = Locator::create();
        $newLocator->Title = 'Locator 2';
        $newLocator->write();

        $this->assertEquals(Locator::locator_categories_by_locator($newLocator->ID)->count(), 0);

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
