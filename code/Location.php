<?php

class Location extends DataObject {

	static $db = array(
		'Name' => 'Varchar(255)',
		'Address' => 'Varchar(255)',
		'Address2' => 'Varchar(255)',
		'City' => 'Varchar(255)',
		'State' => 'Varchar(255)',
		'ZipCode' => 'Float(10,6)',
		'Country' => 'Varchar(255)',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'Fax' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'ShowInLocator' => 'Boolean',
		'Lat' => 'Float(10,6)',
		'Long' => 'Float(10,6)'
	);
	
	static $casting = array(
		'distance' => 'Int'
	);
	
	/*static $extensions = array( 
		"Versioned('Stage', 'Live')" 
	);*/
	
	static $summary_fields = array(
		'Name',
		'Address',
		'City',
		'State',
		'ZipCode',
		'Country',
		'Lat',
		'Long'
	);
	
	static $map_key = '';
	
	static function set_map_key($mapKey) {
		self::$map_key = $mapKey;
	}
	
	function CountryList() {
		return array(
			'' => '(Please Select)',
			'United States' => 'United States',
			'Canada' => 'Canada'
		);
	}
	
	function StateList() {
		return array(
			'' => '(Please Select)',
			'AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming",
			'-' => '-----',
			'AB' => 'Alberta',
			'BC' => 'British Columbia',
			'MB' => 'Manitoba',
			'NB' => 'New Brunswick',
			'NL' => 'Newfoundland and Labrador',
			'NS' => 'Nova Scotia',
			'ON' => 'Ontario',
			'PE' => 'Prince Edward Island',
			'QC' => 'Quebec',
			'SK' => 'Saskatchewan'
			
		);
	
	}	
 
	public function getCMSFields_forPopup() {
		
		return new FieldSet(
			//new TextField('ID', 'ID', $this->ID),
			new TextField('Name'),
			new TextField('Address'),
			new TextField('Address2'),
			new TextField('City'),
			new DropdownField('State', 'State/Province', $this->StateList()),
			new TextField('ZipCode', 'Zip/Postal Code'),
			new DropdownField('Country', 'Country', $this->CountryList()),
			new TextField('Website'),
			new TextField('Phone'),
			new CheckboxField('ShowInLocator'),
			new TextField('Lat'),
			new TextField('Long')//,
			//new FormAction('publish', 'Publish')
		);
	}
	
	/*function getCMSActions(){
     
	    $actions = parent::getCMSActions();
	     
	    $Action = new FormAction(
	           "doPublish",
	           "Publish"
	        );
	    $actions->push($Action);
	     
	    return $actions;
	}*/
	
	public function publish($data, $form) { 
		
		//debug::show($data);
	
	   	$company = false;
		if(isset($data['ID']) && $data['ID']) {
			$company = DataObject::get_by_id("Location", $data['ID']);
		}

		if(!$company) {
			$company = new Company();
		}
		
		//$company = new Download();
		$form->saveInto($company);
		//$company->DownloadHolderID = $this->dataRecord->ID;
		//$company->write();
		//debug::show($company);
		
		$company->Status = "Published";
		$company->writeToStage("Stage");
		$company->publish("Stage", "Live");
		
		if(isset($data['ID']) && $data['ID']) {
			$form->sessionMessage(
				'Company saved',
				'good'
			);
		} else {
			$form->sessionMessage(
				'Company added',
				'good'
			);
		}
	}
		
	function onBeforeWrite() {
		//if (!$this->ID) {
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
		//}
		parent::onBeforeWrite();
	}

}

?>