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
 * FilmActors Controller
 *
 * @method \AdminApi\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmCategoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
            'modelClass' => 'FilmCategories'
        ]);
    }

    /**
     * Index method
     *
     * @param SearchCollectionService $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\FilmCategoriesTable", collection="default")
     */
    public function index(SearchCollectionService $search)
    {
        $this->set('film_categories', $search->setTable('FilmCategories')->search($this));
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
        $this->set('film_category', $resource->setTable('FilmCategories')->get($id));
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
        $this->set('film_category', $add->setTable('FilmCategories')->save($this->request));
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
        $this->set('film_category', $edit->setTable('FilmCategories')->save($this->request, $id));
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
        return $delete->setTable('FilmCategories')->delete($id)->respond();
    }
}
