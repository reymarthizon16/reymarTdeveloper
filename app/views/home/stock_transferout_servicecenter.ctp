<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">   Stock Transfer Branch to Branch</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
           
        </div>
        <div class="panel-body">
            <form role="form">
            <div class="row">
                <div class="col-lg-12">    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">From:</i>
                        </span>
                        <select class="form-control" style="">
                            <option>Branch 1</option>
                            <option>Branch 2</option>
                            <option>Branch 3</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label>Account</label>
                        <p class="form-control-static">Supplier</p>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Address</label>
                        <p class="form-control-static">Address</p>
                    </div>
                </div>

                 <div class="col-lg-12">    
                    <div class="form-group input-group col-lg-3" style="float:left;">
                        <span class="input-group-addon">To:</i>
                        </span>
                        <select class="form-control" style="">
                            <option>Service Center 1</option>
                            <option>Service Center 2</option>
                            <option>Service Center 3</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label>Account</label>
                        <p class="form-control-static">Supplier</p>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Address</label>
                        <p class="form-control-static">Address</p>
                    </div>
                </div>
              
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Transaction
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                            </button>
                                            <button class="btn btn-default" type="button"><i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                    
                                    <div class="list-group" style="overflow: auto;height: 53vh;">
                                        <?php //for ($i=0; $i < 15 ; $i++) {  ?>                                    
                                        <a href="#" class="list-group-item">
                                            <i class=" fa-fw">Fan</i> <strong>Standard</strong>
                                            <span class="pull-right text-muted small">
                                                <b style="padding-right: 10px;">Serial</b>
                                                <em>Standard Fan </em>
                                            </span>
                                        </a>

                                        <a href="#" class="list-group-item">
                                            <i class=" fa-fw">Ref</i> <strong>Samsung</strong>
                                            <span class="pull-right text-muted small">
                                                <b style="padding-right: 10px;">Serial</b>
                                                <em>Refrigerator Samsung 2 doors</em>
                                            </span>
                                        </a>

                                        <a href="#" class="list-group-item">
                                            <i class=" fa-fw">Aircon</i> <strong>LG</strong>
                                            <span class="pull-right text-muted small">
                                                <b style="padding-right: 10px;"> Serial</b>
                                                <em>LG aircon with super fan </em>
                                            </span>
                                        </a>

                                        <a href="#" class="list-group-item">
                                            <i class=" fa-fw">Tv</i> <strong>Samsung</strong>
                                            <span class="pull-right text-muted small">
                                                <b style="padding-right: 10px;">Serial</b>
                                                <em>42 inches Samsung TV </em>
                                            </span>
                                        </a>

                                        <a href="#" class="list-group-item">
                                            <i class=" fa-fw">Speaker</i> <strong>Dr Dre</strong>
                                            <span class="pull-right text-muted small">
                                                <b style="padding-right: 10px;">Serial</b>
                                                <em>Dr Dre Speaker</em>
                                            </span>
                                        </a>
                                     
                                        <?php //} ?>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            &nbsp;
                                            <span style="float:right;">Clear</span>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="" style="overflow: auto;height: 50vh;">
                                                <table class="table table-striped" >
                                                    <thead>
                                                        <tr>
                                                            <th>Model Code</th>
                                                            <th>Model Name</th>
                                                            <th>Serial No.</th>
                                                            <th>SRP</th>
                                                            <th>NET</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php // for ($i=0; $i < 15 ; $i++) {  ?>                                   
                                                        <tr>
                                                            <td>fan0001</td>
                                                            <td>Standard Fan</td>
                                                            <td>Fan</td>
                                                            <td>
                                                                Serial
                                                            </td>
                                                            <td>
                                                                1500
                                                            </td>
                                                            <td>
                                                                1000                                                                
                                                            </td>    
                                                            <td>
                                                                <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </td>                                                       
                                                        </tr>    
                                                         <tr>
                                                            <td>ref0001</td>
                                                            <td>Refrigerator Samsung 2 doors</td>
                                                            <td>Ref</td>
                                                           <td>
                                                                Serial
                                                            </td>
                                                            <td>
                                                                25000
                                                            </td>
                                                            <td>
                                                                20000                                                                
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </td>
                                                        </tr>      
                                                        <?php //} ?>                                                  
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4"> 
                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Recieved By</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="form-group input-group col-lg-10" >
                                            <span class="input-group-addon"><i class="">Approved By</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-8"> 
                                        <div class="form-group input-group col-lg-3" style="float: left;margin-right: 20px;">
                                            <span class="input-group-addon"><i class="">Transfer #</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="form-group input-group col-lg-3" style="float: left;margin-right: 20px;">
                                            <span class="input-group-addon"><i class="">Qty Total</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="form-group input-group col-lg-3" >
                                            <span class="input-group-addon"><i class="">Total Price</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>