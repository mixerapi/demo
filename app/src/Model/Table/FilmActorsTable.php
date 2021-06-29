<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilmActors Model
 *
 * @property \App\Model\Table\ActorsTable&\Cake\ORM\Association\BelongsTo $Actors
 * @property \App\Model\Table\FilmsTable&\Cake\ORM\Association\BelongsTo $Films
 * @method \App\Model\Entity\FilmActor newEmptyEntity()
 * @method \App\Model\Entity\FilmActor newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilmActor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilmActor get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilmActor findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilmActor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilmActor[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilmActor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilmActor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilmActor[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilmActorsTable extends Table
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

        $this->setTable('film_actors');
        $this->setDisplayField('uuid');
        $this->setPrimaryKey('uuid');

        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Actors', [
            'foreignKey' => 'actor_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Films', [
            'foreignKey' => 'film_id',
            'joinType' => 'INNER',
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
            ->scalar('uuid')
            ->allowEmptyString('uuid', null, 'create')
            ->add('uuid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator->integer('actor_id');

        $validator->integer('film_id');

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
        $rules->add($rules->isUnique(['uuid']), ['errorField' => 'uuid']);
        $rules->add($rules->existsIn(['actor_id'], 'Actors'), ['errorField' => 'actor_id']);
        $rules->add($rules->existsIn(['film_id'], 'Films'), ['errorField' => 'film_id']);

        return $rules;
    }

    /**
     * @param Query $query
     * @param string $id
     * @return Query
     */
    public function findFilmsByActor(Query $query, array $options): Query
    {
        return $query
            ->contain(['Films'])
            ->where(['actor_id' => $options['actor_id']]);
    }

    /**
     * @param Query $query
     * @param string $id
     * @return Query
     */
    public function findActorsByFilm(Query $query, array $options): Query
    {
        return $query
            ->contain(['Actors'])
            ->where(['film_id' => $options['film_id']]);
    }
}
