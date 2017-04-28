<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sensor'), ['action' => 'edit', $sensor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sensor'), ['action' => 'delete', $sensor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sensors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sensor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sensor Values'), ['controller' => 'SensorValues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sensor Value'), ['controller' => 'SensorValues', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sensors view large-9 medium-8 columns content">
    <h3><?= h($sensor->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($sensor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($sensor->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($sensor->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Datetime') ?></th>
            <td><?= h($sensor->datetime) ?></td>
        </tr>
        <tr>
            <th><?= __('Tags') ?></th>
            <td>
                <?php foreach ($sensor->tags as $tag): ?>
                    <?= h($tag->label).',' ?>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
    <div class="sensors index large-10 medium-9 columns content">


    <?php foreach (array_keys($chart) as $type):?>
        <div class="chart">
            <h4><?=$type;?></h3> 
            <div id="linewrapper_<?=$type;?>" style="display: block; margin-bottom: 20px;"></div>
            <div class="clear"></div>
            <?php echo $this->Highcharts->render($chart[$type],$type); ?>
        </div>
    <?php endforeach;?>


    </div>
    <div class="related">
        <h4><?= __('Related Sensor Values') ?></h4>
        <?php if (!empty($sensor->sensor_values)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sensor Id') ?></th>
                <th scope="col"><?= __('Datetime') ?></th>
                <th scope="col"><?= __('Value') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sensor->sensor_values as $sensorValues): ?>
            <tr>
                <td><?= h($sensorValues->id) ?></td>
                <td><?= h($sensorValues->sensor_id) ?></td>
                <td><?= h($sensorValues->datetime) ?></td>
                <td><?= h($sensorValues->value) ?></td>
                <td><?= h($sensorValues->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SensorValues', 'action' => 'view', $sensorValues->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SensorValues', 'action' => 'edit', $sensorValues->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SensorValues', 'action' => 'delete', $sensorValues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValues->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
