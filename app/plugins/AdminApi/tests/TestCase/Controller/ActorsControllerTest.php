<?php
declare(strict_types=1);

namespace AdminApi\Test\TestCase\Controller;

use AuthenticationApi\Test\HttpHelper;
use AuthenticationApi\Test\JwtHelper;
use AuthenticationApi\Test\Factory\ActorFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * AdminApi\Controller\ActorsController Test Case
 *
 * @uses \AdminApi\Controller\ActorsController
 */
class ActorsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    private const URL = '/admin/actors';

    public function setUp(): void
    {
        parent::setUp();
        $this->configRequest([
            'headers' => HttpHelper::getJsonHeadersWithJwt()
        ]);
    }

    public function test_index()
    {
        ActorFactory::make()->persist();
        ActorFactory::make()->persist();
        $this->get(self::URL);
        $this->assertResponseOk();

        $body = json_decode($this->_getBodyAsString());
        $this->assertGreaterThan(0, count($body->data));
    }

    public function test_index_auth_required()
    {
        $this->configRequest([
            'headers' => HttpHelper::getJsonHeaders()
        ]);
        $this->get(self::URL);
        $this->assertResponseCode(401);
    }
}
