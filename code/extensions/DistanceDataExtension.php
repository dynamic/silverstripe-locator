<?php

namespace Dynamic\Locator;

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\DataQuery;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;

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

        if ($address) { // on frontend

            $geocoder = new GoogleGeocoder($address);
            $response = $geocoder->getResult();
            $Lat = $response->getLatitude();
            $Lng = $response->getLongitude();

            $query
                ->addSelect(array(
                    '( 3959 * acos( cos( radians(' . $Lat . ') ) * cos( radians( `Lat` ) ) * cos( radians( `Lng` ) - radians(' . $Lng . ') ) + sin( radians(' . $Lat . ') ) * sin( radians( `Lat` ) ) ) ) AS distance',
                ));
        }
    }
}
