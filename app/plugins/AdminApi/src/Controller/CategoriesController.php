<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use Cake\ORM\TableRegistry;
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
    public function initialize() : void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
        $this->loadComponent('Authentication.Authentication');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\CategoriesTable", collection="default")
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $query = $this->Categories->search($this->request);
        $categories = $this->paginate($query);

        $this->set(compact('categories'));
        $this->viewBuilder()->setOption('serialize', 'categories');
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $category = $this->Categories->get($id, [
            'contain' => ['FilmCategories'],
        ]);

        $this->set('category', $category);
        $this->viewBuilder()->setOption('serialize', 'category');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void HTTP 200
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $category = $this->Categories->newEmptyEntity();
        $category = $this->Categories->patchEntity($category, $this->request->getData());
        if ($this->Categories->save($category)) {
            $this->set('category', $category);
            $this->viewBuilder()->setOption('serialize', 'category');

            return;
        }
        throw new \Exception('Record not created');
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        $category = $this->Categories->patchEntity($category, $this->request->getData());
        if ($this->Categories->save($category)) {
            $this->set('category', $category);
            $this->viewBuilder()->setOption('serialize', 'category');

            return;
        }
        throw new \Exception('Record not saved');
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception('Record not deleted');
    }
}
