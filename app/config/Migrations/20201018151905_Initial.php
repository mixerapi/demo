<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $this->table('actors')
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'last_name',
                ]
            )
            ->create();

        /*
        $this->table('addresses')
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('address2', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('district', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('city_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('postal_code', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('phone', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'location',
                ]
            )
            ->addIndex(
                [
                    'city_id',
                ]
            )
            ->create();
        */

        $this->table('categories')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        /*
        $this->table('cities')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('country_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'country_id',
                ]
            )
            ->create();
        */

        /*
        $this->table('countries')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->create();
        */

        $this->table('customers')
            /*
            ->addColumn('store_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            */
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            /*
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            */
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'last_name',
                ]
            )
            /*
            ->addIndex(
                [
                    'address_id',
                ]
            )
            ->addIndex(
                [
                    'store_id',
                ]
            )
            */
            ->create();
        /*
        $this->table('employees')
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('picture', 'binary', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('store_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 16,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'address_id',
                ]
            )
            ->addIndex(
                [
                    'store_id',
                ]
            )
            ->create();
        */

        $this->table('film_actors', ['id' => false, 'primary_key' => ['uuid']])
            ->addColumn('uuid', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('actor_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('film_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('film_categories', ['id' => false, 'primary_key' => ['uuid']])
            ->addColumn('uuid', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('film_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('category_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'category_id',
                ]
            )
            ->create();

        $this->table('film_texts', ['id' => false, 'primary_key' => ['uuid']])
            ->addColumn('uuid', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('film_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'title'
                ]
            )
            ->create();

        $this->table('films')
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('release_year', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('language_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rental_duration', 'integer', [
                'default' => '3',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rental_rate', 'decimal', [
                'default' => '4.99',
                'null' => false,
                'precision' => 4,
                'scale' => 2,
            ])
            ->addColumn('length', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('replacement_cost', 'decimal', [
                'default' => '19.99',
                'null' => false,
                'precision' => 5,
                'scale' => 2,
            ])
            ->addColumn('rating', 'string', [
                'default' => 'G',
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('special_features', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'language_id',
                ]
            )
            ->addIndex(
                [
                    'title',
                ]
            )
            ->create();

        /*
        $this->table('inventories')
            ->addColumn('film_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('store_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'store_id',
                    'film_id',
                ]
            )
            ->addIndex(
                [
                    'film_id',
                ]
            )
            ->create();
        */

        $this->table('languages')
            ->addColumn('name', 'char', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('is_active', 'integer', [
                'default' => '1',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        /*
        $this->table('payments')
            ->addColumn('customer_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('employee_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rental_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 5,
                'scale' => 2,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'rental_id',
                ]
            )
            ->addIndex(
                [
                    'customer_id',
                ]
            )
            ->addIndex(
                [
                    'employee_id',
                ]
            )
            ->create();
        */

        $this->table('rentals')
            ->addColumn('rental_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('film_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('customer_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('return_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            /*
            ->addColumn('employee_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            */
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'rental_date',
                    //'inventory_id',
                    'customer_id',
                ],
                ['unique' => true]
            )
            /*
            ->addIndex(
                [
                    'employee_id',
                ]
            )
            */
            ->addIndex(
                [
                    'customer_id',
                ]
            )
            ->addIndex(
                [
                    'film_id',
                ]
            )
            ->create();

        /*
        $this->table('stores')
            ->addColumn('employee_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'employee_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'address_id',
                ]
            )
            ->create();
        */
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $this->table('actors')->drop()->save();
        //$this->table('addresses')->drop()->save();
        $this->table('categories')->drop()->save();
        //$this->table('cities')->drop()->save();
        //$this->table('countries')->drop()->save();
        $this->table('customers')->drop()->save();
        //$this->table('employees')->drop()->save();
        $this->table('film_actors')->drop()->save();
        $this->table('film_categories')->drop()->save();
        $this->table('film_texts')->drop()->save();
        $this->table('films')->drop()->save();
        //$this->table('inventories')->drop()->save();
        $this->table('languages')->drop()->save();
        $this->table('payments')->drop()->save();
        $this->table('rentals')->drop()->save();
        //$this->table('stores')->drop()->save();
    }
}
