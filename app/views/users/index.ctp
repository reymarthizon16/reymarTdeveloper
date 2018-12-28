
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Users</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php 
$role[0] = "Admin";
$role[1] = "Inventory";
$role[2] = "Accounting";
 ?>
 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button type="button" onclick="window.location='/<?php echo $this->params['prefix']; ?>/users/add';" class="btn btn-primary">Add Users</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Id</th>                                
                            <th>User</th>      
                            <th>Role</th>      
                            <th>Position</th>      
                            <th>Mobile No.</th>      
                            <th>Branch</th>      
                            <th>Enabled</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $key => $value) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['User']['id']; ?></td>
                            <td><?php echo $value['User']['name']; ?></td>
                            <td><?php echo $role[$value['User']['role']]; ?></td>
                            <td><?php echo $value['User']['position']; ?></td>
                            <td><?php echo $value['User']['mobile_no']; ?></td>
                            <td><?php echo $branches[$value['User']['branch_id']]; ?></td>
                            <td><?php echo $value['User']['enabled']; ?></td>
                            <td class="center">
                                <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/users/edit/<?php echo $value['User']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/users/delete/<?php echo $value['User']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
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
