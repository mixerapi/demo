<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use App\Model\Table\FilmsTable;
use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};
use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Extension\CakeSearch\Attribute\OpenApiSearch;

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
            'modelClass' => 'Films'
        ]);
    }

    /**
     * Index method
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     */
    #[OpenApiPaginator]
    #[OpenApiSearch(tableClass: FilmsTable::class)]
    public function index(SearchInterface $search)
    {
        $this->set('data', $search->search($this));
    }

    /**
     * View method
     *
     * This example uses mixerapi/crud.
     *
     * @param ReadInterface $read
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Actor Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(ReadInterface $read)
    {
        $this->set('data', $read->read($this));
    }

    /**
     * Add method
     *
     * This example uses mixerapi/crud.
     *
     * @param CreateInterface $create
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\OpenApiExceptionSchema
     * @throws \Exception
     */
    public function add(CreateInterface $create)
    {
        $this->set('data', $create->save($this));
    }

    /**
     * Edit method
     *
     * This example uses mixerapi/crud.
     *
     * @param UpdateInterface $update
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\OpenApiExceptionSchema
     * @throws \Exception
     */
    public function edit(UpdateInterface $update)
    {
        $this->set('data', $update->save($this));
    }

    /**
     * Delete method
     *
     * This example uses mixerapi/crud.
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
