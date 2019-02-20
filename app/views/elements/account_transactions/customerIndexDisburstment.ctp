<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Account No.</th>
                            <th>DR No.</th>
                            <th>Fullname</th>
                            <th>Mobile no.</th>
                            <th>Address</th>
                            <th>Branch</th>
                            
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $seq = 0;           
                        foreach ($accountTransactions as $accTkey => $accTvalue) { 
                            if( $accTvalue['AccountTransaction']['collection_type_id'] == 5 ){
                            ?>
                            <tr class="<?php if($seq % 2 == 0) echo "odd"; else echo "even"; ?> gradeX">
                                <td><?php echo $accTvalue['AccountTransaction']['id'] ?></td>
                                <td><?php echo $accTvalue['AccountTransaction']['transaction_account_number'] ?></td>
                                <td><?php echo $accTvalue['AccountTransaction']['transaction_dr_no'] ?></td>
                                <td><?php echo $accountCustomers[$accTvalue['AccountTransaction']['person_account_id']]['full_name'] ?></td>
                                <td><?php echo $accountCustomers[$accTvalue['AccountTransaction']['person_account_id']]['mobile_no'] ?></td>
                                <td><?php echo $accountCustomers[$accTvalue['AccountTransaction']['person_account_id']]['address'] ?></td>
                                <td><?php echo $branches[$accTvalue['AccountTransaction']['branch_id']] ?></td>
                                
                                <td  class="center">
                                    <button type="button" onclick="window.location.href='/accounting/account_transactions/edit/<?php echo $accTvalue['AccountTransaction']['person_account_id']; ?>/<?php echo $accTvalue['AccountTransaction']['id']; ?>'"  class="btn btn-primary btn-circle btn-lg"><i class="fa fa-list"></i></button>
                                </td>
                            </tr>    
                        <?php $seq++; }} ?>
                       
                    </tbody>
                </table>
                <!-- /.table-responsive -->
               
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>