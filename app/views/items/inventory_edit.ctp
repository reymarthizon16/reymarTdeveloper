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
                <?php 
                if( $this->data['Item']['status']==1 || $this->data['Item']['status']==5)
                    echo $this->Form->input('status',array('type'=>'select','options'=>array('1'=>'Neutral','5'=>'Reposes'))); 
                    ?>
                <?php echo $this->Form->input('started_branch_id',array('empty'=>'Select Branch')); ?>
                <?php echo $this->Form->input('change_branch',array('value'=>1,'type'=>'checkbox')); ?>
                <?php echo $this->Form->hidden('original_serial_no',array('value'=>$originalSerialNo)); ?>
            </fieldset>
            <br>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>
