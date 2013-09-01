<?php

namespace SpiffyAuthorizeTest\Service;

use SpiffyAuthorize\AuthorizeEvent;
use SpiffyAuthorize\Options\ModuleOptions;
use SpiffyAuthorize\Service\RbacServiceFactory;
use SpiffyAuthorizeTest\Asset\Identity;
use SpiffyAuthorizeTest\Util\ServiceManagerFactory;

class RbacServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceReturned()
    {
        $options = new ModuleOptions();
        $options->setIdentityProvider('IdentityProvider');

        $sm = ServiceManagerFactory::getServiceManager();
        $sm->setService('IdentityProvider', new Identity());

        $factory = new RbacServiceFactory();

        /** @var \SpiffyAuthorize\Service\RbacService $instance */
        $instance = $factory->createService($sm);

        $this->assertInstanceOf('SpiffyAuthorize\Provider\Identity\AuthenticationProvider', $instance->getIdentityProvider());
        $this->assertInstanceOf('SpiffyAuthorize\Service\RbacService', $instance);
        $this->assertCount(2, $instance->getEventManager()->getListeners(AuthorizeEvent::EVENT_INIT));
    }
}
