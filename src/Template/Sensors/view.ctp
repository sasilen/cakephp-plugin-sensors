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
    $this->Breadcrumbs->add('Sensors',['plugin'=>'Sensors','controller' => 'sensors', 'action' => 'index'],['class'=>'breadcrumb-item']);
    $this->Breadcrumbs->add('view',null,['class'=>'breadcrumb-item active']);
		$this->Breadcrumbs->add($sensor->name. '('.$sensor->datetime->i18nFormat('yyyy-MM-dd HH:mm').')',['plugin'=>'Sensors','controller' => 'sensors', 'action' => 'view',$sensor->id],['class'=>'breadcrumb-item']);
    $this->Breadcrumbs->add($this->AuthLink->link($this->Html->image('Blog.ic_note_add_black_24px.svg'),['plugin'=>'Sensors','controller'=>'SensorValues','action' => 'add'],['escape'=>false,'class'=>'ml-1 float-right']));
		foreach ($sensor->tags as $tag) :
      $this->Breadcrumbs->add($tag['label'],['plugin'=>'Sensors','controller' => 'sensors', 'action' => 'index','tags'=>[ $tag['label'] ] ],['class'=>'badge badge-info ml-1 float-right']);
    endforeach;

    echo $this->Breadcrumbs->render(
      ['separator' => '/']
    );
?>
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
				<table class="table table-bordered">
            <tr>
                <th scope="col"><?= __('Sensor Id') ?></th>
                <th scope="col"><?= __('Datetime') ?></th>
                <th scope="col"><?= __('Value') ?></th>
                <th scope="col"><?= __('Type') ?></th>
            </tr>
            <?php foreach ($sensor->sensor_values as $sensorValues): ?>
            <tr>
                <td><?= h($sensor->name) ?></td>
                <td><?= h($sensorValues->datetime->i18nFormat('yyyy-MM-dd HH:mm')) ?></td>
                <td><?= h($sensorValues->value) ?></td>
                <td><?= h($sensorValues->type) ?>
								<?= $this->AuthLink->link($this->Html->image('Blog.ic_mode_edit_black_24px.svg'),['plugin'=>'Sensors','controller'=>'SensorValues','action' => 'edit',$sensorValues->id],['escape'=>false,'class'=>'float-right']);?>
                   <?php if ($this->AuthLink->isAuthorized(['plugin'=>'Sensors','controller'=>'SensorValues','action' => 'delete',$sensorValues->id])) : ?>
                     <?= $this->Form->postLink($this->Html->image('ic_delete_forever_black_24px.svg'), ['action' => 'delete', $sensorValues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensorValues->id),'escape'=>false,'class'=>'float-right']) ?>
                   <?php endif; ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
