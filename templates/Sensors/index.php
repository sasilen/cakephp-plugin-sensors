<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <?php
        $this->Breadcrumbs->setTemplates(['wrapper' => '<ol class="breadcrumb">{{content}}</ol>', 'separator' => '<li{{attrs}}>{{separator}}</li>']);
        $this->Breadcrumbs->add('Sensors',['plugin'=>'Sasilen/Sensors','controller' => 'sensors', 'action' => 'index'],['class'=>'breadcrumb-item']);
        $this->Breadcrumbs->add('index',null,['class'=>'breadcrumb-item active']);
        $this->Breadcrumbs->add($this->AuthLink->link($this->Html->image('Blog.ic_note_add_black_24px.svg'),['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'add'],['escape'=>false,'class'=>'ml-1 float-right']));
        if (isset($tags)) : 
            foreach ($tags as $tag) :
                $this->Breadcrumbs->add($tag,['plugin'=>'Sasilen/Sensors','controller' => 'sensors', 'action' => 'index','tags'=>$tag ],['class'=>'badge badge-info ml-1 float-right']);
            endforeach;
        endif;
        echo $this->Breadcrumbs->render(['separator' => '/']);
    ?>

    <?php if ($chart!=NULL) : foreach (array_keys($chart) as $type): ?>
        <h4><?=$type;?></h4>
        <canvas id="canvas_<?=$type;?>"></canvas>
        <script>
            var config_<?=$type;?> = {
                type:    'line',
                data:    {
                    labels: <?=json_encode($chart[$type]['data']['labels']);?>,
                    datasets: [
                    <?php $color=['red','green','blue','brown','yellow']; foreach (array_keys($chart[$type]['data']['datasets']) as $i): ?>
                        {
                             label: "<?=$chart[$type]['data']['datasets'][$i]['label'];?>",
                             data: <?=json_encode($chart[$type]['data']['datasets'][$i]['data']);?>,
                             fill: false,
                             borderColor: "<?=$color[$i];?>"
                         },
                    <?php endforeach; ?>
                    ]
                },
                options: {
                    responsive: true,
                    title:      {
                        display: true,
                        text:    "<?=$type;?>"
                    }
                }
            };
            window.onload = function () {
                <?php foreach (array_keys($chart) as $type): ?>
                var ctx       = document.getElementById("canvas_<?=$type;?>").getContext("2d");
                window.myLine = new Chart(ctx, config_<?=$type;?>);
                <?php endforeach; ?>

            };
        </script>
    <?php endforeach; endif;?>

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

										<?= $this->AuthLink->link($this->Html->image('Blog.ic_mode_edit_black_24px.svg'),['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'edit',$sensor->id],['escape'=>false,'class'=>'float-right']);?>
   				          <?php if ($this->AuthLink->isAuthorized(['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'delete',$sensor->id])) : ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
    </div>
</div>
