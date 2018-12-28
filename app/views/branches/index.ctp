
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Branches</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">               
               <button type="button" onclick="window.location='/<?php echo $this->params['prefix']; ?>/branches/add';" class="btn btn-primary">Add Branches</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Id</th>                                
                            <th>Code</th>      
                            <th>Branch</th>      
                            <th>Enabled</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($branches as $key => $value) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $value['Branch']['id']; ?></td>
                            <td><?php echo $value['Branch']['code']; ?></td>
                            <td><?php echo $value['Branch']['name']; ?></td>
                            <td><?php echo $value['Branch']['enabled']; ?></td>
                            <td class="center">
                                <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/branches/edit/<?php echo $value['Branch']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/branches/delete/<?php echo $value['Branch']['id']; ?>';" type="button"><i class="glyphicon glyphicon-remove"></i></button>
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
