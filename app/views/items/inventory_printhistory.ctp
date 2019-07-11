 <style>
    @page{
        margin: 2%;
    }
    table{
        border-collapse: collapse;
    }
    .table{
        width: 100%;
    }
    .table td{
        text-align: center;
    }
    .table th{
        text-align: center;
    }
</style>
<table class="table table-striped table-bordered table-hover" style="font-size:16px;border-collapse: collapse;width: 100%;" border="1">
    <thead>
    	<tr>
    		<th colspan="2"> History for Serial No. <span style="color:blue;"><?php echo $serial_no; ?></span>  </th>
    	</tr>
   	<tr>
    		<th colspan="2"> BRAND : <span style="color:blue;"><?php echo $item['Brand']['name'] ; ?></span> ; MODEL : <span style="color:blue;"><?php echo $item['Model']['name'] ; ?></span> ; TYPE : <span style="color:blue;"><?php echo $item['Type']['name'] ; ?></span> </th>
    	</tr>
        <tr>
           <th style="width: 80%;">Note</th> 
           <th style="width: 20%;">DateTime</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value) { ?>
        	<tr>
        		<td><?php echo $value['ItemHistory']['note'] ?></td>
        		<td><?php echo $value['ItemHistory']['datetime'] ?></td>
        	</tr>
        <?php } ?>               
    </tbody>
</table>