<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sensorValue
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sensor Value'), ['action' => 'edit', $sensorValue->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sensor Value'), ['action' => 'delete', $sensorValue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValue->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sensor Values'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sensor Value'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sensorValues view content">
            <h3><?= h($sensorValue->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Sensor') ?></th>
                    <td><?= $sensorValue->has('sensor') ? $this->Html->link($sensorValue->sensor->name, ['controller' => 'Sensors', 'action' => 'view', $sensorValue->sensor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($sensorValue->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($sensorValue->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sensorValue->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Value') ?></th>
                    <td><?= $this->Number->format($sensorValue->value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Datetime') ?></th>
                    <td><?= h($sensorValue->datetime) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
