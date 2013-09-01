<?php

namespace SpiffyAuthorize\Guard;

use SpiffyAuthorize\Service\AuthorizeServiceInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\AbstractOptions;

/**
 * Abstract class for all guards
 */
abstract class AbstractGuard implements GuardInterface
{
    /**
     * Add the listener aggregate trait
     */
    use ListenerAggregateTrait;

    /**
     * List of possible results for the guard
     */
    const INFO_AUTHORIZED          = 'info-authorized';
    const INFO_NO_RULES            = 'info-no-rules';
    const INFO_UNKNOWN_ROUTE       = 'info-unknown-route';
    const ERROR_UNAUTHORIZED_ROUTE = 'error-unauthorized-route';

    /**
     * @var AuthorizeServiceInterface
     */
    protected $authorizeService;

    /**
     * Constructor
     *
     * @param AuthorizeServiceInterface $authorizeService
     */
    public function __construct(AuthorizeServiceInterface $authorizeService)
    {
        $this->authorizeService = $authorizeService;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorizeService()
    {
        return $this->authorizeService;
    }
}
