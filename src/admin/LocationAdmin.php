<?php

namespace Dynamic\Locator;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Forms\Form;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;

/**
 * Class LocationAdmin
 */
class LocationAdmin extends ModelAdmin implements PermissionProvider
{

    /**
     * @var array
     */
    private static $managed_models = array(
        Location::class,
        LocationCategory::class,
    );

    /**
     * @var array
     */
    private static $model_importers = array(
        Location::class => LocationCsvBulkLoader::class,
        LocationCategory::class => CsvBulkLoader::class,
    );

    /**
     * @var string
     */
    private static $menu_title = 'Locator';
    /**
     * @var string
     */
    private static $url_segment = 'locator';

    private static $tree_class = Location::class;

    /**
     * @var string
     */
    private static $required_permission_codes = 'CMS_ACCESS_LocatorAdmin';

    /**
     * @return array
     */
    public function getExportFields()
    {
        if ($this->modelClass == Location::class) {
            $fields = [
                'Title' => 'Name',
                'Address' => 'Address',
                'Address2' => 'Address2',
                'City' => 'City',
                'State' => 'State',
                'PostalCode' => 'PostalCode',
                'CountryCode' => 'Country',
                'Phone' => 'Phone',
                'Fax' => 'Fax',
                'Email' => 'Email',
                'Website' => 'Website',
                'Featured' => 'Featured',
                'CategoryList' => 'Categories',
                'Lat' => 'Lat',
                'Lng' => 'Lng',
                'Import_ID' => 'Import_ID',
            ];
        }

        if (!isset($fields)) {
            $fields = parent::getExportFields();
        }

        $this->extend('updateGetExportFields', $fields);

        return $fields;
    }

    /**
     * @param null $id
     * @param null $fields
     * @return $this|Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        $class = $this->sanitiseClassName($this->modelClass);
        if ($class == Location::class) {
            $gridField = $form->Fields()->fieldByName($class);
            $config = $gridField->getConfig();
            $config->removeComponentsByType('GridFieldDeleteAction');
        }
        return $form;
    }

    public function providePermissions()
    {
        return array(
            "CMS_ACCESS_LocatorAdmin" => array(
                'name' => "Access to 'Locator' section",
                'category' => 'CMS Access'
            )
        );
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null)
    {
        if (!$member && $member !== false) {
            $member = Security::getCurrentUser();
        }

        if (Permission::checkMember($member, 'CMS_ACCESS_LocatorAdmin')) {
            return true;
        }

        // Default permissions
        //return parent::canView($member);
    }
}
