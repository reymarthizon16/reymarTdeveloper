
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Accounts</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button type="button" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/add';" class="btn btn-primary">Add Accounts</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#customer" data-toggle="tab" >Customer</a>
                    </li>
                    <li>
                        <a href="#supplier" data-toggle="tab" >Supplier</a>
                    </li>   
                    <li>
                        <a href="#servicecenter" data-toggle="tab" >Service Center</a>
                    </li>                    
                </ul>
                <div class="tab-content">
                    <br>
                    <div class="tab-pane active" id="customer">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Id</th>                                
                                    <th>Account Number</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>                            
                                    <th>Middle Name</th>
                                    <!-- <th>Company</th> -->
                                    <th>Mobile No.</th>
                                    <th>Address</th>
                                    <th>Account  Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $key => $value) { if($value['Account']['account_type_id'] ==1){ ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $value['Account']['id']; ?></td>
                                    <td><?php echo $value['Account']['account_number']; ?></td>
                                    <td><?php echo $value['Account']['last_name']; ?></td>
                                    <td><?php echo $value['Account']['first_name']; ?></td>
                                    <td><?php echo $value['Account']['middle_name']; ?></td>
                                    <!-- <td><?php echo $value['Account']['company']; ?></td> -->
                                    <td><?php echo $value['Account']['mobile_no']; ?></td>
                                    <td><?php echo $value['Account']['address']; ?></td>
                                    <td><?php echo $accountTypes[$value['Account']['account_type_id']]; ?></td>
                                    <td class="center">

                                        <?php if($this->params['prefix']=='accounting'){ ?>
                                            <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/account_transactions/edit/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-folder-open"></i></button>
                                        <?php } ?>

                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/edit/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/delete/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>                       
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>


                    <div class="tab-pane fade " id="supplier">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Id</th>                                
                                    <th>Account Number</th>
                                    <!-- <th>Last Name</th>
                                    <th>First Name</th>                            
                                    <th>Middle Name</th> -->
                                    <th>Company</th>
                                    <th>Mobile No.</th>
                                    <th>Address</th>
                                    <th>Account  Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $key => $value) { if($value['Account']['account_type_id'] ==2){ ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $value['Account']['id']; ?></td>
                                    <td><?php echo $value['Account']['account_number']; ?></td>
                                    <!-- <td><?php echo $value['Account']['last_name']; ?></td>
                                    <td><?php echo $value['Account']['first_name']; ?></td>
                                    <td><?php echo $value['Account']['middle_name']; ?></td> -->
                                    <td><?php echo $value['Account']['company']; ?></td>
                                    <td><?php echo $value['Account']['mobile_no']; ?></td>
                                    <td><?php echo $value['Account']['address']; ?></td>
                                    <td><?php echo $accountTypes[$value['Account']['account_type_id']]; ?></td>
                                    <td class="center">
                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/edit/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/delete/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>                       
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade " id="servicecenter">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Id</th>                                
                                    <th>Account Number</th>
                                    <!-- <th>Last Name</th>
                                    <th>First Name</th>                            
                                    <th>Middle Name</th> -->
                                    <th>Company</th>
                                    <th>Mobile No.</th>
                                    <th>Address</th>
                                    <th>Account  Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $key => $value) { if($value['Account']['account_type_id'] ==3){ ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $value['Account']['id']; ?></td>
                                    <td><?php echo $value['Account']['account_number']; ?></td>
                                    <!-- <td><?php echo $value['Account']['last_name']; ?></td>
                                    <td><?php echo $value['Account']['first_name']; ?></td>
                                    <td><?php echo $value['Account']['middle_name']; ?></td> -->
                                    <td><?php echo $value['Account']['company']; ?></td>
                                    <td><?php echo $value['Account']['mobile_no']; ?></td>
                                    <td><?php echo $value['Account']['address']; ?></td>
                                    <td><?php echo $accountTypes[$value['Account']['account_type_id']]; ?></td>
                                    <td class="center">
                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/edit/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                        <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/delete/<?php echo $value['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>                       
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>    
                <!-- /.table-responsive -->
               
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
