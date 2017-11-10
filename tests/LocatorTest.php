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
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $locator = singleton(Locator::class);
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
    public function testInit()
    {
    }

    /**
     *
     */
    public function testIndex()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $controller = LocatorController::create($locator);
        $this->assertInstanceOf(ViewableData::class, $controller->index($controller->request));
    }

    /**
     *
     */
    public function testXml()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $controller = LocatorController::create($locator);
        $this->assertInstanceOf(DBHTMLText::class, $controller->xml($controller->request));
    }

    /**
     *
     */
    public function testLocationSearch()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $object = LocatorController::create($locator);
        $form = $object->LocationSearch();
        $this->assertInstanceOf(Form::class, $form);

        $category = $this->objFromFixture(LocationCategory::class, 'service');
        $category2 = $this->objFromFixture(LocationCategory::class, 'manufacturing');
        $locator->Categories()->add($category);
        $locator->Categories()->add($category2);

        $form = $object->LocationSearch();
        $fields = $form->Fields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    public function testGetListTemplate()
    {
        /** @var Locator $object */
        $object = Injector::inst()->create(Locator::class);
        $list = $object->getListTemplate();

        $this->assertStringEndsWith('client/location-list-description.html', $list);
    }
}
