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
 * Language Entity
 *
 * @property int $id
 * @property string $name Language
 * @property int $is_active
 *
 * @property \App\Model\Entity\Film[] $films
 */
class Language extends Entity implements HalResourceInterface, JsonLdDataInterface
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
        'is_active' => true,
        'films' => true,
    ];

    /**
     * @inheritDoc
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => (new HyperMedia())->getHref('/%s/languages/%s', $entity),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdContext(): string
    {
        return '/public/contexts/language';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/Language';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return (new HyperMedia())->getHref('/%s/languages/%s', $entity);
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
