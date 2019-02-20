
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        
        <?php $session=$this->Session->read('User'); ?>
        
                           
        <a class="btn btn-block btn-social btn-twitter">
            <i class="fa fa-twitter"></i> 
            <?php echo "Hi ".$session['User']['last_name']." ".$session['User']['first_name']; ?>
        </a>
        <ul class="nav" id="side-menu">

            <li>
                <a href="/<?php echo $this->params['prefix'] ?>/home/index"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
            </li>
            <?php if( $this->Session->read('Auth.User.original_role') == 1 || $this->Session->read('Auth.User.original_role') == 0 ){ ?>
            <li>
                <a href="/<?php echo $this->params['prefix'] ?>/storages/index"><i class="fa fa-dashboard fa-fw"></i>Stock Details</a>
            </li>

            <li>
                <a href="/<?php echo $this->params['prefix'] ?>/items/index"><i class="fa fa-dashboard fa-fw"></i>Items</a>
            </li>
            
        <!--
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Transactions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/receiving_transactions/stock_transferin_supplier">Receiving Transaction</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/stock_transfer_transactions/stock_transferin_branchtobranch">Stock Transfer</a>
                    </li>                  
                </ul>                
            </li>
        -->
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Transactions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/receiving_transactions/stock_transferin_supplier_list">Receiving Reports</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/stock_transfer_transactions/stock_transferin_branchtobranch_list">Stock Transfer Reports</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/sold_transactions/sold_index">Sales Transaction Reports</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/reports/inventory_reports">Inventory Report</a>
                    </li>     
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/reports/inventory_report_details">Inventory Report Detail</a>
                    </li>                 
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php } ?>

            <?php if( $this->Session->read('Auth.User.original_role') == 2 || $this->Session->read('Auth.User.original_role') == 0 ){ ?>
            <li class="sidebar-search">
                <form action="/accounting/account_transactions/addCollection" method="post">
                <div class="input-group custom-search-form">
                        <input type="text" name="data[dr_or_accountno]" class="form-control" class='addCollectionParam' placeholder="D.R/Acct.No.">
                        <span class="input-group-btn">
                        <button class="btn btn-default addCollection" type="submit">
                            <i class="fa fa-plus"> Collection</i>
                        </button>
                        </span>
                </div>
                </form>
                <!-- /input-group -->
            </li>

            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Encoding<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/accounting/account_transactions/new_account"><i class="fa fa-dashboard fa-fw"></i>New Account</a>
                    </li>
                    <li>
                        <a href="/accounting/account_transactions/installment"><i class="fa fa-dashboard fa-fw"></i>Installment</a>
                    </li>                   
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="/accounting/account_transactions/index"><i class="fa fa-dashboard fa-fw"></i>Accounting Transactions</a>
            </li>            
            <li>
                <a href="/accounting/deposit_slips/index"><i class="fa fa-dashboard fa-fw"></i>Deposit Slips</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/accounting/account_transactions/reports"><i class="fa fa-dashboard fa-fw"></i>Accounting Report List</a>
                    </li>
                    <li>
                        <a href="/accounting/account_transactions/report_daily"><i class="fa fa-dashboard fa-fw"></i>Accounting Report Daily</a>
                    </li>
                    <li>
                        <a href="/accounting/account_transactions/report_monthly"><i class="fa fa-dashboard fa-fw"></i>Accounting Report Monthly</a>
                    </li>               
                </ul>
                <!-- /.nav-second-level -->
            </li>

            
            <?php } ?>

             <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Management<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                                
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/accounts/index">Accounts</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/brands/index">Brands</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/types/index">Types</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/models/index">Models</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/branches/index">Branches</a>
                    </li>
                    <li>
                        <a href="/<?php echo $this->params['prefix'] ?>/users/index">Users</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="#"></a>
            </li>

            <?php if( $this->Session->read('Auth.User.original_role') == 2 || $this->Session->read('Auth.User.original_role') == 0 ){ ?>
                <li>
                    <a href="#" class='unlock'><i class="fa fa-unlock fa-fw"></i> Unlock</a>
                </li>
            <?php } ?>
            <li>
                <a href="#"></a>
            </li>
            <li>
                <a href="/users/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>

<script type="text/javascript">

    jQuery(document).ready(function(){

        jQuery('.unlock').click(function(){

            if(confirm('Do you want to unlock ?')){
                jQuery('.panel-body .addInstallment').css({'display':''});
                jQuery('.panel-body .addItemPayment').css({'display':''});
                jQuery('.panel-body .SavingTransaction').css({'display':''});
                jQuery('.panel-body .addItemTransaction').css({'display':''});
                jQuery('.panel-body .removeItem').css({'display':''});
                jQuery('.panel-body input,select').removeAttr('readonly');
                jQuery('.panel-body input,select').removeAttr('disabled');

            }

            return false;
        });
    });
    

</script>
<!-- /.navbar-static-side -->