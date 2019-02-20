



<script type="text/javascript">
    jQuery(document).ready(function () {
        
        jQuery('.getDueInfo').click(function(){
            var datedeposit = jQuery('.deposit_dateChange').val();

            if( jQuery('.deposit_dateChange').val() !='' && jQuery('#form_branch_id').val() !='' ){

                var dataa = [
                                {name:'data[date]',value:datedeposit},
                                {name:'data[branch_id]',value:jQuery('#form_branch_id').val()},
                            ];


                jQuery.ajax({
                    async:false,
                    data:dataa,
                    url:'/'+prefix+'/account_transactions/getDepositSlipInfo',
                    type:'POST',
                    dataType:'json',
                    success:function(data){             
                        jQuery('.marilynDiv').empty();
                        var createTable = '';
                        if(data.success){
                            
                            createTable += '<table style="width:100%;border-collapse:collapse;" border="1">';
                                createTable += '<tr><td colspan="4">Amount to be Deposited om '+datedeposit+' from Branch '+data.branch.Branch.name+': <strong>'+data.amount+'</strong></td></tr>';
                                createTable += '<tr style="text-align:center;"><td>Branch</td><td>Deposit Date</td> <td>Amount</td> <td>Date Deposited</td></tr>';                               
                            jQuery.each(data.DepositSlip,function(key,value){
                                createTable += '<tr style="text-align:center;"><td>'+value.Branch.name+'</td><td>'+value.DepositSlip.deposit_date+'</td> <td>'+value.DepositSlip.deposit_amount+'</td> <td>'+value.DepositSlip.date_deposited+'</td></tr>';                                
                            });

                             createTable += '<tr><td colspan="2">Total : <strong>'+data.balance+'</strong></td><td colspan="2">Status : <strong>'+data.balance_status+'</strong></td></tr>';
                            createTable += '</table>';

                            jQuery('.marilynDiv').append(createTable);
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
            }else{
                alert('Please Select Date and Branch');
            }

            return false;
        });
    })
</script>