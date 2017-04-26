<?php
namespace Sensors\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sensors\Model\Table\SensorsTable;

/**
 * Sensors\Model\Table\SensorsTable Test Case
 */
class SensorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Sensors\Model\Table\SensorsTable
     */
    public $Sensors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.sensors.sensors',
        'plugin.sensors.sensor_values',
        'plugin.sensors.sensorvalues_o_l_d'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Sensors') ? [] : ['className' => 'Sensors\Model\Table\SensorsTable'];
        $this->Sensors = TableRegistry::get('Sensors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sensors);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
