<?php
declare(strict_types=1);

namespace Crud;

use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use Exception;

class AddRecordService
{
    use CrudTrait;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @param LocatorInterface|null $locator
     */
    public function __construct(?LocatorInterface $locator = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
    }

    /**
     * Saves the data in the request body
     *
     * @param ServerRequest $request
     * @return EntityInterface
     * @throws Exception
     */
    public function save(ServerRequest $request): EntityInterface
    {
        $table = $this->locator->get($this->tableName);

        $entity = $table->patchEntity(
            $table->newEmptyEntity(),
            $request->getData()
        );

        $entity = $table->save($entity);

        if (!$entity) {
            throw new Exception("Unable to save $this->tableName record");
        }

        return $entity;
    }
}
