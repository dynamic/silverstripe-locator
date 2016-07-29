<?php

class LocationTest extends Locator_Test
{
    public function testGetCoords()
    {
        $location = $this->objFromFixture('Location', 'dynamic');

        $coords = ((int)$location->Lat != 0 && (int)$location->Lng != 0) ? 'true' : 'false';

        $this->assertEquals($coords, $location->getCoords());
    }

    public function testFieldLabels()
    {
        $location = $this->objFromFixture('Location', 'dynamic');
        $labels = $location->FieldLabels();
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
            'Category.ID' => 'Category',
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
    }

    public function testEmailAddress()
    {
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
        $this->logInWithPermission('Location_EDIT');
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
        $this->logInWithPermission('Location_DELETE');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('Location');
        $this->logInWithPermission('Location_CREATE');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));
        $nullMember->delete();
    }

    public function testProvidePermissions()
    {
        $object = Location::create();
        $expected = array(
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }
}
