<?php

class DistanceDataExtension extends DataExtension
{
    /**
     * @param SQLQuery $query
     */
    public function augmentSQL(SQLQuery &$query)
    {
        if (Controller::curr()->getRequest()->getVar('Address')) { // on frontend
            $coords = GoogleGeocoding::address_to_point(Controller::curr()->getRequest()->getVar('Address'));

            $Lat = $coords['lat'];
            $Lng = $coords['lng'];

            $query
                ->addSelect(array(
                    '( 3959 * acos( cos( radians('.$Lat.') ) * cos( radians( `Lat` ) ) * cos( radians( `Lng` ) - radians('.$Lng.') ) + sin( radians('.$Lat.') ) * sin( radians( `Lat` ) ) ) ) AS distance',
                ));
        }
    }
}
