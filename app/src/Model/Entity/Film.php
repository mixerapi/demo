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
 * Film Entity
 *
 * @property int $id
 * @property string $title Film Title
 * @property string|null $description Film description
 * @property int|null $release_year Release Year
 * @property int $language_id Language ID
 * @property int $rental_duration
 * @property string $rental_rate
 * @property int|null $length Film duration in hours
 * @property string $replacement_cost
 * @property string|null $rating Film Rating (e.g. PG, R, etc..)
 * @property string|null $special_features Film special features
 * @property \Cake\I18n\FrozenTime|null $modified Last modified date/time
 *
 * @property \App\Model\Entity\Language $language
 * @property \App\Model\Entity\FilmActor[] $film_actors
 * @property \App\Model\Entity\FilmCategory[] $film_categories
 * @property \App\Model\Entity\FilmText[] $film_texts
 * @property \App\Model\Entity\Inventory[] $inventories
 */
class Film extends Entity implements HalResourceInterface, JsonLdDataInterface
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
        'title' => true,
        'description' => true,
        'release_year' => true,
        'language_id' => true,
        'rental_duration' => true,
        'rental_rate' => true,
        'length' => true,
        'replacement_cost' => true,
        'rating' => true,
        'special_features' => true,
        'modified' => true,
        'language' => true,
        'film_actors' => true,
        'film_categories' => true,
        'film_texts' => true,
        'inventories' => true,
    ];

    public function _getTitle(?string $v)
    {
        return h($v);
    }

    public function _getDescription(?string $v)
    {
        return h($v);
    }

    public function _getSpecialFeatures(?string $v)
    {
        return h($v);
    }

    protected $_hidden = [
        '_joinData',
        '_matchingData'
    ];

    /**
     * @inheritDoc
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => (new HyperMedia())->getHref('/%s/films/%s', $entity),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdContext(): string
    {
        return '/public/contexts/Film';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/Movie';
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return (new HyperMedia())->getHref('/%s/films/%s', $entity);
    }

    /**
     * @inheritDoc
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())
                ->setProperty('title')
                ->setSchemaUrl('https://schema.org/name')
                ->setDescription('The title of the movie'),
            (new JsonLdSchema())
                ->setProperty('description')
                ->setSchemaUrl('https://schema.org/about'),
            (new JsonLdSchema())
                ->setProperty('length')
                ->setSchemaUrl('https://schema.org/duration'),
            (new JsonLdSchema())
                ->setProperty('rating')
                ->setSchemaUrl('https://schema.org/contentRating'),
            (new JsonLdSchema())
                ->setProperty('release_year')
                ->setSchemaUrl('https://schema.org/copyrightYear'),
        ];
    }
}
