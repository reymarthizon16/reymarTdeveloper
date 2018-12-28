
<style type="text/css">
	#deltachecktable { width:100%; border:thin solid;}
	#deltachecktable td.header {  width:15%; padding:5px;}
	#deltachecktable thead { text-align:center; font-weight:bold; background-color:#B0B0B0; }
	#deltachecktable thead tr td { border:thin solid; }
	#deltachecktable tbody tr:nth-child(even) { background-color:#D1D1D1; }
	#deltachecktable .filler { text-align:center; font-weight:bold; }
	#deltachecktable tbody td { padding:5px; }
</style>
<table id='deltachecktable'>
	<thead>
		<tr>
			<td rowspan="3" valign="middle" class="header">Test Name</td>
			<td colspan="12" class="header">Delta Check</td>
		</tr>
		<tr>			
			<?php
				foreach($specimenids as $specimenidkey=>$specimenid)
				{
			?>
					<td colspan="2" class="header">
						<span style="font-weight:bold;"><?php echo $specimenid?></span><br /><br />
						<span style="font-weight:normal"><?php echo $data[$specimenid]['release_date']." ".$data[$specimenid]['release_time']?></span><br /><br />
						<span style="font-weight:normal">Location: <?php echo $data[$specimenid]['location'] ?></span>
					</td>
			<?php 
				}
				
				if(count($specimenids) <= 6)
				{
					for($filler = 6 - count($specimenids); $filler!=0;$filler--)
						echo "<td class='filler' colspan='2'></td>";
				}
			?>
		</tr>
		<tr>
			<?php
				foreach($specimenids as $specimenidkey=>$specimenid)
				{
			?>
					<td>
						<span style="font-weight:normal;">CONVE</span>
						
					</td>
					<td><span style="font-weight:normal">SI</span></td>
			<?php 
				}
				
				if(count($specimenids) <= 6)
				{
					for($filler = 6 - count($specimenids); $filler!=0;$filler--)
						echo "<td class='filler'></td><td class='filler'></td>";
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
					<td style="border-left:thin solid;">
						<?php 
							if(isset($data[$specimenid][$testid]))
								echo $data[$specimenid][$testid]['TestOrderDetail']['TestOrderResult']['conventional_value'];
						?>
						
					</td>
					<td style="border-right:thin solid;">
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
							echo "<td class='filler'></td><td class='filler'></td>";
					}
				?>
			</tr>
		<?php 
			}
		?>
	</tbody>
</table>