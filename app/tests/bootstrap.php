<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Migrations\TestSuite\Migrator;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

Configure::write('App.fullBaseUrl', 'http://localhost');
putenv('DB=sqlite');
// in tests/bootstrap.php


/*
 * Run migrations
 * @link https://book.cakephp.org/4/en/development/testing.html#creating-test-database-schema
 */
$migrator = new Migrator();
$migrator->run();

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');

Configure::write('MixerApi.JwtAuth', [
    'alg' => 'RS256',
    'keys' => [
        [
            'kid' => '1',
            'public' => file_get_contents(TESTS . 'public.pem'),
            'private' => file_get_contents(TESTS . 'private.pem'),
        ]
    ]
]);
