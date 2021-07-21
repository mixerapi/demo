<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Addresses seed.
 *
 * @deprecated
 */
class AddressesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @deprecated
     * @return void
     */
    public function run()
    {
        trigger_deprecation('mixerapi/demo', 'v0.3.2', 'this seed has been removed');
        return;

        $data = [
            [
                'id' => '1',
                'address' => '47 MySakila Drive',
                'address2' => NULL,
                'district' => 'New York',
                'city_id' => '1',
                'postal_code' => '10000',
                'phone' => '',
                'location' => '',
                'modified' => '2014-09-25 22:30:27',
            ]
        ];

        $table = $this->table('addresses');
        $table->insert($data)->save();
    }
}
