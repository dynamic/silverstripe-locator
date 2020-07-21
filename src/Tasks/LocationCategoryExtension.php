<?php

namespace Dynamic\Locator\Tasks;

use Dynamic\Locator\Model\LocationCategory;
use SilverStripe\ORM\DataExtension;

/**
 * This is meant to only be applied during the upgrade task, not for normal use
 *
 * Class LocationCategoryExtension
 * @package Dynamic\Locator\Tasks
 */
class LocationCategoryExtension extends DataExtension
{
    private static $has_one = [
        'Category' => LocationCategory::class,
    ];
}
