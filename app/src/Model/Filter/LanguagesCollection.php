<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Search\Model\Filter\FilterCollection;

class LanguagesCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('name', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name'],
            ]);
    }
}
