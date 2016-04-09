<?php

class LocatorTest extends Locator_Test
{
    public function testGetCMSFields()
    {
        $object = new Locator();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testLocations()
    {
        $filter = array('ShowInLocator' => 1);
        $filterAny = array('Suburb' => 'Sheboygan');
        $exclude = array('Suburb' => 'Milwaukee');
        $locations = Locator::locations($filter, $filterAny, $exclude);
        $locations2 = Location::get()->filter($filter)->filterAny($filterAny)->exclude($exclude);
        $this->assertEquals($locations->Count(), $locations2->Count());
    }

    public function testGetAllCategories()
    {
        $locator = singleton('Locator');
        $count = LocationCategory::get();
        $this->assertEquals($locator->getAllCategories(), $count);
    }

    public function testGetPageCategories()
    {
        $locator = Locator::create();
        $this->assertFalse($locator->getPageCategories());

        $this->assertFalse($locator->getPageCategories(500));

        $locator->write();
        $category = $this->objFromFixture('LocationCategory', 'service');
        $locator->Categories()->add($category);
        $this->assertEquals($locator->getPageCategories($locator->ID), $locator->Categories());
    }

    public function testInit()
    {
    }

    public function testIndex()
    {
        $locator = $this->objFromFixture('Locator', 'locator1');
        $controller = Locator_Controller::create($locator);
        $this->assertInstanceOf('ViewableData', $controller->index($controller->request));
    }

    public function testXml()
    {
        $locator = $this->objFromFixture('Locator', 'locator1');
        $controller = Locator_Controller::create($locator);
        $this->assertInstanceOf('HTMLText', $controller->xml($controller->request));
    }

    public function testItems()
    {
        $locator = $this->objFromFixture('Locator', 'locator1');
        $controller = Locator_Controller::create($locator);

        $filter = array('ShowInLocator' => 1);

        $locations = $controller->Items($controller->request);
        $locations2 = Location::get()->filter($filter);
        $this->assertEquals($locations->Count(), $locations2->Count());
    }

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
        $this->assertNotNull($fields->fieldByName('CategoryID'));
    }
}
