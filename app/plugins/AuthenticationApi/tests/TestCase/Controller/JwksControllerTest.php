<?php
declare(strict_types=1);

namespace AuthenticationApi\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

class JwksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    private const KEY_PATH = ROOT . DS . 'plugins' . DS . 'AuthenticationApi' . DS . 'config' . DS . 'keys' . DS . '1' . DS;

    /**
     * @inheritdoc
     */
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

    public function test_jwks(): void
    {
        if (!dir(self::KEY_PATH)) {
            $this->markTestSkipped('You must generate keys to run this test. Place keys in: ' . self::KEY_PATH);
        }

        Configure::write('MixerApi.JwtAuth', [
            'alg' => 'RS256',
            'keys' => [
                [
                    'kid' => '1',
                    'public' => file_get_contents(self::KEY_PATH . 'public.pem'),
                    'private' => file_get_contents(self::KEY_PATH . 'private.pem'),
                ]
            ]
        ]);
        $this->get('/admin/auth/keys');
        $this->assertResponseSuccess();

        $data = json_decode((string) $this->_response->getBody());
        $this->assertCount(1, $data);

        $jwk = reset($data);
        $this->assertEquals('RSA', $jwk->kty);
    }
}
