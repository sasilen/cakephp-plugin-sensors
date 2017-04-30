<?php
/**
  * @var \App\View\AppView $this
  */
?>
    <div class="sensors index large-12 medium-12 columns content">
    <h3><?= __('Sensors') ?></h3>

    <?php foreach (array_keys($chart) as $type):?>
      <div class="chart">
      <h4><?=$type;?></h3> 
      <div id="linewrapper_<?=$type;?>" style="display: block; margin-bottom: 20px;"></div>
      <div class="clear"></div>
      <?php echo $this->Highcharts->render($chart[$type],$type); ?>
      </div>
    <?php endforeach;?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('datetime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col" class="actions"><?= $this->Html->link(__('Tags'), ['action' => 'index']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sensors as $sensor): ?>
            <tr>
                <td><?= h($sensor->id) ?></td>
                <td><?= h($sensor->name) ?></td>
                <td><?= h($sensor->datetime) ?></td>
                <td><?= h($sensor->description) ?></td>
                <td><?php foreach ($sensor->tags as $tag): ?>
                    <?= $this->Html->link($tag->label, ['action' => 'index', $tag->label]) ?>
                    <?php endforeach; ?>
                </td>

                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sensor->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sensor->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sensor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id)]) ?>
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
