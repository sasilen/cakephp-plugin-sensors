<?php
declare(strict_types=1);

namespace Sasilen\Sensors\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SensorValues Model
 *
 * @property \Sensor\Model\Table\SensorsTable&\Cake\ORM\Association\BelongsTo $Sensors
 *
 * @method \Sensor\Model\Entity\SensorValue newEmptyEntity()
 * @method \Sensor\Model\Entity\SensorValue newEntity(array $data, array $options = [])
 * @method \Sensor\Model\Entity\SensorValue[] newEntities(array $data, array $options = [])
 * @method \Sensor\Model\Entity\SensorValue get($primaryKey, $options = [])
 * @method \Sensor\Model\Entity\SensorValue findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sensor\Model\Entity\SensorValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sensor\Model\Entity\SensorValue[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sensor\Model\Entity\SensorValue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensor\Model\Entity\SensorValue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensor\Model\Entity\SensorValue[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\SensorValue[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\SensorValue[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\SensorValue[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SensorValuesTable extends Table
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

        $this->setTable('sensor_values');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sensors', [
            'foreignKey' => 'sensor_id',
            'joinType' => 'LEFT',
            'className' => 'Sensor.Sensors',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('datetime')
            ->requirePresence('datetime', 'create')
            ->notEmptyDateTime('datetime');

        $validator
            ->numeric('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->scalar('type')
            ->maxLength('type', 15)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('name')
            ->maxLength('name', 15)
            ->allowEmptyString('name');

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
        $rules->add($rules->existsIn(['sensor_id'], 'Sensors'));

        return $rules;
    }
}
