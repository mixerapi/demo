<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Crud\AddRecordService;
use Crud\DeleteRecordService;
use Crud\EditRecordService;
use Crud\GetRecordService;
use Crud\SearchCollectionService;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * FilmActors Controller
 *
 * @method \AdminApi\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmActorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
            'modelClass' => 'FilmActors'
        ]);
    }

    /**
     * Index method
     *
     * @param SearchCollectionService $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\FilmActorsTable", collection="default")
     */
    public function index(SearchCollectionService $search)
    {
        $this->set('film_actors', $search->table('FilmActors')->search($this));
    }

    /**
     * View method
     *
     * @param GetRecordService $getRecord
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(GetRecordService $getRecord, string $id)
    {
        $this->set('film_actor', $getRecord->table('FilmActors')->retrieve($id));
    }

    /**
     * Add method
     *
     * @param AddRecordService $addRecord
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add(AddRecordService $addRecord)
    {
        $this->set('film_actor', $addRecord->table('FilmActors')->save($this->request));
    }

    /**
     * Edit method
     *
     * @param EditRecordService $editRecord
     * @param string $id
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit(EditRecordService $editRecord, string $id)
    {
        $this->set('film_actor', $editRecord->table('FilmActors')->save($this->request, $id));
    }

    /**
     * Delete method
     *
     * @param DeleteRecordService $deleteRecord
     * @param string $id
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete(DeleteRecordService $deleteRecord, string $id)
    {
        $deleteRecord->table('FilmActors')->delete($id);
        return $this->response->withStatus(204);
    }
}
