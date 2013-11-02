<?php

namespace SpiffyAuthorize\Factory;

use SpiffyAuthorize\Service\RbacService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RbacServiceFactory implements FactoryInterface
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
        $options   = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');
        $perms     = $serviceLocator->get('SpiffyAuthorize\PermissionProviders');
        $roles     = $serviceLocator->get('SpiffyAuthorize\RoleProviders');
        $providers = array_merge($perms, $roles);
        $service   = new RbacService();

        foreach ($providers as $provider) {
            $service->getEventManager()->attach($provider);
        }

        $service->setIdentityProvider($serviceLocator->get($options->getIdentityProvider()));

        return $service;
    }
}
