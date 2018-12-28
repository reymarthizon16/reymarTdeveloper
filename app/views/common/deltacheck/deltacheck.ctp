<form action="/medtech/test_orders/print_delta" method="POST" target="_blank" style="display:none;" id="formprint">
  	<textarea name="deltahtml" id="deltahtml"></textarea>
</form>

<?php 
echo "<div>"
		.$this->Form->input('start_date',array(
			'type'=>'text','class'=>'datepickersEND','div'=>false
			,'label'=>'Start Date',
			)). "";

	echo "&nbsp;&nbsp;&nbsp;<button class='filter_delta'> Submit </button>";	
	echo "&nbsp;&nbsp;&nbsp;<button class='reset_delta'> Reset </button>";	
	// echo "&nbsp;&nbsp;&nbsp;<button class='print_delta'> Print </button></div>";	
?>

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
					<td colspan="2" class="header td_hasDT" tdreleaseDT='<?php echo date('m/d/Y',strtotime($data[$specimenid]['release_date']));?>'>
						<span style="font-weight:bold;"><?php echo $specimenid?></span><br /><br />
						<span style="font-weight:normal"><?php echo $data[$specimenid]['release_date']." ".$data[$specimenid]['release_time']?></span><br /><br />
						<span style="font-weight:normal">Location: <?php echo $data[$specimenid]['location'] ?></span>
						<span style="font-weight:normal">Branch: <?php echo $branches[$data[$specimenid]['branch']] ?></span>
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
					<td ><span style="font-weight:normal">SI</span></td>
					<td >
						<span style="font-weight:normal;">CONVE</span>
						
					</td>
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
				<td>
					<span>
						<?php echo $testname?> 
					</span>
					<?php if ( $testname != '<strong>Other Test(s)</strong>' ) { ?>
						<br>
						<a href="#" class='linkgraph' graphid='graph-<?php echo $testid;?>'>Show Graph</a>
					<?php } ?>
				</td>
				<?php 
					foreach($specimenids as $specimenidkey=>$specimenid)
					{
				?>
					<td style="border-left:thin solid;" class='td_hasDT si' tdreleaseDT='<?php echo date('m/d/Y',strtotime($data[$specimenid]['release_date']));?>'>
						<?php 
							if(isset($data[$specimenid][$testid]))
								echo $data[$specimenid][$testid]['TestOrderDetail']['TestOrderResult']['value'];
						?>
					</td>
					<td style="border-right:thin solid;" class='td_hasDT conv' tdreleaseDT='<?php echo date('m/d/Y',strtotime($data[$specimenid]['release_date']));?>'>
						<?php 
							if(isset($data[$specimenid][$testid]))
								echo $data[$specimenid][$testid]['TestOrderDetail']['TestOrderResult']['conventional_value'];
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

<script type="text/javascript">
	
	jQuery(document).ready(function(){

		jQuery('.linkgraph').unbind();
		jQuery('.linkgraph').click(function(){
			
			var id = jQuery(this).attr('graphid');
			var value = jQuery(this);

			if( jQuery(this).text() == 'Show Graph' ){

				jQuery('#'+id).empty();

				var plot_num_si = [];
				var plot_num_conv = [];

				var countsi=0;
				var countconv=0;

				jQuery.each(jQuery(value).closest('tr').find('td.si'),function(key,value){

					if ( jQuery(value).find('div.hidedivs').size() == '0' ){

						plot_num_si.push( parseFloat(jQuery(value).text().trim()) );
						
							if(! isNaN( parseFloat(jQuery(value).text().trim()) ) ) {
								countsi++;
							}
					}else{
						plot_num_si.push( null );
					}

				});

				var conv_index=1;
				jQuery.each(jQuery(value).closest('tr').find('td.conv'),function(key,value){

					if ( jQuery(value).find('div.hidedivs').size() == '0' ){

						plot_num_conv.push( [conv_index+0.5, parseFloat(jQuery(value).text().trim())] );
						
							if(! isNaN( parseFloat(jQuery(value).text().trim()) ) ) {
								countconv++;
							}
					}else{
						plot_num_conv.push( [conv_index+0.5, null] );
					}
					conv_index++;

				});
				
				var multiarr = [];
				multiarr[0]=plot_num_si;
				multiarr[1]=plot_num_conv;								
								
				console.log(multiarr);

					if( countsi > 1  || countconv > 1 ){

						// console.log(multiarr);
						
						if ( jQuery(this).closest('table').find('.tr_graph div#'+id).size() == 0 )
							jQuery("<tr style='display: none' class ='tr_graph'><td colspan='13'><div id='"+id+"' style='width:100%;height:150px;'></div></td></tr>").insertBefore(jQuery(this).closest('tr'));

						jQuery('#'+jQuery(this).attr('graphid')).closest('tr.tr_graph').css({'display':''});			

						var plot1 = $.jqplot (id, multiarr,
						// var plot1 = $.jqplot (id,  [plot_num_si, plot_num_conv],
							{
								title: jQuery(this).closest('td').find('span').text().trim(),
								seriesDefauls:{
									pointLabels:{
										show:true,
										formatString: '%.2f'
									}
								},
								axesDefaults:{
									tickOptions:{formatString:'%.2f'}
								},
								 axes: {						           
						            yaxis: {
						                tickOptions: {formatString: '%.2f'},
						                // min:0,
						                // max:max_y_axisS,
						            }
						        }
							}
						);

						jQuery(this).text('Hide Graph');
					}else{
						jQuery('#'+jQuery(this).attr('graphid')).closest('tr.tr_graph').css({'display':'none'});
						alert(' No Graph ');
					}
			}else{
				jQuery('#'+jQuery(this).attr('graphid')).closest('tr.tr_graph').remove();
				jQuery(this).text('Show Graph');
			}	

		});	

		jQuery('.filter_delta').unbind();
        jQuery('.filter_delta').click(function(){

        	jQuery('.td_hasDT').each(function(key,value){
			
				var compare = jQuery(value).attr('tdreleaseDT');
                var thistext = jQuery(value).html().trim();                	                	      
                	
              	if( compare < jQuery('.datepickersEND').val() ){          

              		if ( jQuery(thistext).closest('.hidedivs').size() == 0)   		              		 
						jQuery(value).text('').remove('div').append('<div class="hidedivs">'+thistext+'</div>');					
					else
						jQuery(value).text('').remove('div').append(thistext);					

				}else{
					 var appendd = jQuery(value).find('div.hidedivs').html();
					 jQuery(value).find('div.hidedivs').remove('.hidedivs');					 
					 jQuery(value).append(appendd);					 
				}

				jQuery('.hidedivs').css('display','none');

			});	

        });

        jQuery('.datepickersEND').datepicker();

        jQuery('.reset_delta').unbind();
        jQuery('.reset_delta').click(function(){
        	jQuery('.datepickersEND').val('');
        	jQuery('.filter_delta').trigger('click');
        });

        // jQuery('.print_delta').unbind();
        // jQuery('.print_delta').click(function(){
        // 	jQuery('#deltahtml').text( jQuery('#deltacheckdiv').html() );
        // 	jQuery('#formprint').submit();
        // });
	});
</script>