<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sensorValue
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="sensorValues form content">
            <?= $this->Form->create($sensorValue); ?>
            <fieldset>
                <legend><?= __('Add Sensor Value') ?></legend>
                <?php
                    echo $this->Form->control('sensor_id', ['default'=>$sensorValue['sensor_id'],'options' => $sensors,'label' => ['text' => __('Sensor')]]);
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
