<style type="text/css">
    .setFlex{
        display: flex;
    }
    .setFlex div{
        flex:1;
        margin: 5px;
    }
</style>
<ul class="nav nav-tabs">
    <li class="active"><a href="#accountTransaction<?php echo $accTkey; ?>" data-toggle="tab" aria-expanded="true" class=''>Account Transaction</a></li>
    <li class="divType1 divType2"><a href="#itemTransaction<?php echo $accTkey; ?>" data-toggle="tab" aria-expanded="true" class=''>Item Transaction</a></li>
    <li class="divType1 divType2"><a href="#collectorTransaction<?php echo $accTkey; ?>" data-toggle="tab" aria-expanded="true" class=''>Collector Info</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane fade active in parentDiv" id="accountTransaction<?php echo $accTkey; ?>" style="margin-bottom: 20px;">
        <?php if( !empty($accTvalue['total_payment']) && !empty($accTvalue['total_price'])) { ?>
        <!--
        <div class="col-lg-12">
                <?php 
                    $percent = round(($accTvalue['total_payment'] / $accTvalue['total_price'] ) * 100);
                    $complete = round(100 - $percent);
                 ?>
                <div>
                    <p>
                        <strong><?php echo $accTvalue['total_payment'] ?> of <?php echo $accTvalue['total_price'] ?></strong>
                        <span class="pull-right text-muted"><?php echo $percent; ?>% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%">
                            <span class="sr-only"><?php echo $percent; ?>% Complete (success)</span>
                        </div>
                    </div>
                </div>    
        </div>
        -->
        <?php } ?>
        <div class="col-lg-12">
                
            <div class="col-lg-12">
                <div class="table-responsive " style="font-size: 11px;">
                    <input name="data[AccountTransaction][id]" type="hidden" id="AccountTransactionId" value="<?php echo $accTvalue['id'];?>">
                    <input name="data[AccountTransaction][person_account_id]" type="hidden" id="AccountTransactionPersonAccountId" value="<?php echo $person_id;?>">
                    <div class='setFlex' style="">
                        <div class='setFlex' style="flex:8;flex-direction: column;">   
                            <div style="display:flex;flex-direction: row;">
                                <div class="" style="">
                                    <label>Type:</label>                            
                                    <?php echo $this->Form->input('AccountTransaction.collection_type_id',array('class'=>'form-control CollectionType','empty'=>'Select Type','label'=>false,'type'=>'select','options'=>array(1=>'Cash',2=>'Installment',4=>'Others',5=>'Disbursement'),'value'=>$accTvalue['collection_type_id'],'div'=>false)); ?> 
                                </div>

                                <div class="divType2" style="">
                                    <label>Account #:</label>                            
                                    <input name="data[AccountTransaction][transaction_account_number]" type="text" id="AccountTransactionTransactionAccountNumber" class="form-control" autocomplete="off" value="<?php echo $accTvalue['transaction_account_number']?>">
                                </div>
                                <div class="divType1 divType2 divType4" style="">
                                    <label>D.R. No.:</label>                            
                                    <input name="data[AccountTransaction][transaction_dr_no]" type="text" id="AccountTransactionTransactionDrNo" class="form-control" autocomplete="off" value="<?php echo $accTvalue['transaction_dr_no']?>">
                                </div>
                                <div class="divType1 divType2 divType4" style="">
                                    <label>D.R. Date:</label>                            
                                    <input name="data[AccountTransaction][transaction_dr_date]" type="text" id="AccountTransactionTransactionDrDate" class="form-control datepicker" autocomplete="off" value="<?php echo $accTvalue['transaction_dr_date']?>">
                                </div>                                                               
                                <div class="" style="">
                                    <label>Branch:</label>                            
                                    <?php echo $this->Form->input('AccountTransaction.branch_id',array('class'=>'form-control','empty'=>'Select Branch','label'=>false,'type'=>'select','options'=>$branches,'value'=>$accTvalue['branch_id'],'div'=>false)); ?>
                                    
                                </div>
                                <div class="divType1 divType2" style="">
                                    <label>Sales Man Code:</label>
                                    <?php echo $this->Form->input('AccountTransaction.transaction_sales_man_code',array('class'=>'form-control','empty'=>'Select Sales Man','label'=>false,'type'=>'select','options'=>$sales_users,'value'=>$accTvalue['transaction_sales_man_code'],'div'=>false)); ?>                                    
                                </div>
                                
                                <div class="divType2" style="">
                                    <label>Close Account:</label>                            
                                    <?php 
                                    if($accTvalue['account_closed'])                                        
                                        echo $this->Form->input('AccountTransaction.account_closed',array('type'=>'checkbox','class'=>'form-control','empty'=>'Select Branch','label'=>false,'value'=>$accTvalue['account_closed'],'div'=>false,'checked'=>'checked')); 
                                    else
                                        echo $this->Form->input('AccountTransaction.account_closed',array('type'=>'checkbox','class'=>'form-control','empty'=>'Select Branch','label'=>false,'value'=>$accTvalue['account_closed'],'div'=>false));                                         
                                    ?>
                                </div>
                            </div>
                            <br>
                            <div style="display:flex;flex-direction: row;border-top: 1px solid black">
                               
                                <div class="divType2" style="">
                                    <label>Total Price:</label>                            
                                    <input name="data[AccountTransaction][total_price]" type="text" id="AccountTransactionTotalPrice" class="form-control" autocomplete="off" value="<?php echo $accTvalue['total_price']?>">
                                </div>
                                <div class="divType5" style="">
                                    <label>Disbursement voucher:</label>                            
                                    <input name="data[AccountTransaction][dv]" type="text" id="AccountTransactionTransactionDv" class="form-control " autocomplete="off" value="<?php echo $accTvalue['dv']?>">
                                </div> 
                                <div class="divType1 divType4 divType5" style="">
                                    <label>Amount Payment:</label>                            
                                    <input name="data[AccountTransaction][total_payment]" type="text" id="AccountTransactionTotalPayment" class="form-control" autocomplete="off" value="<?php echo $accTvalue['total_payment']?>">
                                </div>
                                <div class="divType1 divType4 divType5" style="">
                                    <label>Payment OR:</label>                            
                                    <input name="data[AccountTransaction][payment_or]" type="text" id="AccountTransactionPaymentOR" class="form-control" autocomplete="off" value="<?php echo $accTvalue['payment_or']?>">
                                </div>
                                <div class=" divType5" style="">
                                    <label>Payment OR DATE:</label>                            
                                    <input name="data[AccountTransaction][payment_or_date]" type="text" id="AccountTransactionPaymentORDate" class="form-control datepicker" autocomplete="off" value="<?php echo $accTvalue['payment_or_date']?>">
                                </div>

                                <div class="divType1 divType4 divType5" style="">

                                    <label>Payment Date:</label>                            
                                    <input name="data[AccountTransaction][payment_date]" type="text" id="AccountTransactionPaymentDate" class="form-control datepicker" autocomplete="off" value="<?php echo $accTvalue['payment_date']?>">
                                </div>
                                <div class="divType2" style="">
                                    <label>Downpayment:</label>                            
                                    <input name="data[AccountTransaction][down_payment]" type="text" id="AccountTransactionDownpayment" class="form-control" autocomplete="off" value="<?php echo $accTvalue['down_payment']?>">
                                </div>
                                 <div class="divType2" style="">
                                    <label>DP OR:</label>                            
                                    <input name="data[AccountTransaction][down_payment_or]" type="text" id="AccountTransactionDownpaymentOr" class="form-control" autocomplete="off" value="<?php echo $accTvalue['down_payment_or']?>">
                                </div>
                                 <div class="divType2" style="">
                                    <label>DP Date:</label>                            
                                    <input name="data[AccountTransaction][down_payment_date]" type="text" id="AccountTransactionDownpaymentDate" class="form-control datepicker" autocomplete="off" value="<?php echo $accTvalue['down_payment_date']?>">
                                </div>
                                <div class="divType2" style="">
                                    <label>PN Val:</label>                            
                                    <input name="data[AccountTransaction][pn_value]" type="text" id="AccountTransactionPNVal" class="form-control" autocomplete="off" value="<?php echo $accTvalue['pn_value']?>" readonly="readonly">
                                </div>
                                <div class="divType2" style="">
                                    <label>MON.INST:</label>                            
                                    <input name="data[AccountTransaction][installment_amount]" type="text" id="AccountTransactionInstallmentAmount" class="form-control" autocomplete="off" value="<?php echo $accTvalue['installment_amount']?>">
                                </div>
                                <div class="divType1  divType2" style="">
                                    <label>LCP/AF:</label>                            
                                    <input name="data[AccountTransaction][lcp_af]" type="text" id="AccountTransactionTransactionLCPAF" class="form-control " autocomplete="off" value="<?php echo $accTvalue['lcp_af']?>">
                                </div>

                                <div class="divType2" style="">
                                    <label>1st Due Date:</label>                            
                                    <input name="data[AccountTransaction][due_date]" type="text" id="AccountTransactionDueDate" class="form-control datepicker" autocomplete="off" value="<?php echo $accTvalue['due_date']?>">
                                </div>
                                
                                <div class="divType1" style="">
                                    <label>Gross:</label>                            
                                    <input name="data[AccountTransaction][gross]" type="text" id="AccountTransactionTransactionGross" class="form-control " autocomplete="off" value="<?php echo $accTvalue['gross']?>" readonly="readonly">
                                </div> 
                                                              
                              
                            </div>
                             <div class="divType1 divType4 divType5" style="">
                                    <label>REMARKS:</label>                            
                                    <input name="data[AccountTransaction][remarks]" type="text" id="AccountTransactionTransactionRemarks" class="form-control " autocomplete="off" value="<?php echo $accTvalue['remarks']?>">
                                </div>   
                        </div>

                        <div class=" divType2" style="border:1px solid black;flex:1;">
                            
                           
                            <div class="" style="">
                                <label>Terms:</label>                        
                                <input name="data[AccountTransaction][terms]" type="text" id="AccountTransactionTerms" class="form-control" autocomplete="off" value="<?php echo $accTvalue['terms']?>">
                            </div>
                           
                            <div class="" style="">
                                <label>PPD:</label>                            
                                <input name="data[AccountTransaction][ppd]" type="text" id="AccountTransactionPpd" class="form-control" autocomplete="off" value="<?php echo $accTvalue['ppd']?>">
                            </div>


                        </div>
                    </div>

                    <div class='setFlex divType2 InstallmentDiv' style="border-top:1px solid black;border-bottom:1px solid black;">
                        
                        <div class="" style="">
                            <label>PN BALANCE:</label>                            
                            <input name="data[AccountTransaction][pn_balance]" type="text" id="AccountTransactionNotDue" class="form-control" autocomplete="off" value="<?php echo $accTvalue['pn_balance']?>">
                        </div>
                        <div class="" style="">
                            <label>NOT DUE:</label>                            
                            <input name="data[AccountTransaction][not_due]" type="text" id="AccountTransactionNotDue" class="form-control" autocomplete="off" value="<?php echo $accTvalue['not_due']?>">
                        </div>
                        <div class="" style="">
                            <label>CURRENT:</label>                            
                            <input name="data[AccountTransaction][current]" type="text" id="AccountTransactionCurrent" class="form-control" autocomplete="off" value="<?php echo $accTvalue['current']?>">
                        </div>
                        <div class="" style="">
                            <label>OVERDUE:</label>                            
                            <input name="data[AccountTransaction][overdue]" type="text" id="AccountTransactionOverDue" class="form-control" autocomplete="off" value="<?php echo $accTvalue['overdue']?>">
                        </div>
                        <div class="" style="">
                            <label>Total INT:</label>                            
                            <input name="data[AccountTransaction][total_interest]" type="text" id="AccountTransactionTotalInterest"  class="form-control" placeholder="" value="<?php echo $accTvalue['total_interest']; ?>">
                        </div>
                        <div class="divType2" style="">
                            <label>AS OF:</label>                            
                            <input name="data[AccountTransaction][as_of]" type="text" id="AccountTransactionAsOf"  class="form-control datepicker" placeholder="" value="<?php echo $accTvalue['as_of']; ?>">
                        </div>
                    </div>

                <div class="" data-class="payment">                   
                    <table class=" table" border="">
                       
                            <?php 
                            $debit=1;
                            if(!empty($accTvalue['AccountTransactionDetail'])){
                                foreach ($accTvalue['AccountTransactionDetail'] as $actDkeyDebit => $actDvalueDebit) { 

                                    if($actDvalueDebit['type']==2){ 
                                        $totalcredit=0;
                                        ?>
                                    
                                    <tr class="tobedeleted" style="border-bottom:3px solid black;">
                                        <td style="">
                                            <span class="number" style="font-size: 16px;"><?php echo $debit;$debit++; ?></span>                                            
                                            <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>
                                            <input class="detailId" id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][id]" type="hidden" value="<?php echo $actDvalueDebit['id'];?>">
                                        </td>
                                        <td>                                            
                                            <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>account_transaction_id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][account_transaction_id]" type="hidden" value="<?php echo $actDvalueDebit['account_transaction_id'];?>">
                                            <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>type" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][type]" type="hidden" value="<?php echo $actDvalueDebit['type'];?>">
                                            
                                            <label for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>due_date">Due Date:</label>
                                            <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>due_date" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][due_date]" class="form-control" placeholder="" style="" value="<?php echo $actDvalueDebit['due_date']; ?>"  autocomplete="off"  readonly="readonly">
                                            
                                            <label for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>amount_due">Amount Due:</label>
                                            <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>amount_due" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][amount_due]" class="form-control" placeholder="" style="" value="<?php echo $actDvalueDebit['amount_due']; ?>"  autocomplete="off">
                                            
                                            <label for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>interest">Interest:</label>                                            
                                            <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>interest" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>][interest]" class="form-control" placeholder="" style="" value="<?php echo $actDvalueDebit['interest']; ?>"  autocomplete="off">
                                            
                                        </td>
                                       
                                        <td class="itemPayment">
                                            <table class=" table  ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>REF DUE DATE</th>
                                                        <th>DATE PAID</th>
                                                        <th>OR #</th>
                                                        <th>DISCOUNT</th>
                                                        <th>AMOUNT PAID</th>
                                                        <th>Action</th>
                                                        <!-- <th style="width: 12%;">Collect By</th>  -->                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    
                                                    $creditctr=1;
                                                    $dueDateCredits=0;
                                                    if(!empty($accTvalue['AccountTransactionDetail'])){
                                                        foreach ($accTvalue['AccountTransactionDetail'] as $actDkey => $actDvalue) { 
                                                            if($actDvalue['type']==1 && date('Y-m',strtotime($actDvalueDebit['due_date'])) == date('Y-m',strtotime($actDvalue['due_date'])) ){ 
                                                                $dueDateCredits++;
                                                            ?>
                                                            <tr class='tobedeleted'>
                                                                <td>
                                                                    <span class="number"><?php echo $creditctr;$creditctr++; ?></span>
                                                                    <input class="detailId" id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][id]" type="hidden" value="<?php echo $actDvalue['id'];?>">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>account_transaction_id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][account_transaction_id]" type="hidden" value="<?php echo $actDvalue['account_transaction_id'];?>">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>type" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][type]" type="hidden" value="<?php echo $actDvalue['type'];?>">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>parent_id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][parent_id]" type="hidden" value="<?php echo $actDvalue['parent_id'];?>">
                                                                </td>
                                                                <td style="width: 115px;">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>due_date" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][due_date]" class="form-control " placeholder="" style="" value="<?php echo $actDvalue['due_date']; ?>"  autocomplete="off" readonly="readonly">
                                                                </td>
                                                                <td style="width: 115px;">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>payment_date" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][payment_date]" class="form-control datepicker" placeholder="" style="" value="<?php echo $actDvalue['payment_date']; ?>"  autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>or_number" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][or_number]" class="form-control" placeholder="" style="width: 115px;" value="<?php echo $actDvalue['or_number']; ?>"  autocomplete="off">
                                                                </td>
                                                                
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>discount" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][discount]" class="form-control" placeholder="" style="" value="<?php echo $actDvalue['discount']; ?>"  autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkey; ?>payment_amount" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkey; ?>][payment_amount]" class="form-control" placeholder="" style="" value="<?php echo $actDvalue['payment_amount']; ?>"  autocomplete="off">
                                                                </td>
                                                                <!-- <td></td> -->                                                            
                                                                <td class="td_action">
                                                                    <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>
                                                                </td>
                                                            </tr>
                                                        <?php 
                                                        $totalcredit += $actDvalue['discount'];
                                                        $totalcredit += $actDvalue['payment_amount'];
                                                         ?>
                                                        <?php }  ?>                    

                                                    <?php }}  ?>                    

                                                    <?php if($dueDateCredits==0){ ?>
                                                        
                                                        <tr class="">
                                                                <td>                                                                   
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][id]" type="hidden" value="">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999account_transaction_id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][account_transaction_id]" type="hidden" value="<?php echo $accTvalue['id'];?>">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999type" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][type]" type="hidden" value="1">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999parent_id" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][parent_id]" type="hidden" value="<?php echo $actDvalueDebit['id'];?>">
                                                                </td>
                                                                <td style="width: 115px;">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999due_date" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][due_date]" class="form-control " placeholder="" style="" value="<?php echo $actDvalueDebit['due_date']; ?>"  autocomplete="off"  readonly="readonly">
                                                                </td>
                                                                <td style="width: 115px;">
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999payment_date" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][payment_date]" class="form-control datepicker" placeholder="" style="" value=""  autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999or_number" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][or_number]" class="form-control" placeholder="" style="width: 115px;" value=""  autocomplete="off">
                                                                </td>
                                                                
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999discount" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][discount]" class="form-control" placeholder="" style="" value=""  autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input id="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>999payment_amount" name="data[AccountTransaction][AccountTransactionDetail][<?php echo $actDkeyDebit; ?>999][payment_amount]" class="form-control" placeholder="" style="" value=""  autocomplete="off">
                                                                </td>
                                                                <!-- <td></td> -->                                                            
                                                                <td class="td_action">
                                                                    <!-- <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button> -->
                                                                </td>
                                                            </tr>
                                                    <?php } ?>

                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr style="border-bottom:3px solid black;border-top:3px solid black;vertical-align: middle;">
                                                            <?php $totaldebit = $actDvalueDebit['amount_due']+$actDvalueDebit['interest']; ?>
                                                        <td colspan="2"><b> Total Debit </b> : <?php echo $totaldebit ; ?></td>
                                                        <td><b> Total Credit </b> : <?php echo $totalcredit ?></td>
                                                            <?php 
                                                            $totalbalance = $totaldebit-$totalcredit; ?>
                                                        <td><b> Balance </b> : <?php echo $totalbalance ?></td>
                                                        <td><b> Overdue </b> : <?php if($totalbalance<0) echo $totalbalance*-1; else echo "0" ?></td>
                                                        <td>
                                                            <b> Status </b> : <?php if($actDvalueDebit['paid']) echo "PAID"; else echo "NOT PAID"; ?>                                                             
                                                        </td>
                                                        
                                                        <td>
                                                            <?php if(!$actDvalueDebit['paid']){ ?>
                                                                <button class="btn btn-default addItemPayment" type="button">  <i class="glyphicon glyphicon-plus"></i> Payment</button>
                                                            <?php }else{ ?>
                                                                <b> BALANCE </b> : <?php echo $actDvalueDebit['balance_amount'] ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </td>
                                    
                                    </tr>
                                    
                                    
                                <?php } }  ?>                    

                            <?php } ?>                                                                
                                                
                    </table>                                                
                </div>
                    <button class="divType2 btn btn-default addInstallment" data-id="<?php echo $accTvalue['id'];?>" data-person="<?php echo $person_id;?>" type="button">  <i class="glyphicon glyphicon-plus"></i> Installment</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade " id="itemTransaction<?php echo $accTkey; ?>" style="margin-bottom: 20px;">
        <div class="itemTransaction">
            <table style="width: 100%;" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 14%;">Serial No.</th>
                        <th style="width: 14%;">Model</th>
                        <th style="width: 14%;">Brand</th>
                        <th style="width: 14%;">Type</th>
                        <th style="width: 14%;">Srp Price</th>
                        <th style="width: 14%;">Remarks</th>
                        <th style="width: 14%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            if(!empty($accTvalue['AccountTransactionItem'])){
                                foreach ($accTvalue['AccountTransactionItem'] as $actIkey => $actIvalue) { ?>
                                
                                    <tr>
                                        <td>
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.id',array('class'=>'','label'=>false,'type'=>'hidden','value'=>$actIvalue['id'])); ?>
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.account_transaction_id',array('class'=>'','label'=>false,'type'=>'hidden','value'=>$actIvalue['account_transaction_id'])); ?>
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.serial_no',array('class'=>'','label'=>false,'type'=>'text','value'=>$actIvalue['serial_no'])); ?>
                                        </td>
                                        <td style="">
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.model_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Model','label'=>false,'type'=>'select','options'=>$params['models'],'value'=>$actIvalue['model_id'])); ?>
                                        </td>
                                        <td style="">
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.brand_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Brand','label'=>false,'type'=>'select','options'=>$params['brands'],'value'=>$actIvalue['brand_id'])); ?>
                                        </td>
                                        <td style="">
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.type_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Type','label'=>false,'type'=>'select','options'=>$params['types'],'value'=>$actIvalue['type_id'])); ?>
                                        </td>
                                        <td>
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.item_price',array('class'=>'','label'=>false,'type'=>'text','value'=>$actIvalue['item_price'])); ?>
                                        </td>
                                        <td>
                                            <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.'.$actIkey.'.remarks',array('class'=>'','label'=>false,'type'=>'text','value'=>$actIvalue['remarks'])); ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>
                                        </td>
                                    </tr>    
                                <?php }  ?>    
                            <?php }else{  ?>
                                <tr>
                                    <td>
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.serial_no',array('class'=>'','label'=>false,'type'=>'text')); ?>
                                    </td>
                                    <td style="">
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.model_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Model','label'=>false,'type'=>'select','options'=>$params['models'])); ?>
                                    </td>
                                    <td style="">
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.brand_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Brand','label'=>false,'type'=>'select','options'=>$params['brands'])); ?>
                                    </td>
                                    <td style="">
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.type_id',array('style'=>'width:100%;','class'=>'form-control remove-chosen','empty'=>'Select Type','label'=>false,'type'=>'select','options'=>$params['types'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.item_price',array('class'=>'','label'=>false,'type'=>'text')); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('AccountTransaction.AccountTransactionItem.0.remarks',array('class'=>'','label'=>false,'type'=>'text')); ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            <?php }  ?> 
                </tbody>
            </table>
            <button type="button" style="" class="btn btn-info addItemTransaction">Add Serial</button>
        </div>
    </div>

    <div class="tab-pane fade " id="collectorTransaction<?php echo $accTkey; ?>" style="margin-bottom: 20px;">
         <div class='setFlex' style="">
            <div class='setFlex' style="flex:8;flex-direction: column;">   
               
                <div style="display:flex;flex-direction: row;">

                    <div style="display:flex;flex-direction: row;">
                        <div class="" style="">
                            <label>C.I:</label>                            
                            <input name="data[AccountTransaction][transaction_c_i]" type="text" id="AccountTransactionTransactionCI" class="form-control" autocomplete="off" value="<?php echo $accTvalue['transaction_c_i'] ?>" >
                        </div>
                        <div class="" style="">
                            <label>Collector Code:</label>                            
                            <input name="data[AccountTransaction][transaction_collector_code]" type="text" id="AccountTransactionTransactionCollectorCode" class="form-control" autocomplete="off" value="<?php echo $accTvalue['transaction_collector_code'] ?>">
                        </div>
                        <div class="" style="">
                            <label>Commission Code:</label>                            
                            <input name="data[AccountTransaction][transaction_commission_code]" type="text" id="AccountTransactionTransactionCommisionCode" class="form-control " autocomplete="off" value="<?php echo $accTvalue['transaction_commission_code'] ?>">
                        </div>
                      
                    </div>
                                       
                </div>
            </div>              
        </div>        
    </div>
    
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){


        var increment = 1;
        jQuery(".addItemTransaction").unbind();
        jQuery(".addItemTransaction").click(function() {
            
            jQuery('.chosen-select').chosen('destroy');

            increment = jQuery(this).closest('.itemTransaction').find('table tbody tr').length;

            var $newdiv = jQuery(this).closest('.itemTransaction').find("table tbody tr:last").clone(true);

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

            $newdiv.find('.number').empty().append(increment);
            $newdiv.find('.td_action').empty().append('<button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>');
            
            jQuery(this).closest('.itemTransaction').find('table tbody').append($newdiv);
            jQuery('.chosen-select').chosen();
            jQuery('.datepicker').datetimepicker('destroy');            
            jQuery('.datepicker').datetimepicker({timepicker:false,format:'Y-m-d'});            
            jQuery('.datepicker').css({'width':'100px'});
            bind_removeItem();

        });

        var incrementpayment = 999;
        jQuery(".addItemPayment").unbind();
        jQuery(".addItemPayment").click(function() {
            
            jQuery('.chosen-select').chosen('destroy');

            // incrementpayment = jQuery(this).closest('.itemPayment').find('table tbody tr').length;
            incrementpayment ++;

            console.log(incrementpayment);
            
            var $newdiv = jQuery(this).closest('.itemPayment').find("table tbody tr:last").clone(true);

            $newdiv.find('input,select,button').removeAttr('disabled');
            $newdiv.find('input,select').each(function() {
              
                var $this = jQuery(this);
                $this.attr('id', $this.attr('id').replace(/(\d+)/, function($0, $1) {                    
                    return '' + (incrementpayment) + '';
                }));
                $this.attr('name', $this.attr('name').replace(/\[(\d+)\]/, function($0, $1) {                    
                    return '[' + (incrementpayment) + ']';
                }));

                var attr = $this.attr('name');
                if ( attr.toLowerCase().indexOf("due_date") >= 0 || attr.toLowerCase().indexOf("account_transaction_id") >= 0 || attr.toLowerCase().indexOf("type") >= 0 || attr.toLowerCase().indexOf("parent_id") >= 0) {

                }else
                    $this.val('');
            });

            $newdiv.find('.number').empty().append(incrementpayment);
            $newdiv.find('.td_action').empty().append('<button class="btn btn-default removeItem" type="button">  <i class="glyphicon glyphicon-remove"></i></button>');
            
            jQuery(this).closest('.itemPayment').find('table tbody').append($newdiv);
            jQuery('.chosen-select').chosen();
            jQuery('.datepicker').datetimepicker('destroy');            
            jQuery('.datepicker').datetimepicker({timepicker:false,format:'Y-m-d'});            
            jQuery('.datepicker').css({'width':'100px'});
            bind_removeItem();

        });

        function bind_removeItem(){

            jQuery('.removeItem').unbind();
            jQuery('.removeItem').click(function(){                

                
                    if(confirm('Do you want to remove ?')){
                        console.log(jQuery(this).closest('tr').find('.detailId').val());

                        var dataa = [
                                {name:'data[AccountTransactionDetail][id]',value:jQuery(this).closest('tr').find('.detailId').val()},                                
                                ];

                        jQuery.ajax({
                            async:false,
                            data:dataa,
                            url:'/accounting/account_transactions/quickDelete',
                            type:'POST',
                            dataType:'json',
                            success:function(data){             
                                if(data.success){                                        
                                   
                                }
                            },
                            error:function(whaterror){
                            },
                            complete:function(){

                            }
                        });
                        jQuery(this).closest('.tobedeleted').remove();  
                    }

                    
                

            });
        }

        bind_removeItem();

        jQuery('.addInstallment').unbind();
        jQuery('.addInstallment').click(function(){

             var howmany = prompt("How many ?:", "1");
              if (howmany == null || howmany == "") {
                
              }else if (howmany >= 12) {
                 alert('Sorry Maximum of 12 only');
              }else {
                
                var transid = jQuery(this).attr('data-id');
                var person = jQuery(this).attr('data-person');

                var dataa = [
                            {name:'data[AccountTransactionDetail][id]',value:transid},
                            {name:'data[loop]',value:howmany},
                            ];

                jQuery.ajax({
                    async:false,
                    data:dataa,
                    url:'/accounting/account_transactions/quickAddInstallment',
                    type:'POST',
                    dataType:'json',
                    success:function(data){             
                        if(data.success){                                        
                           window.location.href = "/accounting/account_transactions/edit/"+person+"/"+transid;
                        }
                    },
                    error:function(whaterror){
                    },
                    complete:function(){

                    }
                });
            }
        });

        collectionTypeOnLoad();
        jQuery('.CollectionType').change(function(){
            collectionTypeChange(jQuery(this));          
        });
    });

    function collectionTypeChange(thiss){
        console.log('refresh');
        jQuery('.divType1').hide();
        jQuery('.divType2').hide();
        jQuery('.divType4').hide();
        jQuery('.divType5').hide();
        jQuery('.divType'+jQuery(thiss).val()).show();
    }
    function collectionTypeOnLoad(){
        console.log('refresh');
        jQuery('.divType1').hide();
        jQuery('.divType2').hide();
        jQuery('.divType4').hide();
        jQuery('.divType5').hide();
        jQuery('.CollectionType').each(function(key,value){         

            jQuery(value).closest('.parentDiv').find('.divType'+jQuery(value).val()).show();
            jQuery('.nav').find('.divType'+jQuery(value).val()).show();
            
        });
        
    }

</script>