<?php

namespace Dynamic\Locator;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Permission;

/**
 * Class LocationCategory
 *
 * @property string $Name
 * @method Locations|ManyManyList LocationSet()
 * @method Locators|ManyManyList Locators()
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
    private static $belongs_many_many = array(
        'Locators' => Locator::class,
        'LocationSet' => Location::class,
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
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName([
                'Locations',
                'LocationSet',
                'LinkTracking',
                'FileTracking',
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
        });

        $fields = parent::getCMSFields();

        return $fields;
    }

    /**
     * For backwards compatability
     * @return Locations|ManyManyList
     */
    public function Locations() {
        return $this->LocationSet();
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
