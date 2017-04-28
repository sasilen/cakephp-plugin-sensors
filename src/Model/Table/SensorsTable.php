<?php
namespace Sensors\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sensors Model
 *
 * @property \Cake\ORM\Association\HasMany $SensorValues
 * @property \Cake\ORM\Association\HasMany $SensorvaluesOLD
 *
 * @method \Sensors\Model\Entity\Sensor get($primaryKey, $options = [])
 * @method \Sensors\Model\Entity\Sensor newEntity($data = null, array $options = [])
 * @method \Sensors\Model\Entity\Sensor[] newEntities(array $data, array $options = [])
 * @method \Sensors\Model\Entity\Sensor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensors\Model\Entity\Sensor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sensors\Model\Entity\Sensor[] patchEntities($entities, array $data, array $options = [])
 * @method \Sensors\Model\Entity\Sensor findOrCreate($search, callable $callback = null, $options = [])
 */
class SensorsTable extends Table
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

        $this->addBehavior('Muffin/Tags.Tag');

        $this->setTable('sensors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('SensorValues', [
            'foreignKey' => 'sensor_id',
            'className' => 'Sensors.SensorValues'
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->dateTime('datetime')
            ->requirePresence('datetime', 'create')
            ->notEmpty('datetime');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }
}
