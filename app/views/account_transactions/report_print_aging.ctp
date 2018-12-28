
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
    <table class="table" style="text-align: center;" >
        <tr>
            <td>City Trust Appliance Center</td>
        </tr>
        <tr>
            <td>2005-2018 AGING ANALYSIS PER FIELD REPRESENTATIVE</td>
        <tr>
            <td>For The Month Ended <?php echo $month[$this->data['month']]." ".$year[$this->data['year']] ?></td>
        </tr>
        </tr>
        <tr>
            <td>
                <!-- Page No: &#160;&#160;{PAGENO} of {nbpg} -->
                <br>
            </td>
        </tr>
        <tr>
            <td>
                OVERALL-MAHARLIKA
                <?php echo $filterBranches[$this->data['branch_id']] ?></td>
        </tr>
    </table>
</htmlpageheader>

<sethtmlpageheader name="myHTMLHeader1" />

<?php $titles = array(0=>'New Accounts','updated'=>'Updated Accounts',1=>'One Month Overdue',2=>'Two Month Overdue', 3=>'Three Month Overdue','matured'=>'Matured Accounts'); ?>

<table id="tableToExport" class="table table-striped table-bordered table-hover" style="" border="1" cellpadding="5">
	<tr>
        <th style="width: 20%;"></th>   
        <th style="width: 15%;"># of Accts.</th>   
        <th style="width: 15%;">PN Balance</th>   
        <th style="width: 15%;">Due Next</th>   
        <th style="width: 15%;">Amt. OD</th>   
        <th style="width: 15%;">Target Coll.</th>
        <th style="width: 15%;">OD %</th>
        
    </tr>

    <?php foreach ($titles as $titlekey => $titlevalue) { ?>
       
        <?php 
        $numOfAccounts[$titlekey] = 0;
        $pnValueOfAccounts[$titlekey] = 0;
        $dueNextOfAccounts[$titlekey] = 0;
        $overDueOfAccounts[$titlekey] = 0;
        if($data[$titlekey]){
            foreach ($data[$titlekey] as $datakey => $datavalue) { ?> 
            
            <?php 
                $numOfAccounts[$titlekey] += 1;
                $pnValueOfAccounts[$titlekey] += $datavalue['pn_balance'];
                $dueNextOfAccounts[$titlekey] += $datavalue['due_next']>=0?$datavalue['due_next']:0; 
                $overDueOfAccounts[$titlekey] += $datavalue['total_overDue']>=0?$datavalue['total_overDue']:0; 
             ?>                        
            <?php } ?>
            
            <tr>
                <td><?php echo $titlevalue; ?></td>
                <td><?php echo $numOfAccounts[$titlekey]; ?> ACCOUNTS</td>
                <td><?php echo number_format($pnValueOfAccounts[$titlekey],2); ?></td>
                <td><?php echo number_format($dueNextOfAccounts[$titlekey],2); ?></td>
                <td></td>
                <td></td>
                <td></td>
               
            </tr>
            
        <?php }else{ ?>

            
             <tr>
                <td><?php echo $titlevalue; ?></td>
                <td>0 ACCOUNTS</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td></td>
               
            </tr>
        <?php } ?>
    <?php } ?>

</table>

            