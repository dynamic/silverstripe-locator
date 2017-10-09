<?php

namespace Dynamic\Locator;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\Form;
use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;

/**
 * Class LocationAdmin
 */
class LocationAdmin extends ModelAdmin
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

    /**
     * @return array
     */
    public function getExportFields()
    {
        if ($this->modelClass == Location::class) {
            return array(
                'Title' => 'Name',
                'Address' => 'Address',
                'City' => 'City',
                'State' => 'State',
                'PostalCode' => 'PostalCode',
                'Country' => 'Country',
                'Website' => 'Website',
                'Phone' => 'Phone',
                'Fax' => 'Fax',
                'Email' => 'Email',
                'Category.Name' => 'Category',
                'ShowInLocator' => 'ShowInLocator',
                'Featured' => 'Featured',
                'Lat' => 'Lat',
                'Lng' => 'Lng',
            );
        }

        return parent::getExportFields();
    }

    /**
     * @param null $id
     * @param null $fields
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        if ($this->modelClass == Location::class) {
            $class = $this->sanitiseClassName(Location::class);
            $gridField = $form->Fields()->fieldByName($class);
            $config = $gridField->getConfig();
            $config->removeComponentsByType(GridFieldDeleteAction::class);
        }
        return $form;
    }
}
