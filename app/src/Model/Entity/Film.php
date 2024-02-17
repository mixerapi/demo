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
     * @inheritdoc
     */
    protected array $_accessible = [
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
        'language' => true,
        'film_actors' => true,
        'film_categories' => true,
        'film_texts' => true,
        'inventories' => true,
    ];

    /**
     * @inheritdoc
     */
    protected array $_hidden = [
        '_joinData',
        '_matchingData'
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
            new JsonLdSchema('title', 'https://schema.org/name', 'The title of the movie'),
            new JsonLdSchema('description', 'https://schema.org/about'),
            new JsonLdSchema('length', 'https://schema.org/duration'),
            new JsonLdSchema('rating', 'https://schema.org/contentRating'),
            new JsonLdSchema('release_year', 'https://schema.org/copyrightYear'),
        ];
    }
}
