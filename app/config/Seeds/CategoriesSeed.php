<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
                'name' => 'Action',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '2',
                'name' => 'Animation',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '3',
                'name' => 'Children',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '4',
                'name' => 'Classics',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '5',
                'name' => 'Comedy',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '6',
                'name' => 'Documentary',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '7',
                'name' => 'Drama',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '8',
                'name' => 'Family',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '9',
                'name' => 'Foreign',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '10',
                'name' => 'Games',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '11',
                'name' => 'Horror',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '12',
                'name' => 'Music',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '13',
                'name' => 'New',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '14',
                'name' => 'Sci-Fi',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '15',
                'name' => 'Sports',
                'modified' => '2006-02-15 04:46:27',
            ],
            [
                'id' => '16',
                'name' => 'Travel',
                'modified' => '2006-02-15 04:46:27',
            ],
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
