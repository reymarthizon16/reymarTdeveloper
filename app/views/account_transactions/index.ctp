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
                <?php //debug($accountTransactions); ?>
                <?php //debug($accountCompanies); ?>
                <?php //debug($accountCustomers); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tabforcustomers" data-toggle="tab" aria-expanded="false">Installments Open Acc.</a>
                    </li>
                    <li><a href="#tabforcustomers_closed" data-toggle="tab" aria-expanded="false">Installments Close Acc.</a>
                    </li>
                    <li><a href="#tabforcustomers_cash" data-toggle="tab" aria-expanded="false">Cash</a>
                    </li>
                    <li><a href="#tabforcustomers_others" data-toggle="tab" aria-expanded="false">Others/Loads</a>
                    </li>
                    <li><a href="#tabforcustomers_disburstment" data-toggle="tab" aria-expanded="false">Disburstment</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tabforcustomers">                        
                        <?php echo $this->element('account_transactions/customerIndex'); ?>
                    </div>
                    <div class="tab-pane" id="tabforcustomers_closed">                        
                        <?php echo $this->element('account_transactions/customerIndexClose'); ?>
                    </div>
                    <div class="tab-pane" id="tabforcustomers_cash">                        
                        <?php echo $this->element('account_transactions/customerIndexCash'); ?>
                    </div>
                    <div class="tab-pane" id="tabforcustomers_others">                        
                        <?php echo $this->element('account_transactions/customerIndexOther'); ?>
                    </div>
                    <div class="tab-pane" id="tabforcustomers_disburstment">                        
                        <?php echo $this->element('account_transactions/customerIndexDisburstment'); ?>
                    </div> 
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
