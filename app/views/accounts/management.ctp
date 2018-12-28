<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-5">       
        <div class="users form">
        <?php echo $this->Form->create($model);?>
            <fieldset>
                <?php echo $this->element('common/createforms');?>
            </fieldset>
        <?php echo $this->Form->end(__('Submit', true));?>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        
        jQuery('#form_account_type_id').change(function(){

                jQuery('#div_account_type_id').css({'display':'none'});
                jQuery('#div_company').css({'display':'none'});
                jQuery('#div_middle_name').css({'display':'none'});
                jQuery('#div_first_name').css({'display':'none'});
                jQuery('#div_last_name').css({'display':'none'});
                jQuery('#div_account_number').css({'display':'none'});

            if( jQuery(this).val() == 1 ){
                
                jQuery('#div_account_type_id').css({'display':''});
                jQuery('#div_middle_name').css({'display':''});
                jQuery('#div_first_name').css({'display':''});
                jQuery('#div_last_name').css({'display':''});
                jQuery('#div_account_number').css({'display':''});                

            }
            else{
                
                jQuery('#div_company').css({'display':''});
                jQuery('#div_account_type_id').css({'display':''});
                jQuery('#div_account_number').css({'display':''});                

            }
            
        });

        jQuery('#form_account_type_id').trigger('change',jQuery('#form_account_type_id').val());
    });
</script>