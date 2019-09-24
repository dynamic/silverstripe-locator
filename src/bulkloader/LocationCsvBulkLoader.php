<?php

namespace Dynamic\Locator;

use SilverStripe\Dev\CsvBulkLoader;
use SilverStripe\Core\Convert;
use SilverStripe\i18n\Data\Intl\IntlLocales;

/**
 * Class LocationCsvBulkLoader
 * @package Dynamic\Locator
 */
class LocationCsvBulkLoader extends CsvBulkLoader
{

    /**
     * @var array
     */
    public $columnMap = array(
        'Name' => 'Title',
        'EmailAddress' => 'Email',
        'Categories' => '->getCategoryByName',
        'Import_ID' => 'Import_ID',
        'Country' => '->getCountryByName',
    );

    /**
     * @var array
     */
    public $duplicateChecks = array(
        'Import_ID' => 'Import_ID'
    );

    /**
     * @param $val
     * @return string|string[]|null
     */
    public function getEscape($val)
    {
        return preg_replace("/\r|\n/", "", $val);
    }

    /**
     * @param $obj
     * @param $val
     * @param $record
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function getCategoryByName(&$obj, $val, $record)
    {
        $val = Convert::raw2sql($val);
        $parts = explode(', ', $val);

        foreach ($parts as $part) {
            $category = LocationCategory::get()->filter(array('Name' => $part))->first();
            if (!$category) {
                $category = LocationCategory::create();
                $category->Name = $part;
                $category->write();
            }
            $obj->Categories()->add($category);
        }
    }

    /**
     * @param $obj
     * @param $val
     * @param $record
     */
    public function getCountryByName(&$obj, $val, $record)
    {
        $val = $this->getEscape($val);
        $countries = IntlLocales::singleton()->getCountries();

        if (strlen((string)$val) == 2) {
            $val = strtolower($val);
            if (array_key_exists($val, $countries)) {
                $obj->Country = $val;
            }
        }

        if (in_array($val, $countries)) {
            $obj->Country = array_search($val, $countries);
        }
    }

    /**
     * @param array $record
     * @param array $columnMap
     * @param \SilverStripe\Dev\BulkLoader_Result $results
     * @param bool $preview
     * @return int|void
     */
    protected function processRecord($record, $columnMap, &$results, $preview = false)
    {
        $objID = parent::processRecord($record, $columnMap, $results, $preview = false);

        $location = Location::get()->byID($objID);
        $location->publishSingle();
    }
}
