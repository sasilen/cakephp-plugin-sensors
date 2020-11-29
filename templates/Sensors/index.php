<?php
/**
  * @var \App\View\AppView $this
  */
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', ['block' => 'scriptTop']);
echo $this->Html->script('https://cdn.jsdelivr.net/npm/chart.js@2.8.0', ['block' => 'scriptTop']);
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <div style="position: absolute; margin-top:10px; right:0; margin-right:30px;">
            <?=$this->AuthLink->link('<i class="far fa-file"></i>',['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'add'],['escape'=>false]);?>
        </div>
    <?php
        $this->Breadcrumbs->setTemplates(['wrapper' => '<ol class="breadcrumb">{{content}}</ol>', 'separator' => '<li{{attrs}}>{{separator}}</li>']);
        $this->Breadcrumbs->add('Sensors',['plugin'=>'Sasilen/Sensors','controller' => 'sensors', 'action' => 'index'],['class'=>'breadcrumb-item']);
        $this->Breadcrumbs->add('index',null,['class'=>'breadcrumb-item active']);
        if (isset($tags)) :
            foreach ($tags as $tag) :
                $this->Breadcrumbs->add($tag['label'],['plugin'=>'Sasilen/Sensors','controller' => 'sensors', 'action' => 'index','?'=>['tags'=>$tag['label']] ],['class'=>'badge badge-info ml-1 ']);
            endforeach;
        endif;
        echo $this->Breadcrumbs->render(['separator' => '/']);
    ?>

    <?php if ($chart!=NULL) : foreach (array_keys($chart) as $type): ?>
        <h4><?=$type;?></h4>
        <canvas id="canvas_<?=$type;?>"></canvas>
        <script>
            var config_<?=$type;?> = {
                type:    'scatter',
                data:    {
                    labels: <?=json_encode($chart[$type]['data']['labels']);?>,
                    datasets: [
                    <?php $color=['red','green','blue','brown','yellow']; foreach (array_keys($chart[$type]['data']['datasets']) as $i): ?>
                        {
                             label: "<?=$chart[$type]['data']['datasets'][$i]['label'];?>",
                             data: <?=json_encode($chart[$type]['data']['datasets'][$i]['data']);?>,
                             fill: false,
			     borderColor: "<?=$color[$i];?>",
			     showLine: true
                         },
                    <?php endforeach; ?>
                    ]
                },
                options: {
                    responsive: true,
                    title:      {
                        display: true,
                        text:    "<?=$type;?>"
		    },
		    scales: {
		        xAxes: [{
		            ticks: {
	                    	stepSize: 0.5
                            }
        		}]

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

        <table class="table table-sm">
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
                        <?= $this->Html->link($tag->label, ['action' => 'index', '?'=>['tags'=>[$tag->label]]],['class'=>'badge badge-info']) ?>
                    <?php endforeach; ?>
                    <?=$this->AuthLink->link('<i class="far fa-edit"></i>',['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'edit',$sensor->id],['escape'=>false,'class'=>'float-right']);?> 
                    <?=$this->AuthLink->postLink('<i class="far fa-trash-alt"></i>', ['plugin'=>'Sasilen/Sensors','controller'=>'sensors','action' => 'delete', $sensor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id),'escape'=>false,'class'=>'float-right']) ?>
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
</div>
