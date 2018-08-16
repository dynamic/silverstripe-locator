<?php

namespace Dynamic\Locator;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Permission;

/**
 * Class Location
 *
 * @property string $Title
 * @property bool $Featured
 * @property string $Website
 * @property string $Phone
 * @property string $Email
 * @property string $EmailAddress
 * @property string $Fax
 * @property int $Import_ID
 *
 * @method ManyManyList Categories
 */
class Location extends DataObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Location';

    /**
     * @var string
     */
    private static $plural_name = 'Locations';

    /**
     * @var bool
     */
    private static $versioned_gridfield_extensions = true;

    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'Featured' => 'Boolean',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'Email' => 'Varchar(255)',
        'Fax' => 'Varchar(45)',
        'Import_ID' => 'Int',
    );

    private static $many_many = [
        'Categories' => LocationCategory::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'Location';

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
        'City',
        'State',
        'PostalCode',
        'Country',
        'Website',
        'Phone',
        'Email',
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
        'City',
        'State',
        'PostalCode',
        'Country',
        'Featured.NiceAsBoolean',
        'Coords',
    );

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
        $labels['PostalCode'] = 'Postal Code';
        $labels['Category.Name'] = 'Category';
        $labels['Category.ID'] = 'Category';
        $labels['Featured.NiceAsBoolean'] = 'Featured';
        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'Import_ID',
        ));

        $fields->dataFieldByName('Website')
            ->setAttribute('placeholder', 'http://');

        $fields->replaceField('Email', EmailField::create('Email'));

        $featured = $fields->dataFieldByName('Featured')
            ->setDescription('Location will display near the top of the results list');
        $fields->insertAfter(
            $featured,
            'CategoryID'
        );

        // allow to be extended via DataExtension
        $this->extend('updateLocationFields', $fields);

        return $fields;
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canView($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canEdit($member = null, $context = [])
    {
        return Permission::check('Location_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canDelete($member = null, $context = [])
    {
        return Permission::check('Location_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
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
