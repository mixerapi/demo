<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\JwtAuth\Jwt\Jwt;
use MixerApi\JwtAuth\Jwt\JwtEntityInterface;
use MixerApi\JwtAuth\Jwt\JwtInterface;

/**
 * User Entity
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity implements JwtEntityInterface
{
    /**
     * @inheritdoc
     */
    protected array $_accessible = [
        'email' => true,
        'password' => true,
    ];

    /**
     * @inheritdoc
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * @inheritDoc
     */
    public function getJwt(): JwtInterface
    {
        return new Jwt(
            exp: time() + 60 * 60 * 24,
            sub: $this->get('id'),
            iss: 'demo.mixerapi.com',
            aud: null,
            nbf: null,
            iat: null,
            jti: \Cake\Utility\Text::uuid(),
            claims: [
                'user' => [
                    'email' => $this->get('email')
                ]
            ]
        );
    }
}
