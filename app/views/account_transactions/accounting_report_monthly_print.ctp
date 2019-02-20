
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
    #tableToExport th{font-size: 10px;}
    #tableToExport td{font-size: 12px;text-align: center;}
    #tableToExport{border-collapse: collapse;}
</style>
<htmlpageheader name="myHTMLHeader1">
    <table class="table" style="text-align: center;" >
        <tr>
            <td>City Trust Appliance Center</td>
        </tr>
        <tr>
            <td>Monthly Cash Collection Summary</td>    
        </tr>        
        <tr>
            <td>
                <!-- Page No: &#160;&#160;{PAGENO} of {nbpg} -->
                <br>
            </td>
        </tr>
        <tr>
            <td><?php echo $filterBranches[$this->data['branch_id']] ?></td>
        </tr>
    </table>
</htmlpageheader>


<table id="tableToExport" class="table table-striped table-bordered table-hover" style="font-size:10px;" cellpadding="5" border="1">
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
