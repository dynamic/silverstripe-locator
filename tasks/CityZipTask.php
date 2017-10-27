<?php

namespace Dynamic\Locator\Tasks;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\BuildTask;
use Dynamic\Locator\Location;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class CityZipTask
 * @package Dynamic\Locator\Tasks
 */
class CityZipTask extends BuildTask
{

    // title of the script
    protected $title = 'Suburb and Postcode conversion';
    // description of what it does
    protected $description = "Convert depreciated 'Suburb' and 'Postcode' fields to new 'City' and 'ZipCode' fields respectively.";

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     */
    public function run($request)
    {
        // TODO - reads form live and errors
        Config::modify()->set(Location::class, 'validation_enabled', 0);
        echo '<pre>' . print_r(Config::inst()->get(Location::class), true) . '</pre>';
        $ct = 0;
        $update = function ($location) use (&$ct) {
            $didUpdate = false;
            // echo '<pre>' . print_r($location, true) . '</pre>';
            if ( !$location->City && $location->Suburb) {
                $location->City = $location->Suburb;
                $didUpdate = true;
            }

            if (!$location->ZipCode && $location->PostCode) {
                $location->ZipCode = $location->PostCode;
                $didUpdate = true;
            }

            if ($didUpdate) {
                echo '<p>' . $didUpdate . '</p>';
                $location->write();
                ++$ct;
            }
        };
        Location::get()->each($update);
        Config::modify()->set(Location::class, 'validation_enabled', 1);
        echo '<p>' . $ct . ' Locations updated</p>';
    }

}
