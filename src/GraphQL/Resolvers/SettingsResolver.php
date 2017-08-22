<?php

namespace Dynamic\Locator\GraphQL\Resolvers;

use Dynamic\Locator\LocatorSettings;
use SilverStripe\GraphQL\Scaffolding\Interfaces\ResolverInterface;

/**
 * Class SettingsResolver
 * @package Dynamic\Locator\GraphQL\Resolvers
 */
class SettingsResolver implements ResolverInterface
{

    /**
     * Resolves graphql query parameters
     *
     * @param \SilverStripe\ORM\DataObjectInterface $object
     * @param array $args
     * @param array $context
     * @param \GraphQL\Type\Definition\ResolveInfo $info
     * @return \Dynamic\Locator\LocatorSettings
     */
    public function resolve($object, $args, $context, $info)
    {
        return LocatorSettings::current_locator_settings();
    }

}
