
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">AccountTypes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button type="button" onclick="window.location='/inventory/accountTypes/add';" class="btn btn-primary">Add AccountTypes</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Id</th>                                
                            <th>Account Type</th>      
                            <th>Enabled</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accountTypes as $key => $value) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['AccountType']['id']; ?></td>
                            <td><?php echo $value['AccountType']['name']; ?></td>
                            <td><?php echo $value['AccountType']['enabled']; ?></td>
                            <td class="center">
                                <button class="btn btn-default" onclick="window.location='/inventory/accountTypes/edit/<?php echo $value['AccountType']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-default" onclick="window.location='/inventory/accountTypes/delete/<?php echo $value['AccountType']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
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
