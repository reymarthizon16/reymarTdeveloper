
<style type="text/css">
	.thcenter th{text-align: center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inventory Monthly Sales Reports</b>
    </div>    
</div> 
<!-- <br> -->
<?php debug($data) ?>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
            	<form action="/inventory/reports/sales_report" method="POST">
                    
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
                            <th colspan="7" style="text-align: center;font-size: 20px;">
                                Monthly Sales Report ( <?php echo $filterBranches[$this->data['branch_id']] ?> )
                            </th>
                        </tr>
                        <tr>
                            <th colspan="7" style="text-align: center;font-size: 12px;">
                                Start Date : <?php echo $this->data['start_date']; ?> &nbsp; &nbsp; &nbsp; End Date : <?php echo $this->data['end_date']; ?>        
                            </th>
                        </tr>
                        <tr>
                            <th>DR #</th>
                            <th>DR DATETIME</th>
                            <th>SERIAL NO.</th>
                            <th>MODEL</th>
                            <th>TYPE</th>
                            <th>COLLECTION TYPE</th>
                            <th>PRICE</th>                            
                        </tr>
                	</thead>
                    <tbody>
                       <?php 
                       $price = 0;
                       $collection_types = array();
                       $collection_typesPrice = array();
                       foreach ($data as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value['Reports']['delivery_receipt_no'] ?></td>
                            <td><?php echo $value['Reports']['delivery_datetime'] ?></td>
                            <td><?php echo $value['Reports']['serial_no'] ?></td>
                            <td><?php echo $value['Reports']['model_name'] ?></td>
                            <td><?php echo $value['Reports']['type_name'] ?></td>
                            <td><?php 
                                echo $value['Reports']['collection_types']; 
                                $collection_types[ $value['Reports']['collection_types'] ] += 1;
                                $collection_typesPrice[ $value['Reports']['collection_types'] ] += $value['Reports']['sold_price'];
                            ?></td>
                            <td><?php echo $value['Reports']['sold_price']; $price += $value['Reports']['sold_price']; ?></td>
                        </tr> 
                       <?php } ?>
                       <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>                           
                           <td></td>                           
                           <td colspan="1" style="text-align: left;">
                               <?php foreach ($collection_types as $collectiontypesk => $collectiontypesv) {
                                   echo $collectiontypesk.' ( '.$collectiontypesv.' )  =<b> P '.number_format($collection_typesPrice[$collectiontypesk],2).'</b> <br>';
                               } ?>
                           </td>
                           <td style="vertical-align: middle;font-weight: bold;"> P <?php echo number_format($price,2); ?></td>
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
