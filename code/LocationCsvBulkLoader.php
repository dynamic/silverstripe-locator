<?php

class LocationCsvBulkLoader extends CsvBulkLoader
{
    public $columnMap = array(
        'Name' => 'Title',
        'City' => 'Suburb',
        'EmailAddress' => 'Email',
        'Category' => 'Category.Name',
    );

    public $relationCallbacks = array(
       'Category.Name' => array(
           'relationname' => 'Category',
           'callback' => 'getCategoryByName',
        ),
    );

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
