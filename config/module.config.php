<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace MIAInstaller;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'router' => [
        'routes' => [
            'installer' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/installer[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class
        ],
    ],
    'view_manager' => [
        'doctype'                  => 'HTML5',
        'template_map' => [
            'mia-installer/index/index' => __DIR__ . '/../view/mia-installer/index/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'authentication_acl' => [
        'resources' => [
            Controller\IndexController::class => [
                'actions' => [
                    'index' => ['allow' => 'guest']
                ]
            ]
        ],
    ],
);
