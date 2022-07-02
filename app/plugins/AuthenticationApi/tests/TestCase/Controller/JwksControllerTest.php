<?php
declare(strict_types=1);

namespace AuthenticationApi\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

class JwksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->configRequest([
            'headers' => [
                'Content-type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function test_jwks()
    {
        $this->get('/admin/auth/keys');
        $this->assertResponseSuccess();

        $data = json_decode($this->_getBodyAsString());
        $this->assertCount(1, $data);

        $jwk = reset($data);
        $this->assertEquals('RSA', $jwk->kty);
    }
}
