<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use MixerApi\Crud\Interfaces\ReadInterface;
use MixerApi\Crud\Interfaces\SearchInterface;
use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Attribute\OpenApiResponse;
use SwaggerBake\Lib\Extension\CakeSearch\Attribute\OpenApiSearch;

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
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    #[OpenApiPaginator]
    #[OpenApiSearch(tableClass: '\App\Model\Table\FilmsTable')]
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
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
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
     */
    #[OpenApiPaginator(sortEnum: ['Actors.first_name','Actors.last_name'])]
    #[OpenApiResponse(schemaType: 'array', associations: ['table' => 'FilmActors', 'whiteList' => ['Actors']])]
    public function viewActors(string $id)
    {
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
