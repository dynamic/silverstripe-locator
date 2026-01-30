<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Location;
use Dynamic\Locator\Page\LocationPage;
use Dynamic\Locator\Page\Locator;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Versioned\Versioned;

/**
 * Class LocationToPageTask
 * @package Dynamic\Locator\Tasks
 */
class LocationToPageTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Locator - Location to Page Task';

    /**
     * @var string
     */
    private static $segment = 'locator-location-to-page-task';

    /**
     * @var bool
     */
    private static $auto_publish_location = false;

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     */
    public function run($request)
    {
        $this->migrateLocations();
    }

    /**
     *
     */
    protected function migrateLocations()
    {
        if (!$parent = Locator::get()->first()) {
            $parent = Locator::create();
            $parent->Title = "Locator";
            $parent->writeToStage(Versioned::DRAFT);
        }

        /** @var Location $location */
        foreach ($this->getLocations() as $location) {
            if (!LocationPage::get()->filter('LegacyObjectID', $location->ID)->first()) {
                if ($location->hasMethod('isPublished')) {
                    $published = $location->isPublished();
                }

                /** @var LocationPage $newLocation */
                $newLocation = Injector::inst()->create(LocationPage::class, $location->toMap(), false);
                $newLocation->setClassName(LocationPage::class);
                $newLocation->ID = null;
                $newLocation->ParentID = $parent->ID;
                $newLocation->LegacyObjectID = $location->ID;

                $this->extend('preLocationMigrationUpdate', $location, $newLocation);

                $newLocation->writeToStage(Versioned::DRAFT);

                if ((isset($published) && $published) || $this->config()->get('auto_publish_location')) {
                    $newLocation->publishSingle();
                }
            }
        }
    }

    /**
     * @return \Generator
     */
    protected function getLocations()
    {
        foreach (Location::get() as $location) {
            yield $location;
        }
    }
}
