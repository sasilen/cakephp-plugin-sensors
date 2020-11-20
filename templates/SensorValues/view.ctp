<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sensor Value'), ['action' => 'edit', $sensorValue->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sensor Value'), ['action' => 'delete', $sensorValue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValue->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sensor Values'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sensor Value'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sensors'), ['controller' => 'Sensors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sensor'), ['controller' => 'Sensors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sensorValues view large-9 medium-8 columns content">
    <h3><?= h($sensorValue->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sensor') ?></th>
            <td><?= $sensorValue->has('sensor') ? $this->Html->link($sensorValue->sensor->name, ['controller' => 'Sensors', 'action' => 'view', $sensorValue->sensor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($sensorValue->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sensorValue->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= $this->Number->format($sensorValue->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Datetime') ?></th>
            <td><?= h($sensorValue->datetime) ?></td>
        </tr>
    </table>
</div>
