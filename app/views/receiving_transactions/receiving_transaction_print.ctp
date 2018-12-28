<style>
	@page{
		margin: 5%;
	}
	table{
		border-collapse: collapse;
	}
	.table{
		width: 100%;
	}
</style>
<?php
$type[1] = "From Supplier";
$type[2] = "From Stock Transfer";
$type[5] = "From Customer (reposes)";
$type[4] = "From Customer (on repair)";

if($filter['type'] == 1) {
 	foreach ($this->data as $rrkey => $rrvalue) {   ?>
    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
        <tr>
            <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
            <td>Reference # : <strong><?php echo $rrvalue['ReceivingTransaction']['reference_no'] ?></strong></td>
            <td>Supplier : <strong><?php echo $rrvalue['SourceAccount']['company'] ?></strong></td>
            <td colspan="2">Recieving Datetime:  <br /><strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
            
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">
                <table style="width: 700px;font-size: 12px;" border="1" class="table table-striped table-bordered table-hover">
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
            <td style="width: 30%;" colspan="2">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
            <td style="width: 30%;"> Type:  <strong><?php echo $type[$filter['type']] ?></td>       </strong>     
            <td style="width: 30%;" colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
          
        </tr>
    </table>
    <hr />
<?php }} ?>

<?php 
if($filter['type'] == 2) {
foreach ($this->data as $rrkey => $rrvalue) {  
	 ?>
    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="dataTables-example">
        <tr>
            <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
            <td>Reference ST # : <strong><?php echo $rrvalue['ReceivingTransaction']['stock_transfer_no'] ?></strong></td>
            <td colspan="2">Recieving Datetime:  <br/><strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
            
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">
                <table style="width: 700px;font-size: 12px;" border="1" class="table table-striped table-bordered table-hover">
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
            <td style="width: 30%;" colspan="1">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
            <td style="width: 30%;"> Type:  <strong><?php echo $type[$filter['type']] ?></strong></td>
            <td style="width: 30%;" colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
          
        </tr>
    </table>
    <hr />
<?php }} ?>

<?php

if($filter['type'] == 4 || $filter['type'] == 5) {
    foreach ($this->data as $rrkey => $rrvalue) {   ?>
    <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
        <tr>
            <td>Receiving Report # : <strong><?php echo $rrvalue['ReceivingTransaction']['receiving_report_no'] ?></strong></td>
            <td>Reference # : <strong><?php echo $rrvalue['ReceivingTransaction']['reference_no'] ?></strong></td>
            <td>Customer : <strong><?php echo $rrvalue['SourceAccount']['last_name'].' '.$rrvalue['SourceAccount']['first_name'] ?></strong></td>
            <td colspan="2">Recieving Datetime:  <br /><strong><?php echo $rrvalue['ReceivingTransaction']['receiving_datetime'] ?></strong></td>
            
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">
                <table style="width: 700px;font-size: 12px;" border="1" class="table table-striped table-bordered table-hover">
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
            <td style="width: 30%;" colspan="2">Received By : <strong><?php echo $rrvalue['ReceivedByUser']['last_name'].", ".$rrvalue['ReceivedByUser']['first_name'] ?></strong></td>
            <td style="width: 30%;"> Type:  <strong><?php echo $type[$filter['type']] ?></strong></td>
            <td style="width: 30%;" colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
          
        </tr>
    </table>
    <hr />
<?php }} ?>