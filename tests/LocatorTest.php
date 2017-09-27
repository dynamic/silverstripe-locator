<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Location;
use Dynamic\Locator\Locator;
use Dynamic\Locator\LocatorController;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\FunctionalTest;

/**
 * Class LocatorTest
 */
class LocatorTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $locator = singleton('Dynamic\\Locator\\Locator');
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $locator->getCMSFields());
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
        $locator = $this->objFromFixture('Dynamic\\Locator\\Locator', 'locator1');
        $this->assertEquals($locator->getPageCategories()->count(), 2);
    }

    /**
     *
     */
    public function testLocatorCategoriesByLocator()
    {

        $locator = $this->objFromFixture('Dynamic\\Locator\\Locator', 'locator1');
        $this->assertEquals(Locator::locator_categories_by_locator($locator->ID)->count(), 2);

        $newLocator = Locator::create();
        $newLocator->Title = 'Locator 2';
        $newLocator->write();

        $this->assertEquals(Locator::locator_categories_by_locator($newLocator->ID)->count(), 0);

    }

    /**
     *
     */
    public function testInit()
    {
    }

    /**
     *
     */
    public function testIndex()
    {
        $locator = $this->objFromFixture('Dynamic\\Locator\\Locator', 'locator1');
        $controller = LocatorController::create($locator);
        $this->assertInstanceOf('SilverStripe\\View\\ViewableData', $controller->index($controller->request));
    }

    /**
     *
     */
    public function testXml()
    {
        $locator = $this->objFromFixture('Dynamic\\Locator\\Locator', 'locator1');
        $controller = LocatorController::create($locator);
        $this->assertInstanceOf('SilverStripe\\ORM\\FieldType\\DBHTMLText', $controller->xml($controller->request));
    }

    /**
     *
     */
    public function testLocationSearch()
    {
        $locator = $this->objFromFixture('Dynamic\\Locator\\Locator', 'locator1');
        $object = LocatorController::create($locator);
        $form = $object->LocationSearch();
        $this->assertTrue(is_a($form, 'SilverStripe\\Forms\\Form'));

        $category = $this->objFromFixture('Dynamic\\Locator\\LocationCategory', 'service');
        $category2 = $this->objFromFixture('Dynamic\\Locator\\LocationCategory', 'manufacturing');
        $locator->Categories()->add($category);
        $locator->Categories()->add($category2);

        $form = $object->LocationSearch();
        $fields = $form->Fields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     *
     */
    public function testLocationInfoTemplates()
    {
        $this->assertEquals('locator/templates/location-list-description.html', Config::inst()->get(LocatorController::class, 'list_template_path'));
        $this->assertEquals('locator/templates/infowindow-description.html', Config::inst()->get(LocatorController::class, 'info_window_template_path'));
    }

}
