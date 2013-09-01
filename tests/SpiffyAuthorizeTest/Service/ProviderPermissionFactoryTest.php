<?php

namespace SpiffyAuthorizeTest\Service;

use SpiffyAuthorize\Service\ProviderPermissionFactory;
use SpiffyAuthorizeTest\Util\ServiceManagerFactory;

class ProviderPermissionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testProvidersReturned()
    {
        $factory   = new ProviderPermissionFactory();
        $providers = $factory->createService(ServiceManagerFactory::getServiceManager());

        $this->assertCount(1, $providers);
        $this->assertEquals(array('foo' => array('bar', 'baz')), $providers[0]->getRules());
    }
}
