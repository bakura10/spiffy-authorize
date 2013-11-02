<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Options\ModuleOptions;

class ProviderRoleFactory extends AbstractInstanceFactory
{
    /**
     * @param ModuleOptions $options
     * @return array
     */
    protected function getInstances(ModuleOptions $options)
    {
        return $options->getRoleProviders();
    }
}
