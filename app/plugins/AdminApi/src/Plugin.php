<?php
declare(strict_types=1);

namespace AdminApi;

use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use AuthenticationApi\JwtAuthService;
use Cake\Core\BasePlugin;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\AutoRouter;
use MixerApi\Rest\Lib\Route\ResourceScanner;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Plugin for AdminApi
 */
class Plugin extends BasePlugin implements AuthenticationServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    protected ?string $name = 'AdminApi';

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
    protected bool $servicesEnabled = false;

    /**
     * @inheritDoc
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Add the AuthenticationMiddleware. It should be
            // after routing and body parser.
            ->add(new AuthenticationMiddleware($this));

        // Cross Site Request Forgery (CSRF) Protection Middleware
        // https://book.cakephp.org/4/en/controllers/middleware.html#cross-site-request-forgery-csrf-middleware
        //->add(new CsrfProtectionMiddleware([
        //    'httponly' => true,
        //]));

        return $middlewareQueue;
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin('AdminApi', ['path' => '/admin'], function (RouteBuilder $builder) {
            $builder->setExtensions(['json','xml']);
            $builder->connect('/', [
                'plugin' => 'AdminApi', 'controller' => 'Swagger', 'action' => 'index'
            ]);
            $builder->fallbacks();

            $builder->resources('Actors');
            $builder->resources('Categories');
            $builder->resources('Films');
            $builder->resources('Languages');
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
     * @throws \MixerApi\JwtAuth\Exception\JwtAuthException
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        return JwtAuthService::create();
    }
}
