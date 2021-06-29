<?php
declare(strict_types=1);

namespace Crud;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
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
     * The search collection name
     *
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

        if (!$this->hasSearch || !$table->hasBehavior('Search')) {
            return $table->find('all');
        }

        return $table->find('search', [
            'search' => $controller->getRequest()->getQueryParams(),
            'collection' => $this->collectionName,
        ]);
    }

    /**
     * The search collection to use
     *
     * @param string $collection
     * @return $this
     */
    public function setCollection(string $collection)
    {
        $this->collectionName = $collection;

        return $this;
    }
}
