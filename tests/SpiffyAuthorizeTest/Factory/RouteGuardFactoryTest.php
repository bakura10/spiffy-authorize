<?php

namespace SpiffyAuthorizeTest\Factory;

use Mockery as m;
use SpiffyAuthorize\Options\ModuleOptions;
use SpiffyAuthorize\Factory\RouteGuardFactory;

class RouteGuardFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceReturned()
    {
        $config = array(
            'route_rules' => array(
                'route' => 'admin'
            )
        );

        $options = new ModuleOptions();
        $options->setGuards($config);
        $options->setAuthorizeService('AuthorizeService');

        $sm          = m::mock('Zend\ServiceManager\ServiceManager');
        $authService = m::mock('SpiffyAuthorize\Service\AuthorizeServiceInterface');

        $sm->shouldReceive('get')->with('AuthorizeService')->andReturn($authService);
        $sm->shouldReceive('get')->with('SpiffyAuthorize\Options\ModuleOptions')->andReturn($options);

        $factory  = new RouteGuardFactory();
        $instance = $factory->createService($sm);

        $this->assertInstanceOf('SpiffyAuthorize\Guard\RouteGuard', $instance);
    }
}
