
<style>
    @page{
        margin: 5%;
        margin-top: 10%;
        margin-header:1%;
        header: html_myHTMLHeader1;
        
    }
    table{
        border-collapse: collapse;
        font-size: 10px;
    }
    b{
        
        font-size: 10px;
    }
    
    .table{
        width: 100%;
    }
    .thcenter th{text-align: center;}
    #tableToExport th{font-size: 12px;}
    .title{}
</style>

<?php if($accTvalue['collection_type_id']==2){ ?>
    <table class=" table  " style="border-collapse: collapse;width: 100%;" border="1">
       
        <tr>
            <td colspan="4">
                <b class='' style='font-weight: bold;'>Type : </b>
                <?php
                $type = array(1=>'Cash',2=>'Installment',4=>'Others',5=>'Disbursement');
                 echo $type[$accTvalue['collection_type_id']]?> 
            </td>
        </tr>
        <tr>
            
            <td style="width: 25%;">
                <b class='' style='font-weight: bold;'>Account No. : </b>
                <?php echo $accTvalue['transaction_account_number']?>
            </td>
            <td style="width: 25%;">
                <b class='' style='font-weight: bold;'>D.R. No : </b>
                <?php echo $accTvalue['transaction_dr_no']?>
            </td>
            <td style="width: 25%;">
                <b class='' style='font-weight: bold;'>D.R Date : </b>
                <?php echo $accTvalue['transaction_dr_date']?>
            </td>
            <td style="width: 25%;">
                <b class='' style='font-weight: bold;'>Branch : </b>
                <?php echo $branches[$accTvalue['branch_id']]; ?>
            </td>
        </tr>
        <tr>
            <td>
                <b class='' style='font-weight: bold;'>Sales Man Code : </b>
                <?php echo $sales_users[$accTvalue['transaction_sales_man_code']]; ?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>Status : </b>
                <?php 
                if($accTvalue['account_closed'])                                        
                    echo "Account Closed" ;
                else
                    echo "Account Open" ;
                ?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>Terms : </b>
                <?php echo $accTvalue['terms']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>PPD : </b>
                <?php echo $accTvalue['ppd']?>
            </td>
        </tr>
        <tr>
            <td>
                <b class='' style='font-weight: bold;'>Total Price:</b>
                <?php echo $accTvalue['total_price']?>       
            </td>
            <td>
                <b class='' style='font-weight: bold;'>Downpayment:</b>                            
                <?php echo $accTvalue['down_payment']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>DP OR:</b>                            
                <?php echo $accTvalue['down_payment_or']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>DP Date:</b>                            
                <?php echo $accTvalue['down_payment_date']?>
            </td>
        </tr>
        <tr>
            <td>
                <b class='' style='font-weight: bold;'>PN Val:</b>                            
                <?php echo $accTvalue['pn_value']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>MON.INST:</b>                            
                <?php echo $accTvalue['installment_amount']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>LCP/AF:</b>                            
                <?php echo $accTvalue['lcp_af']?>
            </td>
            <td>
                <b class='' style='font-weight: bold;'>1st Due Date:</b>                            
                <?php echo $accTvalue['due_date']?>         
            </td>

        </tr>
    </table>
    <br>
    <table class=" table  " style="border-collapse: collapse;width: 100%;" border="1">
        <tr>

            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>PN BALANCE:</b>                            
                <?php echo $accTvalue['pn_balance']?>
            </td>
            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>NOT DUE:</b>                            
                <?php echo $accTvalue['not_due']?>
            </td>
            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>CURRENT:</b>                            
                <?php echo $accTvalue['current']?>
            </td>
            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>OVERDUE:</b>                            
                <?php echo $accTvalue['overdue']?>
            </td>
            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>Total INT:</b>                            
                <?php echo $accTvalue['total_interest']; ?>
            </td>
            <td style="width: 15%;">
                <b class='' style='font-weight: bold;'>AS OF:</b>                            
                <?php echo $accTvalue['as_of']; ?>
            </td>

        </tr>

    </table>
    <br>
    <table class=" table  " style="border-collapse: collapse;width: 100%;text-align: center;" border="1">
        <thead>
            <tr>
                <th style="width: 14%;">Serial No.</th>
                <th style="width: 14%;">Model</th>
                <th style="width: 14%;">Brand</th>
                <th style="width: 14%;">Type</th>
                <th style="width: 14%;">Srp Price</th>
                <th style="width: 14%;">Remarks</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
                    if(!empty($accTvalue['AccountTransactionItem'])){
                        foreach ($accTvalue['AccountTransactionItem'] as $actIkey => $actIvalue) { ?>
                        
                            <tr>
                                <td>
                                    
                                    <?php echo $actIvalue['serial_no']; ?>
                                </td>
                                <td style="">
                                    <?php echo $params['models'][$actIvalue['model_id']]; ?>
                                </td>
                                <td style="">
                                    <?php echo $params['brands'][$actIvalue['brand_id']]; ?>
                                </td>
                                <td style="">
                                    <?php echo $params['types'][$actIvalue['type_id']]; ?>
                                </td>
                                <td>
                                    <?php echo $actIvalue['item_price']; ?>
                                </td>
                                <td>
                                    <?php echo $actIvalue['remarks']; ?>
                                </td>
                                
                            </tr>    
                        <?php }  ?>    
                    <?php } ?>
                     
        </tbody>
    </table>
    <br>

    <table class=" table  " style="border-collapse: collapse;width: 100%;" border="1">
                       
            <?php 
            $debit=1;
            if(!empty($accTvalue['AccountTransactionDetail'])){
                foreach ($accTvalue['AccountTransactionDetail'] as $actDkeyDebit => $actDvalueDebit) { 

                    if($actDvalueDebit['type']==2){ 
                        $totalcredit=0;
                        ?>
                    
                    <tr class="tobedeleted" style="border-bottom:3px solid black;">
                        <td style="width: 5%;text-align: center;">
                            <span class="number" style="font-size: 16px;"><?php echo $debit;$debit++; ?></span>
                        </td>
                        <td style="width: 25%;">
                            <b for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>due_date">Due Date:</b>
                            <?php echo $actDvalueDebit['due_date']; ?>
                            <br />
                            <b for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>amount_due">Amount Due:</b>
                            <?php echo $actDvalueDebit['amount_due']; ?>
                            <br />
                            <b for="AccountTransactionAccountTransactionDetail<?php echo $actDkeyDebit; ?>interest">Interest:</b>                                            
                            <?php echo $actDvalueDebit['interest']; ?>
                            
                        </td>
                       
                        <td class="itemPayment" style="width: 70%;">
                            <table class=" table  " style="border-collapse: collapse;width: 800px;" border="1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>REF DUE DATE</th>
                                        <th>DATE PAID</th>
                                        <th>OR #</th>
                                        <th>DISCOUNT</th>
                                        <th>AMOUNT PAID</th>  
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
                                                </td>
                                                <td style="width: 115px;">
                                                    <?php echo $actDvalue['due_date']; ?>
                                                </td>
                                                <td style="width: 115px;">
                                                    <?php echo $actDvalue['payment_date']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $actDvalue['or_number']; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo $actDvalue['discount']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $actDvalue['payment_amount']; ?>
                                                </td>
                                                
                                            </tr>
                                        <?php 
                                        $totalcredit += $actDvalue['discount'];
                                        $totalcredit += $actDvalue['payment_amount'];
                                         ?>
                                        <?php }  ?>                    

                                    <?php }}  ?>                    

                                 
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
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    
                    </tr>
                    
                    
                <?php } }  ?>                    

            <?php } ?>                                                                
                                
    </table>               

<?php } ?>
