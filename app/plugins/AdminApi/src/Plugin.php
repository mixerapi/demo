<?php
declare(strict_types=1);

namespace AdminApi;

use Authentication\AuthenticationService;
use Authentication\Middleware\AuthenticationMiddleware;
use AuthenticationApi\Service\JwkSetAuthService;
use AuthenticationApi\Service\JwtAuthService;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\AutoRouter;
use MixerApi\Rest\Lib\Route\ResourceScanner;

/**
 * Plugin for AdminApi
 */
class Plugin extends BasePlugin
{
    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin('AdminApi', ['path' => '/admin'], function (RouteBuilder $builder) {
            /*
             * Enable one of JWT Auth or JWK Set Auth:
             */
            $authService = (new JwkSetAuthService)->getService(new AuthenticationService());
            //$authService = (new JwtAuthService)->getService(new AuthenticationService());

            $authMiddleware = new AuthenticationMiddleware($authService);
            $builder->registerMiddleware('auth', $authMiddleware);
            $builder->applyMiddleware('auth');
            $builder->setExtensions(['json','xml']);
            (new AutoRouter($builder, new ResourceScanner('AdminApi\Controller')))->buildResources();
            $builder->connect('/', [
                'plugin' => 'AdminApi', 'controller' => 'Swagger', 'action' => 'index'
            ]);
            $builder->fallbacks();
        });

        $routes->connect('/admin/contexts/*', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
        ]);
        $routes->connect('/admin/vocab', [
            'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
        ]);

        parent::routes($routes);
    }

    /**
     * @inheritDoc
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue;
    }
}
