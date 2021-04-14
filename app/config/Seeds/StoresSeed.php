<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Stores seed.
 */
class StoresSeed extends AbstractSeed
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
        $data = [
            [
                'id' => '1',
                'employee_id' => '1',
                'address_id' => '1',
                'modified' => '2006-02-15 04:57:12',
            ],
            [
                'id' => '2',
                'employee_id' => '2',
                'address_id' => '2',
                'modified' => '2006-02-15 04:57:12',
            ],
        ];

        $table = $this->table('stores');
        $table->insert($data)->save();
    }
}
