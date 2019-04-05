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