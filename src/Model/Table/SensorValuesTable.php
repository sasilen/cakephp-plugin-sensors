<?php
namespace Sensors\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SensorValues Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sensors
 *
 * @method \Sensors\Model\Entity\SensorValue get($primaryKey, $options = [])
 * @method \Sensors\Model\Entity\SensorValue newEntity($data = null, array $options = [])
 * @method \Sensors\Model\Entity\SensorValue[] newEntities(array $data, array $options = [])
 * @method \Sensors\Model\Entity\SensorValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensors\Model\Entity\SensorValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sensors\Model\Entity\SensorValue[] patchEntities($entities, array $data, array $options = [])
 * @method \Sensors\Model\Entity\SensorValue findOrCreate($search, callable $callback = null, $options = [])
 */
class SensorValuesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sensor_values');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sensors', [
            'foreignKey' => 'sensor_id',
            'joinType' => 'LEFT',
            'className' => 'Sensors.Sensors'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('datetime')
            ->requirePresence('datetime', 'create')
            ->notEmpty('datetime');

        $validator
            ->numeric('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['sensor_id'], 'Sensors'));

        return $rules;
    }
}
