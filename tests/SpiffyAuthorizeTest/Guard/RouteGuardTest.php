<?php

namespace SpiffyAuthorizeTest\Guard;

use Mockery as m;
use SpiffyAuthorize\Guard\RouteGuard;
use SpiffyAuthorizeTest\Asset\AuthorizeService;
use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RouteGuardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RouteGuard
     */
    protected $guard;

    public function setUp()
    {
        $this->guard = new RouteGuard(new AuthorizeService());
    }

    public function testDoesNotHaveRulesByDefault()
    {
        $this->assertCount(0, $this->guard->getRules());
    }

    public function testCanSetRulesByConstructor()
    {
        $guard = new RouteGuard(new AuthorizeService(), array('foo' => array('no-access')));
        $this->assertCount(1, $guard->getRules());
    }

    public function testProperlyConvertStringPermissionToArray()
    {
        $this->guard->setRules(array('foo' => 'bar'));

        $this->assertCount(1, $this->guard->getRules());
        $this->assertEquals(array('bar'), $this->guard->getRules()['foo']);
    }

    public function testCanSetRulesWithNoPermissions()
    {
        $this->guard->setRules(array('foo'));

        $this->assertCount(1, $this->guard->getRules());
        $this->assertEquals(array(), $this->guard->getRules()['foo']);
    }

    public function testNoRuleForRoute()
    {
        $mvcEvent = $this->getMvcEvent('i-do-not-know');

        $this->guard->setRules(array('foo' => array('no-access')));
        $this->guard->onRoute($mvcEvent);

        $this->assertEquals(RouteGuard::INFO_UNKNOWN_ROUTE, $mvcEvent->getParam('guard-result'));
    }

    public function testNoRouteIsPassThru()
    {
        $mvcEvent = $this->getMvcEvent('foo');

        $this->guard->onRoute($mvcEvent);

        $this->assertEquals(RouteGuard::INFO_NO_RULES, $mvcEvent->getParam('guard-result'));
    }

    public function testNoMatchIsUnauthorized()
    {
        $mvcEvent = $this->getMvcEvent('foo');

        $this->guard->setRules(array('foo' => array('no-access')));
        $this->guard->onRoute($mvcEvent);

        $this->assertEquals(RouteGuard::ERROR_UNAUTHORIZED_ROUTE, $mvcEvent->getError());
    }

    public function testNoMatchTriggersDispatchError()
    {
        $mvcEvent = $this->getMvcEvent('foo');

        $triggered = false;
        $app       = $mvcEvent->getTarget();
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH_ERROR, function() use (&$triggered) {
            $triggered = true;
        });

        $this->guard->setRules(array('foo' => array('no-access')));
        $this->guard->onRoute($mvcEvent);

        $this->assertTrue($triggered);
    }

    public function testMatchedRouteIsAuthorized()
    {
        $mvcEvent = $this->getMvcEvent('foo');

        $this->guard->setRules(array('foo' => array('no-access', 'route-foo')));
        $this->guard->onRoute($mvcEvent);

        $this->assertEquals(
            RouteGuard::INFO_AUTHORIZED,
            $mvcEvent->getParam('guard-result')
        );
        $this->assertEquals(
            'route-foo',
            $mvcEvent->getParam('guard-resource')
        );

        $this->guard->setRules(array('^f\w\w$' => array( 'route-foo' )));
        $this->guard->onRoute($mvcEvent);

        $this->assertEquals(
            RouteGuard::INFO_AUTHORIZED,
            $mvcEvent->getParam('guard-result')
        );
        $this->assertEquals(
            'route-foo',
            $mvcEvent->getParam('guard-resource')
        );
    }

    /**
     * @param string $route
     * @return MvcEvent
     */
    protected function getMvcEvent($route)
    {
        $app = m::mock('Zend\Mvc\Application');
        $app->shouldReceive('getEventManager')
            ->andReturn(new EventManager());

        $routeMatch = new RouteMatch(array());
        $routeMatch->setMatchedRouteName($route);

        $mvcEvent = new MvcEvent();
        $mvcEvent->setRouteMatch($routeMatch);
        $mvcEvent->setTarget($app);

        return $mvcEvent;
    }
}
