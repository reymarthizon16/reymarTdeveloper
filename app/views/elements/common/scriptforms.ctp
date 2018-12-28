
<script type="text/javascript">
var data_model;	
var data_select;	
	jQuery(document).ready(function(key,value){

		jQuery('.quick_manage').unbind();
		jQuery('.quick_manage').click(function(){

			jQuery('#management').modal('toggle');
			
			data_model = jQuery(this).attr('data-model');
			data_select = jQuery(this).attr('data-select');
			var data_strip = data_model.trim();
			jQuery('.modalLegend').text( data_strip );

			var dataa = [
                        {name:'data[Model]',value:data_strip},                                
                        ];
            
            jQuery('.modal-body').empty();

			jQuery.ajax({
	            async:false,
	            data:dataa,
	            url:'/'+prefix+'/common/getInputs',
	            type:'POST',
	            dataType:'html',
	            success:function(data){             
	                jQuery('.modal-body').empty().append(data).find('input').attr('autocomplete','off');

	                jQuery('#saveInputform').submit(function(){
            
			            var dataa = jQuery(this).serializeArray();

			            jQuery.ajax({
			                async:false,
			                data:dataa,
			                url:'/'+prefix+'/common/saveInputs/'+data_model,
			                type:'POST',
			                dataType:'json',
			                success:function(data){             
			                    if(data.success){
			                        jQuery.ajax({
			                            async:false,
			                            data:dataa,
			                            url:'/'+prefix+'/common/listInputs/'+data_model,
			                            type:'POST',
			                            dataType:'json',
			                            success:function(data){
			                            console.log(data);
			                                if(data){
			                                    jQuery('#'+data_select).empty();
			                                    jQuery.each(data,function(key,value){
			                                        jQuery('#'+data_select).append('<option value="'+key+'">'+value+'</option>');
			                                    });
			                                }
			                            },
			                            error:function(whaterror){
			                            },
			                            complete:function(){

			                            }
			                        });
			                    }
			                },
			                error:function(whaterror){
			                },
			                complete:function(){

			                }
			            });

			            jQuery('#management').modal('toggle');

			            return false;
			        });               
	            },
	            error:function(whaterror){
	            },
	            complete:function(){

	            }
	        });

			return false;
		});

	});
</script>

<div class="modal fade" id="management" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" class='management_close'>Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
