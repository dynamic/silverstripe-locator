<?php

class Locator extends Page {
	
	private static $db = array(
		'AutoGeocode' => 'Boolean',
		'ModalWindow' => 'Boolean'
	);
	
	private static $defaults = array(
		'AutoGeocode' => true
	);
	
	private static $singular_name = "Locator";
    private static $plural_name = "Locators";
    private static $description = 'Find locations on a map';
    
    public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    
	    // Locations Grid Field
		$config = GridFieldConfig_RecordEditor::create();	
	    $fields->addFieldToTab("Root.Locations", GridField::create("Locations", "Locations", Location::get(), $config));
	    
	    // Location categories
	    $config = GridFieldConfig_RecordEditor::create();
	    $fields->addFieldToTab("Root.Categories", GridField::create("Categories", "Categories", LocationCategory::get(), $config));

	    // Settings
	    $fields->addFieldsToTab('Root.Settings', array(
	    	HeaderField::create('DisplayOptions', 'Display Options', 3),
	    	CheckboxField::create('AutoGeocode', 'Auto Geocode - Automatically filter map results based on user location'),
	    	CheckboxField::create('ModalWindow', 'Modal Window - Show Map results in a modal window')
	    ));
	    
	    return $fields;
    }
	
}

class Locator_Controller extends Page_Controller {

	// allowed actions
	private static $allowed_actions = array('xml');
	
	// Set Requirements based on input from CMS
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
			fullMapStart: true,
			storeLimit: 1000,
			maxDistance: true,';
		}
		
		// in page or modal
		if ($this->ModalWindow) {
			$modal = 'modalWindow: true';
		} else {
			$modal = 'modalWindow: false';
		}		

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
		      	slideMap: false,
		      	zoomLevel: 0,
			  	distanceAlert: 120,
			  	formID: 'Form_LocationSearch',
			  	inputID: 'Form_LocationSearch_address',
			  	categoryID: 'Form_LocationSearch_category'
		      });
		    });
		");
		
	}		
	
	/**
	 * Find all locations for map
	 * 
	 * By default, will return a XML feed of all locations marked "show in locator".
	 * 
	 * If Locator::set_datasource('http:www.example.com') is set in _config.php, Locator will look 
	 * for a JSON feed and return the results.
	 * 
	 * @access public
	 * @return XML file
	 */
	public function xml() {
		
		$Locations = Location::get()->filter(array('ShowInLocator' => true))->exclude('Lat', 0);
			
		return $this->customise(array(
			'Locations' => $Locations
		))->renderWith('LocationXML');
		
	}	
	
	
	/**
	 * LocationSearch form.
	 *
	 * Search form for locations, updates map and results list via AJAX
	 * 
	 * @access public
	 * @return Form
	 */
	public function LocationSearch() {
		$fields = FieldList::create(
			$address = TextField::create('address', '')
		);
		$address->setAttribute('placeholder', 'address or zip code');
		
		if (LocationCategory::get()->Count() > 0) {
			$fields->push(DropdownField::create('category', '', LocationCategory::get()->map('Title', 'Title'))->setEmptyString('Select Category'));
		}
		
		$actions = FieldList::create(
			FormAction::create('', 'Search')
		);
		
		return Form::create($this, 'LocationSearch', $fields, $actions);
		
	}
	
}