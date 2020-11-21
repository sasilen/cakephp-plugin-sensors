<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $sensorValues
 */
?>
<div class="sensorValues index content">
    <?= $this->Html->link(__('New Sensor Value'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sensor Values') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('sensor_id') ?></th>
                    <th><?= $this->Paginator->sort('datetime') ?></th>
                    <th><?= $this->Paginator->sort('value') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
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
                    <td><?= h($sensorValue->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $sensorValue->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sensorValue->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sensorValue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValue->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
