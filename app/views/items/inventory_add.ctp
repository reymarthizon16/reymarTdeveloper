<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $model ?> Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-5">       
        <div class="users form">
        <?php echo $this->Form->create($model);?>
            <fieldset>
                <?php echo $this->Form->input('branches',array('empty'=>'Select Branch')); ?>
                <?php echo $this->element('common/createforms');?>
                <?php echo $this->Form->input('status',array('type'=>'select','options'=>array('1'=>'Neutral'))); ?><!-- ,'5'=>'Reposes' -->
                <?php echo $this->Form->input('entry_datetime',array('type'=>'text','class'=>'datetimepicker')); ?>
            </fieldset>
            <br>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>

<script type="text/javascript">
    var exsisting = 1;
    jQuery(document).ready(function(){

        jQuery('#form_serial_no').focusout(function(){
            getSerialStatus(jQuery(this).val(),jQuery(this));
        });
        jQuery('#form_serial_no').focusin(function(){
            getSerialStatus(jQuery(this).val(),jQuery(this));
        });
        
        jQuery('#form_serial_no').trigger('focusout');

        function getSerialStatus(serial_no,thiss){

            // if(jQuery('.ReceivingTransactionType:checked').val()==2)

            var dataa = [
                    {name:'data[serial_no]',value:serial_no},            
                    ];

            thiss.css({'border':'1px solid #ccc'});

            jQuery.ajax({
                async:true,
                data:dataa,
                url:'/inventory/storages/getItemDetails',
                type:'POST',
                dataType:'json',
                success:function(data){        

                    console.log(data);

                    if(data.success){
                        if(data.exsisting){
                            thiss.css({'border':'1px solid red'});
                            exsisting = 1;
                        }
                        else{
                            thiss.css({'border':'1px solid blue'});
                            exsisting = 0;
                        }
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

        }      

        jQuery('#ItemInventoryAddForm').submit(function(e){
            if( jQuery('#form_serial_no').val() =='' ){
                alert('Empty Serial No');
                e.preventDefault();
                return false;
            }
            if( exsisting == 1 ){
                alert('Exsisting Serial No');
                e.preventDefault();
                return false;
            }

            if( jQuery('#ItemBranches').val() =='' ){
                alert('Please Select Branch');
                e.preventDefault();
                return false;
            }

            if( jQuery('#ItemEntryDatetime').val() =='' ){
                alert('Please Entry DateTime');
                e.preventDefault();
                return false;
            }
        });
    });
</script>