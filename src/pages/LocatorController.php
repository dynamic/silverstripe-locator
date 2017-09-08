<?php

namespace Dynamic\Locator;

use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use muskie9\DataToArrayList\ORM\DataToArrayListHelper;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;

/**
 * Class LocatorController
 */
class LocatorController extends \PageController
{

    private static $allowed_actions = array(
        'json'
    );

    /**
     * @var DataList|ArrayList
     */
    protected $locations;

    /**
     * Set Requirements based on input from CMS
     */
    public function init()
    {
        parent::init();

        $key = Config::inst()->get(GoogleGeocoder::class, 'geocoder_api_key');
        Requirements::css('locator/css/map.css');
        Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);
    }

    public function json()
    {
        $this->getResponse()->addHeader("Content-Type", "application/json");

        $data = new ArrayData(array(
            // TODO
            "Locations" => Location::get()
        ));
        return $data->renderWith('locations');
    }

    /**
     * @param HTTPRequest|null $request
     *
     * @return $this
     */
    public function setLocations(HTTPRequest $request = null)
    {

        if ($request === null) {
            $request = $this->request;
        }
        $filter = $this->config()->get('base_filter');

        if ($request->getVar('CategoryID')) {
            $filter['CategoryID'] = $request->getVar('CategoryID');
        } else {
            if ($this->getPageCategories()->exists()) {
                foreach ($this->getPageCategories() as $category) {
                    $filter['CategoryID'][] = $category->ID;
                }
            }
        }

        $this->extend('updateLocatorFilter', $filter, $request);

        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateLocatorFilterAny', $filterAny, $request);

        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateLocatorExclude', $exclude, $request);

        $locations = Locator::get_locations($filter, $filterAny, $exclude);
        $locations = DataToArrayListHelper::to_array_list($locations);

        //allow for adjusting list post possible distance calculation
        $this->extend('updateLocationList', $locations);

        if ($locations->canSortBy('distance')) {
            $locations = $locations->sort('distance');
        }

        //allow for returning list to be set as
        $this->extend('updateListType', $locations);

        $limit = Config::inst()->get(LocatorController::class, 'limit');
        if ($limit > 0) {
            $locations = $locations->limit($limit);
        }

        $this->locations = $locations;

        return $this;

    }
}
