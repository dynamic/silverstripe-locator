<?php


namespace Dynamic\Locator\Resolvers;

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
     * @return $this|\SilverStripe\ORM\DataList
     */
    public function resolve($object, $args, $context, $info)
    {
        $list = Location::get();
        // TODO - isset($args['ID'])

        if ($args['address'] && $args['radius']) {
            $address = $args['address'];
            $radius = $args['radius'];

            $list = $list->filterByCallback(function ($location) use (&$radius) {
                return $location->distance <= $radius;
            });

        }

        return $list;
    }

}