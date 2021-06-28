<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Cake\ORM\Query;
use Search\Model\Filter\FilterCollection;

class FilmActorsCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {

        $this
            ->_manager->useCollection('default')
            ->add('actor_id', 'Search.Value', [
                'mode' => 'and',
                'fields' => ['actor_id'],
            ])
            ->add('film_id', 'Search.Value', [
                'mode' => 'and',
                'fields' => ['film_id'],
            ])
            ->add('uuid', 'Search.Value', [
                'mode' => 'and',
                'fields' => ['uuid'],
            ]);

        $this
            ->_manager->useCollection('filmsByActor')
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['title'],
            ])
            ->add('release_year', 'Search.Value', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['release_year'],
            ])
            ->callback('film_category', [
                'callback' => function (Query $query, array $args, $manager) {
                    $query->matching('Categories', function (Query $query) use ($args) {
                        return $query->where(['Categories.name LIKE' => '%' . $args['film_category'] .'%' ]);
                    });
                    return true;
                }
            ])
            ->callback('film_language', [
                'callback' => function (Query $query, array $args, $manager) {
                    $query->matching('Languages', function (Query $query) use ($args) {
                        return $query->where(['Languages.name LIKE' => '%' . $args['film_language'] .'%' ]);
                    });
                    return true;
                }
            ]);

    }
}
