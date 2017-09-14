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

    /**
     * @var array
     */
    private static $base_filter = [];

    /**
     * @var array
     */
    private static $base_exclude = [
        'Lat' => 0,
        'Lng' => 0,
    ];

    /**
     * @var array
     */
    private static $base_filter_any = [];

    private static $allowed_actions = array(
        'json',
        'settings'
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
        Requirements::javascript('https://maps.google.com/maps/api/js?key=' . $key);
    }

    public function json()
    {
        $this->getResponse()->addHeader("Content-Type", "application/json");

        $data = new ArrayData(array(
            "Locations" => $this->getLocations($this->getRequest()),
        ));

        return $data->renderWith('Dynamic/Locator/locations');
    }

    public function settings()
    {
        $this->getResponse()->addHeader("Content-Type", "application/json");

        $data = new ArrayData(array(
            // TODO
            "Radii" => $this->getRadii(),
            "Limit" => $this->getLimit(),
            "ShowRadius" => $this->getShowRadius(),
            "InfoWindowTemplate" => $this->getInfoWindowTemplate(),
            "ListTemplate" => $this->getListTemplate(),
            "Categories" => $this->getCategories(),
            "Unit" => $this->Unit,
            "Clusters" => $this->Clusters,
        ));

        return $data->renderWith('Dynamic/Locator/settings');
    }

    /**
     * @param HTTPRequest|null $request
     *
     * @return ArrayList|DataList|static
     */
    public function getLocations(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->request;
        }

        $filter = $this->config()->get('base_filter');

        if ($request->getVar('category')) {
            $filter['CategoryID'] = $request->getVar('category');
        } else {
            if ($this->getCategories()->exists()) {
                foreach ($this->getCategories() as $category) {
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

        if ($request->getVar('address') && $request->getVar('radius')) {
            $radius = $request->getVar('radius');
            $locations = $locations->filterByCallback(function ($location) use (&$radius) {
                if ($radius === -1) {
                    return true;
                }
                return $location->distance <= $radius;
            });
        }

        //allow for returning list to be set as
        $this->extend('updateListType', $locations);
        $limit = Config::inst()->get(LocatorController::class, 'limit');
        if ($limit > 0) {
            $locations = $locations->limit($limit);
        }

        return $locations;
    }
}
