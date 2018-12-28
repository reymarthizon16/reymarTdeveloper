
<style>
    @page{
        margin: 5%;
        margin-top: 10%;
        margin-header:1%;
        header: html_myHTMLHeader1;
        
    }
    table{
        border-collapse: collapse;
    }
   
    .table{
        width: 100%;
    }
    .thcenter th{text-align: center;}
    #tableToExport th{font-size: 12px;}
</style>
<htmlpageheader name="myHTMLHeader1">
    <table class="table" style="" >
        <tr>
            <td>City Trust Appliance Center</td>
        </tr>
        <tr>
            <td>Overdue/Updated Accounts per F.R</td>
        </tr>
        <tr>
            <td><?php echo $filterBranches[$this->data['branch_id']] ?></td>
        </tr>
        <tr>
            <td>Date: <?php echo $month[$this->data['month']]." ".$year[$this->data['year']] ?></td>
        </tr>
        <tr>
            <td>Page No: &#160;&#160;{PAGENO} of {nbpg}</td>
        </tr>
    </table>
</htmlpageheader>

<sethtmlpageheader name="myHTMLHeader1" />

<?php $titles = array(0=>'New Accounts','updated'=>'Updated Accounts',1=>'One Month Overdue',2=>'Two Month Overdue', 3=>'Three Month Overdue','matured'=>'Matured Accounts'); ?>

<table id="tableToExport" class="table table-striped table-bordered table-hover" style="" border="1" cellpadding="5">
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
            <td colspan="8" style="text-align:left;font-weight: bold;"> <?php echo $titlevalue; ?></td>
        </tr>
        <?php 
        $numOfAccounts[$titlekey] = 0;
        $pnValueOfAccounts[$titlekey] = 0;
        $dueNextOfAccounts[$titlekey] = 0;
        $overDueOfAccounts[$titlekey] = 0;
        if($data[$titlekey]){
            foreach ($data[$titlekey] as $datakey => $datavalue) { ?> 
            <tr>
                <td style="text-align:left;"><?php echo $datavalue['transaction_account_number']; ?></td>
                <td style="text-align:left;"><?php echo $datavalue['fullname']; ?></td>
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
                <td colspan="8"><br/></td>
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
                <td colspan="8"><br/></td>
            </tr>
        <?php }else{ ?>

            <tr>
                <td colspan="8"><br/></td>
            </tr>
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

            