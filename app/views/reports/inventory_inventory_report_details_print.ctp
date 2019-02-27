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
    #tableToExport tbody td{
        font-size: 10px;
    }
</style>

<table id="tableToExport" class="table  table-bordered table-hover" style="font-size:10px;" border="1" cellpadding="5">
    <thead class="thcenter">
        <tr>
            <th colspan="12" style="text-align: center;font-size: 20px;">
                Inventory Report ( <?php echo $filterBranches[$this->data['branch_id']] ?> )
            </th>
        </tr>
        <tr>
            <th colspan="12" style="text-align: center;font-size: 12px;">
                Start Date : <?php echo $this->data['start_date']; ?> &nbsp; &nbsp; &nbsp; End Date : <?php echo $this->data['end_date']; ?>        
            </th>
        </tr>
        <tr>
            <th colspan="4">STOCK IN</th>
            <th colspan="4"></th>
            <th colspan="4">STOCK OUT</th>
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
            <th>DR#</th>
            <th>TRANSFER</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($data['from_supplier'])){ ?>
        <tr>
            <td colspan="12" style="text-align:center;font-weight: bold;font-size:16px;"> <b>FROM SUPPLIER</b> </td>
        </tr>
         <?php } ?>
        <?php 
        foreach ($data['from_supplier'] as $fsuppkey => $fsuppvalue) { 
            $count = count($fsuppvalue['Serials']) +1;
            ?>
            <!--<tr>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_datetime'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['reference_no'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_report_no'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['company'] ?></td>
            -->    
                <!-- <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['model'] ?></td> -->                              
            <!--     <td colspan="7"></td>
            </tr> -->
                <?php 
                $tmp = '';
                if($count>1)
                foreach ($fsuppvalue['Serials'] as $Skey => $Svalue) { ?>
                    <tr>
                        <?php if( $tmp != $fsuppvalue['receiving_datetime'] ){ $tmp = $fsuppvalue['receiving_datetime']; ?>
                            <td style="text-align: center;" ><?php echo $fsuppvalue['receiving_datetime'] ?></td>
                            <td style="text-align: center;" ><?php echo $fsuppvalue['reference_no'] ?></td>
                            <td style="text-align: center;" ><?php echo $fsuppvalue['receiving_report_no'] ?></td>
                            <td style="text-align: center;" ><?php echo $fsuppvalue['company'] ?></td>
                        <?php }else{ ?>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                        <?php } ?>

                        <td><?php echo $Svalue['model'] ?></td>    
                        <td><?php echo $Svalue['serial_no'] ?></td>    
                        <td>1</td>
                        <td><?php echo $Svalue['net_price'] ?></td>  
                        <?php if(isset($stockOut[$Svalue['serial_no']])){ ?>  
                            <td><?php echo $stockOut[$Svalue['serial_no']]['stock_datetime']; ?></td>
                            <?php if($stockOut[$Svalue['serial_no']]['type'] ==1 ){ ?>
                                <td><?php echo $stockOut[$Svalue['serial_no']]['stock_transfer_no']; ?></td>
                                <td></td>
                            <?php }else{ ?>
                                <td></td>
                                <td><?php echo $stockOut[$Svalue['serial_no']]['stock_transfer_no']; ?></td>
                            <?php } ?>
                            <td><?php echo $stockOut[$Svalue['serial_no']]['branch']; ?></td>
                                <?php $stockOut[$Svalue['serial_no']]['used'] = 1 ; ?>
                        <?php } else{ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>

        <?php if(!empty($data['from_branch'])){ ?>
        <tr>
            <td colspan="12" style="text-align:center;font-weight: bold;font-size:16px;"> <b>FROM BRANCH</b> </td>
        </tr>
        <?php } ?>

        <?php 
        foreach ($data['from_branch'] as $fbranchkey => $fbranchvalue) { 
            $count = count($fbranchvalue['Serials']) +1;
            ?>
            <!-- <tr>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_datetime'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['reference_no'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_report_no'] ?></td>
                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['branch'] ?></td>
               --> 
                <!-- <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['model'] ?></td> -->    
            <!--    
                <td colspan="7"></td>                     
            </tr> -->
                <?php 
                $tmp = '';
                if($count>1)
                foreach ($fbranchvalue['Serials'] as $Bkey => $Bvalue) { ?>
                    <tr>
                        <?php if( $tmp != $fbranchvalue['receiving_datetime'] ){ $tmp = $fbranchvalue['receiving_datetime']; ?>
                            <td style="text-align: center;" ><?php echo $fbranchvalue['receiving_datetime'] ?></td>
                            <td style="text-align: center;" ><?php echo $fbranchvalue['reference_no'] ?></td>
                            <td style="text-align: center;" ><?php echo $fbranchvalue['receiving_report_no'] ?></td>
                            <td style="text-align: center;" ><?php echo $fbranchvalue['company'] ?></td>
                        <?php }else{ ?>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                            <td style="text-align: center;" > '' </td>
                        <?php } ?>                        

                        <td><?php echo $Bvalue['model'] ?></td>    
                        <td><?php echo $Bvalue['serial_no'] ?></td>    
                        <td>1</td>
                        <td><?php echo $Bvalue['net_price'] ?></td>   
                        <?php if(isset($stockOut[$Bvalue['serial_no']]) && $stockOut[$Bvalue['serial_no']]['stock_datetime'] > $fbranchvalue['receiving_datetime']){ ?> 
                            <td><?php echo $stockOut[$Bvalue['serial_no']]['stock_datetime']; ?></td>
                            <?php if($stockOut[$Bvalue['serial_no']]['type']==1){ ?>
                                <td><?php echo $stockOut[$Bvalue['serial_no']]['stock_transfer_no']; ?></td>
                                <td></td>
                            <?php }else{ ?>
                                <td></td>
                                <td><?php echo $stockOut[$Bvalue['serial_no']]['stock_transfer_no']; ?></td>
                            <?php } ?>
                            <td><?php echo $stockOut[$Bvalue['serial_no']]['branch']; ?></td>
                               <?php $stockOut[$Bvalue['serial_no']]['used'] = 1 ; ?>
                        <?php } else{ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>

        <?php if(!empty($data['from_previous'])){ ?>
        <tr>
            <td colspan="12" style="text-align:center;font-weight: bold;font-size:16px;"> <b>FROM PREVIOUS</b> </td>
        </tr>
        <?php } ?>

         <?php 
        foreach ($data['from_previous'] as $fprevkey => $fprevvalue) { 
            ?>
            <tr>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ><?php echo $fprevvalue['model'] ?></td>    
                <td ><?php echo $fprevvalue['serial'] ?></td>    
                <td >1</td>    
                <td ><?php echo $fprevvalue['net_price'] ?></td>    
                 <?php if(isset($stockOut[$fprevvalue['serial']])){ ?> 
                        <td><?php echo $stockOut[$fprevvalue['serial']]['stock_datetime']; ?></td>
                        <?php if($stockOut[$fprevvalue['serial']]['type']==1){ ?>
                            <td><?php echo $stockOut[$fprevvalue['serial']]['stock_transfer_no']; ?></td>
                            <td></td>
                        <?php }else{ ?>
                            <td></td>
                            <td><?php echo $stockOut[$fprevvalue['serial']]['stock_transfer_no']; ?></td>
                        <?php } ?>
                        <td><?php echo $stockOut[$fprevvalue['serial']]['branch']; ?></td>
                            <?php $stockOut[$fprevvalue['serial']]['used'] = 1 ; ?>
                    <?php } else{ ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    <?php } ?>
            </tr>
               
            <?php } ?>
        
        <?php if(!empty($stockOut)){ ?>
        <tr>
            <td colspan="12" style="text-align:center;font-weight: bold;font-size:16px;"> <b>STOCK OUT</b> </td>
        </tr>
        <?php } ?>

         <?php 
        sort($stockOut);    
        $stockOut=Set::sort($stockOut,'{n}.stock_datetime','asc');
        foreach ($stockOut as $stockOutkey => $stockOutvalue) { 
            if(!isset($stockOutvalue['used'] ) ){
            ?>
            <tr>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ><?php echo $stockOutvalue['model'] ?></td>    
                <td ><?php echo $stockOutvalue['serial_no'] ?></td>    
                <td >1</td>    
                <td ><?php echo $stockOutvalue['net_price'] ?></td>    
                <td><?php echo $stockOutvalue['stock_datetime']; ?></td>
                <?php if($stockOutvalue['type']==1){ ?>
                    <td><?php echo $stockOutvalue['stock_transfer_no']; ?></td>
                    <td></td>
                <?php }else{ ?>
                    <td></td>
                    <td><?php echo $stockOutvalue['stock_transfer_no']; ?></td>
                <?php } ?>
                <td><?php echo $stockOutvalue['branch']; ?></td>
            </tr>
               
            <?php } ?>
        <?php } ?>
    </tbody>

</table>