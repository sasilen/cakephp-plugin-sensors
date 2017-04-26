<?php
namespace Sensors\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sensor Entity
 *
 * @property string $id
 * @property string $name
 * @property \Cake\I18n\Time $datetime
 * @property string $description
 *
 * @property \Sensors\Model\Entity\SensorValue[] $sensor_values
 * @property \Sensors\Model\Entity\SensorvaluesOLD[] $sensorvalues_o_l_d
 */
class Sensor extends Entity
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
        '*' => true,
        'id' => false
    ];
}
