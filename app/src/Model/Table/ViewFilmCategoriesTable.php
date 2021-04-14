<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ViewFilmCategoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('view_film_categories');
        $this->setPrimaryKey('id');
    }
}
