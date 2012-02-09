<?php

class LocationPage extends Page {
	
	static $many_many = array(
		'Locations' => 'Location'
	);
	
	static $extensions = array(
		"Versioned('Stage', 'Live')"
	);
	
	static $map_key = '';
	
	static function set_map_key($mapKey) {
		self::$map_key = $mapKey;
	}
	
	public function getCMSFields() {	
		$f = parent::getCMSFields();
		$f->addFieldToTab("Root.Content.Locations", new ManyManyDataObjectManager(
			$this,
			'Locations',
			'Location',
			array('Name' => 'Name','City'=>'City','State' => 'State'),
			'getCMSFields_forPopup'
		));
        return $f;
	} 
	
	/**
	 * Publishing Versioning support.
	 *
	 * When publishing copy the editable form fields to the live database
	 * Not going to version emails and submissions as they are likely to 
	 * persist over multiple versions
	 *
	 * @return void
	 */
	public function doPublish() {

		// publish the draft pages
		if($this->Locations()) {
			foreach($this->Locations() as $location) {
				$location->doPublish('Stage', 'Live');
			}
		}

		parent::doPublish();
	}

	/**
	 * Unpublishing Versioning support
	 * 
	 * When unpublishing the page it has to remove all the fields from 
	 * the live database table
	 *
	 * @return void
	 */
	public function doUnpublish() {
		if($this->Locations()) {
			foreach($this->Locations() as $location) {
				$location->doDeleteFromStage('Live');
			}
		}

		parent::doUnpublish();
	}
	
	public function doRevertToLive() {
		if($this->Locations()) {
			foreach($this->Locations() as $location) {
				$location->publish("Live", "Stage", false);
				$location->writeWithoutVersion();
			}
		}

		parent::doRevertToLive();
	}

}

class LocationPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		Requirements::css('locations/css/locations.css');
		Requirements::javascript('http://maps.google.com/maps?file=api&v=2&key='.Location::$map_key);
		Requirements::javascript('locations/javascript/locations.js');
		Requirements::javascript('locations/javascript/map_init.js');
	}	
	
	
	function MapXML($radius = 25) {
		
		// Get parameters from URL
		if (isset($_GET["lat"])) $center_lat = $_GET["lat"];
		if (isset($_GET["lng"])) $center_lng = $_GET["lng"];
		if (isset($_GET["radius"])) $radius = $_GET["radius"];
		if (isset($_GET["address"])) $address = $_GET["address"];
		if (isset($_GET["all"])) $all = $_GET['all'];
		
		// save address as query
		if (!isset($all)) {
			$LocationQuery = new LocationQuery();
			$LocationQuery->Name = $address;
			$LocationQuery->Radius = $radius;
			$LocationQuery->QueryDate = date('Y-m-d h:i:s');
			$LocationQuery->write();
		}
		
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);
		
		// Search the rows in the markers table
		if (isset($all)) {
			//$LocationList = DataObject::get('Location', 'ShowInLocator = 1');
			$LocationList = $this->Locations();
		} else {
			$LocationList = $this->GetLocationList($center_lat, $center_lng, $radius);
		}
		
		//debug::show($this->getRequest()->getVar('stage'));
		
		//debug::show($LocationList);
		header("Content-type: text/xml");
		
		// Iterate through the rows, adding XML nodes for each
		//while ($row = @mysql_fetch_assoc($result)){
		//debug::show($LocationList);
		if ($LocationList) {
			foreach ($LocationList as $Location) {
			
			  // record Location result
			  if (!isset($all)) {			  
				  $LocationResult = new LocationResult();
				  $LocationResult->LocationID = $Location->ID;
				  $LocationResult->QueryDate = date('Y-m-d h:i:s');
				  $LocationResult->LocationQueryID = $LocationQuery->ID;
				  $LocationResult->write();
			  }
			  
			  // return XML
			  $address = $Location->Address . ", ";
			  if ($Location->Address2) $address .= $Location->Address2 . ', ';
			  $address .= $Location->City . ", " . $Location->State . " " . $Location->Zip;
			  $node = $dom->createElement("marker");
			  $newnode = $parnode->appendChild($node);
			  //debug::show($Location);
			  $newnode->setAttribute("name", $Location->Name);
			  $newnode->setAttribute("address", $Location->Address);
			  if ($Location->Address2) $newnode->setAttribute("address2", $Location->Address2);
			  $newnode->setAttribute("city", $Location->City);
			  $newnode->setAttribute("state", $Location->State);
			  $newnode->setAttribute("zipcode", $Location->Zip);
			  $newnode->setAttribute('country', $Location->Country);
			  $newnode->setAttribute("website", $Location->Website);
			  $newnode->setAttribute("phone", $Location->Phone);
			  $newnode->setAttribute("lat", $Location->Lat);
			  if (isset($all)) {
			  	$newnode->setAttribute("lng", $Location->Long);
			  } else {
			  	$newnode->setAttribute("lng", $Location->Lng);
			  }
			  if (!isset($all)) $newnode->setAttribute("distance", $Location->distance);
			}
		}
		echo $dom->saveXML();
	}
	
	function GetLocationList($Lat, $Lng, $Radius) {
				
		$sqlQuery = new SQLQuery();
		
		//debug::show($this->baseForumTable());
	
		$sqlQuery->select = array(
		  '( 3959 * acos( cos( radians('.$Lat.') ) * cos( radians( `Lat` ) ) * cos( radians( `Long` ) - radians('.$Lng.') ) + sin( radians('.$Lat.') ) * sin( radians( `Lat` ) ) ) ) AS distance',
		  $this->baseForumTable() . '.Name AS Name',
		  $this->baseForumTable() . '.Address AS Address',
		  $this->baseForumTable() . '.Address2 AS Address2',
		  $this->baseForumTable() . '.City AS City',
		  $this->baseForumTable() . '.State AS State',
		  $this->baseForumTable() . '.ZipCode AS Zip',
		  $this->baseForumTable() . '.Country AS Country',
		  $this->baseForumTable() . '.Website AS Website',
		  $this->baseForumTable() . '.Phone AS Phone',
		  $this->baseForumTable() . '.Lat AS Lat',
		  $this->baseForumTable() . '.Long AS Lng',
		  $this->baseForumTable() . '.ClassName AS ClassName',
		  $this->baseForumTable() . '.ClassName AS RecordClassName',
		  $this->baseForumTable() . '.ID AS ID',
		);
		$sqlQuery->from = array(
		  $this->baseForumTable() . ' LEFT JOIN LocationPage_Locations ON ' . $this->baseForumTable() . '.ID = LocationPage_Locations.LocationID'
		);
		
		$sqlQuery->where = array(
			'LocationPage_Locations.LocationPageID = ' . $this->ID
		);
		
		$sqlQuery->having = array(
		  "distance < " . $Radius
		);
		$sqlQuery->limit = '0 , 15';
		$sqlQuery->orderby = 'distance';
		 
		$result = $sqlQuery->execute();
 
		return singleton('Location')->buildDataObjectSet($result);
	}
	
	// live or stage? return correct DB table for custom query
	static function baseForumTable() {
		$stage = (Versioned::current_stage()) == "Live" ? false : true;
		
		//debug::show($stage);
		
		if (!$stage) $stage = Versioned::get_live_stage();

		if(
			(class_exists('SapphireTest', false) && SapphireTest::is_running_test())
			|| $stage == "Stage"
		) {
			return "Location";
		} else {
			return "Location_Live";
		}
	}
	
	
	
	// query reporting
	public function report() {
	
		$filter = 0;
		if(Director::urlParam('ID')) {
			$filterTmp = Director::urlParam('ID');
			$filterTmp = str_replace('-', '/', $filterTmp);
			//debug::show($filterTmp);
			
			$filter = "QueryDate BETWEEN '" . $filterTmp . "/01' AND '" . $filterTmp . "/31'";
		} else {
			$filter = "QueryDate BETWEEN '". date('Y/m') . "/01' AND '" . date('Y/m') . "/31'";
		}
		
		//debug::show($filter);
		
		$Queries = DataObject::get('LocationQuery', $filter, 'LocationQuery.Name');
						
		$Locations = DataObject::get('LocationResult', $filter);
		
		$sqlQuery = new SQLQuery(); 
		$sqlQuery->select = array( 
			'DISTINCT YEAR(`QueryDate`) AS Year',
			'MONTH(`QueryDate`) AS Month'
		); 
		$sqlQuery->from = array("LocationQuery"); 
		$sqlQuery->orderby = 'QueryDate DESC';

		$rawSQL = $sqlQuery->sql(); 
		$result = $sqlQuery->execute(); 

		$DateFilter = new DataObjectSet(); 
		foreach($result as $row) { 
			$DateFilter->push(new ArrayData($row)); 
			//debug::show($row);
		} 
		//debug::show($DateFilter); 
				
		$page = $this->customise(array(
			'Title' => 'Location Query Report',
			'Locations' => $Locations,
			'Queries' => $Queries,
			'DateFilter' => $DateFilter
		));

		return $page;	
	
	}
	
	// Get current date range of report for title
	function CurrentDateRange() {
	
		$filter = 0;
		if(Director::urlParam('ID')) {
			$filterTmp = Director::urlParam('ID');
			//$filterTmp2 = explode('-', $filterTmp);
			
			$new_date = date('F, Y', strtotime($filterTmp));
				
		} else {
			$new_date = date('F, Y');
		}
		
		return $new_date;
		
	}
	
}

?>