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
            <?= $this->Html->link(__('List Sensor Values'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sensorValues form content">
            <?= $this->Form->create($sensorValue) ?>
            <fieldset>
                <legend><?= __('Add Sensor Value') ?></legend>
                <?php
                    echo $this->Form->control('sensor_id', ['options' => $sensors]);
                    echo $this->Form->control('datetime');
                    echo $this->Form->control('value');
                    echo $this->Form->control('type');
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
