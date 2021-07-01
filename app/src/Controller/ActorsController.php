<?php
declare(strict_types=1);

namespace App\Controller;

use MixerApi\Crud\Interfaces\{SearchInterface, ReadInterface};
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
            'actions' => ['index', 'viewFilms'],
        ]);
    }

    /**
     * Actors Collection
     *
     * Returns a collection of actors
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\ActorsTable", collection="default")
     */
    public function index(SearchInterface $search)
    {
        $this->set('data', $search->search($this));
    }

    /**
     * Actor Resource
     *
     * Returns an actor
     *
     * @param ReadInterface $read
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Actor Not Found
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view(ReadInterface $read)
    {
        $this->set('data', $read->read($this));
    }

    /**
     * View Actor's Films
     *
     * Returns a collection of the actor's films
     *
     * @param SearchInterface $search
     * @param string $id Actor Id
     * @Swag\SwagPaginator(sortEnum={"Films.title","Films.release_year"})
     * @Swag\SwagResponseSchema(schemaItems={"$ref"="#/x-mixerapi-demo/components/schemas/ActorFilm"})
     * @SwagSearch(tableClass="\App\Model\Table\FilmActorsTable", collection="filmsByActor")
     */
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
                    ->setTableName('FilmActors')->setCollection('FilmsByActor')->query($this)
                    ->contain(['Films'])
                    ->andWhere(['actor_id' => $id])
            )
        );

        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
