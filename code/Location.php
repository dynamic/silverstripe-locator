<?php

class Location extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)',
		'Featured' => 'Boolean',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'ShowInLocator' => 'Boolean',
	);
	
	static $has_one = array(
		'Category' => 'LocationCategory'
	);
		
	static $casting = array(
		'distance' => 'Int'
	);
	
	static $default_sort = 'Title';

	static $defaults = array(
		'ShowInLocator' => true
	);
	
	public static $singular_name = "Location";
	public static $plural_name = "Locations";

	// api access via Restful Server module
	static $api_access = true;
	
	// columns for grid field
	static $summary_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Category.Name',
		'Show',
		'Feature'
	);

	// LocatorStatus for $summary_fields
	public function getShow() {
		return $this->obj('ShowInLocator')->Nice();
	}

	public function getFeature(){
		return ($this->Featured) ? 'true' : 'false';
	}

	function fieldLabels($includerelations = true) {
     	$labels = parent::fieldLabels();

     	$labels['Title'] = 'Name';
     	$labels['Suburb'] = "City";
     	$labels['Postcode'] = 'Postal Code';
     	$labels['ShowInLocator'] = 'Show';
     	$labels['Category.Name'] = 'Category';
     	$labels['EmailAddress'] = 'Email';
		$labels['Feature'] = 'Featured';

     	return $labels;
   	}
 
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		
		// remove Main tab
     	$fields->removeByName('Main');
		
		// create and populate Info tab
		$fields->addFieldsToTab('Root.Info', array(
			HeaderField::create('InfoHeader', 'Contact Information'),
			TextField::create('Website'),
			TextField::create('EmailAddress'),
			TextField::create('Phone')
		));
		
		// change label of Suburb from Addressable to City
		$fields->removeByName('Suburb');
		$fields->insertBefore(TextField::create('Suburb', 'City'), 'State');
		
		// If categories have been created, show category drop down
		if (LocationCategory::get()->Count() > 0) {
			$fields->insertAfter(DropDownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title'))->setEmptyString('-- select --'), 'Phone');
		}
		
		// move Title and ShowInLocator fields to Address tab from Addressable
		$fields->insertAfter(TextField::create('Title'), 'AddressHeader');
		$fields->insertAfter(CheckboxField::create('Featured', 'Featured'), 'Title');
		$fields->insertAfter(CheckboxField::create('ShowInLocator', 'Show on Map'), 'Country');

		$this->extend('updateCMSFields', $fields);
				
		return $fields;
	}
	
	// allow locations to be viewed by non logged in users. Useful for ModelAdmin, API
	public function canView($member = null) {
		return true;
	}
			
}