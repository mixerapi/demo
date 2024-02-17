<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Services\HyperMedia;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use MixerApi\HalView\HalResourceInterface;
use MixerApi\JsonLdView\JsonLdDataInterface;
use MixerApi\JsonLdView\JsonLdSchema;

/**
 * Actor Entity
 *
 * @property int $id
 * @property string $first_name Actor First Name
 * @property string $last_name Actor Last Name
 * @property \Cake\I18n\FrozenTime $modified Last modified date/time
 *
 * @property \App\Model\Entity\FilmActor[] $film_actors
 */
class Actor extends Entity implements HalResourceInterface, JsonLdDataInterface
{
    /**
     * @inheritdoc
     */
    protected array $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'film_actors' => true,
    ];

    /**
     * @inheritdoc
     */
    protected array $_hidden = [
        '_joinData',
    ];

    public function _getFirstName(?string $v)
    {
        return h($v);
    }

    public function _getLastName(?string $v)
    {
        return h($v);
    }

    /**
     * @inheritDoc
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => (new HyperMedia())->getHref('/%s/actors/%s', $entity)
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdContext(): string
    {
        return '/public/contexts/actor';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/actor';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return (new HyperMedia())->getHref('/%s/actors/%s', $entity);
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdSchemas(): array
    {
        return [
            new JsonLdSchema('first_name', 'https://schema.org/giveName'),
            new JsonLdSchema('last_name', 'https://schema.org/familyName'),
        ];
    }
}
