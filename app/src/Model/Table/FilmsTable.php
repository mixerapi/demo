<?php
declare(strict_types=1);

namespace App\Model\Table;

use _HumbugBox221ad6f1b81f\React\Http\Server;
use Cake\Http\ServerRequest;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Films Model
 *
 * @property \App\Model\Table\LanguagesTable&\Cake\ORM\Association\BelongsTo $Languages
 * @property \App\Model\Table\FilmActorsTable&\Cake\ORM\Association\HasMany $FilmActors
 * @property \App\Model\Table\FilmCategoriesTable&\Cake\ORM\Association\HasMany $FilmCategories
 * @property \App\Model\Table\FilmTextsTable&\Cake\ORM\Association\HasMany $FilmTexts
 * @property \App\Model\Table\InventoriesTable&\Cake\ORM\Association\HasMany $Inventories
 * @method \App\Model\Entity\Film newEmptyEntity()
 * @method \App\Model\Entity\Film newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Film[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Film get($primaryKey, $options = [])
 * @method \App\Model\Entity\Film findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Film patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Film[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Film|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Film saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilmsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('films');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->belongsTo('Languages', [
            'foreignKey' => 'language_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('FilmActors', [
            'foreignKey' => 'film_id',
        ]);
        $this->hasMany('FilmCategories', [
            'foreignKey' => 'film_id',
        ]);
        $this->hasMany('FilmTexts', [
            'foreignKey' => 'film_id',
        ]);
        $this->hasMany('Inventories', [
            'foreignKey' => 'film_id',
        ]);
        $this->belongsToMany('Actors', [
            'through' => 'FilmActors',
        ]);
        $this->belongsToMany('Categories', [
            'through' => 'FilmCategories',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('release_year')
            ->requirePresence('release_year', 'create')
            ->minLength('release_year', 4, 'Must be a 4 digit year')
            ->maxLength('release_year', 4, 'Must be a 4 digit year');

        $validator
            ->nonNegativeInteger('rental_duration')
            ->greaterThanOrEqual('rental_duration', 1, 'Value must be >= 1')
            ->allowEmptyString('rental_duration');

        $validator
            ->decimal('rental_rate')
            ->greaterThanOrEqual('rental_rate', 1, 'Value must be >= 1')
            ->allowEmptyString('rental_rate');

        $validator
            ->decimal('replacement_cost')
            ->greaterThanOrEqual('replacement_cost', 1, 'Value must be >= 1')
            ->allowEmptyString('replacement_cost');

        $validator
            ->decimal('length')
            ->greaterThanOrEqual('length', 1, 'Value must be >= 1')
            ->allowEmptyString('length');

        $ratings = ['PG','PG-13','R','NC-17','NR'];

        $validator
            ->scalar('rating')
            ->requirePresence('rating', 'create')
            ->inList('rating', $ratings, 'Value must be one of: ' . implode(', ', $ratings))
            ->maxLength('rating', 5);

        $validator
            ->scalar('special_features')
            ->maxLength('special_features', 255)
            ->allowEmptyString('special_features');


        $validator
            ->nonNegativeInteger('language_id')
            ->inList(
                'language_id',
                array_keys(TableRegistry::getTableLocator()->get('Languages')->find('list')->toArray()),
                'Must be a valid Language ID'
            )
            ->requirePresence('language_id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(
            $rules->existsIn(['language_id'], 'Languages', 'Language ID is required'),
            ['errorField' => 'language_id']
        );

        return $rules;
    }

    /**
     * Returns list of films grouped by year
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findGroupByRating(Query $query, array $options): Query
    {
        return $query
            ->select([
                'rating',
                'total' => $query->func()->count('Films.id')
            ])
            ->group(['rating']);
    }

    /**
     * @param ServerRequest $request
     * @param string $collection
     * @return Query
     * @see https://github.com/FriendsOfCake/search
     */
    public function search(ServerRequest $request, string $collection = 'default'): Query
    {
        return $this->find('search', [
            'search' => $request->getQueryParams(),
            'collection' => $collection,
            'contain' => ['Languages','Actors'],
        ]);
    }
}
