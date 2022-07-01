<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\Exception\MissingPluginException;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Exception;
use MixerApi\Core\Event\EventListenerLoader;
use MixerApi\JwtAuth\JwtAuthServiceProvider;
use Muffin\Throttle\Middleware\ThrottleMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->addPlugin('MixerApi');
        $this->addPlugin('MixerApi/Crud', [
            'allowedMethods' => [
                'add' => ['post'],
                'view' => ['get'],
                'edit' => ['patch'],
                'delete' => ['delete'],
                'index' => ['get']
            ]
        ]);
        $this->addPlugin('Search');
        $this->addPlugin('Authentication');
        $this->addPlugin('AdminApi');
        $this->addPlugin('AuthenticationApi');
        $this->addPlugin('Muffin/Throttle');

        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator)->allowFallbackClass(false)
            );
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug') && env('APP_ENV') != 'prod') {
            $this->addPlugin('DebugKit');
        }

        /**
         * Loads all events for all EventInterfaces in App\Event
         */
        (new EventListenerLoader())->load();
    }

    /**
     * @inheritDoc
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(function(ServerRequestInterface $request, RequestHandlerInterface $handler){

                /**
                 * Swagger does not send an accept header on delete requests. This sets delete requests to accept
                 * application/json by default.
                 */
                $clients = $request->getHeader('X-API-CLIENT');
                if (reset($clients) !== 'SWAGGER') {
                    return $handler->handle($request);
                }

                $accept = $request->getHeader('accept');
                if ($request->getMethod() === 'DELETE' && reset($accept) === '*/*') {
                    $request = $request->withHeader('accept', 'application/json');
                }

                return $handler->handle($request);
            })
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))

            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            // Other middleware that CakePHP provides.
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())

            // Cross Site Request Forgery (CSRF) Protection Middleware
            // https://book.cakephp.org/4/en/controllers/middleware.html#cross-site-request-forgery-csrf-middleware
            //->add(new CsrfProtectionMiddleware([
            //    'httponly' => true,
            //]));

            ->add(new ThrottleMiddleware([
                'response' => [
                    'body' => 'Rate limit exceeded',
                ],
                'period' => 60, // Time period as number of seconds
                'limit' => 500, // Number of requests allowed within the above time period
                // Client identifier
                'identifier' => function ($request) {
                    return $request->clientIp();
                }
            ]));

        return $middlewareQueue;
    }

    /**
     * Bootstrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        if (Configure::read('debug')) {
            $this->addPlugin('CakephpFixtureFactories');
        }

        try {
            $this->addPlugin('IdeHelper');
        } catch (Exception $e) {
            // Do not halt
        }

        $this->addPlugin('CakePreloader');
        $this->addPlugin('Migrations');
        $this->addPlugin('Setup');
    }

    /**
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        /** @var \League\Container\Container $container */
        $container->addServiceProvider(new JwtAuthServiceProvider());
    }
}
