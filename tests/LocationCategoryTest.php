<?php

/**
 * Class LocationTest
 */
class LocationCategoryTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'locator/tests/Locator_Test.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture('LocationCategory', 'service');
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('LocationCategory', 'service');
        $this->assertTrue($object->canView());
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture('LocationCategory', 'service');

        $admin = $this->objFromFixture('Member', 'locationedit');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture('LocationCategory', 'service');

        $admin = $this->objFromFixture('Member', 'locationdelete');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture('LocationCategory', 'service');

        $admin = $this->objFromFixture('Member', 'locationcreate');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canCreate($member));
    }
}
