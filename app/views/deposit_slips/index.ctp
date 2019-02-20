
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">DepositSlips</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button type="button" onclick="window.location='/accounting/depositSlips/add';" class="btn btn-primary">Add Deposit Slips</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Id</th>                                
                            <th>Branch</th>      
                            <th>Date Reference</th>      
                            <th>Date Deposited</th>      
                            <th>Deposit Amount</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($depositSlips as $key => $value) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['DepositSlip']['id']; ?></td>
                            <td><?php echo $branches[$value['DepositSlip']['branch_id']]; ?></td>
                            <td><?php echo $value['DepositSlip']['deposit_date']; ?></td>
                            <td><?php echo $value['DepositSlip']['date_deposited']; ?></td>
                            <td><?php echo $value['DepositSlip']['deposit_amount']; ?></td>
                            <td class="center">
                                <button class="btn btn-default" onclick="window.location='/accounting/depositSlips/edit/<?php echo $value['DepositSlip']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-default" onclick="window.location='/accounting/depositSlips/delete/<?php echo $value['DepositSlip']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                            </td>
                        </tr>                       
                        <?php } ?>
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
