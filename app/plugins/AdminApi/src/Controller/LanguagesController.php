<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use Cake\ORM\TableRegistry;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * Languages Controller
 *
 * @property \App\Model\Table\LanguagesTable $Languages
 * @method \App\Model\Entity\Language[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LanguagesController extends AppController
{
    public function initialize() : void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
        $this->loadComponent('Authentication.Authentication');
        $this->Languages = TableRegistry::getTableLocator()->get('Languages');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\LanguagesTable", collection="default")
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $query = $this->Languages
            ->find('search', [
                'search' => $this->request->getQueryParams(),
                'collection' => 'default',
            ]);
        $languages = $this->paginate($query);

        $this->set(compact('languages'));
        $this->viewBuilder()->setOption('serialize', 'languages');
    }

    /**
     * View method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $language = $this->Languages->get($id, [
            'contain' => ['Films'],
        ]);

        $this->set('language', $language);
        $this->viewBuilder()->setOption('serialize', 'language');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $language = $this->Languages->newEmptyEntity();
        $language = $this->Languages->patchEntity($language, $this->request->getData());
        if ($this->Languages->save($language)) {
            $this->set('language', $language);
            $this->viewBuilder()->setOption('serialize', 'language');

            return;
        }
        throw new \Exception('Record not created');
    }

    /**
     * Edit method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Language Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $language = $this->Languages->get($id, [
            'contain' => [],
        ]);
        $language = $this->Languages->patchEntity($language, $this->request->getData());
        if ($this->Languages->save($language)) {
            $this->set('language', $language);
            $this->viewBuilder()->setOption('serialize', 'language');

            return;
        }
        throw new \Exception('Record not saved');
    }

    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Language Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $language = $this->Languages->get($id);
        if ($this->Languages->delete($language)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception('Record not deleted');
    }
}
