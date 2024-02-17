<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use App\Model\Table\ActorsTable;
use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};
use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Attribute\OpenApiSecurity;
use SwaggerBake\Lib\Extension\CakeSearch\Attribute\OpenApiSearch;

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
            'modelClass' => 'Actors'
        ]);
    }

    /**
     * Index method
     *
     * This example uses mixerapi/crud.
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     */
    #[OpenApiSecurity(name: 'bearerAuth')]
    #[OpenApiPaginator]
    #[OpenApiSearch(alias: ActorsTable::class)]
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
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Actor Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    #[OpenApiSecurity(name: 'bearerAuth')]
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
    #[OpenApiSecurity(name: 'bearerAuth')]
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
    #[OpenApiSecurity(name: 'bearerAuth')]
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
    #[OpenApiSecurity(name: 'bearerAuth')]
    public function delete(DeleteInterface $delete)
    {
        return $delete->delete($this)->respond();
    }
}
