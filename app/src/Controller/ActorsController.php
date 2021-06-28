<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Crud\GetRecordService;
use Crud\SearchCollectionService;
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

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
            'actions' => ['index'],
        ]);
    }

    /**
     * Actors Collection
     *
     * Returns a collection of actors
     *
     * @param SearchCollectionService $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\ActorsTable", collection="default")
     */
    public function index(SearchCollectionService $search)
    {
        $this->set('actors', $search->table('Actors')->search($this));
    }

    /**
     * View Actor
     *
     * Returns an actor
     *
     * @param GetRecordService $getRecord
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Actor Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(GetRecordService $getRecord, string $id)
    {
        $this->set('actor', $getRecord->table('Actors')->retrieve($id));
    }

    /**
     * View Actor's Films
     *
     * Returns a collection of the actor's films
     *
     * @param SearchCollectionService $search
     * @param string $id Actor Id
     * @Swag\SwagPaginator(sortEnum={"Films.title","Films.release_year"})
     * @Swag\SwagResponseSchema(schemaItems={"$ref"="#/x-mixerapi-demo/components/schemas/ActorFilm"})
     * @SwagSearch(tableClass="\App\Model\Table\FilmActorsTable", collection="filmsByActor")
     */
    public function viewFilms(SearchCollectionService $search, string $id)
    {
        $this->request->allowMethod('get');

        $this->paginate = [
            'sortableFields' => [
                'Films.title', 'Films.release_year'
            ]
        ];

        $this->set('actors',
            $this->paginate(
                $search
                    ->table('FilmActors')->collection('FilmsByActor')->query($this)
                    ->contain(['Films'])
                    ->andWhere(['actor_id' => $id])
            )
        );
    }
}
