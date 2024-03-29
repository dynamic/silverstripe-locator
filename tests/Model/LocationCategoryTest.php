<?php

namespace Dynamic\Locator\Tests\Model;

use Dynamic\Locator\Model\LocationCategory;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Member;

/**
 * Class LocationCategoryTest
 * @package Dynamic\Locator\Tests\Model
 */
class LocationCategoryTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'categoryfixture.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(LocationCategory::class, 'service');
        $fieldset = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fieldset);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(LocationCategory::class, 'service');
        $this->assertTrue($object->canView());
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(LocationCategory::class, 'service');

        $admin = $this->objFromFixture(Member::class, 'locationedit');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(LocationCategory::class, 'service');

        $admin = $this->objFromFixture(Member::class, 'locationdelete');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture(LocationCategory::class, 'service');

        $admin = $this->objFromFixture(Member::class, 'locationcreate');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canCreate($member));
    }
}
