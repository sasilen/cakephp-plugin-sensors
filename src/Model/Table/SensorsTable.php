<?php
declare(strict_types=1);

namespace Sasilen\Sensors\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sensors Model
 *
 * @property \Sensor\Model\Table\SensorValuesTable&\Cake\ORM\Association\HasMany $SensorValues
 * @property \Sensor\Model\Table\PhinxlogTable&\Cake\ORM\Association\BelongsToMany $Phinxlog
 *
 * @method \Sensor\Model\Entity\Sensor newEmptyEntity()
 * @method \Sensor\Model\Entity\Sensor newEntity(array $data, array $options = [])
 * @method \Sensor\Model\Entity\Sensor[] newEntities(array $data, array $options = [])
 * @method \Sensor\Model\Entity\Sensor get($primaryKey, $options = [])
 * @method \Sensor\Model\Entity\Sensor findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sensor\Model\Entity\Sensor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sensor\Model\Entity\Sensor[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sensor\Model\Entity\Sensor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensor\Model\Entity\Sensor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sensor\Model\Entity\Sensor[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\Sensor[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\Sensor[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Sensor\Model\Entity\Sensor[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SensorsTable extends Table
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

        $this->addBehavior('Muffin/Tags.Tag');

        $this->setTable('sensors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('SensorValues', [
            'foreignKey' => 'sensor_id',
            'className' => 'Sensor.SensorValues',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->dateTime('datetime')
            ->requirePresence('datetime', 'create')
            ->notEmptyDateTime('datetime');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        return $validator;
    }
}
