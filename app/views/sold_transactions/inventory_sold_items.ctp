<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">  </h1>
    </div>    
</div> -->
<br/>
<?php echo $this->Form->create('SoldTransaction');?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <button style="" type="button" onclick="window.location='/inventory/sold_transactions/sold_items';" class="btn btn-primary">Add Sales </button>
        </div>
        <div class="panel-body">
            <form role="form">
            <div class="row">
                <div class="col-lg-12">    
                    <?php 
                        $disableType = "";
                        if(!empty($this->data['SoldTransaction']['id'])){
                            echo $this->Form->input('id',array('label'=>false,'type'=>'text','style'=>'display:none','value'=>$this->data['SoldTransaction']['id'])); 
                            $disableType='readonly';
                        }
                     ?>
                                                          
                    <div class="form-group input-group col-lg-3 type1" style="float:left;">
                        <span class="input-group-addon">Sold To :</i></span>
                        <?php echo $this->Form->input('owner_account_id',array('empty'=>'Select Account','label'=>false,'type'=>'select','readonly'=>$disableType,'class'=>'account_customer')); ?>
                    </div>
                    <div class="col-lg-2">
                        <button style="float:left;" type="button" class="btn btn-xs btn-primary manage-customer type1" data-toggle="modal" data-target="#customer_management">Manage Customer</button>
                    </div>
                    <div class="form-group input-group col-lg-3 type1" style="float:left;margin-left: 10px; ">
                        <span class="input-group-addon">Sold Type :</i></span>
                        <?php echo $this->Form->input('collection_type_id',array('empty'=>'Select Sold Type','label'=>false,'type'=>'select','readonly'=>$disableType,'options'=>array($CollectionTypes))); ?>
                    </div>

                </div>
                <div class="col-lg-12">    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">Delivery Receipt #:</i></span>
                        <?php echo $this->Form->input('delivery_receipt_no',array('label'=>false,'type'=>'text')); ?>
                    </div>                   
                    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">Delivery DateTime:</i></span>
                        <?php $dateValue = "";
                            if(empty($this->data['SoldTransaction']['delivery_datetime'])){
                                $dateValue = date('Y/m/d H:i');
                            }else{
                                $dateValue = $this->data['SoldTransaction']['delivery_datetime'];
                            }
                         ?>
                        <?php echo $this->Form->input('delivery_datetime',array('class'=>'datetimepicker','label'=>false,'type'=>'text','value'=>$dateValue)); ?>
                    </div>

                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">Sold By:</i></span>
                        <?php echo $this->Form->input('sold_by_user_id',array('empty'=>'Select Account','class'=>'','label'=>false,'type'=>'select')); ?>
                    </div>

                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">Deliver By:</i></span>
                        <?php echo $this->Form->input('deliver_by_user_id',array('empty'=>'Select Account','class'=>'','label'=>false,'type'=>'select')); ?>
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
                                        <div class="panel-heading">
                                            <?php if(empty($this->data['SoldTransaction']['id'])){ ?>
                                                <button type="button" class="btn btn-info" id="addItem">Add</button>
                                            <?php } ?>
                                            <!-- <button type="button" class="btn btn-warning">Clear</button> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="" style="overflow: auto;height: 50vh;">
                                                <table class="table table-striped" id="receivingTable">
                                                    <thead>
                                                        <tr>                                                            
                                                            <th style="width: 15%">From Branch</th>
                                                            <th style="width: 25%">Serial No.</th>
                                                            <th style="width: 10%">Type</th>
                                                            <th style="width: 10%">Brand</th>
                                                            <th style="width: 10%">Model</th>
                                                            <th style="width: 8%">SRP</th>
                                                            <th style="width: 8%">NET</th>
                                                            <th style="width: 10%">Sold Price</th>                                                           
                                                            <th style="width: 4%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       

                                                        <?php
                                                        // debug($this->data['ReceivingTransactionDetail']);
                                                            if(!empty($this->data['SoldTransactionDetail'])) 
                                                                foreach ($this->data['SoldTransactionDetail'] as $rTDkey => $rTDvalue) { ?>
                                                                    
                                                                    <?php $disabled="";//disabled  ?>

                                                                     <tr>    
                                                                                                                                 
                                                                        <td>
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.'.$rTDkey.'.id',array('type'=>'text','style'=>'display:none','class'=>'tr_id','label'=>false,'value'=>$rTDvalue['id'])); ?>
                                                                            <?php //echo $this->Form->input('SoldTransactionDetail.'.$rTDkey.'.from_branch_id',array('disabled'=>$disabled,'class'=>'tr_from_branch_id chosen-selectBranch','empty'=>'Select Branch','label'=>false,'value'=>$rTDvalue['from_branch_id'],'options'=>$fromBranches)); ?>
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.'.$rTDkey.'.from_branch_id',array('type'=>'text','style'=>'display:none','label'=>false,'value'=>$rTDvalue['from_branch_id'])); ?>
                                                                            <?php echo $fromBranches[$rTDvalue['from_branch_id']];?>

                                                                        </td>
                                                                        <td class="td_serial_no">                                                                               
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.'.$rTDkey.'.serial_no',array('type'=>'hidden','value'=>$rTDvalue['serial_no'])); ?>
                                                                            <?php echo $rTDvalue['serial_no'];?>
                                                                        </td>
                                                                        <td>                                                                            
                                                                            <?php echo $rTDvalue['ItemType']['name'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $rTDvalue['ItemBrand']['name'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $rTDvalue['ItemModel']['name'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $rTDvalue['ItemDesc']['srp_price'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $rTDvalue['ItemDesc']['net_price'];?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.'.$rTDkey.'.sold_price',array('label'=>false,'placeholder'=>'SRP','value'=>$rTDvalue['srp_price'],'style'=>'width:100%;')); ?>
                                                                        </td>
                                                                       
                                                                        <td class="td_action">
                                                                            
                                                                        </td>
                                                                    </tr>    

                                                            <?php } else { ?>                                             

                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.0.from_branch_id',array('class'=>'tr_from_branch_id chosen-selectBranch','empty'=>'Select Branch','label'=>false,'options'=>$fromBranches)); ?>
                                                                        </td>     
                                                                        <td class="td_serial_no">
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.0.serial_no',array('type'=>'select','class'=>'tr_serial_no chosen-selectItem','label'=>false,'placeholder'=>'Serial No','style'=>'width:100%;')); ?>
                                                                        </td>
                                                                        <td class="trType"></td>
                                                                        <td class="trBrand"></td>
                                                                        <td class="trModel"></td>
                                                                        <td class="trSrp"></td>
                                                                        <td class="trNet"></td>
                                                                        <td>
                                                                            <?php echo $this->Form->input('SoldTransactionDetail.0.sold_price',array('label'=>false,'placeholder'=>'SRP','style'=>'width:100%;')); ?>
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
                                        <?php if(!empty($this->data['SoldTransaction']['id'])){ ?>
                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Cancel</i>
                                            </span> &nbsp;&nbsp;&nbsp;
                                            <?php echo $this->Form->input('cancel',array('label'=>false,'div'=>false,'type'=>'checkbox')); ?>
                                            YES
                                        </div>

                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Cancel DateTime</i>
                                            </span>
                                            <?php echo $this->Form->input('cancel_datetime',array('class'=>'datetimepicker','label'=>false,'type'=>'text')); ?>
                                        </div>
                                        <?php } ?>
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
    
    jQuery(document).ready(function(){

        var increment = 1;
        jQuery("#addItem").click(function() {

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
            $newdiv.insertAfter('#receivingTable tbody tr:last');      
            bind_removeItem();

            jQuery('select').chosen();
        });

        function bind_removeItem(){
            jQuery('.removeItem').unbind();
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
      
        
        jQuery('.chosen-selectBranch').chosen('destroy');
        jQuery('.chosen-selectBranch').chosen().change(function(){    
            
            jQuery(this).closest('tr').find('.td_serial_no select').chosen('destroy');
            var selectId = jQuery(this).closest('tr').find('.td_serial_no select').attr('id');
            
            getSerialStatus(jQuery(this).val(),selectId);

                
        });


        function getSerialStatus(branch_id,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [
                    {name:'data[branch_id]',value:branch_id},                    
                    ];

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/storages/getItemOnBranch/'+branch_id,
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data);

                    // if(data.success){
                        
                        jQuery('#'+thiss).empty();
                        jQuery('#'+thiss).append('<option value=""> Select Serial No </option>');

                        var optionAppend = "";
                        jQuery.each(data,function(optkey,optvalue){

                          optionAppend +='<optgroup label="'+optkey+'">';        
                            if(optvalue)
                                jQuery.each(optvalue,function(optionKey,optionValue){
                                    optionAppend += ' <option value="'+optionValue+'">'+optionValue+'</option>';
                                });

                            optionAppend +='</optgroup>';    
                        });

                        jQuery('#'+thiss).append(optionAppend);

                        jQuery('#'+thiss).chosen();
                    // }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }

        jQuery('.chosen-selectItem').chosen('destroy');
        jQuery('.chosen-selectItem').chosen().change(function(){    
            
            jQuery(this).closest('tr').find('.td_serial_no select').chosen('destroy');
            var selectId = jQuery(this).closest('tr').find('.td_serial_no select').attr('id');
            
            getSerialDetail(jQuery(this).val(),selectId);

                
        });

        function getSerialDetail(serial_no,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [
                    {name:'data[serial_no]',value:serial_no},                    
                    ];

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/storages/getItem',
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data[0]);
                    if(data[0]){
                        jQuery('#'+thiss).closest('tr').find('.trType').text(data[0].Type.name);
                        jQuery('#'+thiss).closest('tr').find('.trModel').text(data[0].Model.name);
                        jQuery('#'+thiss).closest('tr').find('.trBrand').text(data[0].Brand.name);
                        jQuery('#'+thiss).closest('tr').find('.trSrp').text(data[0].Item.srp_price);
                        jQuery('#'+thiss).closest('tr').find('.trNet').text(data[0].Item.net_price);
                    }
                    
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }
    });


</script>