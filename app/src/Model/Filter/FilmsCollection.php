<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Search\Model\Filter\FilterCollection;
use Cake\ORM\Query;

class FilmsCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['title','description'],
            ])
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['title'],
            ])
            ->add('description', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['description'],
            ])
            ->add('release_year', 'Search.Value', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['release_year'],
            ])
            ->add('rating', 'Search.Value', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['rating'],
            ])
            ->callback('actor_first_name', [
                'callback' => function (Query $query, array $args, $manager) {
                    $query->matching('Actors', function (Query $query) use ($args) {
                        return $query->where(['Actors.first_name LIKE' => '%' . $args['actor_first_name'] .'%' ]);
                    });
                    return true;
                }
            ])
            ->callback('actor_last_name', [
                'callback' => function (Query $query, array $args, $manager) {
                    $query->matching('Actors', function (Query $query) use ($args) {
                        return $query->where(['Actors.last_name LIKE' => '%' . $args['actor_last_name'] .'%' ]);
                    });
                    return true;
                }
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
