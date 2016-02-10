<?php

class LocatorTest extends LocatorModule_Test {
	public function testGetCMSFields() {
		$object = new Locator();
		$fieldset = $object->getCMSFields();
		$this->assertTrue(is_a($fieldset, "FieldList"));
	}

	public function testGetAreLocations() {
		$this->markTestSkipped('TODO');
	}

	public function testGetAllCategories() {
		$this->markTestSkipped('TODO');
	}

	public function testInit() {
		$this->markTestSkipped('TODO');
	}

	public function testXml() {
		$this->markTestSkipped('TODO');
	}

	public function testLocationSearch() {
		$this->markTestSkipped('TODO');
	}

}
