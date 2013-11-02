<?php

namespace SpiffyAuthorize\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GuardsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\Options\ModuleOptions $options */
        $options       = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');
        $guardsOptions = $options->getGuards();

        $guards = array();

        $guards[] = $serviceLocator->get('SpiffyAuthorize\Guard\RouteParamsGuard');

        if ($guardsOptions->getRouteRules()) {
            $guards[] = $serviceLocator->get('SpiffyAuthorize\Guard\RouteGuard');
        }

        return $guards;
    }
}
