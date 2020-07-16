<?php

namespace Dynamic\Locator\Admin;

use Dynamic\Locator\Bulkloader\LocationCsvBulkLoader;
use Dynamic\Locator\Model\LocationCategory;
use Dynamic\Locator\Page\LocationPage;
use LittleGiant\CatalogManager\ModelAdmin\CatalogPageAdmin;
use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;

/**
 * Class LocationAdmin
 * @package Dynamic\Locator\Admin
 */
class LocationsAdmin extends CatalogPageAdmin
{

    /**
     * @var array
     */
    private static $managed_models = [
        LocationPage::class,
        LocationCategory::class,
    ];

    /**
     * @var array
     */
    private static $model_importers = [
        LocationCategory::class => CsvBulkLoader::class,
    ];

    /**
     * @var string
     */
    private static $menu_title = 'Locations';

    /**
     * @var string
     */
    private static $url_segment = 'locations';

    /**
     * @return array
     */
    public function getExportFields()
    {
        if ($this->modelClass == LocationPage::class) {
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

        if ($this->modelClass == LocationPage::class) {
            /** @var GridField $gridField */
            if ($gridField = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass))) {
                $gridField->getConfig()
                    ->removeComponentsByType('GridFieldDeleteAction');
            }
        }

        return $form;
    }
}
