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

class AddRecordService
{
    use CrudTrait;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var Deserializer
     */
    private $deserializer;

    /**
     * @param LocatorInterface|null $locator
     * @param Deserializer|null $deserializer
     */
    public function __construct(?LocatorInterface $locator = null, ?Deserializer $deserializer = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->deserializer = $deserializer ?? new Deserializer();
    }

    /**
     * Saves the data in the request body
     *
     * @param ServerRequest $request
     * @return EntityInterface
     * @throws Exception
     * @throws RecordNotSavedException
     */
    public function save(ServerRequest $request): EntityInterface
    {
        $table = $this->locator->get($this->tableName);

        $entity = $table->patchEntity(
            $table->newEmptyEntity(),
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
