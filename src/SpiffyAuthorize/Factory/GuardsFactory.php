<?php

namespace SpiffyAuthorize\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This factory creates all the guards that are defined in the config
 */
class GuardsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|\SpiffyAuthorize\Guard\GuardInterface[]
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyAuthorize\Options\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyAuthorize\Options\ModuleOptions');
        $config  = $options->getGuards();
        $guards  = array();

        foreach ($config as $guardConfig) {
            $guard = $serviceLocator->get($guardConfig['type']);
            $guard->setOptions(isset($guardConfig['options']) ? $guardConfig['options'] : array());

            $guards[] = $guard;
        }

        return $guards;
    }
}
