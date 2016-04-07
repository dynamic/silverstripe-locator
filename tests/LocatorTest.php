<?php

class LocatorTest extends Locator_Test
{
    public function testGetCMSFields()
    {
        $object = new Locator();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testGetLocations()
    {
        $locator = singleton('Locator');
        $count = Location::get()->filter('ShowInLocator', 1)->exclude('Lat', 0)->Count();
        $this->assertEquals($locator->getLocations()->Count(), $count);
    }

    public function testGetAreLocations()
    {
        $locator = singleton('Locator');
        $this->assertEquals($locator->getLocations(), $locator->getAreLocations());
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

    public function testXml()
    {
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
        $this->assertNotNull($fields->fieldByName('category'));
        
    }
}
