<?php
declare(strict_types=1);

namespace Crud;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\TableRegistry;

class GetResourceService
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
     * Returns the Entity
     *
     * @param string|integer $id
     * @return \App\Model\Entity\Actor
     * @throws \Exception
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     */
    public function get($id): EntityInterface
    {
        return $this->locator->get($this->tableName)->get($id, [
            'contain' => [],
        ]);
    }
}
