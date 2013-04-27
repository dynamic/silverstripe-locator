<?php

class Locator extends Page {
	
	static $db = array(
		'FilterByCategory' => 'Boolean',
		'AutoGeocode' => 'Boolean',
		'ModalWindow' => 'Boolean'
	);
	
	static $defaults = array(
		'FilterByCategory' => true,
		'AutoGeocode' => true
	);
	
	// variable holder for custom data source url
	public static $datasource = null;
	
	// get custom data source url
	public static function get_datasource() {
		return self::$datasource;
	}
	
	// allow custom data source url to be set via _config.php
	static public function set_datasource($datasource) {
		self::$datasource = $datasource;
	}
	
	public static $singular_name = "Locator";
    public static $plural_name = "Locators";
    static $description = 'Find locations on a map';
    
    public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    
	    // Locations Grid Field
		$config = GridFieldConfig_RecordEditor::create();	
		//$config->addComponent(new GridFieldBulkEditingTools());
	    $fields->addFieldToTab("Root.Locations", GridField::create("Locations", "Locations", Location::get(), $config));

	    // Settings
	    $fields->addFieldsToTab('Root.Settings', array(
	    	HeaderField::create('DisplayOptions', 'Display Options', 3),
	    	CheckboxField::create('AutoGeocode', 'Auto Geocode - Automatically filter map results based on user location'),
	    	CheckboxField::create('FilterByCategory', 'Filter by Category - allow user to filter map results by category'),
	    	CheckboxField::create('ModalWindow', 'Modal Window - Show Map results in a modal window'),
	    	HeaderField::create('DataOptions', 'Data Options', 3),
	    ));
	    
	    return $fields;
    }
    
    public function getAllCategories() {
	    return LocationCategory::get();
    }
    
    public function getDataLocation() {
	    if (self::get_datasource()) {
			$dataLocation = self::get_datasource();
		} else {
			$dataLocation = getDataLocation();
		}
		return $dataLocation;
    }
	
}

class Locator_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
		Requirements::javascript('framework/thirdparty/jquery/jquery.js');
		Requirements::javascript('http://maps.google.com/maps/api/js?sensor=false');
		Requirements::javascript('locator/thirdparty/jquery-store-locator/js/handlebars-1.0.rc.1.min.js');
		Requirements::javascript('locator/thirdparty/jquery-store-locator/js/jquery.storelocator.js');
		
		Requirements::css('locator/css/map.css');

		// map config based on user input in Settings tab
		// AutoGeocode or Full Map
		if ($this->AutoGeocode) {
			$load = 'autoGeocode: true,
			fullMapStart: false,';
		} else {
			$load = 'autoGeocode: false,
			fullMapStart: true,';
		}
		
		// in page or modal
		if ($this->ModalWindow) {
			$modal = 'modalWindow: true';
		} else {
			$modal = 'modalWindow: false';
		}
		
		// data source
		

		// init map		
		Requirements::customScript("
			$(function($) {
		      $('#map-container').storeLocator({
		      	" . $load . "
		      	dataLocation: '" . $this->Link() . "xml.xml',
		      	listTemplatePath: '/locator/templates/location-list-description.html',
		      	infowindowTemplatePath: '/locator/templates/infowindow-description.html',
		      	originMarker: true,
		      	" . $modal . ",
		      	slideMap: false
		      });
		    });
		");
		
	}	
	
	// Return all locations, render in XML file 
	public function xml() {
		if (self::get_datasource()) {
			
		    $service = new RestfulService(self::get_datasource()); 
			
			return $service->request()->getBody();
			
		} else {
		
			$Locations = Location::get();
			
			return $this->customise(array(
				'Locations' => $Locations
			))->renderWith('LocationXML');
		}
		
	}	
}