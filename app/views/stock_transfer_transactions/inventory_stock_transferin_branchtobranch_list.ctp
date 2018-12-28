
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Stock Transfer Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button style="" type="button" onclick="window.location='/inventory/stock_transfer_transactions/stock_transferin_branchtobranch';" class="btn btn-primary">Add Stock Transfer</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                
                <ul class="nav nav-tabs">
                    <li class="<?php echo $_SESSION['type']==1?'active':''; ?>"><a href="#toSupplier" data-toggle="tab">To Branch</a></li>
                    <li class="<?php echo $_SESSION['type']==2?'active':''; ?>"><a href="#toServiceCenter" data-toggle="tab">To Service Center</a></li>
                    <li class="<?php echo $_SESSION['type']==3?'active':''; ?>"><a href="#toCustomer" data-toggle="tab">To Customer</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade  <?php echo $_SESSION['type']==1?'in active':''; ?>" id="toSupplier">
                        <?php echo $this->Form->create('StockTransferTransaction');?>
                        <div class="row">
                            <?php echo $this->Form->hidden('filter.type',array('value'=>1)); ?>
                            <div class="col-lg-2">
                            Stock Transfer # : <?php echo $this->Form->input('filter.stockT_no',array('label'=>false,'type'=>'text','value'=>$filter['stockT_no'])); ?> </div>
                            <div class="col-lg-2">
                            Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                            <div class="col-lg-2"> 
                            End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                            <div class="col-lg-2" style="padding-top: 15px;">
                                  <!-- <button type="reset" class="btn btn-success">Reset</button>   -->
                                  <button type="submit" class="btn btn-success">Filter</button>  
                                  <button type="submit" name="data[print]" value="" id="printPlease" class="btn btn-success print">Print</button>  
                            </div>
                        </div>
                        
                        <?php foreach ($this->data as $rrkey => $rrvalue) { if($rrvalue['StockTransferTransaction']['type'] == 1) { ?>
                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                            <tr>
                                <td>Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
                                <td>From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
                                <td>To:  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['to_branch_id']] ?></strong></td>
                                <td>DateTime : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
                                <td>
                                    <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/stock_transfer_transactions/stock_transferin_branchtobranch/<?php echo $rrvalue['StockTransferTransaction']['id'] ?>','_blank');">Edit</button>
                                    <button type="button" class="btn btn-outline btn-sm btn-success"  
                                        onclick="print_this('<?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no']; ?>')">Print</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>Status</th><th>Receive</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($rrvalue['StockTransferTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                <tr>
                                                    <td><?php echo $types[$items[$rtdvalue['serial_no']]['type_id']] ?></td>
                                                    <td><?php echo $models[$items[$rtdvalue['serial_no']]['model_id']] ?></td>
                                                    <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['srp_price'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['net_price'] ?></td>                                            
                                                    <td><?php echo $rtdvalue['confirm']==1?"Confirm":"<b style='color:red;'>Not Yet Confirm</b>"; ?></td>
                                                    <td><?php echo $rtdvalue['received']==1?"Received":"<b style='color:red;'>Not Yet Received</b>"; ?></td>
                                                </tr>    
                                            <?php } ?>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
                                <td colspan="3">Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
                              
                            </tr>
                        </table>
                        <?php }} ?>                      
                        <?php echo $this->Form->end();?>
                    </div>

                    <div class="tab-pane fade  <?php echo $_SESSION['type']==2?'in active':''; ?>" id="toServiceCenter">
                        <?php echo $this->Form->create('StockTransferTransaction');?>
                        <div class="row">
                            <?php echo $this->Form->hidden('filter.type',array('value'=>2)); ?>
                            <div class="col-lg-2">
                            Stock Transfer # : <?php echo $this->Form->input('filter.stockT_no',array('id'=>'filterStockTNoOne','label'=>false,'type'=>'text','value'=>$filter['stockT_no'])); ?> </div>
                            <div class="col-lg-2">
                            Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                            <div class="col-lg-2"> 
                            End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                            <div class="col-lg-2" style="padding-top: 15px;">
                                  <!-- <button type="reset" class="btn btn-success">Reset</button>   -->
                                  <button type="submit" class="btn btn-success">Filter</button>  
                                  <button type="submit" name="data[print]" value="" id="printPleaseOne" class="btn btn-success print">Print</button>  
                            </div>
                        </div>
                        
                        <?php foreach ($this->data as $rrkey => $rrvalue) { if($rrvalue['StockTransferTransaction']['type'] == 2) { ?>
                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                            <tr>
                                <td>Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
                                <td>From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
                                <td>To :  <strong><?php echo $rrvalue['ToServiceCenter']['company'] ?></strong></td>
                                <td>DateTime : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
                                <td>
                                    <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/stock_transfer_transactions/stock_transferin_branchtobranch/<?php echo $rrvalue['StockTransferTransaction']['id'] ?>','_blank');">Edit</button>
                                    <button type="button" class="btn btn-outline btn-sm btn-success"  
                                        onclick="print_thisone('<?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no']; ?>')">Print</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>Status</th><th>Receive</th><th>Replaced</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($rrvalue['StockTransferTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                <tr>
                                                    <td><?php echo $types[$items[$rtdvalue['serial_no']]['type_id']] ?></td>
                                                    <td><?php echo $models[$items[$rtdvalue['serial_no']]['model_id']] ?></td>
                                                    <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['srp_price'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['net_price'] ?></td>                                            
                                                    <td><?php echo $rtdvalue['confirm']==1?"Confirm":"<b style='color:red;'>Not Yet Confirm</b>"; ?></td>
                                                    <td><?php echo $rtdvalue['repaired']==1?"Repaired":"<b style='color:red;'>Under Repair</b>"; ?></td>
                                                    <td><?php echo $rtdvalue['is_replaced']==1?"Replaced by Serial <b style='color:red;'>".$rtdvalue['replaced_serial_no']."</b>":""; ?></td>
                                                </tr>    
                                            <?php } ?>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
                                <td colspan="3">Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
                              
                            </tr>
                        </table>
                        <?php }} ?>                      
                        <?php echo $this->Form->end();?>
                    </div>

                    <div class="tab-pane fade  <?php echo $_SESSION['type']==3?'in active':''; ?>" id="toCustomer">
                        <?php echo $this->Form->create('StockTransferTransaction');?>
                        <div class="row">
                            <?php echo $this->Form->hidden('filter.type',array('value'=>3)); ?>
                            <div class="col-lg-2">
                            Stock Transfer # : <?php echo $this->Form->input('filter.stockT_no',array('id'=>'filterStockTNoOne','label'=>false,'type'=>'text','value'=>$filter['stockT_no'])); ?> </div>
                            <div class="col-lg-2">
                            Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                            <div class="col-lg-2"> 
                            End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                            <div class="col-lg-2" style="padding-top: 15px;">
                                  <!-- <button type="reset" class="btn btn-success">Reset</button>   -->
                                  <button type="submit" class="btn btn-success">Filter</button>  
                                  <button type="submit" name="data[print]" value="" id="printPleaseOne" class="btn btn-success print">Print</button>  
                            </div>
                        </div>
                        
                        <?php foreach ($this->data as $rrkey => $rrvalue) { if($rrvalue['StockTransferTransaction']['type'] == 3) { ?>
                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                            <tr>
                                <td>Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
                                <td>From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
                                <td>To :  <strong><?php echo $rrvalue['ToCustomer']['last_name']." ".$rrvalue['ToCustomer']['first_name']; ?></strong></td>
                                <td>DateTime : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
                                <td>
                                    <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/stock_transfer_transactions/stock_transferin_branchtobranch/<?php echo $rrvalue['StockTransferTransaction']['id'] ?>','_blank');">Edit</button>
                                    <button type="button" class="btn btn-outline btn-sm btn-success"  
                                        onclick="print_thisone('<?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no']; ?>')">Print</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($rrvalue['StockTransferTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                <tr>
                                                    <td><?php echo $types[$items[$rtdvalue['serial_no']]['type_id']] ?></td>
                                                    <td><?php echo $models[$items[$rtdvalue['serial_no']]['model_id']] ?></td>
                                                    <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['srp_price'] ?></td>
                                                    <td><?php echo $items[$rtdvalue['serial_no']]['net_price'] ?></td>                                            
                                                    <td><?php echo $rtdvalue['confirm']==1?"Confirm":"<b style='color:red;'>Not Yet Confirm</b>"; ?></td>
                                                    
                                                </tr>    
                                            <?php } ?>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
                                <td colspan="3">Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
                              
                            </tr>
                        </table>
                        <?php }} ?>                      
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script>
    function print_this(stocktransNo){
        jQuery('#filterStockTNo').val(stocktransNo);
        jQuery('#printPlease').trigger('click');
    }

    function print_thisone(stocktransNo){
        jQuery('#filterStockTNoOne').val(stocktransNo);
        jQuery('#printPleaseOne').trigger('click');
    }
</script>