<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">  </h1>
    </div>    
</div> -->
<br/>
<style type="text/css">
    /*.old_serial{display: none;}*/
</style>
<?php echo $this->Form->create('ReceivingTransaction');?>
<?php debug($this->data); ?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <button style="" type="button" onclick="window.location='/inventory/receiving_transactions/stock_transferin_supplier';" class="btn btn-primary">Add Receiving Transaction</button>
        </div>
        <div class="panel-body">
            <form role="form">
            <div class="row">
                <div class="col-lg-12">    
                    <?php 
                        $disableType = "";
                        if(!empty($this->data['ReceivingTransaction']['id'])){
                            echo $this->Form->input('id',array('label'=>false,'type'=>'text','style'=>'display:none','value'=>$this->data['ReceivingTransaction']['id'])); 
                            $disableType='readonly';
                        }
                     ?>
                    
                    
                    <div class="form-group input-group col-lg-8" style="float:left;">
                        <span class="">Type : </i></span>
                        <?php //echo $this->Form->input('type',array('label'=>false,'type'=>'radio','options'=>array('1'=>'From Supplier','2'=>'From Stock Transfer'))); ?>
                        <label class="radio-inline">
                            <input type="radio" name="data[ReceivingTransaction][type]" id="ReceivingTransactionTypeId" class="ReceivingTransactionType" value="1" checked <?php echo $disableType; ?>>From Supplier
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="data[ReceivingTransaction][type]" id="ReceivingTransactionTypeId" class="ReceivingTransactionType" value="2" <?php echo $this->data['ReceivingTransaction']['type']==2?"checked":""; ?> <?php echo $disableType; ?> >From Stock Transfer
                        </label>
                       <!--  <label class="radio-inline">
                            <input type="radio" name="data[ReceivingTransaction][type]" id="ReceivingTransactionTypeId" class="ReceivingTransactionType" value="5" <?php echo $this->data['ReceivingTransaction']['type']==5?"checked":""; ?> <?php echo $disableType; ?> >From Customer (reposes)
                        </label> -->
                         <label class="radio-inline">
                            <input type="radio" name="data[ReceivingTransaction][type]" id="ReceivingTransactionTypeId" class="ReceivingTransactionType" value="4" <?php echo $this->data['ReceivingTransaction']['type']==4?"checked":""; ?> <?php echo $disableType; ?> >From Customer (on repair)
                        </label>
                    </div>                   
                    <div class="form-group input-group col-lg-3 type1" style="float:left;">
                        <span class="input-group-addon">From:</i></span>
                        <?php echo $this->Form->input('source_account_id',array('empty'=>'Select Account','label'=>false,'type'=>'select','readonly'=>$disableType,'style'=>'width:100%;','class'=>'account_supplier account_customer')); ?>
                    </div>
                    <button style="" type="button" class="btn btn-xs btn-primary manage-supplier type1" data-toggle="modal" data-target="#supplier_management">Manage</button>
                   

                </div>
                <div class="col-lg-12">    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">RR #:</i></span>
                        <?php echo $this->Form->input('receiving_report_no',array('label'=>false,'type'=>'text')); ?>
                    </div>
                    <div class="form-group input-group col-lg-3 type1 refno" style="float:left;">
                        <span class="input-group-addon">Ref #:</i></span>
                        <?php echo $this->Form->input('reference_no',array('label'=>false,'type'=>'text')); ?>
                    </div>
                    <div class="form-group input-group col-lg-3 type2" style="float:left;">
                        <span class="input-group-addon">Ref ST#:</i></span>
                        <?php echo $this->Form->input('stock_transfer_no',array('label'=>false,'type'=>'text')); ?>
                    </div>
                    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">RR DateTime:</i></span>
                         <?php $dateValue = "";
                            if(empty($this->data['ReceivingTransaction']['receiving_datetime'])){
                                $dateValue =  date('Y/m/d H:i');
                            }else{
                                $dateValue = $this->data['ReceivingTransaction']['receiving_datetime'];
                            }                        
                         ?>
                        <?php echo $this->Form->input('receiving_datetime',array('class'=>'datetimepicker','label'=>false,'type'=>'text','value'=>$dateValue)); ?>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Transaction
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                               
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="">                                            
                                            <button type="button" style="" class="btn btn-info" id="addItem">Add</button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="button" style="float: right;" class="btn btn-warning fortype1" id="showReplaceSerial">Show Replace Serial</button>
                                            <div class="stockTransferReference" style="float:right;width: 90%;">
                                                <!-- <span class='suggestSerial' data-serial='1313'>1213</span> -->
                                            </div>
                                                                                            
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="" style="overflow: auto;height: 50vh;">
                                                <table class="table table-striped" id="receivingTable">
                                                    <thead>
                                                        <tr>                                                            
                                                            <th>Type</th>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th style="">Serial No.</th>
                                                            <th class="old_serial" style="">Old_SNo.</th>
                                                            <th class="type5">SRP</th>
                                                            <th class="type5">NET</th>
                                                            <th class="type2">From Branch</th>
                                                            <th>To Branch</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       

                                                        <?php
                                                        // debug($this->data['ReceivingTransactionDetail']);
                                                            if(!empty($this->data['ReceivingTransactionDetail'])) 
                                                                foreach ($this->data['ReceivingTransactionDetail'] as $rTDkey => $rTDvalue) { ?>
                                                                    
                                                                    <?php if( $rTDvalue['confirmed']==1){  $disabled="disabled"; }else $disabled=""; ?>

                                                                     <tr>     
                                                                        <td style="width:20px;" class="trType">
                                                                            <?php echo $types[$rTDvalue['type_id']] ?>
                                                                        </td>
                                                                        <td style="width:20px;" class="trBrand">
                                                                            <?php echo $brands[$rTDvalue['brand_id']] ?>
                                                                        </td>
                                                                        <td class="td_model">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.id',array('type'=>'text','style'=>'display:none','class'=>'tr_id','label'=>false,'value'=>$rTDvalue['id'])); ?>
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.model_id',array('disabled'=>$disabled,'empty'=>'Select Model','class'=>'tr_model_id chosen-selectModel','label'=>false,'value'=>$rTDvalue['model_id'],'style'=>'width:150px;')); ?>
                                                                        </td>                                                            
                                                                        <td>                                                                
                                                                            <button type="button" disabled="<?php echo $disabled?>" class="btn btn-success btn-circle assignSerialNo type1" style="float: left;"><i class="fa fa-barcode "></i></button>
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.serial_no',array('disabled'=>$disabled,'class'=>'tr_serial_no','label'=>false,'value'=>$rTDvalue['serial_no'],'placeholder'=>'Serial No','style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td class="<?php echo $rTDvalue['old_serial_no']?'has_old_serial':'old_serial'; ?>">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.old_serial_no',array('disabled'=>$disabled,'class'=>'','label'=>false,'value'=>$rTDvalue['old_serial_no'],'placeholder'=>'Serial No','style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td class="type5">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.srp_price',array('label'=>false,'placeholder'=>'SRP','value'=>$rTDvalue['srp_price'],'style'=>'width:60px;')); ?>
                                                                        </td>
                                                                        <td class="type5">
                                                                             <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.net_price',array('label'=>false,'placeholder'=>'NET','value'=>$rTDvalue['net_price'],'style'=>'width:60px;')); ?>
                                                                        </td>
                                                                        <td class="type2">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.from_branch_id',array('disabled'=>$disabled,'class'=>'tr_from_branch_id','empty'=>'Select Branch','label'=>false,'value'=>$rTDvalue['from_branch_id'],'style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.'.$rTDkey.'.to_branch_id',array('disabled'=>$disabled,'class'=>'tr_to_branch_id','empty'=>'Select Branch','label'=>false,'value'=>$rTDvalue['to_branch_id'],'style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td class="td_action">
                                                                            <?php if( $rTDvalue['confirmed']==1){?>

                                                                                <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>

                                                                                <?php if($this->data['ReceivingTransaction']['type'] == 1 || $this->data['ReceivingTransaction']['type'] == 2){ ?>
                                                                                    <button type="button" class="btn btn-warning btn-circle unconfirmedItem"><i class="fa fa-undo"></i></button>
                                                                                <?php } ?>

                                                                            <?php }else{ 
                                                                                    
                                                                                    if(
                                                                                        !empty($rTDvalue['type_id']) &&
                                                                                        !empty($rTDvalue['model_id']) &&
                                                                                        !empty($rTDvalue['serial_no']) &&
                                                                                        !empty($rTDvalue['to_branch_id']) 
                                                                                        ) ?>
                                                                                    <button type="button" class="btn btn-warning btn-circle confirmedItem"><i class="fa fa-check"></i></button>
                                                                                    <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>

                                                                           <?php  } ?> 
                                                                        </td>
                                                                    </tr>    

                                                            <?php } else { ?>                                             

                                                                    <tr>     
                                                                        <td class="trType">
                                                                            <?php //echo $this->Form->input('ReceivingTransactionDetail.0.type_id',array('empty'=>'Select Type','class'=>'tr_type_id','label'=>false)); ?>
                                                                        </td>                
                                                                        <td class="trBrand">
                                                                            
                                                                        </td>                                       
                                                                        <td class="td_model">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.model_id',array('empty'=>'Select Model','class'=>'tr_model_id chosen-selectModel','label'=>false)); ?>
                                                                        </td>                                                            
                                                                        <td>                                                                
                                                                            <button type="button" class="btn btn-success btn-circle assignSerialNo type1" style="float: left;"><i class="fa fa-barcode"></i></button>
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.serial_no',array('class'=>'tr_serial_no','label'=>false,'placeholder'=>'Serial No','style'=>'width:80%;')); ?>
                                                                        </td>
                                                                         <td class="old_serial">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.old_serial_no',array('class'=>'','label'=>false,'placeholder'=>'New Serial No','style'=>'width:80%;')); ?>
                                                                        </td>
                                                                        <td class="type5">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.srp_price',array('label'=>false,'placeholder'=>'SRP','style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td class="type5">
                                                                             <?php echo $this->Form->input('ReceivingTransactionDetail.0.net_price',array('label'=>false,'placeholder'=>'NET','style'=>'width:100px;')); ?>
                                                                        </td>
                                                                        <td class="type2">
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.from_branch_id',array('class'=>'tr_from_branch_id','empty'=>'Select Branch','label'=>false)); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $this->Form->input('ReceivingTransactionDetail.0.to_branch_id',array('class'=>'tr_to_branch_id','empty'=>'Select Branch','label'=>false)); ?>
                                                                        </td>
                                                                        <td class="td_action">                                                                            
                                                                            <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>
                                                                        </td>
                                                                    </tr>    
                                                                    
                                                            <?php } ?>     
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
                                            <span class="input-group-addon"><i class="">Received By</i>
                                            </span>
                                            <?php echo $this->Form->input('received_by_user_id',array('empty'=>'Select Person','label'=>false,'type'=>'select')); ?>
                                        </div>

                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Deliver By</i>
                                            </span>
                                            <?php echo $this->Form->input('deliver_by_user_id',array('empty'=>'Select Person','label'=>false,'type'=>'select')); ?>
                                        </div>
                                    </div>
                                   <!--  <div class="col-lg-8"> 
                                     
                                        <div class="form-group input-group col-lg-3" style="float: left;margin-right: 20px;">
                                            <span class="input-group-addon"><i class="">Qty Total</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="form-group input-group col-lg-3" >
                                            <span class="input-group-addon"><i class="">Total Price</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success">Save</button>
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
<script type="text/javascript">

    var sourceAccounts = <?php echo $this->Javascript->object($sourceAccounts);?>;
    var customer_sourceAccounts = <?php echo $this->Javascript->object($customer_sourceAccounts);?>;
    var serviceC_sourceAccounts = <?php echo $this->Javascript->object($serviceC_sourceAccounts);?>;

    var sourceAccountValue = <?php echo $this->Javascript->object($this->data['ReceivingTransaction']['source_account_id']);?>;
    
    jQuery(document).ready(function(){

        var increment = 1;
        jQuery("#addItem").click(function() {
            increment = jQuery('#receivingTable td.trType').length;
            jQuery('select').chosen('destroy');

            var $newdiv = jQuery("#receivingTable tbody tr:last").clone(true);
            $newdiv.find('input,select,button').removeAttr('disabled');
            $newdiv.find('input,select').each(function() {
              
                var $this = jQuery(this);
                $this.attr('id', $this.attr('id').replace(/(\d+)/, function($0, $1) {                    
                    return '' + (increment) + '';
                }));
                $this.attr('name', $this.attr('name').replace(/\[(\d+)\]/, function($0, $1) {                    
                    return '[' + (increment) + ']';
                }));

                $this.val('');
            });
            increment++;
            $newdiv.find('.td_action').empty().append('<button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>');            
            $newdiv.find('.trType').empty();
            $newdiv.find('.trBrand').empty();
            $newdiv.find('.trBrand').remove('.tr_id');
            $newdiv.insertAfter('#receivingTable tbody tr:last');      
            bind_removeItem();

            jQuery('select').chosen();
        });

        jQuery('#showReplaceSerial').click(function(){
            jQuery('.old_serial').css({'display':''});
            return false;
        });

        function bind_removeItem(){
            jQuery('.removeItem').click(function(){
                if( jQuery('#receivingTable tbody tr').length > 1){

                    if( jQuery(this).closest('tr').find('.tr_id').val() != '' ){

                        if(confirm('Do you want to remove ?')){

                            var id = jQuery(this).closest('tr').find('.tr_id').val();

                            var dataa = [
                                    {name:'data[id]',value:id},                                
                                    ];
                            jQuery.ajax({
                                async:false,
                                data:dataa,
                                url:'/inventory/receiving_transaction_details/delete/'+id,
                                type:'POST',
                                dataType:'json',
                                success:function(data){             
                                    if(data.success){
                                        alert("Transaction has been deleted");
                                    }
                                },
                                error:function(whaterror){
                                },
                                complete:function(){

                                }
                            });
                        }
                    }

                    jQuery(this).closest('tr').remove();
                }
            });
        }
        bind_removeItem();

        function bind_confirmedItem(){

            jQuery('.confirmedItem').click(function(){

                if( jQuery(this).closest('tr').find('.tr_id').val() != '' ){

                    if(confirm('Do you want to confirm ?')){

                        var id = jQuery(this).closest('tr').find('.tr_id').val();
                        var serial_no = jQuery(this).closest('tr').find('.tr_serial_no').val();
                        var to_branch_id = jQuery(this).closest('tr').find('.tr_to_branch_id').val();

                        var thiss = jQuery(this);
                        var dataa = [
                                {name:'data[id]',value:id},                                
                                {name:'data[serial_no]',value:serial_no},                                
                                {name:'data[to_branch_id]',value:to_branch_id},                                
                                ];
                        jQuery.ajax({
                            async:false,
                            data:dataa,
                            url:'/inventory/receiving_transactions/confirm_receiving_transaction_details/'+id,
                            type:'POST',
                            dataType:'json',
                            success:function(data){             
                                if(data.success){
                                    
                                    thiss.closest('tr').find('select').chosen('destroy');
                                    
                                    thiss.closest('tr').find('select,button,.tr_serial_no').attr('disabled','disabled');
                                    
                                    thiss.closest('tr').find('select').chosen();

                                    if( jQuery('.ReceivingTransactionType:checked').val() == 1 || jQuery('.ReceivingTransactionType:checked').val() == 2)
                                        thiss.closest('tr').find('.td_action').empty().append('<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button><button type="button" class="btn btn-warning btn-circle unconfirmedItem"><i class="fa fa-undo"></i></button>');
                                    else
                                        thiss.closest('tr').find('.td_action').empty().append('<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>');

                                    unconfirmedItem();
                                    // alert("Item has been confirmed");
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
            });
        }
        bind_confirmedItem();

        function unconfirmedItem(){
            jQuery('.unconfirmedItem').click(function(){

                if( jQuery(this).closest('tr').find('.tr_id').val() != '' ){

                    if(confirm('Do you want to confirm ?')){

                        var id = jQuery(this).closest('tr').find('.tr_id').val();
                        var serial_no = jQuery(this).closest('tr').find('.tr_serial_no').val();
                        var to_branch_id = jQuery(this).closest('tr').find('.tr_to_branch_id').val();

                        var thiss = jQuery(this);
                        var dataa = [
                                {name:'data[id]',value:id},                                
                                {name:'data[serial_no]',value:serial_no},                                
                                {name:'data[to_branch_id]',value:to_branch_id},                                
                                ];
                        jQuery.ajax({
                            async:false,
                            data:dataa,
                            url:'/inventory/receiving_transactions/unconfirm_receiving_transaction_details/'+id,
                            type:'POST',
                            dataType:'json',
                            success:function(data){             
                                if(data.success){
                                    
                                    thiss.closest('tr').find('select').chosen('destroy');
                                    
                                    thiss.closest('tr').find('select,button,.tr_serial_no').attr('disabled',false);
                                    
                                    thiss.closest('tr').find('select').chosen();

                                    thiss.closest('tr').find('.td_action').empty().append('<button type="button" class="btn btn-warning btn-circle confirmedItem"><i class="fa fa-check"></i></button><button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>');
                                    
                                    // alert("Item has been confirmed");
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

        jQuery('.assignSerialNo').click(function(){

            var thistr = jQuery(this).closest('tr');

            var dataa = [
                    {name:'data[type_id]',value:jQuery(thistr).find('.tr_type_id').val()},
                    {name:'data[model_id]',value:jQuery(thistr).find('.tr_model_id').val()}                    
                    ];
            jQuery.ajax({
                async:false,
                data:dataa,
                url:'/inventory/items/getItemIncrement',
                type:'POST',
                dataType:'json',
                success:function(data){             
                    if(data.success){
                        jQuery(thistr).find('.tr_serial_no').val(data.serial_no).focus();
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });
        });

        jQuery('.ReceivingTransactionType').change(function(){
            jQuery('.old_serial').css({'display':'none'});
                // console.log(jQuery('.ReceivingTransactionType:checked').val());
            jQuery('.stockTransferReference').empty();
            jQuery('.fortype1').css({'display':'none'});
            
            if( jQuery('.ReceivingTransactionType:checked').val() == 1 ){
                jQuery('.type1').css({'display':''});
                jQuery('.fortype1').css({'display':''});
                jQuery('.type2').css({'display':'none'});
                jQuery('.type5').css({'display':''});
                jQuery('.refno').css({'display':''});
                jQuery('.tr_from_branch_id').val('');
                jQuery('.manage-supplier').attr('data-target','#supplier_management');

            }
            else if( jQuery('.ReceivingTransactionType:checked').val() == 5){
                jQuery('.type1').css({'display':''});
                jQuery('.type2').css({'display':'none'});
                jQuery('.tr_from_branch_id').val('');
                jQuery('.refno').css({'display':'none'});
                jQuery('.manage-supplier').attr('data-target','#customer_management');
             
            }
            else if( jQuery('.ReceivingTransactionType:checked').val() == 4){
                jQuery('.type1').css({'display':''});
                jQuery('.type2').css({'display':'none'});                
                jQuery('.type5').css({'display':'none'});
                jQuery('.refno').css({'display':'none'});
                jQuery('.tr_from_branch_id').val('');
                jQuery('.manage-supplier').attr('data-target','#customer_management');
             
            }
            else{
                jQuery('#ReceivingTransactionSourceAccountId').val('');
                jQuery('.type1').css({'display':'none'});
                jQuery('.type2').css({'display':''});
                jQuery('.type5').css({'display':''});
            }

            changeSourceAccount( jQuery('.ReceivingTransactionType:checked').val() );
            jQuery('select').chosen('destroy');
            jQuery('select').chosen();
        });

        jQuery('.ReceivingTransactionType').trigger('change');

        jQuery('.tr_serial_no').focusout(function(){
            getSerialStatus(jQuery(this).val(),jQuery(this));
        });
        jQuery('.tr_serial_no').focusin(function(){
            getSerialStatus(jQuery(this).val(),jQuery(this));
        });
        
        jQuery('.tr_serial_no').trigger('focusout');

        function getSerialStatus(serial_no,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [
                    {name:'data[serial_no]',value:serial_no},
                    {name:'data[type]',value:jQuery('.ReceivingTransactionType:checked').val()} ,
                    {name:'data[stock_transfer_id]',value:jQuery('#ReceivingTransactionStockTransferNo').val()}  
                    ];

            thiss.css({'border':'1px solid #ccc'});

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/storages/getItemDetails',
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data);

                    if(data.success){
                        if(jQuery('.ReceivingTransactionType:checked').val() == 1){
                            
                            if(data.exsisting)
                                thiss.css({'border':'1px solid red'});
                            else
                                thiss.css({'border':'1px solid blue'});

                            jQuery('select').chosen('destroy');            
                            if(data.onRepair){
                                thiss.css({'border':'1px solid blue'});
                                jQuery('.old_serial').css({'display':''});
                                // thiss.closest('tr').find('.tr_type_id').val(data.Item.type_id);
                                thiss.closest('tr').find('.trType').text(data.Type.name);
                                thiss.closest('tr').find('.trBrand').text(data.Brand.name);
                                thiss.closest('tr').find('.tr_model_id').val(data.Item.model_id);
                                thiss.closest('tr').find('.tr_from_branch_id').val(data.StockTransaction.from_branch_id);
                                thiss.closest('tr').find('.tr_to_branch_id').val(data.StockTransaction.to_branch_id);
                            }                            
                            
                            jQuery('select').chosen();
                        }

                        if( jQuery('.ReceivingTransactionType:checked').val() == 2 ){
                            jQuery('select').chosen('destroy');            
                            if(data.exsisting){
                                thiss.css({'border':'1px solid blue'});                            
                                // thiss.closest('tr').find('.tr_type_id').val(data.Item.type_id);
                                thiss.closest('tr').find('.trType').text(data.Type.name);
                                thiss.closest('tr').find('.trBrand').text(data.Brand.name);
                                thiss.closest('tr').find('.tr_model_id').val(data.Item.model_id);
                                thiss.closest('tr').find('.tr_from_branch_id').val(data.StockTransaction.from_branch_id);
                                thiss.closest('tr').find('.tr_to_branch_id').val(data.StockTransaction.to_branch_id);
                                
                            }
                            else{
                                thiss.css({'border':'1px solid red'});
                                thiss.closest('tr').find('.trType').text('');
                                thiss.closest('tr').find('.trBrand').text('');
                                thiss.closest('tr').find('.tr_model_id').val('');
                                thiss.closest('tr').find('.tr_from_branch_id').val('');
                                thiss.closest('tr').find('.tr_to_branch_id').val('');
                            }
                            jQuery('select').chosen();
                        }

                        if(  jQuery('.ReceivingTransactionType:checked').val() == 5 || jQuery('.ReceivingTransactionType:checked').val() == 4 ){
                            jQuery('select').chosen('destroy');            
                            if(data.exsisting){
                                thiss.css({'border':'1px solid blue'});                            
                                // thiss.closest('tr').find('.tr_type_id').val(data.Item.type_id);
                                thiss.closest('tr').find('.trType').text(data.Type.name);
                                thiss.closest('tr').find('.trBrand').text(data.Brand.name);
                                thiss.closest('tr').find('.tr_model_id').val(data.Item.model_id);
                                thiss.closest('tr').find('.tr_from_branch_id').val('');                                
                            }
                            else{
                                thiss.css({'border':'1px solid red'});
                                thiss.closest('tr').find('.trType').text('');
                                thiss.closest('tr').find('.trBrand').text('');
                                thiss.closest('tr').find('.tr_model_id').val('');
                                thiss.closest('tr').find('.tr_from_branch_id').val('');                                
                            }
                            jQuery('select').chosen();
                        }
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }

        jQuery('#ReceivingTransactionStockTransferNo').focusout(function(){
            getSerialonStockTransfer(jQuery('#ReceivingTransactionStockTransferNo').val(),jQuery(this));
        });
        jQuery('#ReceivingTransactionStockTransferNo').focusin(function(){
            getSerialonStockTransfer(jQuery('#ReceivingTransactionStockTransferNo').val(),jQuery(this));
        });

        function suggestSerial(){
            jQuery('.suggestSerial').click(function(){

                if( jQuery("#receivingTable tbody tr:last .tr_serial_no").val() == ''){
                    jQuery("#receivingTable tbody tr:last .tr_serial_no").val( jQuery(this).attr('data-serial') );
                    jQuery('.tr_serial_no').trigger('focusout');
                }else{
                    jQuery('#addItem').trigger('click');
                    jQuery("#receivingTable tbody tr:last .tr_serial_no").val( jQuery(this).attr('data-serial') );
                    jQuery('.tr_serial_no').trigger('focusout');                    
                }
                return false;
            });
        }

        function getSerialonStockTransfer(stock_transfer_id,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [                    
                    {name:'data[stock_transfer_no]',value:stock_transfer_id}  
                    ];

            thiss.css({'border':'1px solid #ccc'});

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/stock_transfer_transactions/getItems',
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data);

                    if(data.success){
                        jQuery('.stockTransferReference').empty().append('Suggestion : ');
                        if(data.StockTransferTransactionDetail)
                            jQuery.each(data.StockTransferTransactionDetail,function(key,value){
                                console.log(value);
                                jQuery('.stockTransferReference').append("<span><a href='#'  data-serial='"+value.serial_no+"' class='suggestSerial' >"+value.serial_no+"</a></span> &nbsp;&nbsp;&nbsp;");
                                
                            });

                        suggestSerial();
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }


        jQuery('.chosen-selectModel').chosen('destroy');
        jQuery('.chosen-selectModel').chosen().change(function(){    
            
            jQuery(this).closest('tr').find('.td_model select').chosen('destroy');
            var selectId = jQuery(this).closest('tr').find('.td_model select').attr('id');
            
            getModelDetail(jQuery(this).val(),selectId);

                
        });

        function getModelDetail(model_id,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [
                    {name:'data[model_id]',value:model_id},                    
                    ];

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/models/getModel',
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data[0]);
                    if(data[0]){
                        jQuery('#'+thiss).closest('tr').find('.trType').text(data[0].Type.name);                        
                        jQuery('#'+thiss).closest('tr').find('.trBrand').text(data[0].Brand.name);      
                        jQuery('#'+thiss).closest('tr').find('.assignSerialNo').attr('disabled',false);      

                    }
                    
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }        

        function changeSourceAccount(type) {
            
            jQuery('.account_supplier').find('option').remove();
            
            if(type == 1){

                jQuery.each(sourceAccounts,function(key,value){
                    jQuery('.account_supplier').append('<option value="'+key+'">'+value+'</option>');
                });

            }
            else if(type == 2){

                jQuery.each(sourceAccounts,function(key,value){
                    jQuery('.account_supplier').append('<option value="'+key+'">'+value+'</option>');
                });

            }
            else if(type == 5 || type == 4){

                jQuery.each(customer_sourceAccounts,function(key,value){
                    jQuery('.account_supplier').append('<option value="'+key+'">'+value+'</option>');
                });

            }

            if(sourceAccountValue)
                jQuery('.account_supplier').val(sourceAccountValue);
            
                // customer_sourceAccounts
                // serviceC_sourceAccounts
        }

        if( jQuery('.has_old_serial').length >= 1)
            jQuery('.old_serial').css({'display':''});

    });


</script>