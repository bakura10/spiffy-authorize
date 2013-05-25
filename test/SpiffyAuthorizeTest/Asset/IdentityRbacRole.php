<?php

namespace SpiffyAuthorizeTest\Asset;

use SpiffyAuthorize\Identity\IdentityInterface;
use Zend\Permissions\Rbac\Role;

class IdentityRbacRole implements IdentityInterface
{
    /**
     * @return array
     */
    public function getRoles()
    {
        return [
            new Role('foo'),
            new Role('bar')
        ];
    }
}