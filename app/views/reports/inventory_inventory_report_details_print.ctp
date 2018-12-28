 <style>
    @page{
        margin: 2%;
    }
    table{
        border-collapse: collapse;
    }
    table td{
        text-align: center;
    }
    .table{
        width: 100%;
    }
</style>

<table id="tableToExport" class="table  table-bordered table-hover" style="font-size:10px;" border="1" cellpadding="5">
    <thead class="thcenter">
        <tr>
            <th colspan="11" style="text-align: center;font-size: 20px;">
                Inventory Report ( <?php echo $filterBranches[$this->data['branch_id']] ?> )
            </th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center;font-size: 12px;">
                Start Date : <?php echo $this->data['start_date']; ?> &nbsp; &nbsp; &nbsp; End Date : <?php echo $this->data['end_date']; ?>        
            </th>
        </tr>
        <tr>
            <th colspan="4">STOCK IN</th>
            <th colspan="4"></th>
            <th colspan="3">STOCK OUT</th>
        </tr>
        <tr>
            <th>DATE</th>
            <th>REF#</th>
            <th>RR#</th>
            <th>SOURCE</th>
            <th>MODEL</th>
            <th>SERIAL</th>
            <th>QTY</th>
            <th>NET</th>
            <th>DATE</th>
            <th>REF#</th>
            <th>TRANSFER</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($data['from_supplier'] as $fsuppkey => $fsuppvalue) { 
            $count = count($fsuppvalue['Serials']) +1;
            ?>
            <tr>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_datetime'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['reference_no'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_report_no'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['company'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['model'] ?></td> 
                <td colspan="6"></td>
            </tr>
                <?php 
                if($count>1)
                foreach ($fsuppvalue['Serials'] as $Skey => $Svalue) { ?>
                    <tr>
                        <td><?php echo $Svalue['serial_no'] ?></td>    
                        <td>1</td>
                        <td><?php echo $Svalue['net_price'] ?></td>  
                        <?php if(isset($stockOut[$Svalue['serial_no']])){ ?>  
                            <td><?php echo $stockOut[$Svalue['serial_no']]['stock_datetime']; ?></td>
                            <td><?php echo $stockOut[$Svalue['serial_no']]['stock_transfer_no']; ?></td>
                            <td><?php echo $stockOut[$Svalue['serial_no']]['branch']; ?></td>
                        <?php } else{ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>

        <?php 
        foreach ($data['from_branch'] as $fbranchkey => $fbranchvalue) { 
            $count = count($fbranchvalue['Serials']) +1;
            ?>
            <tr>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_datetime'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['reference_no'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_report_no'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['branch'] ?></td>
                <td  style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['model'] ?></td>
                <td colspan="6"></td>
            </tr>
                <?php 
                if($count>1)
                foreach ($fbranchvalue['Serials'] as $Bkey => $Bvalue) { ?>
                    <tr>
                        <td><?php echo $Bvalue['serial_no'] ?></td>    
                        <td>1</td>
                        <td><?php echo $Bvalue['net_price'] ?></td>   
                        <?php if(isset($stockOut[$Bvalue['serial_no']])){ ?> 
                            <td><?php echo $stockOut[$Bvalue['serial_no']]['stock_datetime']; ?></td>
                            <td><?php echo $stockOut[$Bvalue['serial_no']]['stock_transfer_no']; ?></td>
                            <td><?php echo $stockOut[$Bvalue['serial_no']]['branch']; ?></td>
                        <?php } else{ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>
        
    </tbody>

</table>