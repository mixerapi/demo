<?php
declare(strict_types=1);

namespace Crud;

use Cake\Core\ContainerInterface;
use Cake\Core\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
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
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        foreach ($this->provides as $provide) {
            $container->add($provide);
        }
    }
}
