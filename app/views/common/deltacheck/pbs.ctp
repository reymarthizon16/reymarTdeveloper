<style type="text/css">
	#deltachecktable { width:100%; }
	#deltachecktable tr td {  width:15%; padding:5px;}
	#deltachecktable thead { text-align:center; font-weight:bold; background-color:#B0B0B0; }
	#deltachecktable thead tr td { border:thin solid; }
	#deltachecktable tbody tr:nth-child(even) { background-color:#D1D1D1; }
</style>
<table id='deltachecktable'>
	<thead>
		<tr>
			<td colspan="2">Delta Check</td>
		</tr>
		<tr>
			<td style="width:20%;">Date Time Released</td>
			<td style="width:80%">Result</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach($specimenids as $specimenkey=>$specimenid)
			{
		?>
			<tr>
				<td valign="top" font-weight:bold;>
					<?php echo $data[$specimenid]['release_date']." ".$data[$specimenid]['release_time'];?>
					<br />
					Location: <?php echo $data[$specimenid]['location'];?>
				</td>
				<td>
					<?php 
						if($data[$specimenid]['pbsassessment'])
							echo $data[$specimenid]['pbsassessment']['TestOrderDetail']['TestOrderResult']['value']."<br /><br />";
						
						if($data[$specimenid]['pbsfindings'])
							echo $data[$specimenid]['pbsassessment']['TestOrderDetail']['TestOrderResult']['value']."<br /><br />";
					?>
				</td>
			</tr>
		<?php 
			}
		?>
	</tbody>
</table>
