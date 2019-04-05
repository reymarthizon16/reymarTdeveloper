
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Sales Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button style="" type="button" onclick="window.location='/inventory/sold_transactions/sold_items';" class="btn btn-primary">Add Sales </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                
                <?php echo $this->Form->create('SoldTransaction');?>
                <div class="row">
                    <div class="col-lg-2">
                    Delivery Receipt # : <?php echo $this->Form->input('filter.deliveryT_no',array('label'=>false,'type'=>'text','value'=>$filter['deliveryT_no'])); ?> </div>
                    <div class="col-lg-2">
                    Start Date Received : <?php echo $this->Form->input('filter.start_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['start_date'])); ?> </div>
                    <div class="col-lg-2"> 
                    End Date Received : <?php echo $this->Form->input('filter.end_date',array('class'=>'datepicker','label'=>false,'type'=>'text','value'=>$filter['end_date'])); ?> </div>
                    <div class="col-lg-2" style="padding-top: 15px;">
                          <!-- <button type="reset" class="btn btn-success">Reset</button>   -->
                          <button type="submit" class="btn btn-success">Filter</button>  
                          <button type="submit" name="data[print]" value="" id="printPlease" class="btn btn-success print">Print</button>  
                    </div>
                </div>
                
                <?php 
                foreach ($this->data as $rrkey => $rrvalue) { ?>
                <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover" id="">
                    <tr>
                        <td>Delivery Receipt # : <strong><?php echo $rrvalue['SoldTransaction']['delivery_receipt_no'] ?></strong></td>
                        <td>Owned By :  <strong><?php echo $rrvalue['OwnedAccount']['last_name'].", ".$rrvalue['OwnedAccount']['first_name'] ?></strong></td>
                        <td>Collection Type : <strong><?php echo $collectionTypes[$rrvalue['SoldTransaction']['collection_type_id']] ?></strong></td>
                        <td>DateTime : <strong><?php echo $rrvalue['SoldTransaction']['delivery_datetime'] ?></strong></td>
                        <td>
                            <button type="button" class="btn btn-outline btn-sm btn-info" onclick="window.open('/inventory/sold_transactions/sold_items/<?php echo $rrvalue['SoldTransaction']['id'] ?>','_blank');">Edit</button>
                            <button type="button" class="btn btn-outline btn-sm btn-success"  
                                onclick="print_this('<?php echo $rrvalue['SoldTransaction']['delivery_receipt_no']; ?>')">Print</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table style="width: 100%;" border="1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>From</th><th>Type</th><th>Model</th><th>Serial No.</th><th>SRP</th><th>Net</th><th>Sold</th><th>Reposes</th><th>Datetime</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($rrvalue['SoldTransactionDetail'] as $rtdkey => $rtdvalue) { ?>
                                        <tr>
                                            <td><?php echo $branches[$rtdvalue['from_branch_id']] ?></td>
                                            <td><?php echo $types[$items[$rtdvalue['serial_no']]['type_id']] ?></td>
                                            <td><?php echo $models[$items[$rtdvalue['serial_no']]['model_id']] ?></td>
                                            <td><?php echo $rtdvalue['serial_no'] ?></td>
                                            <td><?php echo $items[$rtdvalue['serial_no']]['srp_price'] ?></td>
                                            <td><?php echo $items[$rtdvalue['serial_no']]['net_price'] ?></td>                                            
                                            <td><?php echo $items[$rtdvalue['serial_no']]['sold_price'] ?></td>                                            
                                            <td><?php echo $rtdvalue['reposes']==1?"Yes":''; ?></td>
                                            <td><?php echo $rtdvalue['reposes_datetime'] ?></td>
                                        </tr>    
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Sold By : <strong><?php echo $rrvalue['SoldByUser']['last_name'].", ".$rrvalue['SoldByUser']['first_name'] ?></strong></td>
                        <td></td>
                        <td colspan="2">Deliver By : <strong><?php echo $rrvalue['DeliverByUser']['last_name'].", ".$rrvalue['DeliverByUser']['first_name'] ?></strong></td>
                      
                    </tr>
                </table>
                <?php } ?>                      
                <?php echo $this->Form->end();?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script>
    function print_this(stocktransNo){
        jQuery('#filterStockTNo').val(stocktransNo);
        jQuery('#printPlease').trigger('click');
    }
</script>