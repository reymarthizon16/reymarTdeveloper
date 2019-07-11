
<style type="text/css">
	.thcenter th{text-align: center;}
    #tableToExport td{
        text-align: center;
    }
    #tableToExport th{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inventory Reports</h1>
    </div>    
</div> 
<!-- <br> -->
<?php 
    debug($data);
  
    
?>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/inventory/reports/inventory_reports" method="POST">
                    
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
                <table id="tableToExport" class="table table-striped table-bordered table-hover" style="font-size:10px;">
                	<thead class="thcenter">
                        <tr>
                            <th colspan="<?php echo 3+count($branches)+3+count($branches)+6; ?>" style="text-align: center;font-size: 20px;">
                                Inventory Report ( <?php echo $filterBranches[$this->data['branch_id']] ?> )
                            </th>
                        </tr>
                        <tr>
                            <th colspan="<?php echo 3+count($branches)+3+count($branches)+6; ?>" style="text-align: center;font-size: 12px;">
                                Start Date : <?php echo $this->data['start_date']; ?> &nbsp; &nbsp; &nbsp; End Date : <?php echo $this->data['end_date']; ?>        
                            </th>
                        </tr>
                		<tr>
                			<th colspan="2"></th>
                			<th colspan="<?php echo count($branches)+3; ?>" >STOCK IN FROM</th>
                			<th colspan="<?php echo count($branches)+6; ?>" >STOCK IN TO</th>
                            <th></th>
                		</tr>
                		<tr>
                			<th colspan="5"></th>
                			<th colspan="<?php echo count($branches); ?>" >BRANCH</th>
                            <th colspan="4" >Customer</th>
                			<th colspan="2" >Stock Transfer</th>
                			<th colspan="<?php echo count($branches); ?>" >BRANCH</th>
                            <th></th>
                		</tr>
                		<tr>
                			<th>Model</th>     
                			<th>Prev</th>
                            <th>Prev(repo)</th>
                            <th>Customer(repo)</th>
                			<th>Delivered</th>
                			
                			<?php foreach ($branches as $brancheskey => $branchesvalue) {
                				echo "<th>".$branchesvalue."</th>";
                			} ?>

                			<th>Cash</th>
                			<th>INSTALL</th>
                            <th>COOP</th>
                			<th>REPLACEMENT</th>

                            <th>SC</th>
                            <th>Customer</th>

                			<?php foreach ($branches as $brancheskey => $branchesvalue) {
                				echo "<th>".$branchesvalue."</th>";
                			} ?>
                            <th>Ending</th>
                		</tr>
                	</thead>
                	<tbody>
                		<?php $total = array();
                        foreach ($models as $models_id => $modelsvalue) { 
                            $out = 0;
                            $in = 0;
                            if( isset($thisModelOnly[$models_id])) {
                        ?> 
	                		<tr>
	                			<td style="text-align: left;"><?php echo $modelsvalue; ?></td>
                                <td><?php echo $data['prevStock'][$models_id]['total']; $in += $data['prevStock'][$models_id]['total']; 
                                 $total['prevStock'] += $data['prevStock'][$models_id]['total']; ?></td>
                                <td><?php echo $data['prevRepo'][$models_id]['total']; $in += $data['prevRepo'][$models_id]['total']; 
                                 $total['prevRepo'] += $data['prevRepo'][$models_id]['total']; ?></td>
                                <td><?php echo $data['repoStock'][$models_id]['total']; $in += $data['repoStock'][$models_id]['total']; 
                                 $total['repoStock'] += $data['repoStock'][$models_id]['total']; ?></td>
	                			<td><?php echo $data['deliveryStock'][$models_id]['total']; $in += $data['deliveryStock'][$models_id]['total']; 
                                 $total['deliveryStock'] += $data['deliveryStock'][$models_id]['total']; ?></td>

	                			<?php foreach ($branches as $branch_id => $branchesvalue) {
                                    echo "<td>".$data['stockInFromBranch'][$models_id][$branch_id]['total']."</td>";
                                    $in += $data['stockInFromBranch'][$models_id][$branch_id]['total'];
                                    $total['stockInFromBranch'][$branch_id] += $data['stockInFromBranch'][$models_id][$branch_id]['total'];
                                } ?>

                                <td ><?php echo $data['stockInToCustomer'][$models_id][1]['total']; $out += $data['stockInToCustomer'][$models_id][1]['total']; 
                                    $total['stockInToCustomer'][1] += $data['stockInToCustomer'][$models_id][1]['total'];
                                 ?></td>
                                <td ><?php echo $data['stockInToCustomer'][$models_id][2]['total']; $out += $data['stockInToCustomer'][$models_id][2]['total']; 
                                    $total['stockInToCustomer'][2] += $data['stockInToCustomer'][$models_id][2]['total'];
                                 ?></td>
                                <td ><?php echo $data['stockInToCustomer'][$models_id][3]['total']; $out += $data['stockInToCustomer'][$models_id][3]['total']; 
                                    $total['stockInToCustomer'][3] += $data['stockInToCustomer'][$models_id][3]['total'];
                                 ?></td>
                                <td ><?php echo $data['stockInToCustomer'][$models_id][4]['total']; $out += $data['stockInToCustomer'][$models_id][4]['total']; 
                                    $total['stockInToCustomer'][4] += $data['stockInToCustomer'][$models_id][4]['total'];
                                 ?></td>

                                <td><?php echo $data['stockInToServiceCenter'][$models_id]['total'] ; $out += $data['stockInToServiceCenter'][$models_id]['total']; $stockInToServiceCenter+=$data['stockInToServiceCenter'][$models_id]['total'];  ?> 
                                </td> 
                                <td><?php echo $data['stockInToCustomer'][$models_id]['total'] ; $out += $data['stockInToCustomer'][$models_id]['total']; $stockInToCustomer+=$data['stockInToCustomer'][$models_id]['total'];  ?> 
                                </td> 

                                <?php foreach ($branches as $branch_id => $branchesvalue) {
	                				echo "<td>".$data['stockInToBranch'][$models_id][$branch_id]['total']."</td>";
                                    $out += $data['stockInToBranch'][$models_id][$branch_id]['total'];
                                    $total['stockInToBranch'][$branch_id] += $data['stockInToBranch'][$models_id][$branch_id]['total'];
	                			} ?>
                                <td><?php echo $in - $out;  $total['ending'] += $in - $out; ?></td>
	                		</tr>
                        <?php } ?>
                		<?php } ?>
                		<tr>
                            <td>TOTAL</td>
                            <td><?php echo $total['prevStock']; ?></td>
                            <td><?php echo $total['prevRepo']; ?></td>
                            <td><?php echo $total['repoStock']; ?></td>
                            <td><?php echo $total['deliveryStock']; ?></td>
                            <?php foreach ($branches as $branch_id => $branchesvalue) {
                                echo "<td>".$total['stockInFromBranch'][$branch_id]."</td>";
                            }?>
                            <td><?php echo $total['stockInToCustomer'][1] ?></td>
                            <td><?php echo $total['stockInToCustomer'][2] ?></td>
                            <td><?php echo $total['stockInToCustomer'][3] ?></td>
                            <td><?php echo $total['stockInToCustomer'][4] ?></td>
                            <?php foreach ($branches as $branch_id => $branchesvalue) {
                                echo "<td>".$total['stockInToBranch'][$branch_id]."</td>";
                            }?>
                            <td><?php echo $stockInToServiceCenter; ?></td>
                            <td><?php echo $stockInToCustomer; ?></td>
                            <td><?php echo $total['ending']; ?></td>
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
