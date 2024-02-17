<?php
declare(strict_types=1);

namespace AuthenticationApi\Test\TestCase\Controller;

use App\Test\Factory\UserFactory;
use App\Test\Fixture\UsersFixture;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class LoginControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @inheritdoc
     */
    protected array $fixtures = [
        UsersFixture::class,
    ];

    private const LOGIN_URL = '/admin/auth/login';
    private const VALID_EMAIL = 'test@example.com';
    private const VALID_PASSWORD = 'test@example.com';
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
                'Accept' => 'text/plain',
            ],
        ]);
    }

    public function test_hmac_login_success(): void
    {
        $hashedPassword = (new DefaultPasswordHasher())->hash(self::VALID_PASSWORD);
        UserFactory::make(['email' => self::VALID_EMAIL, 'password' => $hashedPassword])->persist();

        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => self::VALID_PASSWORD]));
        $this->assertResponseSuccess();
    }

    public function test_rsa_login_success(): void
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

        $hashedPassword = (new DefaultPasswordHasher())->hash(self::VALID_PASSWORD);
        UserFactory::make(['email' => self::VALID_EMAIL, 'password' => $hashedPassword])->persist();

        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => self::VALID_PASSWORD]));
        $this->assertResponseSuccess();
    }

    public function test_hmac_login_fails_with_invalid_credentials(): void
    {
        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => 'nope']));
        $this->assertResponseCode(401);
    }

    public function test_rsa_login_fails_with_invalid_credentials(): void
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

        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => 'nope']));
        $this->assertResponseCode(401);
    }
}
