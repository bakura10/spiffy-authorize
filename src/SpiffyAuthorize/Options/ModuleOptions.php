<?php

namespace SpiffyAuthorize\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $authorizeService = 'SpiffyAuthorize\Service\RbacService';

    /**
     * @var string
     */
    protected $defaultRole = 'member';

    /**
     * @var string
     */
    protected $defaultGuestRole = 'guest';

    /**
     * @var string
     */
    protected $identityProvider = 'SpiffyAuthorize\Provider\Identity\AuthenticationProvider';

    /**
     * @var array
     */
    protected $permissionProviders = array();

    /**
     * @var array
     */
    protected $roleProviders = array();

    /**
     * @var GuardsOptions
     */
    protected $guards = array();

    /**
     * @var string
     */
    protected $viewStrategy = 'SpiffyAuthorize\View\UnauthorizedStrategy';

    /**
     * @var string
     */
    protected $viewTemplate = 'error/403';

    /**
     * @param  string $authorizeService
     * @return void
     */
    public function setAuthorizeService($authorizeService)
    {
        $this->authorizeService = (string) $authorizeService;
    }

    /**
     * @return string
     */
    public function getAuthorizeService()
    {
        return $this->authorizeService;
    }

    /**
     * @param string $defaultRole
     * @return void
     */
    public function setDefaultRole($defaultRole)
    {
        $this->defaultRole = (string) $defaultRole;
    }

    /**
     * @return string
     */
    public function getDefaultRole()
    {
        return $this->defaultRole;
    }

    /**
     * @param  string $defaultGuestRole
     * @return void
     */
    public function setDefaultGuestRole($defaultGuestRole)
    {
        $this->defaultGuestRole = (string) $defaultGuestRole;
    }

    /**
     * @return string
     */
    public function getDefaultGuestRole()
    {
        return $this->defaultGuestRole;
    }

    /**
     * @param  string $identityProvider
     * @return void
     */
    public function setIdentityProvider($identityProvider)
    {
        $this->identityProvider = (string) $identityProvider;
    }

    /**
     * @return string
     */
    public function getIdentityProvider()
    {
        return $this->identityProvider;
    }

    /**
     * @param  array $permissionProviders
     * @return void
     */
    public function setPermissionProviders(array $permissionProviders)
    {
        $this->permissionProviders = $permissionProviders;
    }

    /**
     * @return array
     */
    public function getPermissionProviders()
    {
        return $this->permissionProviders;
    }

    /**
     * @param  array $roleProviders
     * @return void
     */
    public function setRoleProviders(array $roleProviders)
    {
        $this->roleProviders = $roleProviders;
    }

    /**
     * @return array
     */
    public function getRoleProviders()
    {
        return $this->roleProviders;
    }

    /**
     * @param  array $guards
     * @return void
     */
    public function setGuards(array $guards)
    {
        $this->guards = new GuardsOptions($guards);
    }

    /**
     * @return GuardsOptions
     */
    public function getGuards()
    {
        return $this->guards;
    }

    /**
     * @param  string $viewTemplate
     * @return void
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = (string) $viewTemplate;
    }

    /**
     * @return string
     */
    public function getViewTemplate()
    {
        return $this->viewTemplate;
    }

    /**
     * @param  string $viewStrategy
     * @return void
     */
    public function setViewStrategy($viewStrategy)
    {
        $this->viewStrategy = (string) $viewStrategy;
    }

    /**
     * @return string
     */
    public function getViewStrategy()
    {
        return $this->viewStrategy;
    }
}