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

 <div class="tab-content">
    <?php    
    $active = false;
    $active_tab = "";           
    $branchkeyTotal = array();
    foreach ($branches as $branchkey => $branchvalue) { 
      
       if(!isset($branchkeyTotal[$branchkey])){
            $branchkeyTotal[$branchkey]['srp'] = 0;
            $branchkeyTotal[$branchkey]['net'] = 0;
       }

        if(!empty($this->data['branch_filter']['active']) && $this->data['branch_filter']['active'] == $branchkey){
            $active = true;
            $active_tab = "active in";
        }else $active_tab = "";  
        ?>                                                
        <div class="tab-pane fade <?php echo $active==0 && !isset($this->data['branch_filter']['active']) ?"active in":$active_tab; ?> " id="storage<?php echo $branchkey; ?>">
            

             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                      
                        <!-- /.panel-heading -->
                        <h3><?php echo $branchvalue; ?> Storage</h3>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="" border="1" cellpadding="4">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Brand</th>
                                        <th>Type</th>
                                        <th>Model Name</th>
                                        <th>Serial No.</th>                                                        
                                        <th>Qty</th>
                                        <th>SRP</th>
                                        <th>NET</th>
                                        <th>INCOME</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //debug($storages);
                                    if(!empty($storages[$branchkey]))
                                    foreach ($storages[$branchkey] as $storageskey => $storagesvalue) { ?>
                                        
                                         <tr class="">
                                            <td><?php echo $storagesvalue['Storage']['id'] ?></td>
                                            <td><?php echo $brands[$storagesvalue['Item']['brand_id']] ?></td>
                                            <td><?php echo $types[$storagesvalue['Item']['type_id']] ?></td>                                                
                                            <td><?php echo $models[$storagesvalue['Item']['model_id']] ?></td>
                                            <td><?php echo $storagesvalue['Item']['serial_no'] ?></td>
                                            <td class="center"><?php echo $storagesvalue['Item']['quantity'] ?></td>
                                            <td class="center"><?php echo $storagesvalue['Item']['srp_price'] ?></td>
                                            <td class="center"><?php echo $storagesvalue['Item']['net_price'] ?></td>
                                            <?php 
                                                if($storagesvalue['Storage']['status']==1 || $storagesvalue['Storage']['status']==5){
                                                    $branchkeyTotal[$branchkey]['srp']+=$storagesvalue['Item']['srp_price'];
                                                    $branchkeyTotal[$branchkey]['net']+=$storagesvalue['Item']['net_price'];
                                                }
                                            ?>
                                            <td class="center"><?php echo $storagesvalue['Item']['sold_price'] ?></td>
                                            <td class="center"><?php 

                                                if($storagesvalue['Storage']['status']==1)
                                                    echo "NEUTRAL";
                                                if($storagesvalue['Storage']['status']==2)
                                                    echo "<b style='color:red;'>ON DELIVERY</b>";
                                                if($storagesvalue['Storage']['status']==3)
                                                    echo "<b style='color:red;'>Defective</b>";
                                            ?></td>
                                            
                                        </tr>

                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                           <h4>Total SRP:  <strong><?php echo number_format($branchkeyTotal[$branchkey]['srp'],2); ?> </strong></h4>
                           <h4>Total NET: <strong><?php echo number_format($branchkeyTotal[$branchkey]['net'],2); ?> </strong></h4>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
         
        </div>
        <?php $active = true; ?>
    <?php } ?>                   
</div>