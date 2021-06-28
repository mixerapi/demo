<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Cake\ORM\Query;
use Search\Model\Filter\FilterCollection;

class FilmsByActorCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['Films.title'],
            ])
            ->add('rating', 'Search.Value', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['Films.rating'],
            ]);

    }
}
