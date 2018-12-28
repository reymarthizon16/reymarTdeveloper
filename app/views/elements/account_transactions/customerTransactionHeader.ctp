<strong>Account No. : </strong>
    <span><?php echo $accTvalue['transaction_account_number'] ?></span>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<strong>DR No. : </strong>
    <span><?php echo $accTvalue['transaction_dr_no'] ?></span>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>    
<strong>Date : </strong>                                                        
    <span><?php echo $accTvalue['transaction_dr_date'] ?></span> 
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<strong>Branch : </strong>                                                        
    <span><?php echo $branches[$accTvalue['branch_id']] ?></span> 

<?php 
    $percent = round( ( ($accTvalue['total_price'] - $accTvalue['pn_value']) / $accTvalue['total_price'] ) * 100);
    $complete =  round( 100 - $percent);
 ?>
<div class="progress progress-striped active" style="width: 20%;background-color:red;float: right; ">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%">       
    </div>
</div>