<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Countries seed.
 * @deprecated
 */
class CountriesSeed extends AbstractSeed
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
                'name' => 'United States',
            ]
        ];

        $table = $this->table('countries');
        $table->insert($data)->save();
    }
}
