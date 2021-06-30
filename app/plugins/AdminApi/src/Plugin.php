<?php
declare(strict_types=1);

namespace AdminApi;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\AutoRouter;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Plugin for AdminApi
 */
class Plugin extends BasePlugin implements AuthenticationServiceProviderInterface
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

        $app->addPlugin('Authentication');
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
        $routes->plugin('AdminApi', ['path' => '/admin'], function (RouteBuilder $builder) {
            $builder->setExtensions(['json','xml']);
            (new AutoRouter($builder, 'AdminApi\Controller'))->buildResources();
            $builder->connect('/', [
                'plugin' => 'AdminApi', 'controller' => 'Swagger', 'action' => 'index'
            ]);
            $builder->connect('/contexts/*', [
                'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
            ]);
            $builder->connect('/vocab', [
                'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
            ]);
            $builder->fallbacks();
        });

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
        $middlewareQueue->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * Returns a service provider instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     * @return \Authentication\AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $service->loadAuthenticator('Authentication.Token', [
            'header' => 'API-KEY',
        ]);

        // Load identifiers
        $service->loadIdentifier('Authentication.Token',[
            'resolver' => 'AdminApi\Identifier\Resolver\CustomResolver'
        ]);

        return $service;
    }
}
