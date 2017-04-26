<?php
namespace Sensors\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sensors\Model\Table\SensorValuesTable;

/**
 * Sensors\Model\Table\SensorValuesTable Test Case
 */
class SensorValuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Sensors\Model\Table\SensorValuesTable
     */
    public $SensorValues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.sensors.sensor_values',
        'plugin.sensors.sensors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SensorValues') ? [] : ['className' => 'Sensors\Model\Table\SensorValuesTable'];
        $this->SensorValues = TableRegistry::get('SensorValues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SensorValues);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
