<?php
declare(strict_types=1);

namespace Crud;

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;
use Exception;

class DeleteRecordService
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
     * @param string|integer $id
     * @throws \Exception
     */
    public function delete($id): void
    {
        $entity = $this->getRecord->table($this->tableName)->retrieve($id);
        $this->allowDelete($entity);

        if (!$this->locator->get($this->tableName)->delete($entity)) {
            throw new Exception("Unable to delete $this->tableName record");
        }
    }

    /**
     * Prevent deletions of seed data in the live demo
     *
     * @param EntityInterface $entity
     * @throws Exception
     */
    private function allowDelete(EntityInterface $entity): void
    {
        if (Configure::read('debug')) {
            return;
        }

        if (!$entity->has('modified')) {
            throw new MethodNotAllowedException(
                'Deletes on certain records are disabled on the public demo, try another.'
            );
        }

        if (Chronos::today()->diffInMonths($entity->get('modified'), false) < 0) {
            throw new MethodNotAllowedException(
                'You may only delete new records. Try creating a record then deleting it instead'
            );
        }
    }
}
