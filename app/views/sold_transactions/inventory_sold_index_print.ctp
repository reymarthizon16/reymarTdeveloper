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
foreach ($this->data as $rrkey => $rrvalue) { ?>
<table style="width: 100%;border-collapse: collapse;" border="1" class="table table-striped table-bordered table-hover" id="">
    <tr>
        <td style="width: 25%;">Delivery Receipt # : <strong><?php echo $rrvalue['SoldTransaction']['delivery_receipt_no'] ?></strong></td>
        <td style="width: 25%;">Owned By :  <strong><?php echo $rrvalue['OwnedAccount']['last_name'].", ".$rrvalue['OwnedAccount']['first_name'] ?></strong></td>
        <td style="width: 25%;">Collection Type : <strong><?php echo $collectionTypes[$rrvalue['SoldTransaction']['collection_type_id']] ?></strong></td>
        <td style="width: 25%;">DateTime : <strong><?php echo $rrvalue['SoldTransaction']['delivery_datetime'] ?></strong></td>       
    </tr>
    <tr>
        <td colspan="4" style="text-align: center;">
            <table style="width: 700px;border-collapse: collapse;font-size: 12px;" border="1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>From</th><th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>Sold</th><th>Reposes</th><th>Datetime</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($rrvalue['SoldTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                        <tr>
                            <td width="10%"><?php echo $branches[$rtdvalue['from_branch_id']] ?></td>
                            <td width="15%"><?php echo $types[$items[$rtdvalue['serial_no']]['type_id']] ?></td>
                            <td width="15%"><?php echo $models[$items[$rtdvalue['serial_no']]['model_id']] ?></td>
                            <td width="10%"><?php echo $rtdvalue['serial_no'] ?></td>
                            <td width="10%"><?php echo $items[$rtdvalue['serial_no']]['srp_price'] ?></td>
                            <td width="10%"><?php echo $items[$rtdvalue['serial_no']]['net_price'] ?></td>                                            
                            <td width="10%"><?php echo $items[$rtdvalue['serial_no']]['sold_price'] ?></td>                                            
                            <td width="10%"><?php echo $rtdvalue['reposes']=1?"Yes":''; ?></td>
                            <td width="10%"><?php echo $rtdvalue['reposes_datetime'] ?></td>
                        </tr>    
                    <?php } ?>
                    
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td >Sold By : <strong><?php echo $rrvalue['SoldByUser']['last_name'].", ".$rrvalue['SoldByUser']['first_name'] ?></strong></td>        
        <td colspan="2"> Type : <strong>Sales</strong> </td>
        <td >Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
      
    </tr>
</table>
 <hr />
<?php } ?>   