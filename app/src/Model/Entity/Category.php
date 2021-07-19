<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Service\HyperMedia;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Entity;
use MixerApi\HalView\HalResourceInterface;
use MixerApi\JsonLdView\JsonLdDataInterface;
use MixerApi\JsonLdView\JsonLdSchema;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name Category name
 * @property \Cake\I18n\FrozenTime $modified Last modified date/time
 *
 * @property \App\Model\Entity\FilmCategory[] $film_categories
 */
class Category extends Entity implements HalResourceInterface, JsonLdDataInterface
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
        'name' => true,
        'modified' => true,
        'film_categories' => true,
    ];

    public function _getName(?string $v)
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
                'href' => (new HyperMedia())->getHref('/%s/categories/%s', $entity)
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdContext(): string
    {
        return '/public/contexts/category';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/genre';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return (new HyperMedia())->getHref('/%s/categories/%s', $entity);
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())->setProperty('name')->setSchemaUrl('https://schema.org/name'),
        ];
    }
}
