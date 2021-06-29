<?php
declare(strict_types=1);

namespace Crud;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SearchCollectionService
{
    use CrudTrait;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * Does this application have https://github.com/FriendsOfCake/search
     *
     * @var bool
     */
    private $hasSearch;

    /**
     * @var string
     */
    private $collectionName = 'default';

    /**
     * @param LocatorInterface|null $locator
     * @param Plugin|null $plugin
     */
    public function __construct(?LocatorInterface $locator = null, ?Plugin $plugin = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->hasSearch = ($plugin ?? new Plugin())::isLoaded('Search');
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

        if ($this->hasSearch && $table->hasBehavior('Search')) {
            return $table->find('search', [
                'search' => $controller->getRequest()->getQueryParams(),
                'collection' => $this->collectionName,
            ]);
        }

        return $table->find('all');
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
