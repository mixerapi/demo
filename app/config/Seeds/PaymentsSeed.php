<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Payments seed.
 * @deprecated
 */
class PaymentsSeed extends AbstractSeed
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
     * @deprecated
     */
    public function run()
    {
        trigger_deprecation('mixerapi/demo', 'v0.3.2', 'this seed has been removed');
        return;

        $data = [
            [
                'id' => '1',
                'customer_id' => '1',
                //'employee_id' => '1',
                'rental_id' => '76',
                'amount' => '2.99',
                'created' => '2005-05-25 11:30:37',
                'modified' => '2006-02-15 22:12:30',
            ]
        ];

        $table = $this->table('payments');
        $table->insert($data)->save();
    }
}
