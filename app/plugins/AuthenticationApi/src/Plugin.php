<?php
declare(strict_types=1);

namespace AuthenticationApi;

use AuthenticationApi\Service\UserAuthenticationService;
use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use Cake\Console\CommandCollection;

/**
 * Plugin for AuthenticationApi
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin('AuthenticationApi', ['path' => '/authentication'], function (RouteBuilder $builder) {
            $builder->setExtensions(['json','xml']);
            $builder->connect('/', [
                'plugin' => 'AuthenticationApi', 'controller' => 'Swagger', 'action' => 'index'
            ]);
            $builder->resources('Authentication', [
                'path' => 'auth',
                'only' => ['user'],
                'map' => [
                    'user' => [
                        'method' => 'post',
                        'path' => 'user',
                        'action' => 'user'
                    ]
                ]
            ]);
            $builder->resources('Jwks', [
                'only' => ['index'],
            ]);
            $builder->fallbacks();
        });
        $routes->connect('/authentication/contexts/*', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
        ]);
        $routes->connect('/authentication/vocab', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
        ]);
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middleware The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param \Cake\Console\CommandCollection $commands The command collection to update.
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands) : CommandCollection
    {
        // Add your commands here

        $commands = parent::console($commands);

        return $commands;
    }

    public function services(ContainerInterface $container): void
    {
        $container->add(UserAuthenticationService::class);
    }
}
