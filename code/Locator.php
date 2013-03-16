<?php

class Locator extends Page {
	
	public static $singular_name = "Locator";
    public static $plural_name = "Locators";
    static $description = 'Find locations on a map';
	
}

class Locator_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
		Requirements::javascript('framework/thirdparty/jquery/jquery.js');
		Requirements::javascript('http://maps.google.com/maps/api/js?sensor=false');
		Requirements::javascript('locator/javascript/jQuery-Store-Locator-Plugin/js/handlebars-1.0.rc.1.min.js');
		Requirements::javascript('locator/javascript/jQuery-Store-Locator-Plugin/js/jquery.storelocator.js');
		
		Requirements::css('locator/css/map.css');

		// init map		
		Requirements::customScript("
			$(function($) {
		      $('#map-container').storeLocator({
		      	autoGeocode: true,
		      	dataLocation: '" . $this->Link() . "xml.xml',
		      	listTemplatePath: '/locator/templates/Includes/location-list-description.html',
		      	infowindowTemplatePath: '/locator/templates/Includes/infowindow-description.html',
		      	originMarker: true,
		      	fullMapStart: false
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