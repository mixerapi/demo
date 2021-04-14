<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use MixerApi\HalView\HalResourceInterface;
use MixerApi\JsonLdView\JsonLdSchema;

/**
 * Actor Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\FilmActor[] $film_actors
 */
class Actor extends Entity implements HalResourceInterface
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'modified' => true,
        'film_actors' => true,
    ];

    protected $_hidden = [
        '_joinData',
    ];

    /**
     * @inheritDoc
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => '/actors/' . $entity->get('id'),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdContext(): string
    {
        return '/contexts/actor';
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
        return '/actors/' . $entity->get('id');
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())->setProperty('first_name')->setSchemaUrl('https://schema.org/giveName'),
            (new JsonLdSchema())->setProperty('last_name')->setSchemaUrl('https://schema.org/familyName'),
        ];
    }
}
