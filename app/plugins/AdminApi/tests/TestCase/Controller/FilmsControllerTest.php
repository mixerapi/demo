<?php
declare(strict_types=1);

namespace AdminApi\Test\TestCase\Controller;

use AdminApi\Controller\FilmsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * AdminApi\Controller\FilmsController Test Case
 *
 * @uses \AdminApi\Controller\FilmsController
 */
class FilmsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.AdminApi.Films',
        'plugin.AdminApi.Languages',
        'plugin.AdminApi.FilmActors',
        'plugin.AdminApi.FilmCategories',
        'plugin.AdminApi.FilmTexts',
        'plugin.AdminApi.Inventories',
        'plugin.AdminApi.Actors',
        'plugin.AdminApi.Categories',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
