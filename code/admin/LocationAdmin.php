<?php

namespace Dynamic\Locator;

use SilverStripe\Admin\ModelAdmin;

/**
 * Class LocationAdmin
 */
class LocationAdmin extends ModelAdmin
{

    /**
     * @var array
     */
    private static $managed_models = array(
        'Dynamic\\Locator\\Location',
        'Dynamic\\Locator\\LocationCategory',
    );

    /**
     * @var array
     */
    private static $model_importers = array(
        'Dynamic\\Locator\\Location' => 'Dynamic\\Locator\\LocationCsvBulkLoader',
        'Dynamic\\Locator\\LocationCategory' => 'SilverStripe\\Dev\\CsvBulkLoader',
    );

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
