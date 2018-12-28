<?php echo $this->Javascript->link('plugins/jqplot.pointLabels.js',false); ?>


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
<div id='deltacheckdiv'>
<style type="text/css">
	#deltachecktable { width:100%; }
	#deltachecktable tr td {  width:15%; padding:5px;}
	#deltachecktable thead { text-align:center; font-weight:bold; background-color:#B0B0B0; }
	#deltachecktable thead tr td { border:thin solid; }
	#deltachecktable tbody tr:nth-child(even) { background-color:#D1D1D1; }
	#deltachecktable .filler { text-align:center; font-weight:bold; }
</style>
	<table id='deltachecktable' >
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
						<td class='td_hasDT' tdreleaseDT='<?php echo date('m/d/Y',strtotime($data[$specimenid]['release_date']));?>' >
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
						<td class='td_hasDT' tdreleaseDT='<?php echo date('m/d/Y',strtotime($data[$specimenid]['release_date']));?>' >
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
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery('.linkgraph').unbind();
		jQuery('.linkgraph').click(function(){
			
			var id = jQuery(this).attr('graphid');
			var value = jQuery(this);

			if( jQuery(this).text() == 'Show Graph' ){

				jQuery('#'+id).empty();

				var plot_num = [];

				var count=0;

				jQuery.each(jQuery(value).closest('tr').find('td').not('td:first'),function(key,value){

					if ( jQuery(value).find('div.hidedivs').size() == '0' ){

						plot_num.push( parseFloat(jQuery(value).text().trim()) );
						
							if(! isNaN( parseFloat(jQuery(value).text().trim()) ) ) {
								count++;
							}
					}else{
						plot_num.push( null );
					}

				});

				var multiarr = [];
				multiarr[0]=plot_num;
								
					if( count > 1 ){

						// console.log(multiarr);
						
						if ( jQuery(this).closest('table').find('.tr_graph div#'+id).size() == 0 )
							jQuery("<tr style='display: none' class ='tr_graph'><td colspan='8'><div id='"+id+"' style='width:100%;height:150px;'></div></td></tr>").insertBefore(jQuery(this).closest('tr'));

						jQuery('#'+jQuery(this).attr('graphid')).closest('tr.tr_graph').css({'display':''});			

						var plot1 = $.jqplot (id, multiarr,
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
         
        jQuery('.datepickersEND').datepicker();

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