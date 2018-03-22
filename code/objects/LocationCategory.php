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

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            if ($locations = $fields->dataFieldByName('Locations')) {
                $config = $locations->getConfig();
                // Locations
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
                $config->removeComponentsByType('GridFieldAddNewButton');
            }

        });

        $fields = parent::getCMSFields();

        return $fields;
    }

    /**
     * @param null|Member $member
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Location_EDIT', 'any', $member);
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Location_DELETE', 'any', $member);
    }

    /**
     * @param null|Member $member
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('Location_CREATE', 'any', $member);
    }
}
