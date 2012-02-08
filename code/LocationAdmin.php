<?php
class LocationAdmin extends ModelAdmin {
   static $managed_models = array(
      'LocationQuery',
      'LocationResult',
      'Location'
   );
   static $model_importers = array(
      'Location' => 'LocationCsvBulkLoader', 
   );
   static $url_segment = 'locations';
}
?>