<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Search\Model\Filter\FilterCollection;

class FilmCategoriesCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('category_id', 'Search.Value', [
                'mode' => 'and',
                'fields' => ['category_id'],
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
