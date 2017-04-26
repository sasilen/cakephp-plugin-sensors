<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sensor Value'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sensors'), ['controller' => 'Sensors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sensor'), ['controller' => 'Sensors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sensorValues index large-9 medium-8 columns content">
    <h3><?= __('Sensor Values') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sensor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('datetime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sensorValues as $sensorValue): ?>
            <tr>
                <td><?= $this->Number->format($sensorValue->id) ?></td>
                <td><?= $sensorValue->has('sensor') ? $this->Html->link($sensorValue->sensor->name, ['controller' => 'Sensors', 'action' => 'view', $sensorValue->sensor->id]) : '' ?></td>
                <td><?= h($sensorValue->datetime) ?></td>
                <td><?= $this->Number->format($sensorValue->value) ?></td>
                <td><?= h($sensorValue->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sensorValue->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sensorValue->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sensorValue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValue->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
