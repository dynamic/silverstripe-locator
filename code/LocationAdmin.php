<?php
class LocationAdmin extends ModelAdmin {
   	static $managed_models = array(
   		'Location'
   	);
   	
   	static $model_importers = array(
      	'Location' => 'LocationCsvBulkLoader', 
    );
   
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