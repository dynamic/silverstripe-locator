<?php

class LocationAdmin extends ModelAdmin
{

    private static $managed_models = array(
        'Location',
        'LocationCategory'
    );

    private static $model_importers = array(
        'Location' => 'LocationCsvBulkLoader',
        'LocationCategory' => 'CsvBulkLoader'
    );

    private static $menu_title = 'Locator';
    private static $url_segment = 'locator';

    public function getExportFields()
    {
        return array(
            'Title' => 'Name',
            'Address' => 'Address',
            'Suburb' => 'City',
            'State' => 'State',
            'Postcode' => 'Postal Code',
            'Country' => 'Country',
            'Website' => 'Website',
            'Phone' => 'Phone',
            'Fax' => 'Fax',
            'EmailAddress' => 'Email Address',
            'ShowInLocator' => 'Show',
            'Lat' => 'Lat',
            'Lng' => 'Lng'
        );
    }
}