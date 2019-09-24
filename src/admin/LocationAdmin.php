<?php

namespace Dynamic\Locator;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Forms\Form;

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
}
