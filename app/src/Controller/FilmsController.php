<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use MixerApi\Crud\Interfaces\{SearchInterface, ReadInterface};
use SwaggerBake\Lib\Annotation as Swag;
use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

/**
 * Films Controller
 *
 * @property \App\Model\Table\FilmsTable $Films
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
    }

    /**
     * Films Collection
     *
     * Returns a collection of films
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     * @SwagSearch(tableClass="\App\Model\Table\FilmsTable", collection="default")
     */
    public function index(SearchInterface $search)
    {
        $this->set('data', $search->search($this));
    }

    /**
     * Film Resource
     *
     * Returns a film
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
     * View Film's Actors
     *
     * Returns a collection of the film's actors
     *
     * @param string $id Actor Id
     * @Swag\SwagPaginator(sortEnum={"Actors.first_name","Actors.last_name"})
     * @Swag\SwagResponseSchema(schemaItems={"$ref"="#/x-mixerapi-demo/components/schemas/FilmActor"})
     */
    public function viewActors(string $id)
    {
        $this->request->allowMethod('get');

        $this->paginate = [
            'sortableFields' => [
                'Actors.first_name', 'Actors.last_name'
            ]
        ];

        $query = TableRegistry::getTableLocator()->get('FilmActors')->find('actorsByFilm', [
            'film_id' => $id
        ]);

        $this->set('films', $this->paginate($query));
        $this->viewBuilder()->setOption('serialize', 'films');
    }
}
