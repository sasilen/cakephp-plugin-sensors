<?php
declare(strict_types=1);

namespace Sensor\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sensor Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $datetime
 * @property string $description
 * @property int|null $tag_count
 *
 * @property \Sensor\Model\Entity\SensorValue[] $sensor_values
 * @property \Sensor\Model\Entity\Phinxlog[] $phinxlog
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
        'name' => true,
        'datetime' => true,
        'description' => true,
        'sensor_values' => true,
    ];
}
