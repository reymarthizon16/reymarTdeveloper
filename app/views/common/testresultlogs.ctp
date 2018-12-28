<style type="text/css">
	#testresultlogstemplate { width:100%; }
	#testresultlogstemplate tr td {  padding:5px;border:1px solid #A9A9A9;vertical-align:middle;}
	#testresultlogstemplate thead { text-align:center; font-weight:bold; background-color:#D6D6D6; }
	#testresultlogstemplate thead tr td { border:thin solid #A9A9A9;vertical-align:middle; }
	#testresultlogstemplate tbody tr:nth-child(even) { background-color:#D1D1D1; }
</style>
<div style="width:100%">

<table id="testresultlogstemplate">
	<thead>
		<tr>
			<td colspan="3">S.I. Unit</td>
			<td colspan="3">Conventional Unit</td>
			<td rowspan="3" style="width:15%;vertical-align:middle;">Date/Time Edited</td>
			<td rowspan="3" style="">User</td>
		</tr>
		<tr>
			<td>Result</td>
			<td style="">Unit</td>
			<td>Ref. Range</td>
			<td>Result</td>
			<td>Unit</td>
			<td>Ref. Range</td>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($data as $key=>$value)
		{
	?>
			<tr>
				<td colspan="8" style="background:grey;text-align:center;font-weight:bold;font-size:16px"><?php echo $value['name']?></td>
			</tr>
	<?php
			foreach($value['detail'] as $detailkey=>$detailvalue)
			{
	?>
			<tr>
				<td><?php echo $detailvalue['value']?></td>
				<td><?php echo $detailvalue['unit']?></td>
				<td><?php echo $detailvalue['reference_range']?></td>
				<td><?php echo $detailvalue['conventional_value']?></td>
				<td><?php echo $detailvalue['conventional_unit']?></td>
				<td><?php echo $detailvalue['conventional_reference_range']?></td>
				<td><?php echo $detailvalue['action_datetime']?></td>
				<td><?php echo $detailvalue['last_name'].", ".$detailvalue['first_name']?></td>
			</tr>
	<?php
			}
		}
	?>
	</tbody>
</table>
</div>
<script>
	
</script>