<?php

namespace Dynamic\Locator\Tests\Model;

use Dynamic\Locator\Tests\TestOnly\Extension\LocationExtension;
use Dynamic\Locator\Tests\TestOnlyModel\ExtendedLocation;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use Dynamic\Locator\Model\Location;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;

/**
 * Class LocationTest
 * @package Dynamic\Locator\Tests\Model
 */
class LocationTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'locationfixture.yml';

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        ExtendedLocation::class,
    ];

    /**
     * @var array
     */
    protected static $required_extensions = [
        ExtendedLocation::class => [
            LocationExtension::class,
        ],
    ];

    /**
     *
     */
    public function testGetCoords()
    {
        $location = $this->objFromFixture(Location::class, 'dynamic');
        $coords = ((int)$location->Lat != 0 && (int)$location->Lng != 0) ? 'true' : 'false';
        $this->assertEquals($coords, $location->getCoords());
    }

    /**
     *
     */
    public function testFieldLabels()
    {
        $this->markTestSkipped();
        // Link and File tracking display as "Tracking" in SS 4.2 & 4.3, "Tracking" in 4.4
        $location = $this->objFromFixture(Location::class, 'dynamic');
        $labels = $location->FieldLabels();
        $expected = [
            'Title' => 'Name',
            'Featured' => 'Featured',
            'Website' => 'Website',
            'Phone' => 'Phone',
            'Email' => 'Email',
            'Fax' => 'Fax',
            'Address' => 'Address',
            'City' => 'City',
            'State' => 'State',
            'PostalCode' => 'Postal Code',
            'Country' => 'Country',
            'Lat' => 'Lat',
            'Lng' => 'Lng',
            'Categories' => 'Categories',
            'Category.Name' => 'Category',
            'Category.ID' => 'Category',
            'Featured.NiceAsBoolean' => 'Featured',
            'Import_ID' => 'Import_ID',
            'Version' => 'Version',
            'Versions' => 'Versions',
            'Address2' => 'Address2',
            'LinkTracking' => 'Link tracking',
            'FileTracking' => 'File tracking',
        ];
        $this->assertEquals($expected, $labels);
    }

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = new Location();
        $fieldset = $object->getCMSFields();
        $this->assertinstanceOf(FieldList::class, $fieldset);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(Location::class, 'dynamic');
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
        $object = $this->objFromFixture(Location::class, 'dynamic');
        $object->write();

        $objectID = $object->ID;

        //test permissions per permission setting
        $create = $this->objFromFixture(Member::class, 'locationcreate');
        $edit = $this->objFromFixture(Member::class, 'locationedit');
        $delete = $this->objFromFixture(Member::class, 'locationdelete');

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
        $object = $this->objFromFixture(Location::class, 'dynamic');
        $object->write();

        //test permissions per permission setting
        $create = $this->objFromFixture(Member::class, 'locationcreate');
        $edit = $this->objFromFixture(Member::class, 'locationedit');
        $delete = $this->objFromFixture(Member::class, 'locationdelete');

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
        $object = singleton(Location::class);

        //test permissions per permission setting
        $create = $this->objFromFixture(Member::class, 'locationcreate');
        $edit = $this->objFromFixture(Member::class, 'locationedit');
        $delete = $this->objFromFixture(Member::class, 'locationdelete');

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
        $expected = [
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location',
        ];
        $this->assertEquals($expected, $object->providePermissions());
    }

    /**
     *
     */
    public function testUpdateWebsiteURL()
    {
        $location = $this->objFromFixture(Location::class, 'dynamic');

        // Create unsaved raw duplicate
        $map = $location->toMap();
        unset($map['Created']);
        /** @var static $clone */
        $clone = Injector::inst()->create(ExtendedLocation::class, $map);
        $clone->ID = 0;

        $this->assertEquals('https://www.dynamicagency.com', $location->getWebsiteURL());
        $this->assertEquals('foo', $clone->getWebsiteURL());
    }
}
