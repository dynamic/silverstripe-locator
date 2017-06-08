<?php

namespace Dynamic\Locator;

use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataExtension;

class AddressDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'Address'  => 'Varchar(255)',
        'Address2' => 'Varchar(255)',
        'City'   => 'Varchar(64)',
        'State'    => 'Varchar(64)',
        'PostalCode' => 'Varchar(10)',
        'Country'  => 'Varchar(2)',
        'Lat' => 'Decimal(10,7)',
        'Lng' => 'Decimal(10,7)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        //$fields->replaceField('Country', CountryDropdownField::create('Country')); /
        /// CountryDropdownField is removed from SS4

        $fields->replaceField('Lat', ReadonlyField::create('Lat'));
        $fields->replaceField('Lng', ReadonlyField::create('Lng'));

        $fields->addFieldsToTab('Root.Address', [
            $fields->dataFieldByName('Address'),
            $fields->dataFieldByName('Address2'),
            $fields->dataFieldByName('City'),
            $fields->dataFieldByName('State'),
            $fields->dataFieldByName('PostalCode'),
            $fields->dataFieldByName('Country'),
            $fields->dataFieldByName('Lat'),
            $fields->dataFieldByName('Lng'),
        ]);
    }

    /**
     * Returns the full address as a simple string.
     *
     * @return string
     */
    public function getFullAddress() {
        $parts = array(
            $this->owner->Address,
            $this->owner->Address2,
            $this->owner->City,
            $this->owner->State,
            $this->owner->PostalCode,
            $this->owner->Country,
        );
        return implode(', ', array_filter($parts));
    }

    /**
     * @return bool
     */
    public function hasAddress() {
        return (
            $this->owner->Address
            && $this->owner->City
            && $this->owner->State
            && $this->owner->PostalCode
        );
    }
    /**
     * Returns TRUE if any of the address fields have changed.
     *
     * @param int $level
     * @return bool
     */
    public function isAddressChanged($level = 1) {
        $fields  = array('Address', 'Address2', 'City', 'State', 'PostalCode', 'Country');
        $changed = $this->owner->getChangedFields(false, $level);
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
                $this->owner->Lat = $response->getLatitude();
                $this->owner->Lng = $response->getLongitude();
            }
        }
    }
}