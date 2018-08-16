<?php

namespace Dynamic\Locator\Control;

use Dynamic\Locator\Location;
use Dynamic\Locator\Locator;
use Dynamic\SilverStripeGeocoder\DistanceDataExtension;
use muskie9\DataToArrayList\ORM\DataToArrayListHelper;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;

/**
 * Class LocatorEndpointController
 * @package Dynamic\Locator\Control
 */
class APIController extends Controller
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'xml',
        'json',
    ];

    /**
     * @var string
     */
    private static $location_class = Location::class;

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

    /**
     * @var \SilverStripe\ORM\DataList|\SilverStripe\ORM\ArrayList
     */
    private $locations;

    /**
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function index()
    {
        return $this->xml();
    }

    /**
     * Renders locations in xml format
     *
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function xml()
    {
        $this->getResponse()->addHeader("Content-Type", "application/xml");
        $data = new ArrayData(array(
            "Locations" => $this->getLocations(),
            "AddressCoords" => $this->getAddressSearchCoords(),
        ));

        return $data->renderWith('Dynamic/Locator/Data/XML');
    }

    /**
     * Renders locations in json format
     *
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function json()
    {
        $this->getResponse()->addHeader("Content-Type", "application/json");
        $data = new ArrayData(array(
            "Locations" => $this->getLocations(),
            "AddressCoords" => $this->getAddressSearchCoords(),
        ));

        return $data->renderWith('Dynamic/Locator/Data/JSON');
    }

    /**
     * @param HTTPRequest|null $request
     * @return ArrayList|DataList
     */
    public function getLocations(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->getRequest();
        }

        if (!$this->locations) {
            $this->setLocations($request);
        }

        return $this->locations;
    }

    /**
     * @param HTTPRequest|null $request
     *
     * @return $this
     */
    public function setLocations(HTTPRequest $request = null)
    {

        if ($request === null) {
            $request = $this->getRequest();
        }

        $locations = $this->getLocationList($request);

        if ($locations->canSortBy('Distance')) {
            $locations = $locations->sort('Distance');
        }

        // filter out locations farther than the radius
        $radiusVar = $this->config()->get('radius_var');
        if ($radius = (int)$request->getVar($radiusVar)) {
            $locations = $locations->filterByCallback(function ($location) use (&$radius) {
                return $location->Distance <= $radius;
            });
        }

        $this->extend('updateListType', $locations);

        $limit = $this->getLimit($request);
        if ($limit > 0) {
            $locations = $locations->limit($limit);
        }

        $this->locations = $locations;

        return $this;
    }

    /**
     * @param HTTPRequest $request
     * @return \SilverStripe\ORM\ArrayList
     */
    public function getLocationList(HTTPRequest $request)
    {
        if ($request === null) {
            $request = $this->getRequest();
        }

        $filter = $this->getFilter($request);
        $filterAny = $this->getFilterAny($request);
        $exclude = $this->getExclude($request);

        $locationClass = $this->config()->get('location_class');

        $locations = $locationClass::get();

        if (!empty($filter)) {
            $locations = $locations->filter($filter);
        }

        if (!empty($filterAny)) {
            $locations = $locations->filterAny($filterAny);
        }

        if (!empty($exclude)) {
            $locations = $locations->exclude($exclude);
        }

        $locations = DataToArrayListHelper::to_array_list($locations);
        $this->extend('updateLocationList', $locations);
        return $locations;
    }

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @return array
     */
    public function getFilter(HTTPRequest $request)
    {
        $filter = $this->config()->get('base_filter');

        // filter by category
        $categoryVar = $this->config()->get('category_var');
        if ($request->getVar($categoryVar)) {
            $filter['Categories.ID'] = $request->getVar($categoryVar);
        }

        $this->extend('updateFilter', $filter, $request);
        return $filter;
    }

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @return array
     */
    public function getFilterAny(HTTPRequest $request)
    {
        $filterAny = $this->config()->get('base_filter_any');
        $this->extend('updateFilterAny', $filterAny, $request);
        return $filterAny;
    }

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @return array
     */
    public function getExclude(HTTPRequest $request)
    {
        $exclude = $this->config()->get('base_exclude');
        $this->extend('updateExclude', $exclude, $request);
        return $exclude;
    }

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @return int
     */
    public function getLimit(HTTPRequest $request)
    {
        $limitVar = $this->config()->get('limit_var');
        $requestedLimit = $request->getVar($limitVar);
        $maxLimit = $this->config()->get('limit');
        $limit = $maxLimit;

        if ($requestedLimit && $requestedLimit < $maxLimit) {
            $limit = $requestedLimit;
        }

        $this->extend('updateLimit', $limit, $request);
        return $limit;
    }

    /**
     * @return ArrayData|boolean
     */
    public function getAddressSearchCoords(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->getRequest();
        }

        $addressVar = Config::inst()->get(DistanceDataExtension::class, 'address_var');
        if (!$request->getVar($addressVar)) {
            return false;
        }
        if (class_exists(GoogleGeocoder::class)) {
            $geocoder = new GoogleGeocoder($request->getVar($addressVar));
            $response = $geocoder->getResult();
            $lat = $response->getLatitude();
            $lng = $response->getLongitude();

            return new ArrayData([
                "Lat" => $lat,
                "Lng" => $lng,
            ]);
        }
    }

    /**
     * @param string|null $action
     * @return string
     */
    public function Link($action = null)
    {
        return Controller::join_links(static::getRoute(), $action);
    }

    /**
     * Gets the current route of the controller.
     *
     * @return int|string
     */
    public static function getRoute()
    {
        $rules = Director::config()->get('rules');
        foreach ($rules as $route => $class) {
            if (is_array($class)) {
                if ($class['Controller'] === static::class) {
                    return $route;
                }
            }
            if ($class === static::class) {
                return $route;
            }
        }
        return '';
    }
}
