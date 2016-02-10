<?php

class LocationTest extends LocatorModule_Test {
	public function testGetCoords() {
		$this->markTestSkipped('TODO');
	}

	public function testFieldLabels() {
		$this->markTestSkipped('TODO');
	}

	public function testGetCMSFields() {
		$object = new Location();
		$fieldset = $object->getCMSFields();
		$this->assertTrue(is_a($fieldset, "FieldList"));
	}

	public function testValidate() {
		$this->markTestSkipped('TODO');
	}

	public function testEmailAddress() {
		$this->markTestSkipped('TODO');
	}

	public function testCanView() {
		$object = singleton('Location');
		$this->logInWithPermission('ADMIN');
		$this->assertTrue($object->canView());
		$this->logOut();
		$nullMember = Member::create();
		$nullMember->write();
		$this->assertTrue($object->canView($nullMember));
		$nullMember->delete();
	}

	public function testCanEdit() {
		$object = Location::create(array(
			'Title' => 'Test Location',
		));
		$object->write();
		$this->logInWithPermission('Location_EDIT');
		$toEdit = Location::get()->byID($object->ID);
		$originalTitle = $toEdit->Title;
		$this->assertEquals($originalTitle, 'Test Location');
		$this->assertTrue($toEdit->canEdit());
		$toEdit->Title = 'Changed Title';
		$toEdit->write();
		$testEdit = Location::get()->byID($object->ID);
		$this->assertEquals($testEdit->Title, 'Changed Title');
		$this->logOut();
	}

	public function testCanDelete() {
		$this->logInWithPermission('Location_DELETE');
		$location = $this->objFromFixture('Location', 'silverstripe');
		$locationID = $location->ID;
		$this->logOut();

		$this->logInWithPermission('Location_DELETE');
		$this->assertTrue($location->canDelete());
		$location->delete();

		$locations = Location::get()->column('ID');
		$this->assertFalse(in_array($locationID, $locations));
	}

	public function testCanCreate() {
		$this->logInWithPermission('Location_CREATE');
		$location = $this->objFromFixture('Location', 'dynamic');

		$this->assertTrue($location->canCreate());

		$locationID = $location->ID;

		$this->assertTrue($locationID > 0);

		$getLocal = Location::get()->byID($locationID);
		$this->assertTrue($getLocal->ID == $locationID);
	}

	public function testProvidePermissions() {
		$this->markTestSkipped('TODO');
	}

	public function testOnBeforeWrite() {
		$this->markTestSkipped('TODO');
	}

}
