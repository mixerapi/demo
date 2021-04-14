<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use Cake\ORM\TableRegistry;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * Actors Controller
 *
 * @method \AdminApi\Model\Entity\Actor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
        $this->loadComponent('Authentication.Authentication');
        $this->Actors = TableRegistry::getTableLocator()->get('Actors');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\ActorsTable", collection="default")
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $query = $this->Actors->search($this->request);
        $actors = $this->paginate($query);

        $this->set(compact('actors'));
        $this->viewBuilder()->setOption('serialize', 'actors');
    }


    /**
     * View method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Actor Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $actor = $this->Actors->get($id, [
            'contain' => [],
        ]);

        $this->set('actor', $actor);
        $this->viewBuilder()->setOption('serialize', 'actor');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $actor = $this->Actors->newEmptyEntity();
        $actor = $this->Actors->patchEntity($actor, $this->request->getData());
        if ($this->Actors->save($actor)) {
            $this->set('actor', $actor);
            $this->viewBuilder()->setOption('serialize', 'actor');

            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $actor = $this->Actors->get($id, [
            'contain' => [],
        ]);
        $actor = $this->Actors->patchEntity($actor, $this->request->getData());
        if ($this->Actors->save($actor)) {
            $this->set('actor', $actor);
            $this->viewBuilder()->setOption('serialize', 'actor');

            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $actor = $this->Actors->get($id);
        if ($this->Actors->delete($actor)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }
}
