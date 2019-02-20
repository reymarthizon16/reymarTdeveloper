
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Items</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
                <form action="/inventory/items/index" method="POST">
                    
                    <div style="" class="filter">
                        <div class="form-group" style="">
                            <label>Status</label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[item_filter][Item.status][]" 
                                <?php 
                                    if(!empty($this->data['item_filter']['Item.status']))
                                        if(in_array("1",$this->data['item_filter']['Item.status'])){echo "checked";} ?> 
                                    value="1">NEUTRAL
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[item_filter][Item.status][]" 
                                <?php 
                                    if(!empty($this->data['item_filter']['Item.status']))
                                        if(in_array("2",$this->data['item_filter']['Item.status'])){echo "checked";} ?> 
                                    value="2">ON DELIVERY
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[item_filter][Item.status][]" 
                                <?php 
                                    if(!empty($this->data['item_filter']['Item.status']))
                                        if(in_array("3",$this->data['item_filter']['Item.status'])){echo "checked";} ?> 
                                    value="3">SOLD
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[item_filter][Item.status][]" 
                                <?php 
                                    if(!empty($this->data['item_filter']['Item.status']))
                                        if(in_array("5",$this->data['item_filter']['Item.status'])){echo "checked";} ?> 
                                    value="5">REPOSES
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[item_filter][Item.status][]" 
                                <?php 
                                    if(!empty($this->data['item_filter']['Item.status']))
                                        if(in_array("6",$this->data['item_filter']['Item.status'])){echo "checked";} ?> 
                                    value="6">Service Center
                            </label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div> 
                </form>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
               
                <?php //debug($items); ?>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>                            
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Model Name</th>
                            <th>Serial No.</th>                                                                                    
                            <th>SRP</th>
                            <th>NET</th>
                            <th>INCOME</th>
                            <th>Status</th>
                            <th>SC</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $key => $value) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['Type']['name']; ?></td>
                            <td><?php echo $value['Brand']['name']; ?></td>
                            <td><?php echo $value['Model']['name']; ?></td>
                            <td><?php echo $value['Item']['serial_no']; ?></td>
                            <td><?php echo $value['Item']['srp_price']; ?></td>
                            <td><?php echo $value['Item']['net_price']; ?></td>                            
                            <td><?php echo $value['Item']['sold_price']; ?></td>
                            <td>
                                <?php 
                                    if($value['Item']['status']==1)
                                        echo "NEUTRAL";
                                    if($value['Item']['status']==3)
                                        echo "<b style='color:green;'>OWNED</b>";
                                    if($value['Item']['status']==2)
                                        echo "<b style='color:red;'>ON DELIVERY</b>";
                                    if($value['Item']['status']==4 && $value['Item']['is_repair']==0)
                                        echo "<b style='color:red;'>Need to Repair</b>";
                                    if($value['Item']['status']==4 && $value['Item']['is_repair']==1)
                                        echo "<b style='color:red;'>Repaired</b>";
                                    if($value['Item']['status']==5)
                                        echo "<b style='color:red;'>Reposes</b>";
                                    if($value['Item']['status']==6)
                                        echo "<b style='color:red;'>On SC</b>";
                                ?>
                            </td>
                            <td><?php echo $value['RepairAccount']['company'] ?></td>
                            <td class="center">
                                <?php if( $value['Item']['is_replaced'] != '1'){ ?>
                                    <button class="btn btn-primary btn-sm viewHistorybtn" data-serial="<?php echo $value['Item']['serial_no'] ?>" data-toggle="modal" data-target="#itemHistory">History</button>     
                                    <a class="btn btn-success btn-sm" href="/inventory/items/edit/<?php echo $value['Item']['serial_no'] ?>">Edit</a>
                                <?php }else{ echo "Replaced by Serial <b style='color:red;'>".$value['Item']['new_serial_no'].""; }?>

                                <?php if( $value['Item']['status'] == '4' && !$value['Item']['is_repair']){ ?>
                                    <a class="btn btn-success btn-sm" href="/inventory/items/repair/<?php echo $value['Item']['serial_no'] ?>">HO Repair</a>
                                <?php } ?>
                            </td>
                        </tr>                       
                        <?php } ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
               
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
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

<div class="modal fade" id="itemSold" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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

        jQuery('.viewSoldbtn').click(function(){
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
    });
</script>