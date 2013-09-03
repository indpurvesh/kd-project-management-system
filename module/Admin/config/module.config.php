<?php

// module/StickyNotes/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Role' => 'Admin\Controller\RoleController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'system-settings' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/system-settings',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'admin' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                    
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action][/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'page' => 1,
                            ),
                        ),
                    ),
                    'user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'controller' => 'user',
                                'page' => 1,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
         'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array( 
            'pagination' => __DIR__ . '/../view/partial/slidePaginator.phtml',
        ),
    ),
);