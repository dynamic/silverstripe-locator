<?php


namespace Dynamic\Locator\GraphQL\Resolvers;

use Dynamic\Locator\Location;
use SilverStripe\GraphQL\Scaffolding\Interfaces\ResolverInterface;

class LocationResolver implements ResolverInterface
{

    /**
     * Resolves graphql query parameters
     *
     * @param \SilverStripe\ORM\DataObjectInterface $object
     * @param array $args
     * @param array $context
     * @param \GraphQL\Type\Definition\ResolveInfo $info
     *
     * @return $this|\SilverStripe\ORM\DataList
     */
    public function resolve($object, $args, $context, $info)
    {
        $list = Location::get();
        // TODO - isset($args['ID'])

        $list = $list->exclude(array(
            'Lat' => 0,
            'Lng' => 0
        ));

        if ($args['category']) {
            $list = $list->filter('CategoryID', $args['category']);
        }

        if ($args['address']) {
            if ($args['radius']) {

                $radius = $args['radius'];
                $list   = $list->filterByCallback(function ($location) use (&$radius) {
                    return $location->distance <= $radius;
                });
            } else {
                //to avoid stupid errors when trying to sort by distance
                $list = $list->filterByCallback(function () {
                    return true;
                });
            }

            $list = $list->sort('distance');
        }

        return $list;
    }

}
