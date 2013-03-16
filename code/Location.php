<?php

class Location extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'Fax' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'ShowInLocator' => 'Boolean',
	);
		
	static $casting = array(
		'distance' => 'Int'
	);
	
	static $summary_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Lat',
		'Lng'
	);	
 
	public function getCMSFields() {
		
		return new FieldList(

			new TextField('Title'),
			new TextField('Website'),
			new TextField('Phone'),
			new TextField('Fax'),
			new TextField('EmailAddress'),
			new CheckboxField('ShowInLocator')
		);
	}
			
	/**
	 * onBeforeWrite function to get coordinates via PHP
	 *
	 * removed in favor of javascript due to IP blacklists and shared web servers
	**/
	/*function onBeforeWrite() {
		if (!$this->Lat || !$this->Long) {
			$MAPS_HOST = "maps.google.com";
			$KEY = self::$map_key;
			$base_url = "http://" . $MAPS_HOST . "/maps/geo?output=xml" . "&key=" . $KEY;
			
			$address = $this->Address . ", ".$this->City . " " . $this->State . " " . $this->ZipCode;
		    $request_url = $base_url . "&q=" . urlencode($address);
		    $xml = simplexml_load_file($request_url) or die("url not loading");
		    
			$status = $xml->Response->Status->code;
		    if (strcmp($status, "200") == 0) {
		      // Successful geocode
		      //$geocode_pending = false;
		      $coordinates = $xml->Response->Placemark->Point->coordinates;
		      $coordinatesSplit = split(",", $coordinates);
		      // Format: Longitude, Latitude, Altitude
		      $this->Lat = $coordinatesSplit[1];
		      $this->Long = $coordinatesSplit[0];
		      
		      // strip slashes from spreadsheet import
		      $this->Name = stripslashes($this->Name);
		      $this->Address = stripslashes($this->Address);
		      $this->City = stripslashes($this->City);
		      
		    }
		}
		parent::onBeforeWrite();
	}*/

}