<?php

namespace Dynamic\Locator\Model;

use Dynamic\Locator\Location;
use Dynamic\Locator\Page\Locator;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Permission;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class LocationCategory
 *
 * @property string $Name
 * @method ManyManyList LocationSet()
 * @method ManyManyList Locators()
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
    private static $db = [
        'Name' => 'Varchar(100)',
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Locators' => Locator::class,
        'LocationSet' => Location::class,
    ];

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
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'Locations',
                'LocationSet',
                'Locators',
                'LinkTracking',
                'FileTracking',
            ]);

            if ($this->ID) {
                // Locations
                $config = GridFieldConfig_RelationEditor::create();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldAddNewButton::class,
                ])
                    ->addComponents([
                        new GridFieldAddExistingSearchButton(),
                    ]);
                $locations = $this->Locations();
                $locationField = GridField::create('Locations', 'Locations', $locations, $config);

                $fields->addFieldsToTab('Root.Main', [
                    $locationField,
                ]);
            }
        });

        $fields = parent::getCMSFields();

        return $fields;
    }

    /**
     * For backwards compatability
     * @return ManyManyList
     */
    public function Locations()
    {
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
