<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Location;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;

/**
 * Class LocationPublishTask
 */
class LocationPublishTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Publish all Locations';
    /**
     * @var string
     */
    protected $description = 'Migration task - pre versioning on Location';
    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @param $request
     */
    public function run($request)
    {
        $class = ($request->getVar('locationclass')) ? $request->getVar('locationclass') : Location::class;
        $this->publishLocations($class);
    }

    /**
     * @param string $class
     * @return Generator
     */
    protected function iterateLocations($class)
    {
        foreach ($class::get()->filter('ShowInLocator', true) as $location) {
            yield $location;
        }
    }

    /**
     * mark all ProductDetail records as ShowInMenus = 0.
     *
     * @param string $class
     */
    public function publishLocations($class)
    {
        if (!isset($class) || !class_exists($class) || !$class instanceof Location) $class = 'Location';
        $ct = 0;
        $publish = function ($location) use (&$ct) {
            if (!$location->isPublished()) {
                $title = $location->Title;
                $location->writeToStage('Stage');
                $location->publish('Stage', 'Live');
                static::write_message($title);
                ++$ct;
            }
        };

        foreach ($this->iterateLocations($class) as $location) {
            $publish($location);
        }

        static::write_message("{$ct} locations updated.");
    }

    /**
     * @param $message
     */
    protected static function write_message($message)
    {
        if (Director::is_cli()) {
            echo "{$message}\n";
        } else {
            echo "{$message}<br><br>";
        }
    }
}