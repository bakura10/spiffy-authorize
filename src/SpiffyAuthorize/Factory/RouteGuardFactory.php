<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Guard\RouteGuard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteGuardFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return RouteGuard
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\Options\ModuleOptions $options */
        $options          = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');
        $authorizeService = $serviceLocator->get($options->getAuthorizeService());

        return new RouteGuard($authorizeService, $options->getGuards());
    }
}
