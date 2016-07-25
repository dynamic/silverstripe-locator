<?php

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
        'Locations' => 'Location',
    );

    /**
     * @var array
     */
    private static $belogs_many_many = array(
        'Locators' => 'Locator',
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
