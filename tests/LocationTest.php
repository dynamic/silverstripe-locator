<?php

namespace Dynamic\Locator\Tests;

use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use Dynamic\Locator\Location;
use SilverStripe\Security\Member;

/**
 * Class LocationTest
 */
class LocationTest extends LocatorTest_Base
{

    /**
     *
     */
    public function testGetCoords()
    {
        $location = $this->objFromFixture('Dynamic\\Locator\\Location', 'dynamic');
        $coords = ((int)$location->Lat != 0 && (int)$location->Lng != 0) ? 'true' : 'false';
        $this->assertEquals($coords, $location->getCoords());
    }

    /**
     *
     */
    public function testFieldLabels()
    {
        $location = $this->objFromFixture(Location::class, 'dynamic');
        $labels = $location->FieldLabels();
        $expected = array(
            'Title' => 'Name',
            'Featured' => 'Featured',
            'Website' => 'Website',
            'Phone' => 'Phone',
            'Email' => 'Email',
            'Address' => 'Address',
            'City' => 'City',
            'State' => 'State',
            'PostalCode' => 'Postal Code',
            'Country' => 'Country',
            'Lat' => 'Lat',
            'Lng' => 'Lng',
            'Category' => 'Category',
            'Category.Name' => 'Category',
            'Category.ID' => 'Category',
            'Featured.NiceAsBoolean' => 'Featured',
            'Import_ID' => 'Import_ID',
            'Version' => 'Version',
            'Versions' => 'Versions',
            'Address2' => 'Address2'
        );
        $this->assertEquals($expected, $labels);
    }

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
    public function testCanView()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canCreate($member));
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
