<?php
declare(strict_types=1);

namespace Crud;

use Cake\Controller\Controller;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for Crud
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
        EventManager::instance()->on('Controller.initialize', function (Event $event) {
            /** @var Controller $controller */
            $controller = $event->getSubject();
            $actionMap = [
                'add' => ['post'],
                'index' => ['get'],
                'view' => ['get'],
                'edit' => ['patch'],
                'delete' => ['delete'],
            ];

            $action = $controller->getRequest()->getParam('action');

            if (isset($actionMap[$action])) {
                $controller->getRequest()->allowMethod($actionMap[$action]);
            }
        });

        EventManager::instance()->on('Controller.beforeRender', function (Event $event) {
            /** @var Controller $controller */
            $controller = $event->getSubject();
            $keys = array_keys($controller->viewBuilder()->getVars());

            if ($controller->getResponse()->getStatusCode() >= 300) {
                return;
            }

            if (!empty($keys)) {
                $controller->viewBuilder()->setOption('serialize', reset($keys));
            }
        });
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
        // Add your middlewares here

        return $middlewareQueue;
    }
}
