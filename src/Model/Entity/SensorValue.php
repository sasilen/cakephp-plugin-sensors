<?php
declare(strict_types=1);

namespace Sensor\Model\Entity;

use Cake\ORM\Entity;

/**
 * SensorValue Entity
 *
 * @property int $id
 * @property string $sensor_id
 * @property \Cake\I18n\FrozenTime $datetime
 * @property float $value
 * @property string $type
 * @property string|null $name
 *
 * @property \Sensor\Model\Entity\Sensor $sensor
 */
class SensorValue extends Entity
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
        'sensor_id' => true,
        'datetime' => true,
        'value' => true,
        'type' => true,
        'name' => true,
        'sensor' => true,
    ];
}
