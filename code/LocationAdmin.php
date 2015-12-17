<?php

class LocationAdmin extends ModelAdmin
{
    private static $managed_models = array(
        'Location',
        'LocationCategory',
    );

    private static $model_importers = array(
        'Location' => 'LocationCsvBulkLoader',
        'LocationCategory' => 'CsvBulkLoader',
    );

    private static $menu_title = 'Locator';
    private static $url_segment = 'locator';

    public function getExportFields()
    {
        if ($this->modelClass == 'Location') {
            return array(
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
            );
        }

        return parent::getExportFields();
    }
}
