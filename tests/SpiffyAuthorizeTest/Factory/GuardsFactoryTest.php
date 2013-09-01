<?php

namespace SpiffyAuthorizeTest\Service;

use Mockery as m;
use SpiffyAuthorize\Factory\GuardsFactory;
use SpiffyAuthorize\Guard\RouteGuard;
use SpiffyAuthorize\Options\ModuleOptions;
use SpiffyAuthorizeTest\Asset\AuthorizeService;
use Zend\ServiceManager\ServiceManager;

class GuardsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceReturned()
    {
        $options = new ModuleOptions(array(
            'guards' => array(
                array(
                    'type'    => 'SpiffyAuthorize\Guard\RouteGuard',
                    'options' => array(
                        'rules' => array(
                            'foo' => array('bar')
                        )
                    )
                ),
                array(
                    'type'    => 'SpiffyAuthorize\Guard\RouteGuard',
                    'options' => array(
                        'rules' => array(
                            'baz' => array('PHP is awesome')
                        )
                    )
                )
            )
        ));

        $options->setAuthorizeService('AuthorizeService');
        $authorizeService = new AuthorizeService();

        $sm = m::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('SpiffyAuthorize\Guard\RouteGuard')->twice()->andReturn(new RouteGuard($authorizeService));
        $sm->shouldReceive('get')->with('AuthorizeService')->andReturn($authorizeService);
        $sm->shouldReceive('get')->with('SpiffyAuthorize\Options\ModuleOptions')->andReturn($options);

        $factory = new GuardsFactory();
        $guards  = $factory->createService($sm);

        $this->assertInternalType('array', $guards);
        foreach ($guards as $guard) {
            $this->assertInstanceOf('SpiffyAuthorize\Guard\RouteGuard', $guard);
        }
    }
}
