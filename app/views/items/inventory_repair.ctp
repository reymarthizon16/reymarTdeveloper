<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $model ?> Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-5">       
        <div class="users form">
        <?php echo $this->Form->create($model);?>
            <fieldset>
                <?php echo $this->element('common/createforms');?>
                <?php echo $this->Form->hidden('original_serial_no',array('value'=>$originalSerialNo)); ?>
                <?php echo $this->Form->input('repair_datetime',array('type'=>'text','class'=>'datetimepicker')); ?>                
            </fieldset>
            <br>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>

