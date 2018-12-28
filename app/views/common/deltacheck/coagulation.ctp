<style type="text/css">
	#deltachecktable { width:100%; }
	#deltachecktable tr td {  width:15%; padding:5px;}
	#deltachecktable thead { text-align:center; font-weight:bold; background-color:#B0B0B0; }
	#deltachecktable thead tr td { border:thin solid; }
	#deltachecktable tbody tr:nth-child(even) { background-color:#D1D1D1; }
	#deltachecktable .filler { text-align:center; font-weight:bold; }
</style>

<table id='deltachecktable'>
	<thead>
		<tr>
			<td rowspan="2" valign="middle">Test Name</td>
			<td colspan="6">Delta Check</td>
		</tr>
		<tr>			
			<?php
				foreach($specimenids as $specimenidkey=>$specimenid)
				{
			?>
					<td>
						<span style="font-weight:bold;"><?php echo $specimenid?></span><br /><br />
						<span style="font-weight:normal"><?php echo $data[$specimenid]['release_date']." ".$data[$specimenid]['release_time']?></span><br /><br />
						<span style="font-weight:normal">Location: <?php echo $data[$specimenid]['location'] ?></span>
					</td>
			<?php 
				}
				
				if(count($specimenids) <= 6)
				{
					for($filler = 6 - count($specimenids); $filler!=0;$filler--)
						echo "<td class='filler'></td>";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach($testcode as $testid=>$testname)
			{
		?>
			<tr>
				<td><?php echo $testname?></td>
				<?php 
					foreach($specimenids as $specimenidkey=>$specimenid)
					{
				?>
					<td>
						<?php 
							if(isset($data[$specimenid][$testid]))
								echo $data[$specimenid][$testid]['TestOrderDetail']['TestOrderResult']['value'];
						?>
					</td>
				<?php 
					}
					
					if(count($specimenids) <= 6)
					{
						for($filler = 6 - count($specimenids); $filler>0;$filler--)
							echo "<td class='filler'></td>";
					}
				?>
			</tr>
		<?php 
			}
		?>
	</tbody>
</table>
