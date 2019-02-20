
<style type="text/css">
	.thcenter th{text-align: center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Daily Cash Collection Summary</h1>
    </div>    
</div> 
<!-- <br> -->

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/accounting/account_transactions/report_daily" method="POST">
                                        
                    <?php echo $this->Form->input('date',array('type'=>'text','div'=>false,'class'=>'datepicker')); ?>
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
                            <th>ACCT.NO.</th>   
                            <th>ACCT.Name</th>   
                            <th>OR</th>   
                            <th>Amount Recieved</th>   
                            <th>Discount(PPD)</th>   
                            <th>Interest</th>
                            <th>Amount Credited</th>
                            <th>Cash Sales</th>
                            <th>Downpayment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $label_AmountR = 0;
                        $label_AmountCR = 0;
                        $label_AmountPPD = 0;
                        $label_AmountDown = 0;
                        $Credited = 0;
                        foreach ($data as $datakey => $datavalue) { ?>
                            <tr>
                                <td colspan="9" style="font-weight: bold;"><?php echo $datakey ?></td>
                            </tr>
                            <?php
                            
                            if(!empty($data[$datakey]))
                            foreach ($data[$datakey] as $datadetailkey => $datadetail) { 
                                
                                
                            ?>
                                <?php if($datakey =='InsUpdate'){ ?>
                                <tr>
                                    <td><?php echo $datadetail['account_number'] ?></td>
                                    <td><?php echo $datadetail['last_name'] ?> <?php echo $datadetail['first_name'] ?></td>
                                    <td><?php echo $datadetail['label_OR'] ?></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php 
                                    $label_AmountR += $datadetail['label_AmountR'];
                                    $label_AmountPPD += $datadetail['label_AmountPPD']; 
                                    ?>
                                    <td><?php echo $datadetail['label_AmountPPD'] ?></td>
                                    <td>N/A</td>
                                    <td><?php echo number_format($datadetail['label_AmountR']+$datadetail['label_AmountPPD'],2); ?></td>
                                    <?php $Credited +=  $datadetail['label_AmountR']+$datadetail['label_AmountPPD']; ?>
                                    <?php $Collection +=  $datadetail['label_AmountR']+$datadetail['label_AmountPPD']; ?>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <?php if($datakey =='InsDown'){ ?>
                                <tr>
                                    <td><?php echo $datadetail['account_number'] ?></td>
                                    <td><?php echo $datadetail['last_name'] ?> <?php echo $datadetail['first_name'] ?></td>
                                    <td><?php echo $datadetail['label_OR'] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountDown += $datadetail['label_AmountR']; ?>
                                    <?php $Collection += $datadetail['label_AmountR']; ?>

                                </tr>
                                <?php } ?>
                                <?php if($datakey =='Disbursement'){ ?>
                                <tr>
                                    <td><?php echo $datadetail['account_number'] ?></td>
                                    <td><?php echo $datadetail['last_name'] ?> <?php echo $datadetail['first_name'] ?> <?php echo $datadetail['company'] ?></td>
                                    <td><?php echo $datadetail['label_OR'] ?></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountR += $datadetail['label_AmountR']; ?>
                                    <?php $Deducted += $datadetail['label_AmountR']; ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                    
                                </tr>
                                <?php } ?>
                                <?php if($datakey =='Cash'){ ?>
                                <tr>
                                    <td><?php echo $datadetail['account_number'] ?></td>
                                    <td><?php echo $datadetail['last_name'] ?> <?php echo $datadetail['first_name'] ?> <?php echo $datadetail['company'] ?></td>
                                    <td><?php echo $datadetail['label_OR'] ?></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountR += $datadetail['label_AmountR']; ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountCR += $datadetail['label_AmountR']; ?>
                                    <?php $Collection += $datadetail['label_AmountR']; ?>
                                    <td></td>                                    
                                </tr>
                                <?php } ?>
                                <?php if($datakey =='Others'){ ?>
                                <tr>
                                    <td><?php echo $datadetail['account_number'] ?></td>
                                    <td><?php echo $datadetail['last_name'] ?> <?php echo $datadetail['first_name'] ?> <?php echo $datadetail['company'] ?></td>
                                    <td><?php echo $datadetail['label_OR'] ?></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountR += $datadetail['label_AmountR']; ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($datadetail['label_AmountR'],2) ?></td>
                                    <?php $label_AmountCR += $datadetail['label_AmountR']; ?>
                                    <?php $Collection += $datadetail['label_AmountR']; ?>
                                    <td></td>                                    
                                </tr>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>
                            <tr>
                                <td colspan="9" style="font-weight: bold;"><br></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td><?php echo number_format($label_AmountR,2) ?></td>
                                <td><?php echo number_format($label_AmountPPD,2) ?></td>
                                <td></td>
                                <td><?php echo number_format($Credited,2) ?></td>
                                <td><?php echo number_format($label_AmountCR,2) ?></td>
                                <td><?php echo number_format($label_AmountDown,2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="9" style="font-weight: bold;"><br></td>
                            </tr>
                             <tr style="font-weight: bold;">
                                <td></td>                                
                                <td >Collection Amount</td>
                                <td><?php echo number_format($Collection,2) ?></td>
                                <td colspan="6"></td>
                                
                            </tr>
                            <tr style="font-weight: bold;">
                                <td></td>                                
                                <td >Amount Credited</td>
                                <td><?php echo number_format($Deducted,2) ?></td>
                                <td colspan="6"></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td></td>                                
                                <td >Amount to be Deposited</td>
                                <td><?php echo number_format($Collection-$Deducted,2) ?></td>
                                <td></td>
                                
                                <td colspan="5">
                                    Status : 
                                    <?php   
                                        if(!empty($deposit)){
                                            $tobedeposit = $Collection-$Deducted;
                                            $deposited = 0;
                                            foreach ($deposit as $depositkey => $depositvalue) {
                                                $deposited += $depositvalue['DepositSlip']['deposit_amount'];
                                            }

                                            if( $deposited > $tobedeposit){
                                                echo "Over Deposit";
                                            }
                                            if( $deposited < $tobedeposit){
                                                echo "Short Deposit";
                                            }

                                            if( $deposited == $tobedeposit){
                                                echo "Exact Deposit";
                                            }
                                        }
                                     ?>
                                </td>
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
