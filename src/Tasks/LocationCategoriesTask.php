<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Location;
use Dynamic\Locator\Model\LocationCategory;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;

/**
 * Class LocationCategoriesTask
 * @package Dynamic\Locator\Tasks
 */
class LocationCategoriesTask extends BuildTask
{

    /**
     * @var string
     */
    protected $title = 'Location categories to many_many';

    /**
     * @var string
     */
    protected $description = 'Migration task - Converts locations to have multiple categories';

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @param $request
     */
    public function run($request)
    {
        /** @var DataObject $class */
        $class = ($request->getVar('locationclass')) ? $request->getVar('locationclass') : Location::class;
        $class::add_extension(LocationCategoryExtension::class);


        $categories = [];

        $convert = function (DataObject $location) use (&$categories) {
            /** @var Location $location */
            // skip if no category
            if ($location->CategoryID > 0) {
                $categories[$location->CategoryID][] = $location->ID;
            }
        };

        foreach ($this->iterateLocations($class) as $location) {
            $convert($location);
        }

        $catCt = 0;
        $locCT = 0;

        foreach ($categories as $categoryID => $locations) {
            /** @var LocationCategory $category */
            $category = LocationCategory::get()->byID($categoryID);
            $category->Locations()->addMany($locations);

            $catCt++;
            $locCT += count($locations);
        }

        echo "{$catCt} categories converted<br />";
        echo "{$locCT} location relations converted<br />";

        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        echo "Process Time: {$time} seconds";
    }

    /**
     * @param string $class
     * @return \Generator
     */
    protected function iterateLocations($class)
    {
        foreach ($class::get() as $location) {
            yield $location;
        }
    }
}
