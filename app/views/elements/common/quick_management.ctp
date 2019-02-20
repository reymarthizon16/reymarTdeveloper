
<div class="modal fade" id="supplier_management" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('Account',array('id'=>'supplierAccount','prefix'=>$this->params['prefix'],'controller'=>'accounts','action'=>'add'));?>
			    <fieldset>
			        <legend><?php __('Accounts'); ?></legend>
			    <?php
			        echo $this->Form->input('account_number',array('class'=>'reset_class'));
			        echo $this->Form->input('company',array('class'=>'reset_class supplier_require'));
			        echo $this->Form->hidden('account_type_id',array('value'=>2));
			        echo $this->Form->hidden('enabled',array('value'=>1));
			    ?>
			    </fieldset>
			    <br>
			<?php echo $this->Form->end(__('Submit', true));?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" class='supplier_management_close'>Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="serviceC_management" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('Account',array('id'=>'serviceCAccount','prefix'=>$this->params['prefix'],'controller'=>'accounts','action'=>'add'));?>
			    <fieldset>
			        <legend><?php __('Accounts'); ?></legend>
			    <?php
			        echo $this->Form->input('account_number',array('class'=>'reset_class'));
			        echo $this->Form->input('company',array('class'=>'reset_class serviceC_require'));
			        echo $this->Form->hidden('account_type_id',array('value'=>3));
			        echo $this->Form->hidden('enabled',array('value'=>1));
			    ?>
			    </fieldset>
			    <br>
			<?php echo $this->Form->end(__('Submit', true));?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" class='serviceC_management_close'>Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="customer_management" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('Account',array('id'=>'customerAccount','prefix'=>$this->params['prefix'],'controller'=>'accounts','action'=>'add'));?>
			    <fieldset>
			        <legend><?php __('Accounts'); ?></legend>
			    <?php
			        echo $this->Form->input('account_number',array('class'=>'reset_class'));
			        echo $this->Form->input('last_name',array('class'=>'reset_class supplier_require'));
			        echo $this->Form->input('first_name',array('class'=>'reset_class supplier_require'));
			        echo $this->Form->input('middle_name',array('class'=>'reset_class'));			        
			        echo $this->Form->input('mobile_no',array('class'=>'reset_class'));			        
			        echo $this->Form->input('address',array('class'=>'reset_class'));			        
			        echo $this->Form->hidden('account_type_id',array('value'=>1));
			        echo $this->Form->hidden('enabled',array('value'=>1));
			    ?>
			    </fieldset>
			    <br>
			<?php echo $this->Form->end(__('Submit', true));?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" class='customer_management_close'>Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery('#supplierAccount').submit(function(){
			
			if( jQuery('.supplier_require').val() !== ''){
				
				var dataa = jQuery(this).serializeArray();

		        jQuery.ajax({
		            async:false,
		            data:dataa,
		            url:'/'+prefix+'/accounts/quickadd/2',
		            type:'POST',
		            dataType:'json',
		            success:function(data){             
		                if(data.success){
		                    if(data.Account){
		                    	jQuery('.account_supplier').chosen('destroy');
		                    	jQuery('.account_supplier').empty();
		                    	jQuery('.account_supplier').append('<option value="" >Select Supplier</option>');
		                    	jQuery.each(data.Account,function(key,value){
		                    		jQuery('.account_supplier').append('<option value="'+key+'" >'+value+'</option>');
		                    	});
		                    	jQuery('.account_supplier').val('');
		                    	jQuery('.account_supplier').chosen();
		                    }
		                }
		            },
		            error:function(whaterror){
		            },
		            complete:function(){

		            }
		        });
		        
		        jQuery('.reset_class').val('');
	 			jQuery('#supplier_management').modal('toggle');
	 			jQuery('.supplier_require').css({'border':'0px solid red'});
 			}else{
 				jQuery('.supplier_require').css({'border':'1px solid red'});
 			}
			return false;			
		});

		jQuery('#serviceCAccount').submit(function(){
			
			if( jQuery('.serviceC_require').val() !== ''){
				
				var dataa = jQuery(this).serializeArray();

		        jQuery.ajax({
		            async:false,
		            data:dataa,
		            url:'/'+prefix+'/accounts/quickadd/3',
		            type:'POST',
		            dataType:'json',
		            success:function(data){             
		                if(data.success){
		                    if(data.Account){
		                    	jQuery('.account_serviceC').chosen('destroy');
		                    	jQuery('.account_serviceC').empty();
		                    	jQuery('.account_serviceC').append('<option value="" >Select Service Center</option>');
		                    	jQuery.each(data.Account,function(key,value){
		                    		jQuery('.account_serviceC').append('<option value="'+key+'" >'+value+'</option>');
		                    	});
		                    	jQuery('.account_serviceC').val('');
		                    	jQuery('.account_serviceC').chosen();
		                    }
		                }
		            },
		            error:function(whaterror){
		            },
		            complete:function(){

		            }
		        });
		        
		        jQuery('.reset_class').val('');
	 			jQuery('#serviceC_management').modal('toggle');
	 			jQuery('.serviceC_require').css({'border':'0px solid red'});
 			}else{
 				jQuery('.serviceC_require').css({'border':'1px solid red'});
 			}
			return false;			
		});

		jQuery('#customerAccount').submit(function(){
			
			if( jQuery('.customer_require').val() !== ''){
				
				var dataa = jQuery(this).serializeArray();

		        jQuery.ajax({
		            async:false,
		            data:dataa,
		            url:'/'+prefix+'/accounts/quickadd/1',
		            type:'POST',
		            dataType:'json',
		            success:function(data){             
		                if(data.success){
		                    if(data.Account){
		                    	jQuery('.account_customer').chosen('destroy');
		                    	jQuery('.account_customer').empty();
		                    	jQuery('.account_customer').append('<option value="" >Select Customer</option>');
		                    	jQuery.each(data.Account,function(key,value){
		                    		jQuery('.account_customer').append('<option value="'+key+'" >'+value+'</option>');
		                    	});
		                    	jQuery('.account_customer').val('');
		                    	jQuery('.account_customer').chosen();
		                    }
		                }
		            },
		            error:function(whaterror){
		            },
		            complete:function(){

		            }
		        });
		        
		        jQuery('.reset_class').val('');
	 			jQuery('#customer_management').modal('toggle');
	 			jQuery('.customer_require').css({'border':'0px solid red'});
 			}else{
 				jQuery('.customer_require').css({'border':'1px solid red'});
 			}
			return false;			
		});
	});
</script>