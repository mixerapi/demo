<?php
declare(strict_types=1);

namespace Crud;

use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorInterface;
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
     * @param LocatorInterface $locator
     * @param GetRecordService $getRecord
     */
    public function __construct(LocatorInterface $locator, GetRecordService $getRecord)
    {
        $this->locator = $locator;
        $this->getRecord = $getRecord;
    }

    /**
     * @param string|integer $id
     * @throws \Exception
     */
    public function delete($id): void
    {
        $entity = $this->getRecord->table($this->tableName)->retrieve($id);
        if (!$this->locator->get($this->tableName)->delete($entity)) {
            throw new Exception("Unable to delete $this->tableName record");
        }
    }
}
