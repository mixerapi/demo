<?php
declare(strict_types=1);

namespace Crud;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class GetRecordService
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
     * @param string|integer $id
     * @return \App\Model\Entity\Actor
     * @throws \Exception
     */
    public function retrieve($id): EntityInterface
    {
        return $this->locator->get($this->tableName)->get($id, [
            'contain' => [],
        ]);
    }

    /**
     * Returns the Table
     *
     * @return Table
     */
    public function getRepository(): Table
    {
        return $this->locator->get($this->tableName);
    }
}
