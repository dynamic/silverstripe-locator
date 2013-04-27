<?php

class Locator extends Page {
	
	public static $singular_name = "Locator";
    public static $plural_name = "Locators";
    static $description = 'Find locations on a map';
    
    public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    
	    // Locations
		$config = GridFieldConfig_RecordEditor::create();	
		//$config->addComponent(new GridFieldBulkEditingTools());
	    
		$LocationField = GridField::create("Locations", "Locations", Location::get(), $config);
	    
	    $fields->addFieldToTab("Root.Locations", $LocationField);
	    
	    return $fields;
    }
    
    public function getAllCategories() {
	    return LocationCategory::get();
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

		// init map		
		Requirements::customScript("
			$(function($) {
		      $('#map-container').storeLocator({
		      	autoGeocode: true,
		      	dataLocation: '" . $this->Link() . "xml.xml',
		      	listTemplatePath: '/locator/templates/location-list-description.html',
		      	infowindowTemplatePath: '/locator/templates/infowindow-description.html',
		      	originMarker: true,
		      	fullMapStart: false,
		      	slideMap: true,
		      	modalWindow: false
		      });
		    });
		");
		
	}	
	
	// Return all locations, render in XML file 
	public function xml() {
		return $this->customise(array(
			'Locations' => Location::get()
		))->renderWith('LocationXML');

	}	
}