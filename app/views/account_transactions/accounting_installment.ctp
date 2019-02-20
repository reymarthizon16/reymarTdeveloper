<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Installment</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<style type="text/css">
    .marilyndiv div {
        margin:3px;
        padding: 3px;
    }
</style>
<div class="row marilyndiv">
        
        <?php //echo $this->Form->create();?>	   
        <div style="display: flex;" class="marilyndiv">
            <div> <strong> Account # / D.R. No : </strong></div>
            <div class="" style="">                
                <input name="data[AccountTransaction][acc_dr_no]" type="text" id="AccountTransactionTransactionAccDrNo" class="form-control" autocomplete="off" value="">
            </div>
        
            <div> <strong> Branch : </strong></div>
            <div class="" style="">                
                <?php echo $this->Form->input('branch_id',array('type'=>'select','id'=>'BranchId','div'=>false,'options'=>$branches,'label'=>false)); ?>
            </div>

        </div>
            <button class="getInfo btn btn-info btn-md" style="">Getting Information</button>
        <br />
            <div id="account_info">
                
            </div>
        
        <strong> Due  </strong>
        <br />
        <div style="display: flex;border: 1px solid black;" class="marilyndiv">
            
            <div> <strong> Month : </strong></div>
            <div class="" style="">                
                <?php echo $this->Form->input('month',array('id'=>'duemonth','type'=>'select','div'=>false,'options'=>array($month),'label'=>false)); ?>                  
            </div>

            <div> <strong> Year : </strong></div>
            <div class="" style="">                
                <?php echo $this->Form->input('year',array('id'=>'dueyear','type'=>'select','div'=>false,'options'=>array($year),'label'=>false)); ?>
            </div>            
            
            <div>
                <button class="getDueInfo btn btn-info btn-md" style="">Getting Due Info</button>
            </div>
            
                <div> <strong> Amount Due : </strong></div>
                <input name="data[AccountTransactionDetail][id]" type="hidden" id="AccountTransactionDetailTransactionId" class="form-control" autocomplete="off" value="">
                <div class="" style="">                
                    <input name="data[AccountTransactionDetail][Amount_Due]" type="text" id="AccountTransactionDetailTransactionAmount_Due" class="form-control" autocomplete="off" value="">
                </div>

                <div> <strong> Interest : </strong></div>
                <div class="" style="">                
                    <input name="data[AccountTransactionDetail][Amount_Interest]" type="text" id="AccountTransactionDetailTransactionAmount_Interest" class="form-control" autocomplete="off" value="">
                </div>
                
                <div>
                    <button class="saveInterest btn btn-info btn-md" style="">Edit</button>
                </div>

            <div> <strong> Balance : </strong></div>
            <div class="Balance" style="width: 100px;border:1px solid black;"> 
                
            </div>

            
        </div>
        <br />
            <div id="payment_info">
                
            </div>
        
        <strong> Payment  </strong>
        <br />
        <div style="display: flex;border: 1px solid black;" class="marilyndiv">
            
            <div> <strong> O.R Date : </strong></div>
            <div class="" style="">                
                <input name="data[AccountTransaction][payment_date]" type="text" id="AccountTransactionTransactionPaymentDate" class="datepicker form-control" autocomplete="off" value="">
            </div>

            <div> <strong> O.R No : </strong></div>
            <div class="" style="">                
                <input name="data[AccountTransaction][or_number]" type="text" id="AccountTransactionTransactionOrNumber" class="form-control" autocomplete="off" value="">
            </div>            

            <div> <strong> Discount : </strong></div>
            <div class="" style="">                
                <input name="data[AccountTransaction][discount]" type="text" id="AccountTransactionTransactionDiscount" class="form-control" autocomplete="off" value="">
            </div>

            <div> <strong> Amount Paid : </strong></div>
            <div class="" style="">                
                <input name="data[AccountTransaction][payment_amount]" type="text" id="AccountTransactionTransactionPaymentAmount" class="form-control" autocomplete="off" value="">
            </div>

            <div>
                <button class="paidInstallment btn btn-info btn-md" style="">Paid</button>
            </div>
            
        </div>


        <?php //echo $this->Form->end(__('Submit', true));?>
       
</div>

