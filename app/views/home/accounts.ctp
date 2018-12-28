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
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tabforcustomers" data-toggle="tab" aria-expanded="false">Customers</a>
                    </li>
                    <li class=""><a href="#tabforsuppliers" data-toggle="tab" aria-expanded="false">Suppliers</a>
                    </li>
                    <li class=""><a href="#tabforserviceCenters" data-toggle="tab" aria-expanded="false">Service Centers</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tabforcustomers">                        
                        <?php echo $this->element('accounts/customerIndex'); ?>
                    </div>
                    <div class="tab-pane fade " id="tabforsuppliers">
                        <?php echo $this->element('accounts/suppliersIndex'); ?>
                    </div>
                    <div class="tab-pane fade " id="tabforserviceCenters">
                        <?php echo $this->element('accounts/servicecenterIndex'); ?>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
