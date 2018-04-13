<?php

/**
 * Class LocationAdmin
 */
class LocationAdmin extends ModelAdmin
{

    /**
     * @var array
     */
    private static $managed_models = [
        'Location',
        'LocationCategory',
    ];

    /**
     * @var array
     */
    private static $model_importers = [
        'Location' => 'LocationCsvBulkLoader',
        'LocationCategory' => 'CsvBulkLoader',
    ];

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
        if ($this->modelClass == 'Location') {
            $fields = [
                'Title' => 'Name',
                'Address' => 'Address',
                'Suburb' => 'City',
                'State' => 'State',
                'Postcode' => 'Postcode',
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
        if ($class == 'Location') {
            $gridField = $form->Fields()->fieldByName($class);
            $config = $gridField->getConfig();
            $config->removeComponentsByType('GridFieldDeleteAction');
        }
        return $form;
    }
}
