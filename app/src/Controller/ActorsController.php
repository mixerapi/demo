<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\ActorsTable;
use App\Model\Table\FilmActorsTable;
use MixerApi\Crud\Interfaces\{SearchInterface, ReadInterface};
use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Attribute\OpenApiResponse;
use SwaggerBake\Lib\Extension\CakeSearch\Attribute\OpenApiSearch;

/**
 * Actors Controller
 *
 * @property \App\Model\Table\ActorsTable $Actors
 * @method \App\Model\Entity\Actor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index', 'viewFilms'],
        ]);
    }

    /**
     * Actors Collection
     *
     * This example uses mixerapi/crud.
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    #[OpenApiPaginator]
    #[OpenApiSearch(tableClass: ActorsTable::class)]
    public function index(SearchInterface $search)
    {
        $this->set('data', $this->paginate($search->query($this)));
    }

    /**
     * Actor Resource
     *
     * This example uses mixerapi/crud.
     *
     * @param ReadInterface $read
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(ReadInterface $read)
    {
        $this->set('data', $read->read($this));
    }

    /**
     * View Actor's Films
     *
     * Returns a collection of the actor's films.
     *
     * @param SearchInterface $search
     * @param string $id Actor Id
     */
    #[OpenApiPaginator(sortEnum: ['Films.title', 'Films.release_year'])]
    #[OpenApiSearch(tableClass: FilmActorsTable::class, collection: 'filmsByActor')]
    #[OpenApiResponse(schemaType: 'array', associations: ['table' => 'FilmActors','whiteList' => ['Films.Languages']])]
    public function viewFilms(SearchInterface $search, string $id)
    {
        $this->paginate = [
            'sortableFields' => [
                'Films.title', 'Films.release_year'
            ]
        ];

        $this->set('data',
            $this->paginate(
                $search
                    ->setAllowMethod('get')
                    ->setTableName('FilmActors')
                    ->setCollection('FilmsByActor')
                    ->query($this)
                    ->contain(['Films' => ['Languages']])
                    ->andWhere(['actor_id' => $id])
            )
        );

        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
