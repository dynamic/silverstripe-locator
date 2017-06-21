<?php

/**
 * Class Location
 *
 * @property string $Title
 * @property bool $Featured
 * @property string $Website
 * @property string $Phone
 * @property string $Email
 * @property string $EmailAddress
 * @property bool $ShowInLocator
 * @property int $Import_ID
 * @property int $CategoryID
 * @method LocationCategory $Category
 */
class Location extends DataObject implements PermissionProvider
{

    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'Featured' => 'Boolean',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'Email' => 'Varchar(255)',
        'EmailAddress' => 'Varchar(255)',
        'ShowInLocator' => 'Boolean',
        'Import_ID' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Category' => 'LocationCategory',
    );

    /**
     * @var array
     */
    private static $casting = array(
        'distance' => 'Decimal(9,3)',
    );

    /**
     * @var string
     */
    private static $default_sort = 'Title';

    /**
     * @var array
     */
    private static $defaults = array(
        'ShowInLocator' => true,
    );

    /**
     * @var string
     */
    private static $singular_name = 'Location';
    /**
     * @var string
     */
    private static $plural_name = 'Locations';

    /**
     * api access via Restful Server module
     *
     * @var bool
     */
    private static $api_access = true;

    /**
     * search fields for Model Admin
     *
     * @var array
     */
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
        'Featured',
    );

    /**
     * columns for grid field
     *
     * @var array
     */
    private static $summary_fields = array(
        'Title',
        'Address',
        'Suburb',
        'State',
        'Postcode',
        'Country',
        'Category.Name',
        'Featured.NiceAsBoolean',
        'Coords',
    );

    /**
     * @var array
     */
    private static $extensions = [
        'Dynamic\ViewableDataObject\Extensions\VersionedDataObject',
    ];

    /**
     * Coords status for $summary_fields
     *
     * @return string
     */
    public function getCoords()
    {
        return ($this->Lat != 0 && $this->Lng != 0) ? 'true' : 'false';
    }

    /**
     * custom labels for fields
     *
     * @param bool $includerelations
     * @return array|string
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

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
        $labels['Import_ID'] = 'Import_ID';

        return $labels;
    }

    /**
     * @return FieldList
     */
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
                    DropdownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title'))
                        ->setEmptyString('-- select --'),
                    CheckboxField::create('Featured')
                        ->setDescription('Location will show at/near the top of the results list')
                )
            )
        );

        // allow to be extended via DataExtension
        $this->extend('updateCMSFields', $fields);

        $fields->removeByName([
            'ShowInLocator',
            'Import_ID',
        ]);

        // override Suburb field name
        $fields->dataFieldByName('Suburb')->setTitle('City');

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        return $result;
    }

    /**
     * @return bool|string
     */
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

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location',
        );
    }

}
