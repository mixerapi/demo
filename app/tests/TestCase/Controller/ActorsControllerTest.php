<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use AuthenticationApi\Test\Factory\ActorFactory;
use AuthenticationApi\Test\HttpHelper;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ActorsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    private const URL = '/public/actors';

    public function setUp(): void
    {
        parent::setUp();
        $this->configRequest([
            'headers' => HttpHelper::getJsonHeaders()
        ]);
    }

    public function test_index()
    {
        ActorFactory::make()->persist();
        ActorFactory::make()->persist();
        $this->get(self::URL);
        $this->assertResponseOk();

        $body = json_decode((string)$this->_response->getBody());
        $this->assertCount(2, $body->data);
    }

    public function test_view()
    {
        $record = ActorFactory::make(['id' => 123, 'first_name' => 'Tom', 'last_name' => 'Hanks'])->persist();
        $this->get(self::URL . '/123');
        $this->assertResponseOk();

        $body = json_decode((string)$this->_response->getBody());
        $this->assertEquals($record->get('first_name'), $body->first_name);
        $this->assertEquals($record->get('last_name'), $body->last_name);
    }
}
