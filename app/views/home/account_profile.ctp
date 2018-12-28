 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Account Profile
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab" aria-expanded="false">Transactions</a>
                    </li>
                    <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Profile</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="home">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        
                                                        <strong>Full Name : </strong>
                                                            <span>REYMART HIZON</span>
                                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <strong>Address : </strong>                                                        
                                                            <span>SJC</span> 
                                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <strong>Contact No. : </strong>                                                        
                                                            <span>0917 886 5039</span> 
                                                        
                                                    </div>
                                                    <!-- .panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> 
                                                                            <?php echo $this->element('/account_profile/customerTransactionHeader'); ?>                                                                            
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        
                                                                        <div class="panel panel-default">
                                                                            <!-- <div class="panel-heading">
                                                                                &nbsp;
                                                                            </div> -->
                                                                            <!-- /.panel-heading -->
                                                                            <div class="panel-body">
                                                                                <!-- Nav tabs -->
                                                                                <ul class="nav nav-tabs">
                                                                                    <li class="active"><a href="#itemTransaction" data-toggle="tab" aria-expanded="true">Item Transaction</a>
                                                                                    </li>
                                                                                    <li class=""><a href="#itemHistory" data-toggle="tab" aria-expanded="false">Item History</a>
                                                                                    </li>
                                                                                    
                                                                                </ul>

                                                                                <!-- Tab panes -->
                                                                                <div class="tab-content">
                                                                                    <div class="tab-pane fade active in" id="itemTransaction" style="margin-bottom: 20px;">
                                                                                        <?php echo $this->element('/account_profile/customerTransactionBody'); ?>
                                                                                    </div>
                                                                                    <div class="tab-pane fade" id="itemHistory" style="margin-bottom: 20px;">
                                                                                        <?php echo $this->element('/account_profile/customerItemHistory'); ?>
                                                                                    </div>                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.panel-body -->
                                                                        </div>
                                                                        

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> 
                                                                            <?php echo $this->element('/account_profile/customerTransactionHeader'); ?>                                                                            
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <?php echo $this->element('/account_profile/customerTransactionBody'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> 
                                                                            <?php echo $this->element('/account_profile/customerTransactionHeader'); ?>                                                                            
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <?php echo $this->element('/account_profile/customerTransactionBody'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                
                    </div>
                    <div class="tab-pane fade" id="profile">
                        <div class="row">
                            <div class="col-lg-3 well well-lg">
                                <h4>Profile</h4>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>                               
                            </div>
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-3 well well-lg">
                                <h4>Address</h4>
                                <div class="form-group">
                                    <label>REGION</label>
                                    <select class="form-control">
                                        <option>REGION IV</option>
                                        <option>REGION II</option>
                                        <option>REGION III</option>
                                    </select>
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="form-group">
                                    <label>PROVINCE</label>
                                    <select class="form-control">
                                        <option>NUEVA ECIJA</option>                                        
                                    </select>
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control">
                                        <option>Calaocan</option>                                        
                                    </select>
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="form-group">
                                    <label>Free Text</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
