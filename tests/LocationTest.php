<?php

class LocationTest extends Locator_Test
{
    public function testGetCoords()
    {
        $this->logInWithPermission('Location_CREATE');
        $location = $this->objFromFixture('Location', 'dynamic');
        $location->write();
        $locationID = $location->ID;

        $geoCodable = Location::get()->byID($locationID);
        $this->assertTrue($geoCodable->Lat == $location->Lat);
        $this->assertTrue($geoCodable->Lng == $location->Lng);
    }

    public function testFieldLabels()
    {
        $location = $this->objFromFixture('Location', 'dynamic');
        $labels = $location->FieldLabels();
        //debug::show($labels);
        $expected = array(
            'Title' => 'Name',
            'Featured' => 'Featured',
            'Website' => 'Website',
            'Phone' => 'Phone',
            'Email' => 'Email',
            'EmailAddress' => 'Email Address',
            'ShowInLocator' => 'Show',
            'Address' => 'Address',
            'Suburb' => 'City',
            'State' => 'State',
            'Postcode' => 'Postal Code',
            'Country' => 'Country',
            'Lat' => 'Lat',
            'Lng' => 'Lng',
            'Category' => 'Category',
            'ShowInLocator.NiceAsBoolean' => 'Show',
            'Category.Name' => 'Category',
            'Featured.NiceAsBoolean' => 'Featured',
            'Coords' => 'Coords',
        );
        $this->assertEquals($expected, $labels);
    }

    public function testGetCMSFields()
    {
        $object = new Location();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testValidate()
    {
        $this->markTestSkipped('TODO');
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canView());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canView($nullMember));
        $nullMember->delete();
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'Dynamic, Inc.');
        $this->assertTrue($object->canEdit());
        $object->Title = 'Changed Title';
        $object->write();
        $testEdit = Location::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
        $this->logOut();
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('Location');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));
        $nullMember->delete();
    }

    public function testProvidePermissions()
    {
        $this->markTestSkipped('TODO');
    }

    public function testOnBeforeWrite()
    {
        $this->markTestSkipped('TODO');
    }
}
