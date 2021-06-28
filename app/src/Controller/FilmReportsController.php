<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use SwaggerBake\Lib\Annotation as Swag;

/**
 * Film Reports Controller
 *
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmReportsController extends AppController
{
    /**
     * Film Ratings
     *
     * List a sum count of films by rating. This example demonstrates creating a report referencing an adhoc schema
     * `#/x-mixerapi-demo/components/schemas/FilmByRating`
     *
     * @Swag\SwagPaginator(sortEnum={"rating","total"})
     * @Swag\SwagResponseSchema(schemaItems={"$ref"="#/x-mixerapi-demo/components/schemas/FilmByRating"})
     */
    public function byRating()
    {
        $this->request->allowMethod('get');

        $this->paginate = [
            'sortableFields' => [
                'rating', 'total'
            ]
        ];

        $query = TableRegistry::getTableLocator()->get('Films')->find('groupByRating');
        $films = $this->paginate($query);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }

    /**
     * Film Categories
     *
     * List a sum count of films by category using a MySQL View.
     *
     * @Swag\SwagPaginator(sortEnum={"name","total"})
     * @Swag\SwagResponseSchema(schemaItems={"$ref"="#/x-swagger-bake/components/schemas/ViewFilmCategory"})
     */
    public function byCategory()
    {
        $this->request->allowMethod('get');

        $this->paginate = [
            'sortableFields' => [
                'name', 'total'
            ]
        ];

        $query = TableRegistry::getTableLocator()->get('ViewFilmCategories')->find();
        $films = $this->paginate($query);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }
}
