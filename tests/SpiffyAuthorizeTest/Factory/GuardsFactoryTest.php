<?php

namespace SpiffyAuthorizeTest\Factory;

use Mockery as m;
use SpiffyAuthorize\Options\ModuleOptions;
use SpiffyAuthorize\Factory\GuardsFactory;
use Zend\ServiceManager\ServiceManager;

class GuardsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGuardsCreated()
    {
        $config = array(
            'route_rules' => array(
                'route' => array(
                    'perm1',
                    'perm2'
                ),
                'route2' => array(
                    'perm3',
                    'perm4'
                )
            )
        );

        $options = new ModuleOptions();
        $options->setGuards($config);

        $sm = new ServiceManager();

        $sm->setFactory('SpiffyAuthorize\Guard\RouteGuard', 'SpiffyAuthorize\Factory\RouteGuardFactory');
        $sm->setFactory('SpiffyAuthorize\Guard\RouteParamsGuard', 'SpiffyAuthorize\Factory\RouteParamsGuardFactory');

        $sm->setService('SpiffyAuthorize\Options\ModuleOptions', $options);
        $sm->setService('SpiffyAuthorize\Service\RbacService', m::mock('SpiffyAuthorize\Service\AuthorizeServiceInterface'));

        $factory = new GuardsFactory();
        $guards  = $factory->createService($sm);

        $this->assertCount(2, $guards);
        foreach ($guards as $guard) {
            $this->assertInstanceOf('SpiffyAuthorize\Guard\GuardInterface', $guard);
        }

        // First is always the route params guard
        $this->assertInstanceOf('SpiffyAuthorize\Guard\RouteParamsGuard', $guards[0]);
        $this->assertInstanceOf('SpiffyAuthorize\Guard\RouteGuard', $guards[1]);

        $this->assertEquals(['route' => ['perm1', 'perm2'], 'route2' => ['perm3', 'perm4']], $guards[1]->getRules());
    }
}
