<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Migrations\TestSuite\Migrator;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';
Configure::write('App.fullBaseUrl', 'http://localhost');


// DebugKit skips settings these connection config if PHP SAPI is CLI / PHPDBG.
// But since PagesControllerTest is run with debug enabled and DebugKit is loaded
// in application, without setting up these config DebugKit errors out.
ConnectionManager::setConfig('test_debug_kit', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Sqlite',
    'database' => TMP . 'debug_kit.sqlite',
    'encoding' => 'utf8',
    'cacheMetadata' => true,
    'quoteIdentifiers' => false,
]);

ConnectionManager::alias('test_debug_kit', 'debug_kit');

/*
 * Use SQLite as database when running tests
 */
putenv('DB=sqlite');

/*
 * Fixate sessionid early on, as php7.2+ does not allow the sessionid to be set after stdout has been written to.
 */
session_id('cli');

/*
 * MixerApi/JwtAuth config
 */
Configure::write('MixerApi.JwtAuth', [
    'alg' => 'HS256',
    'secret' => file_get_contents(ROOT . DS . 'plugins' . DS . 'AuthenticationApi' . DS . 'config' . DS . 'keys' . DS . 'hmac_secret.txt'),
]);

/*
 * Run migrations
 * @link https://book.cakephp.org/4/en/development/testing.html#creating-test-database-schema
 */
(new Migrator())->run();
