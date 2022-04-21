<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{

    public function up()
    {
        $this->table('users', [
                'id' => false
            ])
            ->addColumn('id', 'uuid', [
                'null' => false
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex('email', ['unique' => true])
            ->addPrimaryKey('id')
            ->create();
    }

    public function down()
    {
        $this->table('users')->drop()->save();
    }
}
