<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Inventories seed.
 * @deprecated
 */
class InventoriesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        trigger_deprecation('mixerapi/demo', 'v0.3.2', 'this seed has been removed');
        return;

        $data = [
            [
                'id' => '1',
                'film_id' => '1',
                'store_id' => '1',
                'modified' => '2006-02-15 05:09:17',
            ],
            [
                'id' => '2',
                'film_id' => '1',
                'store_id' => '1',
                'modified' => '2006-02-15 05:09:17',
            ],
            [
                'id' => '3',
                'film_id' => '1',
                'store_id' => '1',
                'modified' => '2006-02-15 05:09:17',
            ],
            [
                'id' => '4',
                'film_id' => '1',
                'store_id' => '1',
                'modified' => '2006-02-15 05:09:17',
            ],
            [
                'id' => '5',
                'film_id' => '1',
                'store_id' => '2',
                'modified' => '2006-02-15 05:09:17',
            ]
        ];

        $table = $this->table('inventories');
        $table->insert($data)->save();
    }
}
