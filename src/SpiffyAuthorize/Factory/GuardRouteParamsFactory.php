<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Guard\RouteParamsGuard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GuardRouteParamsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\Options\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');
        $guard   = new RouteParamsGuard();
        $guard->setAuthorizeService($serviceLocator->get($options->getAuthorizeService()));

        return $guard;
    }
}
