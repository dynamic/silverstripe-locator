<?php

class Location extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'Fax' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'ShowInLocator' => 'Boolean',
	);
		
	static $casting = array(
		'distance' => 'Int'
	);
	
	static $default_sort = 'Title';
	
	static $summary_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Lat',
		'Lng'
	);	
 
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldsToTab('Root.Main', array(
			TextField::create('Title'),
			TextField::create('Website'),
			TextField::create('Phone'),
			TextField::create('Fax'),
			TextField::create('EmailAddress'),
			CheckboxField::create('ShowInLocator')
		));
		
		return $fields;
	}
			
}