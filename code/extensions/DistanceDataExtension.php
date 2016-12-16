<?php

namespace Dynamic\Locator;

use SilverStripe\ORM\DataExtension,
    SilverStripe\ORM\Queries\SQLSelect,
    SilverStripe\ORM\DataQuery,
    SilverStripe\Control\Controller;

class DistanceDataExtension extends DataExtension
{
    /**
     * @param SQLSelect $query
     * @param DataQuery|null $dataQuery
     */
    public function augmentSQL(SQLSelect $query, DataQuery $dataQuery = null)
    {
        $address = Controller::curr()->getRequest()->getVar('Address');
        if ($this->owner->hasMethod('updateAddressValue')) {
            $address = $this->owner->updateAddressValue($address);
        }
        if (class_exists('GoogleGeocoding')) {
            if ($address) { // on frontend
                $coords = GoogleGeocoding::address_to_point($address);

                $Lat = $coords['lat'];
                $Lng = $coords['lng'];

                $query
                    ->addSelect(array(
                        '( 3959 * acos( cos( radians(' . $Lat . ') ) * cos( radians( `Lat` ) ) * cos( radians( `Lng` ) - radians(' . $Lng . ') ) + sin( radians(' . $Lat . ') ) * sin( radians( `Lat` ) ) ) ) AS distance',
                    ));
            }
        }
    }
}
