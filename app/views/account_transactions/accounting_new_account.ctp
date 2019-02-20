<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Account</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    
        <?php echo $this->Form->create();?>	   
        <div class="col-lg-12">
        	<div class="col-lg-1">
	        	<label>Account</label>
	        </div>
	        <div class="col-lg-3">
        <?php echo $this->Form->input('AccountTransaction.person_account_id',array('id'=>'PersonId','empty'=>'Select Account','options'=>$accountCustomers,'style'=>'width:300px;','label'=>false,'class'=>'account_customer')); ?>
        	</div>
	        <div class="col-lg-3">
	        	<button style="float:left;" type="button" class="btn btn-xs btn-primary manage-customer type1" data-toggle="modal" data-target="#customer_management">Manage Customer</button>
	        </div>
	        
        </div>
        <br />
        <br />
	   	<?php echo $this->element('account_transactions/customerTransactionBody');?>       
	   	               
        <?php echo $this->Form->end(__('Submit', true));?>
       
</div>
<?php echo $this->element('/common/quick_management'); ?>
<script type="text/javascript">
    var exsisting = 1;
    jQuery(document).ready(function(){
    	jQuery('#AccountTransactionPersonAccountId').remove();
    	jQuery('.addInstallment').remove();
    	jQuery('.InstallmentDiv').remove();

        jQuery('#AccountTransactionAccountingNewAccountForm').submit(function(e){
           
           if( jQuery('.account_customer').val() == '' ){
                alert('Please Select Account'); 
                e.preventDefault();
           }

           if( jQuery('#AccountTransactionBranchId').val() == '' ){
                alert('Please Select Branch'); 
                e.preventDefault();
           }

        });
    });
</script>