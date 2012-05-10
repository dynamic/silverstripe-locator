<?php

class LocationDataObjectManager extends ManyManyDataObjectManager {

	public $popupClass = "LocationDataObjectManager_Popup";

}

//Custom Popup Class
class LocationDataObjectManager_Popup extends DataObjectManager_Popup
{
    function __construct($controller, $name, $fields, $validator, $readonly, $dataObject) {
        parent::__construct($controller, $name, $fields, $validator, $readonly, $dataObject);
        
        //Custom JS
        Requirements::javascript('http://maps.google.com/maps?file=api&v=2&key='.LocationPage::$map_key);
        Requirements::javascript('locations/javascript/editLocation.js');
        
    }
}