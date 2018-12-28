<style>
	@page{
		margin: 5%;
	}
	table{
		border-collapse: collapse;
		font-size: 12px;
	}
	.table{
		width: 100%;
	}
</style>
<?php 
	$type[1] = "Stock Transfer to Branch";
	$type[2] = "Stock Transfer to Service Center";
	$type[3] = "Stock Transfer to Customer";
 ?>
<?php if($filter['type'] == 1) { ?>
<?php foreach ($this->data as $rrkey => $rrvalue) { ?>
	<table style="width: 100%;" border="1" class="table " style="" id="" cellpadding="5px">
	    <tr>
	        <td style="width: 25%;">Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
	        <td style="width: 25%;">From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
	        <td style="width: 25%;">To:  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['to_branch_id']] ?></strong></td>
	        <td style="width: 25%;">DateTime : <br/><strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
	        
	    </tr>
	    <tr>
	        <td colspan="4" style="text-align: center;">
	        	<div style="">
	            <table style="width: 700px;" border="1" class="table " cellpadding="5px">
	                
	                    <tr>
	                        <th style="width: 15%;">Type</th>
	                        <th style="width: 20%;">Model</th>
	                        <th style="width: 15%;">Serial No.</th>
	                        <th style="width: 10%;">SRP</th>
	                        <th style="width: 10%;">Net</th>
	                        <th style="width: 10%;">Status</th>
	                        <th style="width: 15%;">Receive</th>
	                    </tr>
	                	               

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
	                    	               
	            </table>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td>Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
	        <td colspan="2"> Type:  <strong><?php echo $type[$filter['type']] ?></td>       </strong>     
	        <td >Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
	      
	    </tr>
	</table>
	<hr />
<?php } ?> 

<?php } ?>  

<?php if($filter['type'] == 2) { ?>

<?php foreach ($this->data as $rrkey => $rrvalue) { ?>
	<table style="width: 100%;" border="1" class="table " style="" id="" cellpadding="5px">
	    <tr>
	        <td style="width: 25%;">Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
	        <td style="width: 25%;">From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
	        <td style="width: 25%;">To :  <strong><?php echo $rrvalue['ToServiceCenter']['company'] ?></strong></td>strong></td>
	        <td style="width: 25%;">DateTime : <br/><strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
	        
	    </tr>
	    <tr>
	        <td colspan="4" style="text-align: center;">
	        	<div style="">
	            <table style="width: 700px;" border="1" class="table " cellpadding="5px">
	                
	                    <tr>
	                        <th style="width: 15%;">Type</th>
	                        <th style="width: 15%;">Model</th>
	                        <th style="width: 15%;">Serial No.</th>
	                        <th style="width: 10%;">SRP</th>
	                        <th style="width: 10%;">Net</th>
	                        <th style="width: 10%;">Status</th>
	                        <th style="width: 10%;">Repair</th>
	                        <th style="width: 10%;">Replaced</th>
	                    </tr>
	                	               

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
	                    	               
	            </table>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td  colspan="1">Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
	        <td  colspan="2"> Type:  <strong><?php echo $type[$filter['type']] ?></td>       </strong>     
	        <td  colspan="1">Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
	      
	    </tr>
	</table>
	<hr />
<?php } ?>  

<?php } ?>  

<?php if($filter['type'] == 3) { ?>

<?php foreach ($this->data as $rrkey => $rrvalue) { ?>
	<table style="width: 100%;" border="1" class="table " style="" id="" cellpadding="5px">
	    <tr>
	        <td style="width: 25%;">Stock Transfer # : <strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_no'] ?></strong></td>
	        <td style="width: 25%;">From :  <strong><?php echo $branches[$rrvalue['StockTransferTransaction']['from_branch_id']] ?></strong></td>
	        <td style="width: 25%;">To :  <strong><?php echo $rrvalue['ToCustomer']['last_name'].' '.$rrvalue['ToCustomer']['first_name'] ?></strong></td>strong></td>
	        <td style="width: 25%;">DateTime : <br/><strong><?php echo $rrvalue['StockTransferTransaction']['stock_transfer_datetime'] ?></strong></td>
	        
	    </tr>
	    <tr>
	        <td colspan="4" style="text-align: center;">
	        	<div style="">
	            <table style="width: 700px;" border="1" class="table " cellpadding="5px">
	                
	                    <tr>
	                        <th style="width: 15%;">Type</th>
	                        <th style="width: 20%;">Model</th>
	                        <th style="width: 15%;">Serial No.</th>
	                        <th style="width: 10%;">SRP</th>
	                        <th style="width: 10%;">Net</th>
	                        <th style="width: 10%;">Status</th>
	                        
	                    </tr>
	                	               

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
	                    	               
	            </table>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td  colspan="1">Prepared By : <strong><?php echo $rrvalue['PreparedByUser']['last_name'].", ".$rrvalue['PreparedByUser']['first_name'] ?></strong></td>
	        <td  colspan="2"> Type:  <strong><?php echo $type[$filter['type']] ?></td>       </strong>     
	        <td  colspan="1">Approved By : <strong><?php echo $rrvalue['ApprovedByUser']['last_name'].", ".$rrvalue['ApprovedByUser']['first_name'] ?></strong></td>
	      
	    </tr>
	</table>
	<hr />
<?php } ?>  

<?php } ?>  
