<?php
class LocationAdmin extends ModelAdmin {

  static $managed_models = array(
    'Location',
    'LocationCategory'
  );

  static $model_importers = array(
    'Location' => 'LocationCsvBulkLoader',
    'LocationCategory' => 'CsvBulkLoader'
  );

  static $menu_title = 'Locator';
  static $url_segment = 'locator';

  public function getExportFields() {
    if($this->modelClass == 'Location') {
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
        'EmailAddress' => 'EmailAddress',
        'Category.Name' => 'Category',
        'ShowInLocator' => 'ShowInLocator',
        'Featured' => 'Featured',
        'Lat' => 'Lat',
        'Lng' => 'Lng'
      );
    }
    return parent::getExportFields();
  }
}