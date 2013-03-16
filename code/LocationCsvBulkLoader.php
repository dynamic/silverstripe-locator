<?php
class LocationCsvBulkLoader extends CsvBulkLoader {
   public $columnMap = array(
      'Name' => 'Name', 
      'Website' => 'Website', 
      'Address' => 'Address', 
      'City' => 'City',
      'State' => 'State',
      'Zip' => 'Zip',
      'Phone' => 'Phone'
   );
   public $duplicateChecks = array(
      //'Address' => 'Address',
      //'Website' => 'Website',
      //'Address' => 'Address'
   );
}