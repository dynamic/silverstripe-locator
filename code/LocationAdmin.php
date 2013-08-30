<?php
class LocationAdmin extends ModelAdmin {
   	
   	static $managed_models = array(
   		'Location',
   		'LocationCategory'
   	);
   	
   	static $model_importers = array(
      	'Location' => 'LocationCsvBulkLoader', 
    );
   
	static $menu_title = 'Locations';
    static $url_segment = 'locations';

    public function getExportFields() {
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