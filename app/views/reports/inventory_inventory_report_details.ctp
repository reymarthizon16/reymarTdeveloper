
<style type="text/css">
	.thcenter th{text-align: center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inventory Reports</h1>
    </div>    
</div> 
<!-- <br> -->
<?php debug($data) ?>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/inventory/reports/inventory_report_details" method="POST">
                    
                    <?php echo $this->Form->input('start_date',array('class'=>'datepicker','type'=>'text','div'=>false)); ?>
                    <?php echo $this->Form->input('end_date',array('class'=>'datepicker','type'=>'text','div'=>false)); ?>
                    <?php echo $this->Form->input('branch_id',array('type'=>'select','div'=>false,'options'=>$filterBranches)); ?>

                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="submit" name="data[print]" value="1" id="printPlease" class="btn btn-success btn-sm print">Print</button>  
                    <button id="export" class="btn btn-success btn-sm export">Export</button>  
                </form>

            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table id="tableToExport" class="table  table-bordered table-hover" style="font-size:10px;">
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
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_datetime'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['reference_no'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['receiving_report_no'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['company'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fsuppvalue['model'] ?></td>                              
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
                                                <?php $stockOut[$Svalue['serial_no']]['used'] = 1 ; ?>
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
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_datetime'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['reference_no'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['receiving_report_no'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['branch'] ?></td>
                                <td style="vertical-align:top;" rowspan="<?php echo $count; ?>"><?php echo $fbranchvalue['model'] ?></td>    
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
                                               <?php $stockOut[$Bvalue['serial_no']]['used'] = 1 ; ?>
                                        <?php } else{ ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
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
                                        <td><?php echo $stockOut[$fprevvalue['serial']]['stock_transfer_no']; ?></td>
                                        <td><?php echo $stockOut[$fprevvalue['serial']]['branch']; ?></td>
                                            <?php $stockOut[$fprevvalue['serial']]['used'] = 1 ; ?>
                                    <?php } else{ ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                            </tr>
                               
                            <?php } ?>
                        
                         <?php 
                        foreach ($stockOut as $stockOutkey => $stockOutvalue) { 
                            if(!isset($stockOut[$stockOutkey]['used'] ) ){
                            ?>
                            <tr>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ><?php echo $stockOutvalue['model'] ?></td>    
                                <td ><?php echo $stockOutkey ?></td>    
                                <td >1</td>    
                                <td ><?php echo $stockOutvalue['net_price'] ?></td>    
                                <td><?php echo $stockOutvalue['stock_datetime']; ?></td>
                                <td><?php echo $stockOutvalue['stock_transfer_no']; ?></td>
                                <td><?php echo $stockOutvalue['branch']; ?></td>
                            </tr>
                               
                            <?php } ?>
                        <?php } ?>
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
