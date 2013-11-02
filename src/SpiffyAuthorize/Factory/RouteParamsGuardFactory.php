<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Guard\RouteParamsGuard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteParamsGuardFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RouteParamsGuard
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\Options\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');

        return new RouteParamsGuard(
            $serviceLocator->get($options->getAuthorizeService())
        );
    }
}
