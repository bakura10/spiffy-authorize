<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService'
        )
    ),
    'spiffy_authorize' => array(
        'permission_providers' => array(
            array(
                'name'    => 'SpiffyAuthorize\Provider\Permission\Config\RbacProvider',
                'options' => array(
                    'rules' => array(
                        'foo' => array( 'bar', 'baz' )
                    )
                )
            )
        ),
        'role_providers' => array(
            array(
                'name'    => 'SpiffyAuthorize\Provider\Role\Config\RbacProvider',
                'options' => array(
                    'rules' => array(
                        'admin' => array('moderator')
                    )
                )
            )
        ),
        'guards' => array(
            'route_rules' => array(
                'foo' => array('bar'),
                'baz' => array('biz')
            )
        ),
    )
);