<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-5">       
        <div class="users form">
        <?php echo $this->Form->create('User');?>
            <fieldset>
                <?php echo $this->element('common/createforms');?>
            </fieldset>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>
