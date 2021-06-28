<?php
declare(strict_types=1);

namespace Crud;

use Cake\Core\ServiceProvider;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;

class CrudServiceProvider extends ServiceProvider
{
    protected $provides = [
        AddRecordService::class,
        EditRecordService::class,
        DeleteRecordService::class,
        GetRecordService::class,
        SearchCollectionService::class,
    ];

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var GetRecordService
     */
    private $getRecord;

    /**
     * @param LocatorInterface|null $locator
     * @param GetRecordService|null $getRecord
     */
    public function __construct(?LocatorInterface $locator = null, ?GetRecordService $getRecord = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->getRecord = $getRecord ?? new GetRecordService($this->locator);
    }

    public function services($container): void
    {
        $container
            ->add(AddRecordService::class)
            ->addArgument($this->locator);

        $container
            ->add(EditRecordService::class)
            ->addArgument($this->locator)
            ->addArgument($this->getRecord);

        $container
            ->add(DeleteRecordService::class)
            ->addArgument($this->locator)
            ->addArgument($this->getRecord);

        $container
            ->add(GetRecordService::class)
            ->addArgument($this->locator);

        $container
            ->add(SearchCollectionService::class)
            ->addArgument($this->locator);
    }
}
