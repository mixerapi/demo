<?php
declare(strict_types=1);

namespace Crud;

use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use Exception;

class EditRecordService
{
    use CrudTrait;

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
        $this->getRecord = $getRecord ?? new GetRecordService();
    }

    /**
     * Saves the data in the request body
     *
     * @param ServerRequest $request
     * @param string|integer $id
     * @return EntityInterface
     * @throws Exception
     */
    public function save(ServerRequest $request, $id): EntityInterface
    {
        $table = $this->locator->get($this->tableName);
        $entity = $table->patchEntity(
            $this->getRecord->table($this->tableName)->retrieve($id),
            $request->getData()
        );

        $entity = $table->save($entity);

        if (!$entity) {
            throw new Exception("Unable to save $this->tableName record");
        }

        return $entity;
    }
}
