<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <?php $this->Breadcrumbs->templates([
      'wrapper' => '<ol class="breadcrumb">{{content}}</ol>',
      'separator' => '<li{{attrs}}>{{separator}}</li>'
    ]);
    $this->Breadcrumbs->add('Sensor value',['plugin'=>'Sensors','controller' => 'SensorValues', 'action' => 'index'],['class'=>'breadcrumb-item']);
    $this->Breadcrumbs->add('add',null,['class'=>'breadcrumb-item active']);

    echo $this->Breadcrumbs->render(
      ['separator' => '/']
    );
?>
    <div class="form-group col-sm-12">
    <?= $this->Form->create($sensorValue,['class'=>'form-horizontal']) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name',['label' => ['class' => 'col-sm-2 control-label', 'text' => __('Name')]]);
            echo $this->Form->control('sensor_id', ['default'=>$sensorValue['sensor_id'],'options' => $sensors,'label' => ['class' => 'col-sm-2 control-label', 'text' => __('Sensor')]]);
            echo $this->Form->control('datetime',['label' => ['class' => 'col-sm-2 control-label', 'text' => __('Datetime')]]);
            echo $this->Form->control('value',['label' => ['class' => 'col-sm-2 control-label', 'text' => __('Value')]]);
            echo $this->Form->control('type',['label' => ['class' => 'col-sm-2 control-label', 'text' => __('Type')]]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
