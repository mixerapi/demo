<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};
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
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\FilmCategoriesTable", collection="default")
     */
    public function index(SearchInterface $search)
    {
        $this->set('data', $search->search($this));
    }

    /**
     * View method
     *
     * @param ReadInterface $read
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Category Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(ReadInterface $read)
    {
        $this->set('data', $read->read($this));
    }

    /**
     * Add method
     *
     * @param CreateInterface $create
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add(CreateInterface $create)
    {
        $this->set('data', $create->save($this));
    }

    /**
     * Edit method
     *
     * @param UpdateInterface $update
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit(UpdateInterface $update)
    {
        $this->set('data', $update->save($this));
    }

    /**
     * Delete method
     *
     * @param DeleteInterface $delete
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    public function delete(DeleteInterface $delete)
    {
        return $delete->delete($this)->respond();
    }
}
