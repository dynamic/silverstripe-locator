<?php

class Location extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)',
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

	// api access
	static $api_access = true;
	
	static $summary_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Category.Name',
		//'Website',
		//'EmailAddress',
		//'Phone'
	);	

	function fieldLabels($includerelations = true) {
     	$labels = parent::fieldLabels();

     	$labels['Title'] = 'Name';
     	$labels['Suburb'] = "City";
     	$labels['Postcode'] = 'Postal Code';
     	$labels['ShowInLocator'] = 'Show';
     	$labels['Category.Name'] = 'Category';
     	$labels['EmailAddress'] = 'Email';

     	return $labels;
   	}
 
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		
		// remove Main tab
     	$fields->removeByName('Main');
		
		$fields->addFieldsToTab('Root.Info', array(
			HeaderField::create('InfoHeader', 'Contact Information'),
			TextField::create('Website'),
			TextField::create('EmailAddress'),
			TextField::create('Phone')
		));
		
		if (LocationCategory::get()->Count() > 0) {
			$fields->insertAfter(DropDownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title'))->setEmptyString('-- select --'), 'Phone');
		}
		
		$fields->insertAfter(TextField::create('Title'), 'AddressHeader');
		$fields->insertAfter(CheckboxField::create('ShowInLocator', 'Show on Map'), 'Country');
				
		return $fields;
	}
	
	public function canView($member = null) {
		return true;
	}
			
}