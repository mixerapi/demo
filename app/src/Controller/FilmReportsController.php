<?php
declare(strict_types=1);

namespace App\Controller;

use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Attribute\OpenApiResponse;

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
     * List a sum count of films by rating. This example demonstrates creating a report referencing an adhoc openapi
     * schema `#/x-mixerapi-demo/components/schemas/FilmByRating`
     */
    #[OpenApiPaginator(sortEnum: ['rating','total'])]
    #[OpenApiResponse(schemaType: 'array', ref: '#/x-mixerapi-demo/components/schemas/FilmByRating')]
    public function byRating()
    {
        $this->paginate = [
            'sortableFields' => [
                'rating', 'total'
            ]
        ];

        $query = $this->getTableLocator()->get('Films')->find('groupByRating');
        $films = $this->paginate($query);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }

    /**
     * Film Categories
     *
     * List a sum count of films by category using a MySQL View.
     */
    #[OpenApiPaginator(sortEnum: ['name','total'])]
    #[OpenApiResponse(schemaType: 'array', associations: ['table' => 'ViewFilmCategories', 'whiteList' => []])]
    public function byCategory()
    {
        $this->paginate = [
            'sortableFields' => [
                'name', 'total'
            ]
        ];

        $query = $this->getTableLocator()->get('ViewFilmCategories')->find();
        $films = $this->paginate($query);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }
}
