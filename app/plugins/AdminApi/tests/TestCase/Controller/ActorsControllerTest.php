<?php
declare(strict_types=1);

namespace AdminApi\Test\TestCase\Controller;

use App\Test\Factory\ActorFactory;
use AuthenticationApi\Test\HttpHelper;
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

    private const URL = '/admin/actors/';

    public function setUp(): void
    {
        parent::setUp();
        $this->configRequest([
            'headers' => HttpHelper::getJsonHeadersWithJwt()
        ]);
    }

    public function test_index()
    {
        $this->disableErrorHandlerMiddleware();
        ActorFactory::make()->persist();
        ActorFactory::make()->persist();
        $this->get(self::URL);
        $this->assertResponseOk();

        $body = json_decode((string)$this->_response->getBody());
        $this->assertIsArray($body->data);
    }

    public function test_index_responds_with_401_when_missing_jwt()
    {
        $this->configRequest([
            'headers' => HttpHelper::getJsonHeaders()
        ]);
        $this->get(self::URL);
        $this->assertResponseCode(401);
    }

    public function test_view()
    {
        $entity = ActorFactory::make()->persist();
        $this->get(self::URL . $entity->get('id'));
        $this->assertResponseCode(200);
    }

    public function test_add()
    {
        $this->post(self::URL, json_encode(['first_name' => 'test', 'last_name' => 'test']));
        $this->assertResponseCode(201);

        $body = json_decode((string)$this->_response->getBody());
        $this->assertEquals('test', $body->first_name);
    }

    public function test_edit()
    {
        $entity = ActorFactory::make()->persist();
        $this->patch(self::URL . $entity->get('id'), json_encode(['first_name' => 'updated']));
        $this->assertResponseCode(200);

        $body = json_decode((string)$this->_response->getBody());
        $this->assertEquals('updated', $body->first_name);
    }
}
