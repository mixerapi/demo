<?php
declare(strict_types=1);

namespace Crud;

use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Crud\Exception\RecordNotSavedException;
use Exception;

class EditRecordService
{
    use CrudTrait;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var GetResourceService
     */
    private $resource;

    /**
     * @var Deserializer
     */
    private $deserializer;

    /**
     * @param LocatorInterface|null $locator
     * @param GetResourceService|null $resource
     * @param Deserializer|null $deserializer
     */
    public function __construct(
        ?LocatorInterface $locator = null,
        ?GetResourceService $resource = null,
        ?Deserializer $deserializer = null
    ){
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->resource = $resource ?? new GetResourceService();
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * Saves the data in the request body
     *
     * @param ServerRequest $request
     * @param string|integer $id
     * @return EntityInterface
     * @throws Exception
     * @throws RecordNotSavedException
     */
    public function save(ServerRequest $request, $id): EntityInterface
    {
        $table = $this->locator->get($this->tableName);

        $entity = $table->patchEntity(
            $this->resource->setTable($this->tableName)->get($id),
            $this->deserializer->deserialize($request)
        );

        $entity = $table->save($entity);

        if (!$entity) {
            $name = ucwords(Inflector::singularize(Inflector::delimit($this->tableName, ' ')));
            throw new RecordNotSavedException("Unable to save $name");
        }

        return $entity;
    }
}
