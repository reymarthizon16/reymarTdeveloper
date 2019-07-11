
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Receiving Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button style="" type="button" onclick="window.location='/inventory/receiving_transactions/stock_transferin_supplier';" class="btn btn-primary">Add Receiving Transaction</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">                        

                <ul class="nav nav-tabs">
                    <li class="<?php echo $_SESSION['type']==1?'active':''; ?>"><a href="#fromSupplier" data-toggle="tab">From Supplier</a></li>
                    <li class="<?php echo $_SESSION['type']==2?'active':''; ?>"><a href="#fromStockTransfer" data-toggle="tab">From Stock Transfer</a></li>
                    <li class="<?php echo $_SESSION['type']==5?'active':''; ?>"><a href="#fromCustomer" data-toggle="tab">From Customer (reposes)</a></li>
                    <li class="<?php echo $_SESSION['type']==4?'active':''; ?>"><a href="#fromCustomerOnRepair" data-toggle="tab">From Customer (on repair)</a></li>
                </ul>

                <div class="tab-content">

                   
                    <div class="tab-pane fade  <?php echo $_SESSION['type']==1?'in active':''; ?>" id="fromSupplier">
                         <?php echo $this->Form->create('ReceivingTransaction');?>
                            <div class="row">
                                <?php echo $this->Form->hidden('filter.type',array('value'=>1)); ?>
                                <div class="col-lg-2">
                                Receiving Report # : <?php echo $this->Form->input('filter.receiving_report_no',array('label'=>false,'type'=>'text','value'=>$filter['receiving_report_no'])); ?> </div>
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
                        <?php echo $this->Form->end() ?>
                        <?php foreach ($this->data as $rrkey => $rrvalue) {  if($rrvalue['ReceivingTransaction']['type'] == 1) { ?>
                            <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                                <tr>
                                    <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
                                    <td>Reference # : <strong><?php echo $rrvalue['ReceivingTransaction']['reference_no'] ?></strong></td>
                                    <td>Supplier : <strong><?php echo $rrvalue['SourceAccount']['company'] ?></strong></td>
                                    <td>Recieving Datetime:  <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
                                    <td>
                                        <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/receiving_transactions/stock_transferin_supplier/<?php echo $rrvalue['ReceivingTransaction']['id'] ?>','_blank');">Edit</button>
                                        <button type="button" class="btn btn-outline btn-sm btn-success" 
                                        onclick="print_this('<?php echo $rrvalue['ReceivingTransaction']['receiving_report_no']; ?>')">Print</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th><th>Brand</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>To Branch</th><th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($rrvalue['ReceivingTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                    <tr>
                                                        <td><?php echo $types[$rtdvalue['type_id']] ?></td>
                                                        <td><?php echo $brands[$rtdvalue['brand_id']] ?></td>
                                                        <td><?php echo $models[$rtdvalue['model_id']] ?></td>
                                                        <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                        <td><?php echo $rtdvalue['srp_price'] ?></td>
                                                        <td><?php echo $rtdvalue['net_price'] ?></td>
                                                        <td><?php echo $branches[$rtdvalue['to_branch_id']] ?></td>
                                                        <td><?php echo $rtdvalue['confirmed']==1?"Confirm":"<b style='color:red;'>Not Confirm</b>"; ?></td>
                                                    </tr>    
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
                                    <td colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
                                  
                                </tr>
                            </table>
                            <hr />
                        <?php }} ?>

                
                    </div>

                    <div class="tab-pane fade <?php echo $_SESSION['type']==2?'in active':''; ?>" id="fromStockTransfer">
                         <?php echo $this->Form->create('ReceivingTransaction'); ?>
                         <div class="row">
                            <div class="col-lg-2">
                                <?php echo $this->Form->hidden('filter.type',array('value'=>2)); ?>
                            Receiving Report # : <?php echo $this->Form->input('filter.receiving_report_no',array('id'=>'filterReceivingReportNoOne','label'=>false,'type'=>'text','value'=>$filter['receiving_report_no'])); ?> </div>
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
                        <?php echo $this->Form->end();?>
                        <?php foreach ($this->data as $rrkey => $rrvalue) {  if($rrvalue['ReceivingTransaction']['type'] == 2) { ?>
                            <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <tr>
                                    <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
                                    <td>Reference ST # : <strong><?php echo $rrvalue['ReceivingTransaction']['stock_transfer_no'] ?></strong></td>
                                    <td>Recieving Datetime:  <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
                                    <td>
                                        <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/receiving_transactions/stock_transferin_supplier/<?php echo $rrvalue['ReceivingTransaction']['id'] ?>','_blank');">Edit</button>
                                        <button type="button" class="btn btn-outline btn-sm btn-success"onclick="print_thisone('<?php echo $rrvalue['ReceivingTransaction']['receiving_report_no']; ?>')">Print</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>From Branch</th><th>To Branch</th><th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($rrvalue['ReceivingTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                    <tr>
                                                        <td><?php echo $types[$rtdvalue['type_id']] ?></td>
                                                        <td><?php echo $models[$rtdvalue['model_id']] ?></td>
                                                        <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                        <td><?php echo $rtdvalue['srp_price'] ?></td>
                                                        <td><?php echo $rtdvalue['net_price'] ?></td>
                                                        <td><?php echo $branches[$rtdvalue['from_branch_id']] ?></td>
                                                        <td><?php echo $branches[$rtdvalue['to_branch_id']] ?></td>
                                                        <td><?php echo $rtdvalue['confirmed']==1?"Confirm":"<b style='color:red;'>Not Confirm</b>"; ?></td>
                                                    </tr>    
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
                                    <td colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
                                  
                                </tr>
                            </table>
                            <hr />
                        <?php }} ?>
                    </div>

                    <div class="tab-pane fade  <?php echo $_SESSION['type']==5?'in active':''; ?>" id="fromCustomer">
                         <?php echo $this->Form->create('ReceivingTransaction');?>
                            <div class="row">
                                <?php echo $this->Form->hidden('filter.type',array('value'=>5)); ?>
                                <div class="col-lg-2">
                                Receiving Report # : <?php echo $this->Form->input('filter.receiving_report_no',array('id'=>'filterReceivingReportNoTwo','label'=>false,'type'=>'text','value'=>$filter['receiving_report_no'])); ?> </div>
                                <div class="col-lg-2">
                                Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                                <div class="col-lg-2"> 
                                End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                                <div class="col-lg-2" style="padding-top: 15px;">
                                   
                                      <button type="submit" class="btn btn-success">Filter</button>  
                                      <button type="submit" name="data[print]" value="" id="printPleaseTwo" class="btn btn-success print">Print</button>
                                </div>
                            </div>
                        <?php echo $this->Form->end() ?>
                        <?php foreach ($this->data as $rrkey => $rrvalue) {  if($rrvalue['ReceivingTransaction']['type'] == 5) { ?>
                            <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                                <tr>
                                    <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
                                    <td>Reference # : <strong><?php echo $rrvalue['ReceivingTransaction']['reference_no'] ?></strong></td>
                                    <td>Customer : <strong><?php echo $rrvalue['SourceAccount']['last_name'].' '.$rrvalue['SourceAccount']['first_name'] ?></strong></td>
                                    <td>Recieving Datetime:  <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
                                    <td>
                                        <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/receiving_transactions/stock_transferin_supplier/<?php echo $rrvalue['ReceivingTransaction']['id'] ?>','_blank');">Edit</button>
                                        <button type="button" class="btn btn-outline btn-sm btn-success" 
                                        onclick="print_thistwo('<?php echo $rrvalue['ReceivingTransaction']['receiving_report_no']; ?>')">Print</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th><th>Brand</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>To Branch</th><th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($rrvalue['ReceivingTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                    <tr>
                                                        <td><?php echo $types[$rtdvalue['type_id']] ?></td>
                                                        <td><?php echo $brands[$rtdvalue['brand_id']] ?></td>
                                                        <td><?php echo $models[$rtdvalue['model_id']] ?></td>
                                                        <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                        <td><?php echo $rtdvalue['srp_price'] ?></td>
                                                        <td><?php echo $rtdvalue['net_price'] ?></td>
                                                        <td><?php echo $branches[$rtdvalue['to_branch_id']] ?></td>
                                                        <td><?php echo $rtdvalue['confirmed']==1?"Confirm":"<b style='color:red;'>Not Confirm</b>"; ?></td>
                                                    </tr>    
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
                                    <td colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
                                  
                                </tr>
                            </table>
                            <hr />
                        <?php }} ?>

                
                    </div>
 
                     <div class="tab-pane fade  <?php echo $_SESSION['type']==4?'in active':''; ?>" id="fromCustomerOnRepair">
                         <?php echo $this->Form->create('ReceivingTransaction');?>
                            <div class="row">
                                <?php echo $this->Form->hidden('filter.type',array('value'=>4)); ?>
                                <div class="col-lg-2">
                                Receiving Report # : <?php echo $this->Form->input('filter.receiving_report_no',array('id'=>'filterReceivingReportNoThree','label'=>false,'type'=>'text','value'=>$filter['receiving_report_no'])); ?> </div>
                                <div class="col-lg-2">
                                Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                                <div class="col-lg-2"> 
                                End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                                <div class="col-lg-2" style="padding-top: 15px;">
                                      <!-- <button type="reset" class="btn btn-success">Reset</button>   -->
                                      <button type="submit" class="btn btn-success">Filter</button>  
                                      <button type="submit" name="data[print]" value="" id="printPleaseThree" class="btn btn-success print">Print</button>
                                </div>
                            </div>
                        <?php echo $this->Form->end() ?>
                        <?php foreach ($this->data as $rrkey => $rrvalue) {  if($rrvalue['ReceivingTransaction']['type'] == 4) { ?>
                            <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                                <tr>
                                    <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
                                    <td>Reference # : <strong><?php echo $rrvalue['ReceivingTransaction']['reference_no'] ?></strong></td>
                                    <td>Customer : <strong><?php echo $rrvalue['SourceAccount']['last_name'].' '.$rrvalue['SourceAccount']['first_name'] ?></strong></td>
                                    <td>Recieving Datetime:  <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
                                    <td>
                                        <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/receiving_transactions/stock_transferin_supplier/<?php echo $rrvalue['ReceivingTransaction']['id'] ?>','_blank');">Edit</button>
                                        <button type="button" class="btn btn-outline btn-sm btn-success" 
                                        onclick="print_thisthree('<?php echo $rrvalue['ReceivingTransaction']['receiving_report_no']; ?>')">Print</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th><th>Brand</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>To Branch</th><th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($rrvalue['ReceivingTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                                    <tr>
                                                        <td><?php echo $types[$rtdvalue['type_id']] ?></td>
                                                        <td><?php echo $brands[$rtdvalue['brand_id']] ?></td>
                                                        <td><?php echo $models[$rtdvalue['model_id']] ?></td>
                                                        <td><?php echo $rtdvalue['serial_no'] ?></td>
                                                        <td><?php echo $rtdvalue['srp_price'] ?></td>
                                                        <td><?php echo $rtdvalue['net_price'] ?></td>
                                                        <td><?php echo $branches[$rtdvalue['to_branch_id']] ?></td>
                                                        <td><?php echo $rtdvalue['confirmed']==1?"Confirm":"<b style='color:red;'>Not Confirm</b>"; ?></td>
                                                    </tr>    
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
                                    <td colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
                                  
                                </tr>
                            </table>
                            <hr />
                        <?php }} ?>

                
                    </div>
                    
                    
                </div>
                

               
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php echo $this->Form->end(); ?>


<script>
    function print_this(receivingreportNo){
        jQuery('#filterReceivingReportNo').val(receivingreportNo);
        jQuery('#printPlease').trigger('click');
    } 
    function print_thisone(receivingreportNo){
        jQuery('#filterReceivingReportNoOne').val(receivingreportNo);
        jQuery('#printPleaseOne').trigger('click');
    }
    function print_thistwo(receivingreportNo){
        jQuery('#filterReceivingReportNoTwo').val(receivingreportNo);
        jQuery('#printPleaseTwo').trigger('click');
    }
    function print_thisthree(receivingreportNo){
        jQuery('#filterReceivingReportNoThree').val(receivingreportNo);
        jQuery('#printPleaseThree').trigger('click');
    }
</script>