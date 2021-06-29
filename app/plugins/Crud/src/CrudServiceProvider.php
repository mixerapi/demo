<?php
declare(strict_types=1);

namespace Crud;

use Cake\Core\ContainerInterface;
use Cake\Core\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $sharedProviders = [];

    /**
     * @var string[]
     */
    protected $provides = [
        AddRecordService::class,
        EditRecordService::class,
        DeleteRecordService::class,
        GetRecordService::class,
        SearchCollectionService::class,
    ];

    /**
     * By default services are not shared. Every object (and dependencies) is created each time it is fetched from the
     * container. If you want to re-use a single instance, often referred to as a singleton, you can mark a service
     * as shared.
     *
     * @param array|null $providers an array of the services in self::provides that should shared, defaults to all
     * @return CrudServiceProvider
     */
    public function withSharing(?array $providers = null): CrudServiceProvider
    {
        $this->sharedProviders = $providers ?? $this->provides;

        return clone $this;
    }

    /**
     * Adds all services found in $this->provides to the container
     *
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        foreach ($this->provides as $provide) {
            $container->add(
                $provide,
                null,
                in_array($provide, $this->sharedProviders)
            );
        }
    }
}
