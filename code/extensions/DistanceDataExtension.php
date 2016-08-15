<?php

class DistanceDataExtension extends DataExtension
{
    /**
     * @param SQLQuery $query
     */
    public function augmentSQL(SQLQuery &$query)
    {
        $address = Controller::curr()->getRequest()->getVar('Address');
        if ($this->owner->hasMethod('updateAddressValue')) {
            $address = $this->owner->updateAddressValue($address);
        }
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
