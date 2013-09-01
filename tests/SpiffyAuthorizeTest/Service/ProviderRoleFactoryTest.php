<?php

namespace SpiffyAuthorizeTest\Service;

use SpiffyAuthorize\Service\ProviderRoleFactory;
use SpiffyAuthorizeTest\Util\ServiceManagerFactory;

class ProviderRoleFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testProvidersReturned()
    {
        $factory   = new ProviderRoleFactory();
        $providers = $factory->createService(ServiceManagerFactory::getServiceManager());

        $this->assertCount(1, $providers);
        $this->assertEquals(array('admin' => array('moderator')), $providers[0]->getRules());
    }
}
