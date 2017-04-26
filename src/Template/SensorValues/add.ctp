<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sensor Values'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sensors'), ['controller' => 'Sensors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sensor'), ['controller' => 'Sensors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sensorValues form large-9 medium-8 columns content">
    <?= $this->Form->create($sensorValue) ?>
    <fieldset>
        <legend><?= __('Add Sensor Value') ?></legend>
        <?php
            echo $this->Form->control('sensor_id', ['options' => $sensors]);
            echo $this->Form->control('datetime');
            echo $this->Form->control('value');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
