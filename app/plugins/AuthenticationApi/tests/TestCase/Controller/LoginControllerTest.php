<?php
declare(strict_types=1);

namespace AuthenticationApi\Test\TestCase\Controller;

use App\Test\Factory\UserFactory;
use App\Test\Fixture\UsersFixture;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class LoginControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $fixtures = [
        UsersFixture::class,
    ];

    private const LOGIN_URL = '/admin/auth/login';
    private const VALID_EMAIL = 'test@example.com';
    private const VALID_PASSWORD = 'test@example.com';

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

    public function test_login_success()
    {
        $hashedPassword = (new DefaultPasswordHasher())->hash(self::VALID_PASSWORD);
        UserFactory::make(['email' => self::VALID_EMAIL, 'password' => $hashedPassword])->persist();

        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => self::VALID_PASSWORD]));
        $this->assertResponseSuccess();
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $this->post(self::LOGIN_URL, json_encode(['email' => self::VALID_EMAIL, 'password' => 'nope']));
        $this->assertResponseCode(401);
    }
}
