<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ConnectionManager;

/**
 * Refreshes the demo database
 */
class DropTablesCommand extends Command
{
    /**
     * List Cake Routes that can be added to Swagger. Prints to console.
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     * @throws \ReflectionException
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $connection = ConnectionManager::get('default');
        $connection->execute('DROP TABLE actors');
        //$connection->execute('TRUNCATE TABLE addresses');
        $connection->execute('DROP TABLE categories');
        //$connection->execute('TRUNCATE TABLE countries');
        //$connection->execute('TRUNCATE TABLE cities');
        $connection->execute('DROP TABLE customers');
        //$connection->execute('TRUNCATE TABLE employees');
        $connection->execute('DROP TABLE film_actors');
        $connection->execute('DROP TABLE film_categories');
        $connection->execute('DROP TABLE film_texts');
        $connection->execute('DROP TABLE films');
        //$connection->execute('TRUNCATE TABLE inventories');
        $connection->execute('DROP TABLE languages');
        //$connection->execute('DROP TABLE payments');
        $connection->execute('DROP TABLE rentals');
        $connection->execute('TRUNCATE TABLE phinxlog');
        $connection->execute('DROP VIEW view_film_categories');
    }
}
