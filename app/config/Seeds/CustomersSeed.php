<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Customers seed.
 */
class CustomersSeed extends AbstractSeed
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
                'store_id' => '1',
                'first_name' => 'MARY',
                'last_name' => 'SMITH',
                'email' => 'MARY.SMITH@sakilacustomer.org',
                'address_id' => '5',
                'is_active' => '1',
                'created' => '2006-02-14 22:04:36',
                'modified' => '2006-02-15 04:57:20',
            ],
            [
                'id' => '2',
                'store_id' => '1',
                'first_name' => 'PATRICIA',
                'last_name' => 'JOHNSON',
                'email' => 'PATRICIA.JOHNSON@sakilacustomer.org',
                'address_id' => '6',
                'is_active' => '1',
                'created' => '2006-02-14 22:04:36',
                'modified' => '2006-02-15 04:57:20',
            ],
            [
                'id' => '3',
                'store_id' => '1',
                'first_name' => 'LINDA',
                'last_name' => 'WILLIAMS',
                'email' => 'LINDA.WILLIAMS@sakilacustomer.org',
                'address_id' => '7',
                'is_active' => '1',
                'created' => '2006-02-14 22:04:36',
                'modified' => '2006-02-15 04:57:20',
            ],
            [
                'id' => '4',
                'store_id' => '2',
                'first_name' => 'BARBARA',
                'last_name' => 'JONES',
                'email' => 'BARBARA.JONES@sakilacustomer.org',
                'address_id' => '8',
                'is_active' => '1',
                'created' => '2006-02-14 22:04:36',
                'modified' => '2006-02-15 04:57:20',
            ],
            [
                'id' => '5',
                'store_id' => '1',
                'first_name' => 'ELIZABETH',
                'last_name' => 'BROWN',
                'email' => 'ELIZABETH.BROWN@sakilacustomer.org',
                'address_id' => '9',
                'is_active' => '1',
                'created' => '2006-02-14 22:04:36',
                'modified' => '2006-02-15 04:57:20',
            ]
        ];

        $table = $this->table('customers');
        $table->insert($data)->save();
    }
}