<script type="text/javascript">
    var exsisting = 1;

    jQuery(document).ready(function(){
        jQuery('.getDueInfo').attr('disabled','disabled');
        jQuery('.paidInstallment').attr('disabled','disabled');
        jQuery('.saveInterest').attr('disabled','disabled');



    	jQuery('.getInfo').click(function(){            

            var dataa = [
                            {name:'data[AccDrNo]',value:jQuery('#AccountTransactionTransactionAccDrNo').val()},
                            {name:'data[BranchId]',value:jQuery('#BranchId').val()},
                        ];


            jQuery.ajax({
                async:false,
                data:dataa,
                url:'/'+prefix+'/account_transactions/getAccountInfo',
                type:'POST',
                dataType:'json',
                success:function(data){             
                    jQuery('#account_info').empty();
                    if(data.success){

                        if(data.AccountTransactionItem){
                            var marilynText = '';
                            jQuery.each(data.AccountTransactionItem,function(key,value){
                                marilynText += '<tr>';
                                marilynText += '<td style="text-align:center;">'+value.serial_no+'</td>';
                                marilynText += '<td style="text-align:center;">'+data.params.models[value.model_id]+'</td>';
                                marilynText += '<td style="text-align:center;">'+data.params.brands[value.brand_id]+'</td>';
                                marilynText += '<td style="text-align:center;">'+data.params.types[value.type_id]+'</td>';
                                marilynText +='</tr>';
                            });
                        }

                        if(data.AccountTransactionDetail){
                            var marilynText1 = '';
                                
                            jQuery.each(data.AccountTransactionDetail,function(key,value){
                                if(value.type==2 && value.paid==1)
                                    marilynText1 += '<div style="text-align:center;border:1px solid black;padding:5px;">'+value.due_date+' <span style="color:blue;">( PAID )</span></div>';
                               if(value.type==2 && value.paid==0)
                                    marilynText1 += '<div style="text-align:center;border:1px solid black;padding:5px;">'+value.due_date+' <span style="color:red;">(N/A)</span></div>';
                            });
                               
                        }

                        jQuery('#account_info').append(''+
                            '<table style="width:100%;border-collapse:collapse" border="1" cellpadding="3">'+
                                '<tr style="display:none">'+
                                    '<td colspan="4" id="tdforTrnsId">'+data.AccountTransaction.id+'</td>'+
                                '</tr>'+
                                '<tr>'+                                    
                                    '<td colspan="1"> <strong> Customer Name : </strong> '+data.Account.last_name+', '+data.Account.first_name+' '+data.Account.middle_name+' </td>'+
                                    '<td colspan="1"> <strong> Branch : </strong> '+data.params.branches[data.AccountTransaction.branch_id]+' </td>'+
                                    '<td colspan="1"> <strong> As of : </strong> '+data.AccountTransaction.as_of+' </td>'+
                                    '<td colspan="1"> <strong> PN Balance : </strong> '+data.AccountTransaction.pn_balance+' </td>'+
                                '</tr>'+
                                '<tr>'+                                    
                                    '<td colspan="1"> <strong> First Due Date : </strong> '+data.AccountTransaction.due_date+' </td>'+
                                    '<td colspan="1"> <strong> Monthly Installment : </strong> '+data.AccountTransaction.installment_amount+' </td>'+
                                    
                                    '<td colspan="1"> </td>'+
                                    '<td colspan="1"> </td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td colspan="4" style="font-weight:bold;text-align:center;"> ITEMS </td>'+
                                '</tr>'+     
                                '<tr>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Serial No </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Models </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Brand </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Types </td>'+
                                '</tr>'+       
                                marilynText+    
                                '<tr>'+
                                    '<td colspan="4" style="font-weight:bold;text-align:center;">'+
                                        'Payments'+
                                        '<div style="display:flex;">'+
                                        marilynText1+
                                        '</div>'+
                                    '</td>'+
                                '</tr>'+                         
                            '</table>'+
                            '');
                        jQuery('.getDueInfo').attr('disabled',false);
                    }else{
                        alert('No Record Found');
                        jQuery('.getDueInfo').attr('disabled','disabled');
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

            return false;
        });

        jQuery('.getDueInfo').click(function(){            

            var dataa = [
                            {name:'data[Account_Transaction_id]',value:jQuery('#tdforTrnsId').text()},
                            {name:'data[BranchId]',value:jQuery('#BranchId').val()},
                            {name:'data[month]',value:jQuery('#duemonth').val()},
                            {name:'data[year]',value:jQuery('#dueyear').val()},
                        ];


            jQuery.ajax({
                async:false,
                data:dataa,
                url:'/'+prefix+'/account_transactions/getAccountDueInfo',
                type:'POST',
                dataType:'json',
                success:function(data){             
                    jQuery('#payment_info').empty();
                    if(data.success){
                        jQuery('.getInfo').trigger('click');
                        if(data.Payments){
                            var marilynText = '';
                            jQuery.each(data.Payments,function(key,value){
                                marilynText += '<tr>';
                                marilynText += '<td style="text-align:center;">'+value.AccountTransactionDetail.due_date+'</td>';
                                marilynText += '<td style="text-align:center;">'+value.AccountTransactionDetail.payment_date+'</td>';
                                marilynText += '<td style="text-align:center;">'+value.AccountTransactionDetail.or_number+'</td>';
                                marilynText += '<td style="text-align:center;">'+value.AccountTransactionDetail.discount+'</td>';
                                marilynText += '<td style="text-align:center;">'+value.AccountTransactionDetail.payment_amount+'</td>';
                                marilynText +='</tr>';
                            });
                        }
                         jQuery('#payment_info').append(''+
                            '<table style="width:100%;border-collapse:collapse" border="1" cellpadding="3">'+                                
                                '<tr>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Reference Date </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Payment Date </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> OR </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Discount </td>'+
                                    '<td colspan="1" style="font-weight:bold;text-align:center;"> Payment </td>'+
                                '</tr>'+       
                                marilynText+                        
                            '</table>'+
                            '');

                        jQuery('#AccountTransactionDetailTransactionId').val(data.AccountTransactionDetail.id);
                        jQuery('#AccountTransactionDetailTransactionAmount_Due').val(data.AccountTransactionDetail.amount_due);
                        jQuery('#AccountTransactionDetailTransactionAmount_Interest').val(data.AccountTransactionDetail.interest);
                        jQuery('.Balance').text(data.AccountTransactionDetail.balance);
                        jQuery('.paidInstallment').attr('disabled',false);
                        jQuery('.saveInterest').attr('disabled',false);
                    }else{
                        jQuery('.paidInstallment').attr('disabled','disabled');
                        jQuery('.saveInterest').attr('disabled','disabled');
                        alert('Wrong Date Input');
                    }
                },
                error:function(whaterror){
                },
                complete:function(){

                }
            });

            return false;
        });

        jQuery('.paidInstallment').click(function(){            

            jQuery('.getDueInfo').trigger('click');

            if(jQuery('#AccountTransactionTransactionPaymentDate').val() == '' || jQuery('#AccountTransactionTransactionOrNumber').val() == '' || jQuery('#AccountTransactionTransactionPaymentAmount').val() == ''){
                alert('Required -OR Date -OR No -Amount Payment');
            }else{ 
                var dataa = [
                                {name:'data[Account_Transaction_id]',value:jQuery('#tdforTrnsId').text()},
                                {name:'data[month]',value:jQuery('#duemonth').val()},
                                {name:'data[year]',value:jQuery('#dueyear').val()},
                                {name:'data[payment_date]',value:jQuery('#AccountTransactionTransactionPaymentDate').val()},
                                {name:'data[or_number]',value:jQuery('#AccountTransactionTransactionOrNumber').val()},
                                {name:'data[discount]',value:jQuery('#AccountTransactionTransactionDiscount').val()},
                                {name:'data[payment_amount]',value:jQuery('#AccountTransactionTransactionPaymentAmount').val()},
                            ];


                jQuery.ajax({
                    async:false,
                    data:dataa,
                    url:'/'+prefix+'/account_transactions/paidinstallment',
                    type:'POST',
                    dataType:'json',
                    success:function(data){             
                        
                        if(data.success){
                            jQuery('.getInfo').trigger('click');
                            jQuery('.getDueInfo').trigger('click');
                            alert('Payment Successful !');

                            jQuery('#AccountTransactionTransactionPaymentDate').val('');
                            jQuery('#AccountTransactionTransactionOrNumber').val('');
                            jQuery('#AccountTransactionTransactionDiscount').val('');
                            jQuery('#AccountTransactionTransactionPaymentAmount').val('');
                            jQuery('.paidInstallment').attr('disabled','disabled');
                        }else{
                            alert('No Record Found');

                        }
                    },
                    error:function(whaterror){
                    },
                    complete:function(){

                    }
                });
            }

            return false;
        });

        jQuery('.saveInterest').click(function(){            

            var dataa = [
                            {name:'data[id]',value:jQuery('#AccountTransactionDetailTransactionId').val()},
                            {name:'data[amount_due]',value:jQuery('#AccountTransactionDetailTransactionAmount_Due').val()},
                            {name:'data[interest]',value:jQuery('#AccountTransactionDetailTransactionAmount_Interest').val()},
                            
                        ];

            jQuery.ajax({
                async:false,
                data:dataa,
                url:'/'+prefix+'/account_transactions/saveInterest',
                type:'POST',
                dataType:'json',
                success:function(data){             
                    
                    if(data.success){
                        jQuery('.getDueInfo').trigger('click');
                    }
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