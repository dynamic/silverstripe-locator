<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Location;
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

        $ct = 0;

        $convert = function (DataObject $location) use (&$ct) {
            $location->Categories()->add($location->Category());
            $location->write();
            $ct++;
        };

        foreach ($this->iterateLocations($class) as $location) {
            $convert($location);
        }

        echo "{$ct} categories converted";
    }

    /**
     * @param string $class
     * @return Generator
     */
    protected function iterateLocations($class)
    {
        foreach ($class::get() as $location) {
            yield $location;
        }
    }

}
