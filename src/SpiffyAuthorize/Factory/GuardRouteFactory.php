<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Guard\RouteGuard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GuardRouteFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyAuthorize\ModuleOptions');

        return new RouteGuard($serviceLocator->get($options->getAuthorizeService()));
    }
}
