<?php

namespace Dynamic\Locator;

use SilverStripe\Control\Email\Email;
use SilverStripe\Forms\CountryDropdownField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Security\Permission;
use SilverStripe\Dev\Deprecation;
use SilverStripe\i18n\i18n;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;

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
        'Address'  => 'Varchar(255)',
        'Address2' => 'Varchar(255)',
        'City'   => 'Varchar(64)',
        'State'    => 'Varchar(64)',
        'PostalCode' => 'Varchar(10)',
        'Country'  => 'Varchar(2)',
        'Lat' => 'Decimal(10,7)',
        'Lng' => 'Decimal(10,7)',
        'Website' => 'Varchar(255)',
        'Phone' => 'Varchar(40)',
        'Email' => 'Varchar(255)',
        'ShowInLocator' => 'Boolean',
        'Featured' => 'Boolean',
        'Import_ID' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Category' => 'Dynamic\\Locator\\LocationCategory',
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
        'City',
        'State',
        'PostalCode',
        'Country',
        'Website',
        'Phone',
        'Email',
        'Category.ID',
        'ShowInLocator',
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
        'Category.Name',
        'ShowInLocator.NiceAsBoolean',
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
        $labels['City'] = 'City';
        $labels['PostalCode'] = 'Postal Code';
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
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'Import_ID',
        ));

        $fields->replaceField('Country', CountryDropdownField::create('Country'));
        $fields->replaceField('Lat', ReadonlyField::create('Lat'));
        $fields->replaceField('Lng', ReadonlyField::create('Lng'));
        $fields->dataFieldByName('Website')
            ->setAttribute('placeholder', 'http://');
        $fields->replaceField('Email', EmailField::create('Email'));
        $fields->dataFieldByName('ShowInLocator')
            ->setTitle('Show In Locator')
            ->setDescription('Location will be included in results list');
        $fields->dataFieldByName('Featured')
            ->setDescription('Location will display near the top of the results list');
        $fields->replaceField(
            'CategoryID',
            DropdownField::create('CategoryID', 'Category', LocationCategory::get()->map())->setEmptyString('')
        );

        // allow to be extended via DataExtension
        $this->extend('updateLocationFields', $fields);

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
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
        }

        return false;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Location_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canDelete($member = null)
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

    /**
     * Returns the full address as a simple string.
     *
     * @return string
     */
    public function getFullAddress() {
        $parts = array(
            $this->Address,
            $this->Address2,
            $this->City,
            $this->State,
            $this->PostalCode,
            $this->getCountryName()
        );
        return implode(', ', array_filter($parts));
    }

    /**
     * Returns the country name (not the 2 character code).
     *
     * @return string
     */
    public function getCountryName() {
        return \Zend_Locale::getTranslation($this->Country, 'territory',  i18n::get_locale());
    }

    /**
     * @return bool
     */
    public function hasAddress() {
        return (
            $this->Address
            && $this->City
            && $this->State
            && $this->PostalCode
        );
    }

    /**
     * Returns TRUE if any of the address fields have changed.
     *
     * @param int $level
     * @return bool
     */
    public function isAddressChanged($level = 1) {
        $fields  = array('Address', 'City', 'State', 'PostalCode', 'Country');
        $changed = $this->getChangedFields(false, $level);
        foreach ($fields as $field) {
            if (array_key_exists($field, $changed)) return true;
        }
        return false;
    }

    /**
     *
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if ($this->hasAddress()) {
            if (!$this->isAddressChanged()) {
                return;
            }

            if ($address = $this->getFullAddress()) {
                $geocoder = new GoogleGeocoder($address);
                $response = $geocoder->getResult();
                $this->Lat = $response->getLatitude();
                $this->Lng = $response->getLongitude();
            }
        }
    }
}
