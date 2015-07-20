<?php

class Location extends DataObject implements PermissionProvider
{

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Featured' => 'Boolean',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'EmailAddress' => 'Varchar(255)',
        'ShowInLocator' => 'Boolean',
    );

    private static $has_one = array(
        'Category' => 'LocationCategory'
    );

    private static $casting = array(
        'distance' => 'Int'
    );

    private static $default_sort = 'Title';

    private static $defaults = array(
        'ShowInLocator' => true
    );

    private static $singular_name = "Location";
    private static $plural_name = "Locations";

    // api access via Restful Server module
    private static $api_access = true;

    // search fields for Model Admin
    private static $searchable_fields = array(
        'Title',
        'Address',
        'Suburb',
        'State',
        'Postcode',
        'Country',
        'Category.ID',
        'ShowInLocator',
        'Featured',
        'Website',
        'Phone',
        'EmailAddress'
    );

    // columns for grid field
    private static $summary_fields = array(
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
    public function getCoords()
    {
        return ($this->Lat != 0 && $this->Lng != 0) ? 'true' : 'false';
    }

    // custom labels for fields
    function fieldLabels($includerelations = true)
    {
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

    public function getCMSFields()
    {

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
            $fields->insertAfter(DropDownField::create('CategoryID', 'Category',
                LocationCategory::get()->map('ID', 'Title'))->setEmptyString('-- select --'), 'Phone');
        }

        // move Title and ShowInLocator fields to Address tab from Addressable
        $fields->insertAfter(TextField::create('Title'), 'AddressHeader');
        $fields->insertAfter(CheckboxField::create('Featured', 'Featured'), 'Title');
        $fields->insertAfter(CheckboxField::create('ShowInLocator', 'Show on Map'), 'Country');

        // allow to be extended via DataExtension
        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        return $result;
    }

    /**
     * @param Member $member
     * @return true
     */
    public function canView($member = false)
    {
        return true;
    }

    public function canEdit($member = false)
    {
        return Permission::check('Location_EDIT');
    }

    public function canDelete($member = false)
    {
        return Permission::check('Location_DELETE');
    }

    public function canCreate($member = false)
    {
        return Permission::check('Location_CREATE');
    }

    public function providePermissions()
    {
        return array(
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location'
        );
    }

    public function onBeforeWrite()
    {

        parent::onBeforeWrite();
    }

}