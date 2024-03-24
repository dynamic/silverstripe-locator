<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Model\Location;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\BuildTask;

/**
 * Class EmailAddressTask
 * @package Dynamic\Locator\Tasks
 */
class EmailAddressTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Email Address Task'; // title of the script

    /**
     * @var string
     */
    protected $description = "Convert depreciated 'Email Address' field to new 'Email' field.";

    /**
     * @param HTTPRequest $request
     */
    public function run($request)
    {
        Config::modify()->set('DataObject', 'validation_enabled', false);

        $ct = 0;
        $updateEmail = function ($location) use (&$ct) {
            if (!$location->Email && $location->EmailAddress) {
                $location->Email = $location->EmailAddress;
                $location->write();
                ++$ct;
            }
        };

        Location::get()->each($updateEmail);
        Config::modify()->set('DataObject', 'validation_enabled', true);

        echo '<p>' . $ct . ' Locations updated</p>';
    }
}
