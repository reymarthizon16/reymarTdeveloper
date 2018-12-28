<!--  <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Warehouse</h1>
    </div>
</div> -->
<?php //debug($branches); ?>
<br>
 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Warehouse
                <div style="float: right;">
                    <a class="btn btn-success btn-sm" href="/inventory/items/add">Add Item</a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <?php   
                    $active = false;
                    $active_tab = "";                  
                    foreach ($branches as $branchkey => $branchvalue) { 

                        if(!empty($this->data['branch_filter']['active']) && $this->data['branch_filter']['active'] == $branchkey){
                            $active = true;
                            $active_tab = "active in";
                        }else $active_tab = "";  
                        ?>
                        <li class="<?php echo $active==0 && !isset($this->data['branch_filter']['active']) ?"active":$active_tab; ?> ">
                            <a href="#storage<?php echo $branchkey; ?>" data-toggle="tab" ><?php echo $branchvalue; ?></a>
                        </li>
                        <?php $active = true; ?>
                    <?php } ?>
                   
                </ul>

                <!-- Tab panes -->
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
                                        <div class="panel-heading">
                                            <?php //echo $value; ?>
                                            <form action="/inventory/storages/index" method="POST">
                                                <input type="hidden" name="data[branch_filter][active]" value="<?php echo $branchkey?>">
                                                <input type="hidden" name="data[branch_filter][<?php echo $branchkey?>][branch_id]" value="<?php echo $branchkey?>">
                                                <div style="display: none;" class="filter">
                                                    <div class="form-group" style="">
                                                        <label>Status</label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][storage.status][]" 
                                                            <?php 
                                                                if(!empty($this->data['branch_filter'][$branchkey]['storage.status']))
                                                                    if(in_array("1",$this->data['branch_filter'][$branchkey]['storage.status'])){echo "checked";} ?> 
                                                                value="1">NEUTRAL
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][storage.status][]" 
                                                            <?php 
                                                                if(!empty($this->data['branch_filter'][$branchkey]['storage.status']))
                                                                    if(in_array("2",$this->data['branch_filter'][$branchkey]['storage.status'])){echo "checked";} ?> 
                                                                value="2">ON DELIVERY
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][storage.status][]" 
                                                            <?php 
                                                                if(!empty($this->data['branch_filter'][$branchkey]['storage.status']))
                                                                    if(in_array("5",$this->data['branch_filter'][$branchkey]['storage.status'])){echo "checked";} ?> 
                                                                value="5">REPOSES
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][storage.status][]" 
                                                            <?php 
                                                                if(!empty($this->data['branch_filter'][$branchkey]['storage.status']))
                                                                    if(in_array("6",$this->data['branch_filter'][$branchkey]['storage.status'])){echo "checked";} ?> 
                                                                value="6">Service Center
                                                        </label>
                                                    </div>
                                                    <div class="form-group" style="">
                                                        <label>Model</label>
                                                        <?php foreach ($models as $key => $value) { ?>
                                                             <label class="checkbox-inline" style="">
                                                                <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][model_id][]" 
                                                                <?php
                                                                    if(!empty($this->data['branch_filter'][$branchkey]['model_id']))
                                                                        if(in_array($key,$this->data['branch_filter'][$branchkey]['model_id'])){echo "checked";} ?> value="<?php echo $key; ?>"><?php echo $value; ?>
                                                            </label>
                                                        <?php } ?>
                                                    </div>
                                                     <div class="form-group" style="">
                                                        <label>Brand</label>
                                                        <?php foreach ($brands as $key => $value) { ?>
                                                             <label class="checkbox-inline" style="">
                                                                <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][brand_id][]" 
                                                                <?php
                                                                    if(!empty($this->data['branch_filter'][$branchkey]['brand_id']))
                                                                        if(in_array($key,$this->data['branch_filter'][$branchkey]['brand_id'])){echo "checked";} ?> value="<?php echo $key; ?>"><?php echo $value; ?>
                                                            </label>
                                                        <?php } ?>
                                                    </div>
                                                     <div class="form-group" style="">
                                                        <label>Type</label>
                                                        <?php foreach ($types as $key => $value) { ?>
                                                             <label class="checkbox-inline" style="">
                                                                <input type="checkbox" name="data[branch_filter][<?php echo $branchkey?>][type_id][]" 
                                                                <?php
                                                                    if(!empty($this->data['branch_filter'][$branchkey]['type_id']))
                                                                        if(in_array($key,$this->data['branch_filter'][$branchkey]['type_id'])){echo "checked";} ?> value="<?php echo $key; ?>"><?php echo $value; ?>
                                                            </label>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <button class="showfilter btn btn-primary">Show Filter</button>
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                                <button type="submit" name="data[branch_filter][print]" class="btn btn-primary" value="<?php echo $branchkey; ?>">Print</button>
                                            </form>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <table width="100%" class="table table-striped table-bordered table-hover dataTables-example" >
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
                                                        <th>SC</th>
                                                        <th>View</th>
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
                                                                    echo "<b style='color:red;'>OWNED</b>";
                                                                if($storagesvalue['Storage']['status']==4 && $storagesvalue['Item']['is_repair'] == 0)
                                                                    echo "<b style='color:red;'>Need to Repair</b>";
                                                                if($storagesvalue['Storage']['status']==4 && $storagesvalue['Item']['is_repair'] == 1)
                                                                    echo "<b style='color:red;'>Repaired</b>";
                                                                if($storagesvalue['Storage']['status']==5)
                                                                    echo "<b style='color:red;'>Reposes</b>";
                                                                if($storagesvalue['Storage']['status']==6)
                                                                    echo "<b style='color:red;'>on SC</b>";
                                                            ?></td>
                                                            <td><?php echo $serviceAccountId[$storagesvalue['Item']['repair_on_account_id']] ?></td>
                                                            <td class="center">                                                                
                                                                <button class="btn btn-primary btn-sm viewHistorybtn" data-serial="<?php echo $storagesvalue['Item']['serial_no'] ?>" data-toggle="modal" data-target="#itemHistory">History</button>

                                                                 <?php if( $storagesvalue['Item']['status'] == '4' && !$storagesvalue['Item']['is_repair']){ ?>
                                                                    <a class="btn btn-success btn-sm" href="/inventory/items/repair/<?php echo $storagesvalue['Item']['serial_no'] ?>">HO Repair</a>
                                                                <?php } ?>

                                                                <?php if( $storagesvalue['Item']['status'] == '1' ){ ?>
                                                                    <a class="btn btn-danger btn-sm" href="/inventory/items/needrepair/<?php echo $storagesvalue['Item']['serial_no'] ?>">Mark as Defect</a>
                                                                <?php } ?>
                                                            </td>
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
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>

<div class="modal fade" id="itemHistory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <table style="width:100%;" border="1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                           <th style="width: 80%;">Note</th> 
                           <th style="width: 20%;">DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                                             
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    jQuery(document).ready(function(){
        jQuery('.viewHistorybtn').click(function(){
            console.log(jQuery(this).attr('data-serial'));

            var dataa = [                    
                    {name:'data[serial_no]',value:jQuery(this).attr('data-serial')},                                                                                
                    ];

            jQuery('#myModalLabel').text('History for Serial No '+jQuery(this).attr('data-serial'));

            jQuery.ajax({
                async:false,
                data:dataa,
                url:'/inventory/items/getHistory',
                type:'POST',
                dataType:'json',
                success:function(data){             
                    if(data){
                                            
                        jQuery('#itemHistory table tbody').empty();
                        jQuery.each(data,function(key,value){
                            console.log(value);
                            jQuery('#itemHistory table tbody').append('<tr><td>'+value.ItemHistory.note+'</td><td>'+value.ItemHistory.datetime+'</td></tr>');
                        });
                      
                    }else{
                    
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });
        });

        jQuery('.showfilter').click(function(){
            jQuery(".filter").toggle();
            return false;
        });
    });
</script>