<?php

namespace SpiffyAuthorizeTest\Service;

use Mockery as m;
use SpiffyAuthorize\Options\ModuleOptions;
use SpiffyAuthorize\Factory\RouteParamsGuardFactory;
use SpiffyAuthorizeTest\Asset\AuthorizeService;
use Zend\ServiceManager\ServiceManager;

class RouteParamsGuardFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceReturned()
    {
        $options = new ModuleOptions();
        $options->setAuthorizeService('AuthorizeService');

        $sm = m::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('AuthorizeService')->andReturn(new AuthorizeService());
        $sm->shouldReceive('get')->with('SpiffyAuthorize\Options\ModuleOptions')->andReturn($options);

        $factory  = new RouteParamsGuardFactory();
        $instance = $factory->createService($sm);

        $this->assertInstanceOf('SpiffyAuthorize\Guard\RouteParamsGuard', $instance);
    }
}
