<?php

namespace Dynamic\Locator\Tasks;

use SilverStripe\Dev\BuildTask;

class EmailAddressTask extends BuildTask
{
    protected $title = 'Email Address Task'; // title of the script
    protected $description = "Convert depreciated 'Email Address' field to new 'Email' field."; // description of what it does

    public function run($request)
    {
        Config::inst()->update('DataObject', 'validation_enabled', false);
        $ct = 0;
        $updateEmail = function ($location) use (&$ct) {
            if (!$location->Email && $location->EmailAddress) {
                $location->Email = $location->EmailAddress;
                $location->write();
                ++$ct;
            }
        };
        Location::get()->each($updateEmail);
        Config::inst()->update('DataObject', 'validation_enabled', true);
        echo '<p>'.$ct.' Locations updated</p>';
    }
}
