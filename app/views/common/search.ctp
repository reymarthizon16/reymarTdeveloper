<table class='tblresult' style="width:945px;">
<!--<table style="width:1300px;">-->
	<thead>
		<tr> 
			<th style="width:30px;">Order status</th>
			<th style="width:100px;">Patient ID</th>
			<th style="width:200px;">Patient Name</th>
			<th style="width:100px;">Specimen ID</th>
			<?php if (!empty($dashboard)):?>
				<?php foreach($dashboard as $dashboardKey=>$dashboardValue):?>
					<th style="width:50px;">
						<?php echo $dashboardValue;?>
					</th>
				<?php endforeach;?>
			<?php endif;?>			
			<th style="width:100px;">Processing Status</th>
			<th style="width:150px;">Requested Date</th>
			<th style="width:150px;">Released Date</th>
			<th style="width:345px;">Test</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($testOrders) && !empty($testOrders)):?>
			<?php foreach($testOrders as $key=>$value):?>
					<tr id="specimen<?php echo $value['TestOrder']['id'].'-'.$value['TestOrder']['specimen_id'];?>" class="test_box" testCount="<?php echo $value['TestOrder']['test_count']?>" testCompleted="<?php echo $value['TestOrder']['completed_test_count']?>">
						<td style="border:thin solid;" class="status status<?php echo $value['TestOrder']['status']?>">
						<?php echo $this->Form->hidden('TestOrder.id',array('value'=>$value['TestOrder']['id'],'id'=>'testOrderId')); ?>
							<?php echo $this->Form->hidden('TestOrder.status',array('value'=>$value['TestOrder']['status'],'id'=>'testOrderStatus')); ?>
						</td>
						<td><?php echo $value['PatientOrder']['Patient']['id']?></td>
						<td><?php echo $value['PatientOrder']['Patient']['last_name'].", ".$value['PatientOrder']['Patient']['first_name']." ".$value['PatientOrder']['Patient']['middle_name']?></td>
						<td class="specimenID"><?php echo $value['TestOrder']['specimen_id'];?></td>
						<?php if (!empty($dashboard)):?>
							<?php foreach($dashboard as $dashboardKey=>$dashboardValue):?>
								<td>
									<?php if (!empty($value['PatientOrder']['Patient']['PatientExtraField'])):?>
										<?php foreach($value['PatientOrder']['Patient']['PatientExtraField'] as $extraFieldKey=>$extraFieldValue):?>
											<?php if ($extraFieldValue['extra_field_id']==$dashboardKey):?>
												<?php echo $extraFieldValue['value'];?>
											<?php endif;?>
										<?php endforeach;?>
									<?php endif;?>
								</td>
							<?php endforeach;?>
						<?php endif;?>						
						<td class="testCount" style="text-align:center">
						<?php echo round(($value['TestOrder']['completed_test_count']?$value['TestOrder']['completed_test_count']/$value['TestOrder']['test_count']:0)*100, 0, PHP_ROUND_HALF_UP);?>% completed
							<div class="percentCompleted" style="width:<?php echo ($value['TestOrder']['completed_test_count']?$value['TestOrder']['completed_test_count']/$value['TestOrder']['test_count']:0)*100;?>%;">
							</div>
							
						</td>
						<td>
							<?php echo $value['PatientOrder']['date_requested'].' '.$value['PatientOrder']['time_requested']?>
						</td>
						<td>
							<?php echo $value['TestOrder']['release_date'].' '.$value['TestOrder']['release_time']?>
						</td>
						<td>
							
							<?php foreach( $value['TestResult'] as  $testResultKey=>$testResultValue):?>
								<?php foreach($testResultValue['TestOrderDetail'] as $testOrderDetailKey=>$testOrderDetailValue):?>
									<?php echo ($testOrderDetailKey>0||$testResultKey>0?", ":"").$testOrderDetailValue['TestCode']['name'];?>
								<?php endforeach;?>
							<?php endforeach;?>
						</td>
					</tr>			
			<?php endforeach;?>
		<?php endif;?>
	</tbody>
</table>
<?php	//echo $this->element('sql_dump');?>