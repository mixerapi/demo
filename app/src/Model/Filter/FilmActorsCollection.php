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
    }
}
