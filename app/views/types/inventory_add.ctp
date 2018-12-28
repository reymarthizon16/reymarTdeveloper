<div class="col-lg-5">
<?php echo $this->Form->create('Type');?>
    <fieldset>
        <legend><?php __('Types'); ?></legend>
    <?php
        echo $this->Form->input('name');
        echo $this->Form->input('enabled');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
