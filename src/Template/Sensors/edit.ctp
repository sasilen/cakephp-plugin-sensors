<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sensor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sensors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sensor Values'), ['controller' => 'SensorValues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sensor Value'), ['controller' => 'SensorValues', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sensors form large-9 medium-8 columns content">
    <?= $this->Form->create($sensor) ?>
    <fieldset>
        <legend><?= __('Edit Sensor') ?></legend>
        <?php
            echo $this->Form->control('id',array('type'=>'text'));
            echo $this->Form->control('name');
            echo $this->Form->control('datetime');
            echo $this->Form->control('description');
            echo $this->Form->input('tags');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
