<?php

namespace SpiffyAuthorize\Guard;

use SpiffyAuthorize\Service\AuthorizeServiceInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Interface that each guard must implement
 *
 * A guard is a simple protection layer that occurs between the dispatch and response
 * of your application. A guard allows to simply protect a controller, a route or a
 * route hierarchy (eg. all routes that are child routes of "admin" route), BUT should
 * not be used as the only way to protect your application. Your service layer should
 * also be protected.
 */
interface GuardInterface extends ListenerAggregateInterface
{
    /**
     * Get the authorize service
     *
     * @return AuthorizeServiceInterface
     */
    public function getAuthorizeService();
}
