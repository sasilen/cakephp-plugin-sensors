<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="sensors form large-9 medium-8 columns content">
    <?= $this->Form->create($sensor) ?>
    <fieldset>
        <legend><?= __('Edit Sensor') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('name');
            echo $this->Form->control('datetime');
            echo $this->Form->control('description');
            echo $this->Form->input('Tags');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
