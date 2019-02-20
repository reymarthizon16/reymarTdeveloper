
<style type="text/css">
	.thcenter th{text-align: center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Monthly Cash Collection Summary</h1>
    </div>    
</div> 
<!-- <br> -->

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/accounting/account_transactions/report_monthly" method="POST">
                                        
                    <?php echo $this->Form->input('month',array('type'=>'select','div'=>false,'options'=>array($month))); ?>
                    <?php echo $this->Form->input('year',array('type'=>'select','div'=>false,'options'=>array($year))); ?>
                    <?php echo $this->Form->input('branch_id',array('type'=>'select','div'=>false,'options'=>$filterBranches)); ?>

                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="submit" name="data[print]" value="1" id="printPlease" class="btn btn-success btn-sm print">Print</button>                    
                </form>

            </div>
            <!-- /.panel-heading -->         
            <div class="panel-body">
                <table id="tableToExport" class="table table-striped table-bordered table-hover" style="font-size:10px;">
                    <thead>
                    	<tr>
                            <th>Coll. Date</th>   
                            <th>Expenses</th>                               
                            <th>Amount Recieved</th>   
                            <th>Discount(PPD)</th>   
                            <th>Interest</th>
                            <th>Amount Credited</th>
                            <th>Others</th>
                            <th>Cash Sales</th>
                            <th>Downpayment</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
                        $bottotal = array();
                        foreach ($data as $datakey => $datavalue) { 
                            $tdtotal = 0;
                            ?>
                    		<tr>
                    			<td><?php echo $datakey ?></td>

                    			<td><?php echo number_format($datavalue['Disbursement']['amount'],2); $tdtotal-= $datavalue['Disbursement']['amount'];  
                                    $bottotal[1]+= $datavalue['Disbursement']['amount']; ?></td>

                    			<td><?php echo number_format($datavalue['InsUpdate']['amount'],2); $tdtotal+= $datavalue['InsUpdate']['amount'];  
                                    $bottotal[2]+= $datavalue['InsUpdate']['amount']; ?></td>

                    			<td><?php echo number_format($datavalue['InsUpdate']['ppd'],2); $tdtotal+= $datavalue['InsUpdate']['ppd'];  
                                    $bottotal[3]+= $datavalue['InsUpdate']['ppd']; ?></td>
                    			<td></td>
                    			<td><?php 
                    				if($datavalue['InsUpdate']['amount'] && $datavalue['InsUpdate']['ppd'])
                    					echo number_format($datavalue['InsUpdate']['amount'] + $datavalue['InsUpdate']['ppd'],2);
                                        $bottotal[4] +=$datavalue['InsUpdate']['amount'] + $datavalue['InsUpdate']['ppd'];
                                         ?>	
                    				</td>
                    			<td><?php echo number_format($datavalue['Others']['amount'],2); $tdtotal+= $datavalue['Others']['amount'];  
                                    $bottotal[5]+= $datavalue['Others']['amount']; ?></td>

                    			<td><?php echo number_format($datavalue['Cash']['amount'],2); $tdtotal+= $datavalue['Cash']['amount'];  
                                    $bottotal[6]+= $datavalue['Cash']['amount']; ?></td>

                    			<td><?php echo number_format($datavalue['InsDown']['amount'],2); $tdtotal+= $datavalue['InsDown']['amount'];  
                                    $bottotal[7]+= $datavalue['InsDown']['amount']; ?></td>

                                <td><?php echo number_format($tdtotal,2); $bottotal[8]+=$tdtotal;?></td>
                    		</tr>
                    	<?php } ?>


                        <tr>
                            <td>TOTAL</td>
                            <td><?php echo number_format($bottotal[1],2) ?></td>
                            <td><?php echo number_format($bottotal[2],2) ?></td>
                            <td><?php echo number_format($bottotal[3],2) ?></td>
                            <td></td>
                            <td><?php echo number_format($bottotal[4],2) ?></td>
                            <td><?php echo number_format($bottotal[5],2) ?></td>
                            <td><?php echo number_format($bottotal[6],2) ?></td>
                            <td><?php echo number_format($bottotal[7],2) ?></td>
                            <td><?php echo number_format($bottotal[8],2) ?></td>
                        </tr>

                    </tbody>    
                </table>


               
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#export').click(function(){

            doExport('#tableToExport', {type: 'excel'});
            return false;
        });
    });
</script>
