<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> Stock Transfer Branch to Branch</h1>
    </div>
</div>
 -->
<br/>
<?php echo $this->Form->create('StockTransferTransaction');?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
           <button style="" type="button" onclick="window.location='/inventory/stock_transfer_transactions/stock_transferin_branchtobranch';" class="btn btn-primary">Add Stock Transfer</button>
        </div>
        <div class="panel-body">
            <form role="form">
            <div class="row">
                <div class="col-lg-12"> 
                    <?php 
                        if(!empty($this->data['StockTransferTransaction']['id'])){
                            echo $this->Form->input('id',array('label'=>false,'type'=>'text','style'=>'display:none','value'=>$this->data['StockTransferTransaction']['id'])); 
                        }
                     ?>                                     
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">Stock # :</i></span>
                        <?php echo $this->Form->input('stock_transfer_no',array('label'=>false,'type'=>'text')); ?>
                    </div>                                    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">DateTime:</i></span>
                        <?php $dateValue = "";
                            if(empty($this->data['StockTransferTransaction']['stock_transfer_datetime'])){
                                $dateValue =  date('Y/m/d H:i');
                            }else{
                                $dateValue = $this->data['StockTransferTransaction']['stock_transfer_datetime'];
                            }                        
                         ?>
                        <?php echo $this->Form->input('stock_transfer_datetime',array('class'=>'datetimepicker','label'=>false,'type'=>'text','value'=>$dateValue)); ?>
                    </div>
                </div>
                <div class="col-lg-12">                       
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">From:</i></span>
                        <?php echo $this->Form->input('from_branch_id',array('id'=>'FromBranchId','empty'=>'Select Branch','label'=>false,'type'=>'select')); ?>
                    </div>
                <!-- </div> -->
                    <div class="col-lg-4">
                        <span class="">Type : </i></span>
                        <?php //echo $this->Form->input('type',array('label'=>false,'type'=>'radio','options'=>array('1'=>'From Supplier','2'=>'From Stock Transfer'))); ?>
                        <label class="radio-inline">
                            <input type="radio" name="data[StockTransferTransaction][type]" id="StockTransferTransactionTypeId" class="StockTransferTransactionType" value="1" checked <?php echo $disableType; ?>>To Branch
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="data[StockTransferTransaction][type]" id="StockTransferTransactionTypeId" class="StockTransferTransactionType" value="2" <?php echo $this->data['StockTransferTransaction']['type']==2?"checked":""; ?>  <?php echo $disableType; ?>>To Service Center
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="data[StockTransferTransaction][type]" id="StockTransferTransactionTypeId" class="StockTransferTransactionType" value="3" <?php echo $this->data['StockTransferTransaction']['type']==3?"checked":""; ?>  <?php echo $disableType; ?>>To Customer
                        </label>
                    </div>
                <!-- <div class="col-lg-12">    --> 
                    <div class="form-group input-group col-lg-4 type1" style="float:left;">
                        <span class="input-group-addon">To Branch:</i></span>
                        <?php echo $this->Form->input('to_branch_id',array('id'=>'ToBranchId','empty'=>'Select Branch','label'=>false,'type'=>'select')); ?>
                    </div>

                    <div class="form-group input-group col-lg-4 type2" style="float:left;">
                        <span class="input-group-addon">To Service Center:</i></span>
                        <?php echo $this->Form->input('service_account_id',array('id'=>'ServiceAccountId','empty'=>'Select Service Center','label'=>false,'type'=>'select','class'=>'account_serviceC')); ?>
                    </div>
                    <button style="" type="button" class="btn btn-xs btn-primary manage-supplier type2" data-toggle="modal" data-target="#serviceC_management">Manage</button>

                    <div class="form-group input-group col-lg-4 type3" style="float:left;">
                        <span class="input-group-addon">To Customer:</i></span>
                        <?php echo $this->Form->input('customer_account_id',array('id'=>'CustomerAccountId','empty'=>'Select Customer','label'=>false,'type'=>'select','class'=>'account_customer')); ?>
                    </div>
                    <button style="" type="button" class="btn btn-xs btn-primary manage-supplier type3" data-toggle="modal" data-target="#customer_management">Manage</button>
                </div>

              
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Transfer
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12" style="<?php echo $this->data['StockTransferTransaction']['confirm']==1?'display:none;':''; ?>">
                                    <div class="form-group input-group" style="">
                                       <?php echo $this->Form->input('StockTransferTransactionDetail',array('id'=>'StockTransferTransactionDetail','multiple'=>'multiple','empty'=>'Select Item','label'=>'Select Items','type'=>'select','style'=>'width:500px;')); ?>                                        
                                    </div>                                                                    
                                </div>
                                

                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            &nbsp;
                                            <span style="float:right;">Clear</span>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="" style="overflow: auto;height: 50vh;">
                                                <table class="table table-striped"  id="ItemTable" >
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Model</th>
                                                            <th>Serial No.</th>
                                                            <th>Qty</th>
                                                            <th>SRP</th>
                                                            <th>NET</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                                                                 
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4"> 
                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Prepared By</i>
                                            </span>
                                            <?php echo $this->Form->input('prepared_by_user_id',array('empty'=>'Select Person','label'=>false,'type'=>'select')); ?>
                                        </div>

                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Approved By</i>
                                            </span>
                                            <?php echo $this->Form->input('approved_by_user_id',array('empty'=>'Select Person','label'=>false,'type'=>'select')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">                                                        
                                <button type="submit" id="savingg" class="btn btn-success" disabled="disabled">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
</form>
<?php echo $this->element('/common/quick_management'); ?>
<script>
    
    var stock_transfer = <?php echo $this->Javascript->object($this->data['StockTransferTransaction']);?>;
    var stock_transfer_id = ""; 
    var stock_transfer_detail = <?php echo $this->Javascript->object($this->data['StockTransferTransactionDetail']);?>;
    var stock_transfer_detailId = [];
    jQuery.each(stock_transfer_detail,function(keyY,valueE){
        stock_transfer_detailId[valueE.serial_no] = valueE;
    });

    jQuery(document).ready(function(){        

        setInterval(function () {  

            if( jQuery('#FromBranchId').val() != '' && ( ( jQuery('#ToBranchId').val() != '' && jQuery('.StockTransferTransactionType:checked').val() == 1 ) || ( jQuery('#ServiceAccountId').val() != '' && jQuery('.StockTransferTransactionType:checked').val() == 2 ) ||  ( jQuery('#CustomerAccountId').val() != '' && jQuery('.StockTransferTransactionType:checked').val() == 3 ) ) && jQuery('#StockTransferTransactionStockTransferNo').val() != '' ){
                jQuery('#savingg').removeAttr('disabled');
            }else
                jQuery('#savingg').attr('disabled','disabled');

        },1000);// 5 secs    
        
        jQuery('#FromBranchId').change(function(){
            var vaLueE = jQuery(this).val();
            
            jQuery('#StockTransferTransactionDetail').chosen('destroy');
            jQuery('#StockTransferTransactionDetail').empty();
            jQuery('#StockTransferTransactionDetail').find('option').remove();

            if(vaLueE){
                
                if( stock_transfer )
                    stock_transfer_id = stock_transfer.id;

                var dataa = [{name:'data[id]',value:vaLueE},{name:'data[stock_transfer_id]',value:stock_transfer_id}];                                

                jQuery.ajax({
                    async:false,
                    data:dataa,
                    url:'/inventory/storages/getItemOnBranch/'+vaLueE,
                    type:'POST',
                    dataType:'json',
                    success:function(data){             
                      
                        if(data){
                            
                            var optionAppend = "";
                            jQuery.each(data,function(optkey,optvalue){

                              optionAppend +='<optgroup label="'+optkey+'">';        
                                if(optvalue)
                                    jQuery.each(optvalue,function(optionKey,optionValue){
                                        optionAppend += ' <option value="'+optionValue+'">'+optionValue+'</option>';
                                    });

                                optionAppend +='</optgroup>';    
                            });

                            jQuery('#StockTransferTransactionDetail').append(optionAppend);
                            
                        }
                      
                    },
                    error:function(whaterror){
                    },
                    complete:function(){

                    }
                });
            }

            jQuery('#StockTransferTransactionDetail').chosen();
        });

        jQuery('#StockTransferTransactionDetail').change(function(event){
        
         // console.log('select2 change', event, $(event.target).val(),$(event.deselected).val());
         console.log(event);
            var values = jQuery(this).val();
            
            var dataa = [{name:'data[serial_no]',value:values}];

                jQuery.ajax({
                    async:false,
                    data:dataa,
                    url:'/inventory/storages/getItem',
                    type:'POST',
                    dataType:'json',
                    success:function(data){             
                      
                        if(data){
                            
                            var ItemstoAppend = "";                            

                            jQuery.each(data,function(key,value){
                                
                                var ifconfirm = '';
                                if(stock_transfer_detailId[value.Item.serial_no])
                                    if( stock_transfer_detailId[value.Item.serial_no].confirm == 1 && stock_transfer_detailId[value.Item.serial_no].received == 0 ){
                                        ifconfirm = '<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button> <button type="button" class="btn btn-warning btn-circle unconfirmedItem" data-id="'+stock_transfer_detailId[value.Item.serial_no].id+'"><i class="fa fa-undo"></i></button>';
                                    }else if( stock_transfer_detailId[value.Item.serial_no].confirm == 1 && stock_transfer_detailId[value.Item.serial_no].received == 1 ){
                                        ifconfirm = '<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>';
                                    }
                                    else{
                                        ifconfirm = '<button type="button" class="btn btn-warning btn-circle confirmedItem" data-id="'+stock_transfer_detailId[value.Item.serial_no].id+'"><i class="fa fa-check"></i></button>';
                                    }

                                ItemstoAppend +='<tr>'+
                                    '<td>'+value.Type.name+'</td>'+
                                    '<td>'+value.Model.name+'</td>'+
                                    '<td class="tr_serial_no">'+value.Item.serial_no+'</td>'+
                                    '<td>'+value.Item.quantity+'</td>'+
                                    '<td>'+value.Item.srp_price+'</td>'+
                                    '<td>'+value.Item.net_price+'</td>'+                                    
                                    '<td class="td_action">'+ifconfirm+'</td>'+                                    
                                '</tr>';
                            });
                            
                            jQuery('#ItemTable tbody').empty().append(ItemstoAppend);

                            jQuery('.confirmedItem').click(function(){

                                if( jQuery(this).attr('data-id') != '' ){

                                    if(confirm('Do you want to confirm ?')){

                                        var id = jQuery(this).attr('data-id');
                                        var serial_no = jQuery(this).closest('tr').find('.tr_serial_no').text();                                        

                                        var thiss = jQuery(this);
                                        var dataa = [
                                                {name:'data[id]',value:id},                                
                                                {name:'data[serial_no]',value:serial_no},                                                                                
                                                ];
                                        jQuery.ajax({
                                            async:false,
                                            data:dataa,
                                            url:'/inventory/stock_transfer_transactions/confirm_stock_transfer_transaction_details/'+id,
                                            type:'POST',
                                            dataType:'json',
                                            success:function(data){             
                                                if(data.success){                                                    
                                                    stock_transfer_detailId[serial_no].confirm = 1;
                                                    jQuery('#StockTransferTransactionDetail').trigger('change');
                                                }else{
                                                    alert("Error "+ data.errorMessage);
                                                }
                                            },
                                            error:function(whaterror){
                                            },
                                            complete:function(){

                                            }
                                        });
                                    }

                                    
                                }    
                                unconfirmedItem();
                            });

                        }
                      
                    },
                    error:function(whaterror){
                    },
                    complete:function(){

                    }
                });

        });

        jQuery('.StockTransferTransactionType').change(function(){
            
                // console.log(jQuery('.StockTransferTransactionType:checked').val());
            if( jQuery('.StockTransferTransactionType:checked').val() == 1 ){
                jQuery('.type1').css({'display':''});
                jQuery('.type2').css({'display':'none'});     
                jQuery('.type3').css({'display':'none'});     
                jQuery('#ServiceAccountId').val('');
            }
            else if( jQuery('.StockTransferTransactionType:checked').val() == 2){
                jQuery('.type1').css({'display':'none'});                             
                jQuery('.type3').css({'display':'none'});                             
                jQuery('.type2').css({'display':''});
                jQuery('#ToBranchId').val('');
            }
            else if( jQuery('.StockTransferTransactionType:checked').val() == 3){
                jQuery('.type1').css({'display':'none'});                             
                jQuery('.type3').css({'display':''});                             
                jQuery('.type2').css({'display':'none'});
                jQuery('#ToBranchId').val('');
            }
            
            jQuery('select').chosen('destroy');
            jQuery('select').chosen();
        });

        jQuery('.StockTransferTransactionType').trigger('change');

        jQuery('#FromBranchId').trigger('change');
        if(stock_transfer_detail){

            jQuery('#StockTransferTransactionDetail').chosen('destroy');

            jQuery.each(stock_transfer_detail,function(key,value){       
                jQuery("#StockTransferTransactionDetail option[value='"+value.serial_no+"']").prop("selected", true);
            });

            jQuery('#StockTransferTransactionDetail').chosen();
            jQuery('#StockTransferTransactionDetail').trigger('change');
        }
        
        function unconfirmedItem(){
            jQuery('.unconfirmedItem').click(function(){

                if( jQuery(this).closest('tr').find('.tr_id').val() != '' ){

                    if(confirm('Do you want to confirm ?')){
                        
                        var id = jQuery(this).attr('data-id');
                        var serial_no = jQuery(this).closest('tr').find('.tr_serial_no').text();

                        var thiss = jQuery(this);
                        var dataa = [
                                {name:'data[id]',value:id},                                
                                {name:'data[serial_no]',value:serial_no},                                            
                                ];
                        jQuery.ajax({
                            async:false,
                            data:dataa,
                            url:'/inventory/stock_transfer_transactions/unconfirm_stock_transfer_transaction_details/'+id,
                            type:'POST',
                            dataType:'json',
                            success:function(data){             
                                if(data.success){
                                    stock_transfer_detailId[serial_no].confirm = 0;
                                    jQuery('#StockTransferTransactionDetail').trigger('change');                                         
                                }else{
                                    alert("Error "+ data.errorMessage);
                                }
                            },
                            error:function(whaterror){
                            },
                            complete:function(){

                            }
                        });
                    }

                    bind_confirmedItem();
                }              
            });
        }
        unconfirmedItem();   
        
    });
</script>