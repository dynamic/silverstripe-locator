<?php

namespace Dynamic\Locator\Page;

use Dynamic\Locator\Model\LocationCategory;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\EmailField;
use SilverStripe\Security\Permission;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

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
class LocationPage extends \Page implements PermissionProvider
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
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Featured' => 'Boolean',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'Email' => 'Varchar(255)',
        'Fax' => 'Varchar(45)',
        'Import_ID' => 'Int',
        'LegacyObjectID' => 'Int',
    ];

    private static $many_many = [
        'Categories' => LocationCategory::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'LocationPage';

    /**
     * @var array
     */
    private static $casting = [
        'distance' => 'Decimal(9,3)',
    ];

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
    private static $searchable_fields = [
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
    ];

    /**
     * columns for grid field
     *
     * @var array
     */
    private static $summary_fields = [
        'Title',
        'Address',
        'Address2',
        'City',
        'State',
        'PostalCode',
        'CountryCode',
        'Phone' => 'Phone',
        'Fax' => 'Fax',
        'Email' => 'Email',
        'Website' => 'Website',
        'Featured',
        'CategoryList',
        'Lat',
        'Lng',
        'Import_ID',
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
     * @return string
     */
    public function getCategoryList()
    {
        if ($this->Categories()->count()) {
            return implode(', ', $this->Categories()->column('Name'));
        }

        return '';
    }

    /**
     * @return bool|string
     */
    public function getCountryCode()
    {
        if ($this->Country) {
            return strtoupper($this->Country);
        }

        return false;
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
        $labels['Address2'] = 'Address 2';
        $labels['PostalCode'] = 'Postal Code';
        $labels['Categories.Name'] = 'Categories';
        $labels['Featured.NiceAsBoolean'] = 'Featured';

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldsToTab(
                'Root.Main',
                [
                    CheckboxField::create('Featured')
                        ->setTitle('Featured'),
                    TextField::create('Website')
                        ->setTitle('Website')
                        ->setDescription('Include the http/https (example: https://google.com)'),
                    TextField::create('Phone')
                        ->setTitle('Phone'),
                    EmailField::create('Email')
                        ->setTitle('Email'),
                    TextField::create('Fax')
                        ->setTitle('Fax'),
                ],
                'Content'
            );

            if ($this->exists()) {
                $fields->addFieldToTab(
                    'Root.Categories',
                    GridField::create(
                        'Categories',
                        'Categories',
                        $this->Categories(),
                        $catConfig = GridFieldConfig_RelationEditor::create()
                    )
                );

                $catConfig->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                ])->addComponents([
                    new GridFieldAddExistingSearchButton()
                ]);
            }
        });

        return parent::getCMSFields();
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
        return [
            'Location_EDIT' => 'Edit a Location',
            'Location_DELETE' => 'Delete a Location',
            'Location_CREATE' => 'Create a Location',
        ];
    }

    /**
     * @return string
     */
    public function getWebsiteURL()
    {
        $url = $this->Website;

        $this->extend('updateWebsiteURL', $url);

        return $url;
    }
}
