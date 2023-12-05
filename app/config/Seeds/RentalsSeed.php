<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Rentals seed.
 */
class RentalsSeed extends AbstractSeed
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
    public function run(): void
    {
        $data = [
            [
                'id' => '1',
                'rental_date' => '2005-05-24 22:53:30',
                'film_id' => '1',
                'customer_id' => '1',
                'return_date' => '2005-05-26 22:04:30',
                //'employee_id' => '1',
                'modified' => '2006-02-15 21:30:53',
            ]
        ];

        $table = $this->table('rentals');
        $table->insert($data)->save();
    }
}
