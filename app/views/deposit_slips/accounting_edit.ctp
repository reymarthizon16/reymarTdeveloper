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
                <?php echo $this->Form->input('deposit_date',array('type'=>'text','class'=>'datepicker deposit_dateChange')); ?>
                
                <?php echo $this->element('common/createforms');?>
                <?php echo $this->Form->input('date_deposited',array('type'=>'text','class'=>'datepicker')); ?>

                <div style="width: 800px;text-align: right;">
                    <button class='getDueInfo btn-xs btn btn-info '>Get Info</button>
                </div>
                <div class="marilynDiv" style="width: 800px;border:1px solid black;margin: 10px;" >
                
                </div>
            </fieldset>
            <br>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>

<?php echo $this->element('deposit_script'); ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.getDueInfo').trigger('click');
    });
</script>