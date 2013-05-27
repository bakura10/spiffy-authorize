<?php

namespace SpiffyAuthorize\Collector;

use RecursiveIteratorIterator;
use ReflectionClass;
use Serializable;
use SpiffyAuthorize\Permission\PermissionInterface;
use SpiffyAuthorize\Service\RbacService;
use Zend\Mvc\MvcEvent;
use ZendDeveloperTools\Collector\CollectorInterface;

class PermissionCollector implements
    CollectorInterface,
    Serializable
{
    const NAME     = 'spiffy_authorize_permission_collector';
    const PRIORITY = 100;

    /**
     * @var RbacService
     */
    protected $rbacService;

    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @param RbacService $rbacService
     */
    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Collector Name.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Collector Priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        return self::PRIORITY;
    }

    /**
     * Collects data.
     *
     * @param MvcEvent $mvcEvent
     * @return void
     */
    public function collect(MvcEvent $mvcEvent)
    {
        $service  = $this->rbacService;
        $provider = $this->rbacService->getIdentityProvider();

        if (!$provider) {
            return;
        }

        /** @var \Zend\Permissions\Rbac\Rbac $rbac */
        $rbac        = $service->getContainer();
        $roles       = $provider->getIdentityRoles();
        $permissions = [];

        // No getPermissions() available, have to use reflection.
        $reflClass    = new ReflectionClass('Zend\Permissions\Rbac\Role');
        $reflProperty = $reflClass->getProperty('permissions');
        $reflProperty->setAccessible(true);

        foreach ($roles as $role) {
            if ($rbac->hasRole($role)) {
                if (!isset($permissions[$role])) {
                    $permissions[$role] = [];
                }
                $permissions[$role] = array_merge($reflProperty->getValue($rbac->getRole($role)), $permissions[$role]);

                $it = new RecursiveIteratorIterator(
                    $rbac->getRole($role),
                    RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($it as $leaf) {
                    $permissions[$role] = array_merge($reflProperty->getValue($leaf), $permissions[$role]);
                }
            }
        }

        $this->permissions = $permissions;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->permissions);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->permissions = unserialize($serialized);
    }
}