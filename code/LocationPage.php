<?php

class LocationPage extends Page {
	
	static $map_key = '';
	
	static function set_map_key($mapKey) {
		self::$map_key = $mapKey;
	}
	
	public function getCMSFields() {	
		$f = parent::getCMSFields();
		$f->addFieldToTab("Root.Content.Locations", new DataObjectManager(
			$this,
			'Locations',
			'Location',
			array('Name' => 'Name','City'=>'City','State' => 'State'),
			'getCMSFields_forPopup'
		));
        return $f;
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
			'Title' => 'Location Locator Query Report',
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