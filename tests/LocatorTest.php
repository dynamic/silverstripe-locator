<?php

/**
 * Class LocatorTest
 */
class LocatorTest extends Locator_Test
{

    /**
     *
     */
    public function testGetCMSFields()
    {
        $locator = singleton('Locator');
        $this->assertInstanceOf('FieldList', $locator->getCMSFields());
    }

    /**
     *
     */
    public function testLocations()
    {
        $filter = Config::inst()->get('Locator_Controller', 'base_filter');
        $filterAny = Config::inst()->get('Locator_Controller', 'base_filter_any');
        $exclude = Config::inst()->get('Locator_Controller', 'base_exclude');
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
        $locator = $this->objFromFixture('Locator', 'locator1');
        $this->assertEquals($locator->getPageCategories()->count(), 2);
    }

    /**
     *
     */
    public function testLocatorCategoriesByLocator()
    {

        $locator = $this->objFromFixture('Locator', 'locator1');
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
        $locator = $this->objFromFixture('Locator', 'locator1');
        $controller = Locator_Controller::create($locator);
        $this->assertInstanceOf('ViewableData', $controller->index($controller->request));
    }

    /**
     *
     */
    public function testXml()
    {
        $locator = $this->objFromFixture('Locator', 'locator1');
        $controller = Locator_Controller::create($locator);
        $this->assertInstanceOf('HTMLText', $controller->xml($controller->request));
    }

    /**
     *
     */
    public function testLocationSearch()
    {
        $locator = $this->objFromFixture('Locator', 'locator1');
        $object = Locator_Controller::create($locator);
        $form = $object->LocationSearch();
        $this->assertTrue(is_a($form, 'Form'));

        $category = $this->objFromFixture('LocationCategory', 'service');
        $category2 = $this->objFromFixture('LocationCategory', 'manufacturing');
        $locator->Categories()->add($category);
        $locator->Categories()->add($category2);

        $form = $object->LocationSearch();
        $fields = $form->Fields();
        $this->assertInstanceOf('FieldList', $fields);
    }

    /**
     *
     */
    public function testLocationInfoTemplates()
    {
        $this->assertEquals('locator/templates/location-list-description.html', Config::inst()->get('Locator_Controller', 'list_template_path'));
        $this->assertEquals('locator/templates/infowindow-description.html', Config::inst()->get('Locator_Controller', 'info_window_template_path'));
    }

}
