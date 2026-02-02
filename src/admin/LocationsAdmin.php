<?php

namespace Dynamic\Locator\Admin;

use Dynamic\Locator\Bulkloader\LocationCsvBulkLoader;
use Dynamic\Locator\Bulkloader\LocationPageCsvBulkLoader;
use Dynamic\Locator\Model\LocationCategory;
use Dynamic\Locator\Page\LocationPage;
use LittleGiant\CatalogManager\ModelAdmin\CatalogPageAdmin;
use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldImportButton;

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
        LocationPage::class => LocationPageCsvBulkLoader::class,
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
                $exportButton = new GridFieldExportButton('buttons-before-left');
                $exportButton->setExportColumns($this->getExportFields());
                $gridField->getConfig()
                    ->addComponent($exportButton)
                    ->removeComponentsByType('GridFieldDeleteAction');
            }

            if ($this->showImportForm) {
                $fieldConfig = $gridField->getConfig();
                $fieldConfig->addComponent(
                    GridFieldImportButton::create('buttons-before-left')
                        ->setImportForm($this->ImportForm())
                        ->setModalTitle(_t('SilverStripe\\Admin\\ModelAdmin.IMPORT', 'Import from CSV'))
                );
            }
        }

        return $form;
    }
}
