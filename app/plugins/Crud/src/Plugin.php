<?php
declare(strict_types=1);

namespace Crud;

use Cake\Controller\Controller;
use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use League\Container\Container;

/**
 * Plugin for Crud
 */
class Plugin extends BasePlugin
{
    /**
     * Console middleware
     *
     * @var bool
     */
    protected $consoleEnabled = false;

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected $middlewareEnabled = false;

    /**
     * Enforce request->allowMethod() for the follow action/http-method pair.
     *
     * To alter: Set $options['allowedMethods'] to the mapping of your choice
     * To disable: Set $options['allowedMethods'] to an empty array to turn this functionality off.
     *
     * @var array
     */
    private $allowedMethods = [
        'add' => ['post'],
        'index' => ['get'],
        'view' => ['get'],
        'edit' => ['patch','put','patch'],
        'delete' => ['delete'],
    ];

    /**
     * Should viewVars be serialized automatically? Defaults to true, set to false to disable.
     *
     * @var bool
     */
    private $doSerialize = true;

    /**
     * See this class for allowed $options
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->allowedMethods = $options['allowedMethods'] ?? $this->allowedMethods;
        $this->doSerialize = $options['doSerialize'] ?? $this->doSerialize;
    }

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
        $this->allowedMethodsEvent();
        $this->serializeEvent();
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        /** @var Container $container */
        $container->addServiceProvider((new CrudServiceProvider())->withSharing());
    }

    /**
     * Registers listener to enforce allowed methods
     */
    private function allowedMethodsEvent(): void
    {
        if (empty($this->actionMap)) {
            return;
        }

        EventManager::instance()->on('Controller.initialize', function (Event $event) {
            /** @var Controller $controller */
            $controller = $event->getSubject();
            $action = $controller->getRequest()->getParam('action');

            if (is_array($this->allowedMethods) && isset($this->allowedMethods[$action])) {
                $controller->getRequest()->allowMethod($this->allowedMethods[$action]);
            }
        });
    }

    /**
     * Register listener for automatic serialization on all responses with a status code in the 200-299 range.
     */
    private function serializeEvent(): void
    {
        if (!$this->doSerialize) {
            return;
        }

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
}
