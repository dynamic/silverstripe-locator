<?php

/**
 * Class LocationCsvBulkLoader
 */
class LocationCsvBulkLoader extends CsvBulkLoader
{

    /**
     * @var array
     */
    public $columnMap = array(
        'Name' => 'Title',
        'City' => 'Suburb',
        'EmailAddress' => 'Email',
        'Category' => 'Category.Name',
    );

    /**
     * @var array
     */
    public $relationCallbacks = array(
       'Category.Name' => array(
           'relationname' => 'Category',
           'callback' => 'getCategoryByName',
        ),
    );

    /**
     * @param $obj
     * @param $val
     * @param $record
     * @return DataObject|static
     */
    public static function getCategoryByName(&$obj, $val, $record)
    {
        $val = Convert::raw2sql($val);
        $category = LocationCategory::get()->filter(array('Name' => $val))->First();
        if (!$category) {
            $category = LocationCategory::create();
            $category->Name = $val;
            $category->write();
        }

        return $category;
    }

}
