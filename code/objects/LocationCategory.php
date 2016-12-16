<?php

namespace Dynamic\Locator;

use SilverStripe\ORM\DataObject;

/**
 * Class LocationCategory
 *
 * @property string $Name
 * @method Locations|HasManyList $Locations
 * @method Locators|ManyManyList $Locators
 */
class LocationCategory extends DataObject
{

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(100)',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'Locations' => 'Dynamic\\Locator\\LocationLocation',
    );

    /**
     * @var array
     */
    private static $belogs_many_many = array(
        'Locators' => 'Dynamic\\Locator\\Locator',
    );

    /**
     * @var string
     */
    private static $singular_name = 'Category';
    /**
     * @var string
     */
    private static $plural_name = 'Categories';

    /**
     * @var string
     */
    private static $default_sort = 'Name';

}
