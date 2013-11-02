<?php

namespace SpiffyAuthorize\Options;

use Zend\Stdlib\AbstractOptions;

class GuardsOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $routeRules = array();

    /**
     * @param  array $routeRules
     * @return void
     */
    public function setRouteRules(array $routeRules)
    {
        $this->routeRules = $routeRules;
    }

    /**
     * @return array
     */
    public function getRouteRules()
    {
        return $this->routeRules;
    }
} 