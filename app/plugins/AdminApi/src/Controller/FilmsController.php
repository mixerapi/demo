<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use Cake\ORM\TableRegistry;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * Films Controller
 *
 * @method \AdminApi\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmsController extends AppController
{
    public function initialize() : void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
        $this->loadComponent('Authentication.Authentication');
        $this->Films = TableRegistry::getTableLocator()->get('Films');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\FilmsTable", collection="default")
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $films = $this->paginate($this->Films);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }

    /**
     * View method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Film Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $film = $this->Films->get($id, [
            'contain' => [],
        ]);

        $this->set('film', $film);
        $this->viewBuilder()->setOption('serialize', 'film');
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
        $film = $this->Films->newEmptyEntity();
        $film = $this->Films->patchEntity($film, $this->request->getData());
        if ($this->Films->save($film)) {
            $this->set('film', $film);
            $this->viewBuilder()->setOption('serialize', 'film');

            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Film Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $film = $this->Films->get($id, [
            'contain' => [],
        ]);
        $film = $this->Films->patchEntity($film, $this->request->getData());
        if ($this->Films->save($film)) {
            $this->set('film', $film);
            $this->viewBuilder()->setOption('serialize', 'film');

            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Film Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $film = $this->Films->get($id);
        if ($this->Films->delete($film)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }
}
