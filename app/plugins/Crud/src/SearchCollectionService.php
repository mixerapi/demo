<?php
declare(strict_types=1);

namespace Crud;

use Cake\Controller\Controller;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
use Cake\ORM\Table;

class SearchCollectionService
{
    use CrudTrait;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var string
     */
    private $collectionName = 'default';

    /**
     * @param LocatorInterface $locator
     */
    public function __construct(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * The search collection to use
     *
     * @param string $collection
     * @return $this
     */
    public function collection(string $collection)
    {
        $this->collectionName = $collection;

        return $this;
    }

    /**
     * Performs the search and returns a ResultSetInterface suitable for CakePHP view rendering
     *
     * @param Controller $controller The Controller object
     * @return ResultSetInterface
     */
    public function search(Controller $controller): ResultSetInterface
    {
        return $controller->paginate(
            $this->query($controller)
        );
    }

    /**
     * Builds a Query object and returns it
     *
     * @param Controller $controller
     * @return Query
     */
    public function query(Controller $controller): Query
    {
        $controller->getRequest()->allowMethod('get');

        $table = $this->locator->get($this->tableName);

        if ($table->hasBehavior('Search')) {
            $query = $table->find('search', [
                'search' => $controller->getRequest()->getQueryParams(),
                'collection' => $this->collectionName,
            ]);
        } else {
            $query = $table->find('all');
        }

        return $query;
    }

    /**
     * Returns the Table
     *
     * @return Table
     */
    public function getTable(): Table
    {
        return $this->locator->get($this->tableName);
    }
}
