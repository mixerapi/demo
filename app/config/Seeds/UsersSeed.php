<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Chronos\Date;
use Cake\Utility\Text;
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
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
                'id' => Text::uuid(),
                'email' => 'test@example.com',
                'password' => (new DefaultPasswordHasher)->hash('password'),
                'created' => Date::now(),
                'modified' => Date::now(),
            ]
        ];

        $this->table('users')->insert($data)->save();
    }
}
