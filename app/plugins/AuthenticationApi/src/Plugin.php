<?php
declare(strict_types=1);

namespace AuthenticationApi;

use Cake\Core\BasePlugin;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for AuthenticationApi
 */
class Plugin extends BasePlugin
{
    /**
     * @inheritdoc
     */
    protected ?string $name = 'AuthenticationApi';

    /**
     * @inheritdoc
     */
    protected bool $bootstrapEnabled = false;

    /**
     * @inheritdoc
     */
    protected bool $consoleEnabled = false;

    /**
     * @inheritdoc
     */
    protected bool $middlewareEnabled = false;

    /**
     * @inheritdoc
     */
    protected bool $servicesEnabled = false;

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin('AuthenticationApi', ['path' => '/admin/auth'], function (RouteBuilder $builder) {
            $builder->setExtensions(['json','xml']);
            $builder->connect('/', [
                'plugin' => 'AuthenticationApi', 'controller' => 'Swagger', 'action' => 'index'
            ]);
            $builder->resources('Login', [
                'path' => '/login',
                'only' => ['login'],
                'map' => [
                    'login' => [
                        'method' => 'post',
                        'path' => null,
                        'action' => 'login'
                    ]
                ]
            ]);
            $builder->resources('Jwks', [
                'path' => '/keys',
                'only' => ['index'],
            ]);
            $builder->fallbacks();
        });

        $routes->connect('/admin/auth/contexts/*', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
        ]);
        $routes->connect('/admin/auth/vocab', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
        ]);

        parent::routes($routes);
    }
}
