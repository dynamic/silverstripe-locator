<?php

class LocationController extends Controller {

	protected $template = "LocationController";
 
	function Link($action = null) {
		return Controller::join_links('LocationController', $action);
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
			$LocationList = DataObject::get('Location', 'ShowInLocator = 1');
		} else {
			$LocationList = $this->GetLocationList($center_lat, $center_lng, $radius);
		}
		
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
	
		$sqlQuery->select = array(
		  '( 3959 * acos( cos( radians('.$Lat.') ) * cos( radians( `Lat` ) ) * cos( radians( `Long` ) - radians('.$Lng.') ) + sin( radians('.$Lat.') ) * sin( radians( `Lat` ) ) ) ) AS distance',
		  'Location.Name AS Name',
		  'Location.Address AS Address',
		  'Location.Address2 AS Address2',
		  'Location.City AS City',
		  'Location.State AS State',
		  'Location.ZipCode AS Zip',
		  'Location.Country AS Country',
		  'Location.Website AS Website',
		  'Location.Phone AS Phone',
		  'Location.Lat AS Lat',
		  'Location.Long AS Lng',
		  'Location.ClassName AS ClassName',
		  'Location.ClassName AS RecordClassName',
		  'Location.ID AS ID',
		);
		$sqlQuery->from = array(
		  "Location"
		);
		
		$sqlQuery->where = array(
			"Location.ShowInLocator = 1"
		);
		
		$sqlQuery->having = array(
		  "distance < " . $Radius
		);
		$sqlQuery->limit = '0 , 15';
		$sqlQuery->orderby = 'distance';
		 
		$result = $sqlQuery->execute();
 
		return singleton('Location')->buildDataObjectSet($result);
	}

}

?>