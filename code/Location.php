<?php

class Location extends DataObject implements PermissionProvider{

	static $db = array(
		'Title' => 'Varchar(255)',
		'Featured' => 'Boolean',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'ShowInLocator' => 'Boolean'
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

	// search fields for Model Admin
	private static $searchable_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Website',
		'Phone',
		'EmailAddress',
		'Category.ID',
		'ShowInLocator',
		'Featured'
	);

	// columns for grid field
	static $summary_fields = array(
		'Title',
		'Address',
		'Suburb',
		'State',
		'Postcode',
		'Country',
		'Category.Name',
		'ShowInLocator.NiceAsBoolean',
		'Featured.NiceAsBoolean',
		'Coords'
	);

	// Coords status for $summary_fields
	public function getCoords() {
		return ($this->Lat != 0 && $this->Lng != 0) ? 'true' : 'false';
	}

	// custom labels for fields
	function fieldLabels($includerelations = true) {
		$labels = parent::fieldLabels();

		$labels['Title'] = 'Name';
		$labels['Suburb'] = "City";
		$labels['Postcode'] = 'Postal Code';
		$labels['ShowInLocator'] = 'Show';
		$labels['ShowInLocator.NiceAsBoolean'] = 'Show';
		$labels['Category.Name'] = 'Category';
		$labels['EmailAddress'] = 'Email';
		$labels['Featured.NiceAsBoolean'] = 'Featured';
		$labels['Coords'] = 'Coords';

		return $labels;
	}

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->insertBefore(HeaderField::create('InfoHeader', 'Contact Information'), 'Title');
		$fields->insertAfter($featuredField = CheckboxField::create('Featured'), 'EmailAddress');
		$fields->insertAfter(TextField::create('Website'), 'EmailAddress');

		$featuredField->setDescription('Location will show at/near the top of the results list');
		$showField = $fields->dataFieldByName('ShowInLocator');
		$showField
			->setTitle('Show in results')
			->setDescription('Location will be included in results list');

		// If categories have been created, show category drop down
		if (LocationCategory::get()->Count() > 0) {
			$fields->insertAfter($categoryField = DropDownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title')), 'Website');
		}
		$categoryField->setEmptyString('-- select --');

		// allow to be extended via DataExtension
		$this->extend('updateCMSFields', $fields);

		return $fields;
	}

	public function validate() {
		$result = parent::validate();

		return $result;
	}

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canView($member = false) {
		//return Permission::check('Location_VIEW');
		return true;
	}

	public function canEdit($member = false) {
		return Permission::check('Location_EDIT');
	}

	public function canDelete($member = false) {
		return Permission::check('Location_DELETE');
	}

	public function canCreate($member = false) {
		return Permission::check('Location_CREATE');
	}

	public function providePermissions() {
		return array(
			//'Location_VIEW' => 'Read a Location',
			'Location_EDIT' => 'Edit a Location',
			'Location_DELETE' => 'Delete a Location',
			'Location_CREATE' => 'Create a Location'
		);
	}

  public function onBeforeWrite(){
    parent::onBeforeWrite();
  }

}