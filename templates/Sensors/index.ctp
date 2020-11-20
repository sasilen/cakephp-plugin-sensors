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
    $this->Breadcrumbs->add('index',null,['class'=>'breadcrumb-item active']);
    $this->Breadcrumbs->add($this->AuthLink->link($this->Html->image('Blog.ic_note_add_black_24px.svg'),['plugin'=>'Sensors','controller'=>'sensors','action' => 'add'],['escape'=>false,'class'=>'ml-1 float-right']));
		foreach ($tags as $tag) :
  		$this->Breadcrumbs->add($tag['label'],['plugin'=>'Sensors','controller' => 'sensors', 'action' => 'index','tags'=>[ $tag['label'] ] ],['class'=>'badge badge-info ml-1 float-right']);
		endforeach;

    echo $this->Breadcrumbs->render(
      ['separator' => '/']
    );
?>


    <?php foreach (array_keys($chart) as $type):?>
      <div class="chart">
      <h4><?=$type;?></h3> 
      <div id="linewrapper_<?=$type;?>" class="large-12"style="display: block; margin-bottom: 20px;"></div>
      <div class="clear"></div>
      <?php echo $this->Highcharts->render($chart[$type],$type); ?>
      </div>
    <?php endforeach;?>
		</div>

		 <table class="table table-bordered">

        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('datetime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col" class="actions"><?= $this->Html->link(__('Tags'), ['action' => 'index']) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sensors as $sensor): ?>
            <tr>
                <td><?=$this->Html->link(h($sensor->name), ['action' => 'view', $sensor->id]) ?></td>
                <td><?= h($sensor->datetime->i18nFormat('dd-MM-yyyy')) ?></td>
                <td><?= h($sensor->description) ?></td>
                <td><?php foreach ($sensor->tags as $tag): ?>
                    <?= $this->Html->link($tag->label, ['action' => 'index', '?'=>['tags'=>[$tag->label] ]]) ?>
                    <?php endforeach; ?>

										<?= $this->AuthLink->link($this->Html->image('Blog.ic_mode_edit_black_24px.svg'),['plugin'=>'Sensors','controller'=>'sensors','action' => 'edit',$sensor->id],['escape'=>false,'class'=>'float-right']);?>
   				          <?php if ($this->AuthLink->isAuthorized(['plugin'=>'Sensors','controller'=>'sensors','action' => 'delete',$sensor->id])) : ?>
                     <?= $this->Form->postLink($this->Html->image('ic_delete_forever_black_24px.svg'), ['action' => 'delete', $sensor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id),'escape'=>false,'class'=>'float-right']) ?>
                   <?php endif; ?>
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
