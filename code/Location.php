<?php

class Location extends DataObject implements PermissionProvider
{
    private static $db = array(
        'Title' => 'Varchar(255)',
        'Featured' => 'Boolean',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'Email' => 'Varchar(255)',
        'EmailAddress' => 'Varchar(255)',
        'ShowInLocator' => 'Boolean',
    );

    private static $has_one = array(
        'Category' => 'LocationCategory',
    );

    private static $casting = array(
        'distance' => 'Int',
    );

    private static $default_sort = 'Title';

    private static $defaults = array(
        'ShowInLocator' => true,
    );

    private static $singular_name = 'Location';
    private static $plural_name = 'Locations';

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
        'Website',
        'Phone',
        'Email',
        'Category.ID',
        'ShowInLocator',
        'Featured',
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
        'Coords',
    );

    // Coords status for $summary_fields
    public function getCoords()
    {
        return ($this->Lat != 0 && $this->Lng != 0) ? 'true' : 'false';
    }

    // custom labels for fields
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels();

        $labels['Title'] = 'Name';
        $labels['Suburb'] = 'City';
        $labels['Postcode'] = 'Postal Code';
        $labels['ShowInLocator'] = 'Show';
        $labels['ShowInLocator.NiceAsBoolean'] = 'Show';
        $labels['Category.Name'] = 'Category';
        $labels['Category.ID'] = 'Category';
        $labels['Email'] = 'Email';
        $labels['Featured.NiceAsBoolean'] = 'Featured';
        $labels['Coords'] = 'Coords';

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            new TabSet(
                $name = 'Root',
                new Tab(
                    $title = 'Main',
                    HeaderField::create('ContactHD', 'Contact Information'),
                    TextField::create('Title', 'Name'),
                    TextField::create('Phone'),
                    EmailField::create('Email', 'Email'),
                    TextField::create('Website')
                        ->setAttribute('placeholder', 'http://'),
                    DropDownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title'))
                        ->setEmptyString('-- select --'),
                    CheckboxField::create('ShowInLocator', 'Show in results')
                        ->setDescription('Location will be included in results list'),
                    CheckboxField::create('Featured')
                        ->setDescription('Location will show at/near the top of the results list')
                )
            )
        );

        // allow to be extended via DataExtension
        $this->extend('updateCMSFields', $fields);

        // override Suburb field name
        $fields->dataFieldByName('Suburb')->setTitle('City');

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        return $result;
    }

    public function EmailAddress()
    {
        Deprecation::notice('3.0', 'Use "$Email" instead.');
        if ($this->Email) {
            return $this->Email;
        } elseif ($this->EmailAddress) {
            return $this->EmailAddress;
        }

        return false;
    }

    /**
     * @param null|Member $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Location_EDIT', 'any', $member);
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Location_DELETE', 'any', $member);
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('Location_CREATE', 'any', $member);
    }

    public function providePermissions()
    {
        return array(
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location',
        );
    }
}
