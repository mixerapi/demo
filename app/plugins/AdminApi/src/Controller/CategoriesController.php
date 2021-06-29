<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use Crud\AddRecordService;
use Crud\DeleteRecordService;
use Crud\EditRecordService;
use Crud\GetResourceService;
use Crud\SearchCollectionService;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
            'modelClass' => 'Categories'
        ]);
    }

    /**
     * Index method
     *
     * @param SearchCollectionService $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\CategoriesTable", collection="default")
     */
    public function index(SearchCollectionService $search)
    {
        $this->set('categories', $search->setTable('Categories')->search($this));
    }

    /**
     * View method
     *
     * @param GetResourceService $resource
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(GetResourceService $resource, string $id)
    {
        $this->set('category', $resource->setTable('Categories')->get($id));
    }

    /**
     * Add method
     *
     * @param AddRecordService $add
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add(AddRecordService $add)
    {
        $this->set('category', $add->setTable('Categories')->save($this->request));
    }

    /**
     * Edit method
     *
     * @param EditRecordService $edit
     * @param string $id
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit(EditRecordService $edit, string $id)
    {
        $this->set('category', $edit->setTable('Categories')->save($this->request, $id));
    }

    /**
     * Delete method
     *
     * @param DeleteRecordService $delete
     * @param string $id
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete(DeleteRecordService $delete, string $id)
    {
        return $delete->setTable('Categories')->delete($id)->respond();
    }
}
