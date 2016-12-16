<?php

namespace Dynamic\Locator\Tests;

use SilverStripe\Dev\SapphireTest,
    Dynamic\Locator\Location,
    SilverStripe\Security\Member;

/**
 * Class LocationTest
 */
class LocationTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'locator/tests/Locator_Test.yml';

    /**
     *

    public function testGetCoords()
    {
        $location = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');

        $coords = ((int)$location->Lat != 0 && (int)$location->Lng != 0) ? 'true' : 'false';

        $this->assertEquals($coords, $location->getCoords());
    }
     */

    /**
     *

    public function testFieldLabels()
    {
        $location = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');
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
            'Import_ID' => 'Import_ID',
            'LatLngOverride' => 'Lat Lng Override',
            'Version' => 'Version',
            'Versions' => 'Versions'
        );
        $this->assertEquals($expected, $labels);
    }
     */

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = new Location();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'SilverStripe\\Forms\\FieldList'));
    }

    /**
     *
     */
    public function testValidate()
    {
    }

    /**
     *
     */
    public function testEmailAddress()
    {
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');
        $object->write();

        $this->assertTrue($object->canView());

        $nullMember = Member::create();
        $nullMember->write();

        $this->assertTrue($object->canView($nullMember));

        $nullMember->delete();
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');
        $object->write();

        $objectID = $object->ID;

        //test permissions per permission setting
        $create = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationcreate');
        $edit = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationedit');
        $delete = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationdelete');

        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'Dynamic, Inc.');

        $this->assertTrue($object->canEdit($edit));
        $this->assertFalse($object->canEdit($create));
        $this->assertFalse($object->canEdit($delete));

        $object->Title = 'Changed Title';
        $object->write();

        $testEdit = Location::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');
        $object->write();

        //test permissions per permission setting
        $create = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationcreate');
        $edit = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationedit');
        $delete = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationdelete');

        $this->assertTrue($object->canDelete($delete));
        $this->assertFalse($object->canDelete($create));
        $this->assertFalse($object->canDelete($edit));

        $checkObject = $object;
        $object->delete();

        $this->assertEquals($checkObject->ID, 0);
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = singleton('Dynamic\\Locator\\Location');

        //test permissions per permission setting
        $create = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationcreate');
        $edit = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationedit');
        $delete = $this->objFromFixture('SilverStripe\\Security\\Member', 'locationdelete');

        $this->assertTrue($object->canCreate($create));
        $this->assertFalse($object->canCreate($edit));
        $this->assertFalse($object->canCreate($delete));

        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));

        $nullMember->delete();
    }

    /**
     *
     */
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
