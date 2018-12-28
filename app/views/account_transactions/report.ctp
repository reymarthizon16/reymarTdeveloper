
<style type="text/css">
	.thcenter th{text-align: center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Overdue/Updated Accounts Reports</h1>
    </div>    
</div> 
<!-- <br> -->

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/accounting/account_transactions/reports" method="POST">
                                        
                    <?php echo $this->Form->input('month',array('type'=>'select','div'=>false,'options'=>array($month))); ?>
                    <?php echo $this->Form->input('year',array('type'=>'select','div'=>false,'options'=>array($year))); ?>
                    <?php echo $this->Form->input('branch_id',array('type'=>'select','div'=>false,'options'=>$filterBranches)); ?>

                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="submit" name="data[print]" value="1" id="printPlease" class="btn btn-success btn-sm print">Print</button>  
                    <button type="submit" name="data[aging]" value="1" id="printPleaseAging" class="btn btn-success btn-sm print">Print Aging</button>  
                    <button id="export" class="btn btn-success btn-sm export">Export</button>  
                </form>

            </div>
            <!-- /.panel-heading -->
            <?php $titles = array(0=>'New Accounts','updated'=>'Updated Accounts',1=>'One Month Overdue',2=>'Two Month Overdue', 3=>'Three Month Overdue','matured'=>'Matured Accounts'); ?>
            <div class="panel-body">
                <table id="tableToExport" class="table table-striped table-bordered table-hover" style="font-size:10px;">
                	<tr>
                        <th>ACCT.NO.</th>   
                        <th>Customer Name</th>   
                        <th>Due Date</th>   
                        <th>PN BALANCE</th>   
                        <th>DUE NEXT</th>   
                        <th>OVERDUE</th>
                        <th>PAYMENT</th>
                        <th>REMARKS</th>
                    </tr>

                    <?php foreach ($titles as $titlekey => $titlevalue) { ?>
                        <tr>
                            <td colspan="8" style="font-size: 14px;"> <?php echo $titlevalue; ?></td>
                        </tr>
                        <?php 
                        $numOfAccounts[$titlekey] = 0;
                        $pnValueOfAccounts[$titlekey] = 0;
                        $dueNextOfAccounts[$titlekey] = 0;
                        $overDueOfAccounts[$titlekey] = 0;
                        if($data[$titlekey]){
                            foreach ($data[$titlekey] as $datakey => $datavalue) { ?> 
                            <tr>
                                <td><?php echo $datavalue['transaction_account_number']; ?></td>
                                <td><?php echo $datavalue['fullname']; ?></td>
                                <td><?php echo $datavalue['due_date']; ?></td>
                                <td><?php echo number_format($datavalue['pn_balance'],2); ?></td>
                                <td><?php echo $datavalue['due_next']>=0?number_format($datavalue['due_next'],2):0; ?></td>
                                <td><?php echo $datavalue['total_overDue']>=0?number_format($datavalue['total_overDue'],2):0; ?></td>                                
                                <td></td>
                                <td></td>
                            </tr>
                            <?php 
                                $numOfAccounts[$titlekey] += 1;
                                $pnValueOfAccounts[$titlekey] += $datavalue['pn_balance'];
                                $dueNextOfAccounts[$titlekey] += $datavalue['due_next']>=0?$datavalue['due_next']:0; 
                                $overDueOfAccounts[$titlekey] += $datavalue['total_overDue']>=0?$datavalue['total_overDue']:0; 
                             ?>                        
                            <?php } ?>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $numOfAccounts[$titlekey]; ?> ACCOUNTS</td>
                                <td>SUBTOTAL</td>
                                <td><?php echo number_format($pnValueOfAccounts[$titlekey],2); ?></td>
                                <td><?php echo number_format($dueNextOfAccounts[$titlekey],2); ?></td>
                                <td><?php echo number_format($overDueOfAccounts[$titlekey],2); ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                        <?php }else{ ?>
                             <tr>
                                <td></td>
                                <td>0 ACCOUNTS</td>
                                <td>SUBTOTAL</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

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
