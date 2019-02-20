<?php 
if(!empty($this->data['AccountTransaction'])){
    foreach ($this->data['AccountTransaction'] as $accTkey => $accTvalue) { ?>
    
        <?php if($accTvalue['id'] == $transactionId){ ?>
            
            <table class=" table  " style="border-collapse: collapse;width: 100%;" border="1">
                <tr>
                    <td><strong>Full Name : </strong></td>
                    <td><span><?php echo $this->data['Account']['last_name'].", ".$this->data['Account']['first_name'] ?></span></td>
                
                    <td>  <strong>Contact No. : </strong>    </td>
                    <td><span><?php echo $this->data['Account']['mobile_no'] ?></span>     </td>
                    
                    <td>  <strong>Address : </strong>         </td>
                    <td><span><?php echo $this->data['Account']['address'] ?></span> </td>
                </tr>                                                                 
                    
            </table>
            <br>
            <?php echo $this->element('/account_transactions/customerTransactionBodyPrint',array('accTkey'=>$accTkey,'accTvalue'=>$accTvalue,'branches'=>$branches,'params'=>$params)); ?>            
           
        <?php } ?>
                                                            
    <?php } ?>

<?php } ?>