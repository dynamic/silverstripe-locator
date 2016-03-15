<?php

class LocatorTest extends Locator_Test
{
    public function testGetCMSFields()
    {
        $object = new Location();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testGetLocations()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();

        $object2 = $this->objFromFixture('Location', 'silverstripe');
        $object2->write();

        $object3 = $this->objFromFixture('Location', '3sheeps');
        $object3->write();

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

        $object = $this->objFromFixture('LocationCategory', 'service');
        $object->write();

        $object2 = $this->objFromFixture('LocationCategory', 'manufacturing');
        $object2->write();

        $count = LocationCategory::get();

        $this->assertEquals($locator->getAllCategories(), $count);
    }

    public function testInit()
    {
        $this->markTestSkipped('TODO');
    }

    public function testXml()
    {
        $this->markTestSkipped('TODO');
    }

    public function testLocationSearch()
    {
        $this->markTestSkipped('TODO');
    }
}
