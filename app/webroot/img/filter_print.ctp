<div class='printDialog'>
	<?php //echo $this->Form->create('TestOrder', array('id'=>'print_filter','target'=>'_blank','url'=>'/medtech/test_orders/print/'.$this->data['PatientOrder']['specimen_id']));?>
	<form id="print_filter" target="_blank" method="post" action="/medtech/test_orders/print/<?php echo $this->data[0]['PatientOrder']['specimen_id']; ?>" accept-charset="utf-8">
		
		<div class='ui-dialog-titlebar' style='padding:3px;'>Print Profile</div>
		
		<div class="input checkbox" >
			<input type="checkbox" class='doctors_copy' name="data[TestOrder][printcopy][doctor_copy]" id="doctor_copy" style="margin:1px" >
			<label for="doctor_copy">Doctor's Copy</label>
			<input type="checkbox" name="data[TestOrder][printcopy][patient_copy]" id="doctor_copy" style="margin:1px" value="1">
			<label for="patient_copy">Patient's Copy</label>
		</div>
		
		<br />
		<?php echo $this->Form->input('TestOrder.copy_number', array('value'=>1))?>
		<br />
		<div class='ui-dialog-titlebar' style='padding:3px;'>
			<?php //echo $this->Form->input('print_all', array('id'=>'print_all', 'type'=>'checkbox', 'style'=>'margin:1px'))?>
			

			<div class="input checkbox">
				<input type="hidden" name="data[TestOrder][print_all]" id="print_all_" value="0">
				<input type="checkbox" name="data[TestOrder][print_all]" id="print_all" style="margin:1px" value="1">
				<label for="print_all">Print All</label>
			</div>
		</div>
		<div class='ui-dialog-titlebar' style='margin-top:5px;'>
			Select test to print
		</div>
		<div id="testlist">
			<?php foreach($this->data[0]['TestOrder']['TestResult'] as $testGroupIndex=>$testGroupValue):?>
				<?php debug($testGroupValue); ?>
				<?php if($testGroupValue['release_date'] <> null){?>
							<div style='margin-top:10px'>
								<div class='testGroup'>
									<?php //echo $this->Form->input("TestResult.{$testGroupIndex}.TestGroup.print", array('type'=>'checkbox', 'label'=>$testGroupValue['TestGroup']['name']))?>
									<div class="input checkbox">
										<input type="hidden" name="data[TestResult][<?php echo $testGroupIndex?>][print]" id="TestResult<?php echo $testGroupIndex?>TestGroupPrint_" value="0">
										<input type="checkbox" name="data[TestResult][<?php echo $testGroupIndex?>][print]" value="1" id="TestResult<?php echo $testGroupIndex?>TestGroupPrint">
										<input type="hidden" name="data[TestResult][<?php echo $testGroupIndex?>][id]" value="<?php echo $testGroupValue['id']?>" class='testresultid'/>
										<label for="TestResult<?php echo $testGroupIndex?>TestGroupPrint"><?php echo $testGroupValue['TestGroup']['name']?></label>
									</div>						
								</div>
								<div style='margin-left:10px;' class='testCode'>
									<?php foreach($testGroupValue['TestOrderDetail'] as $testOrderDetailIndex=>$testOrderDetailValue):?>
										<?php //echo $this->Form->input("TestResult.{$testGroupIndex}.TestOrderDetail.{$testOrderDetailIndex}.TestCode.print", array('type'=>'checkbox', 'label'=>$testOrderDetailValue['TestCode']['name']))?>
										<div class="input checkbox">
											<input type="hidden" name="data[TestResult][<?php echo $testGroupIndex?>][TestOrderDetail][<?php echo $testOrderDetailIndex?>][print]" id="TestResult<?php echo $testGroupIndex?>TestOrderDetail<?php echo $testOrderDetailIndex?>TestCodePrint_" value="0">
											<input type="checkbox" name="data[TestResult][<?php echo $testGroupIndex?>][TestOrderDetail][<?php echo $testOrderDetailIndex?>][print]" value="1" id="TestResult<?php echo $testGroupIndex?>TestOrderDetail<?php echo $testOrderDetailIndex?>TestCodePrint">
											<input type="hidden" name="data[TestResult][<?php echo $testGroupIndex?>][TestOrderDetail][<?php echo $testOrderDetailIndex?>][id]" value="<?php echo $testOrderDetailValue['id']?>" class='testorderdetailid'/>
											<label for="TestResult<?php echo $testGroupIndex?>TestOrderDetail<?php echo $testOrderDetailIndex?>TestCodePrint"><?php echo $testOrderDetailValue['TestCode']['name'];?></label>
											<?php if (substr($testOrderDetailValue['TestOrderResult']['value'],0,7)=="GRAPH::"):?>
												<input type="hidden" name="data[TestResult][graphs][<?php echo $testOrderDetailValue['id']?>]" id="graph<?php echo $testOrderDetailValue['TestOrderResult']['id']?>" />	
											<?php endif;?>
										</div>		
										
															
									<?php endforeach;?>
								</div>
							</div>
				<?php }?>
			<?php endforeach;?>		
		</div>
	<?php //echo $this->Form->end();?>
	</form>
</div>

<div id="printpreviewdialog">
	
</div>


<script>

	jQuery(document).ready(function(){

		
		jQuery('.printDialog input').attr('checked','checked');
		//jQuery('.printDialog .doctors_copy').attr('checked','checked');

		jQuery('.printpreview').unbind('click');
		jQuery('.printpreview').click(function(){

			var thispreview=null;
			var thispreview = jQuery('.printDialog').clone();
			
			thispreview.find('#print_filter').removeAttr('action').attr('action',jQuery(this).attr('href'));
			jQuery('#printpreviewdialog').empty().append(thispreview).find('form').submit().end();

			return false;
		});
			
		
	});

</script>