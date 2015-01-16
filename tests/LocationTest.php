<?php

class LocationTest extends LocatorTest{

    protected static $use_draft_site = true;

    function setUp(){
        parent::setUp();
    }

    function testLocationCreation(){

        $this->logInWithPermission('Location_CREATE');
        $location = $this->objFromFixture('Location', 'dynamic');

        $this->assertTrue($location->canCreate());

        $locationID = $location->ID;

        $this->assertTrue($locationID > 0);

        $getLocal = Location::get()->byID($locationID);
        $this->assertTrue($getLocal->ID == $locationID);

    }

    function testLocationDeletion(){

        $this->logInWithPermission('ADMIN');
        $location = $this->objFromFixture('Location', 'silverstripe');
        $locationID = $location->ID;

        $this->logOut();

        $this->logInWithPermission('Location_DELETE');

        $this->assertTrue($location->canDelete());
        $location->delete();

        $locations = Location::get()->column('ID');
        $this->assertFalse(in_array($locationID, $locations));

    }


}