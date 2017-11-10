<?php

namespace Dynamic\Locator;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

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
     * @var string
     */
    private static $singular_name = 'Category';

    /**
     * @var string
     */
    private static $plural_name = 'Categories';

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
        'Locations' => Location::class,
    );

    /**
     * @var array
     */
    private static $belogs_many_many = array(
        'Locators' => Locator::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'LocationCategory';

    /**
     * @var string
     */
    private static $default_sort = 'Name';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Locations',
        ]);

        if ($this->ID) {
            // Locations
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new GridFieldAddExistingAutocompleter());
            $config->removeComponentsByType(GridFieldAddNewButton::class);
            $locations = $this->Locations();
            $locationField = GridField::create('Locations', 'Locations', $locations, $config);

            $fields->addFieldsToTab('Root.Locations', array(
                $locationField,
            ));
        }

        return $fields;
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canView($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canEdit($member = null, $context = [])
    {
        return Permission::check('Location_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canDelete($member = null, $context = [])
    {
        return Permission::check('Location_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Location_CREATE', 'any', $member);
    }
}
