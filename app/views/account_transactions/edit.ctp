<?php //debug($this->data); ?>
 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Account Profile
                <a href="#" class="btn btn-info btn-sm newTransaction col-lg-offset-1" data-toggle="modal" data-target="#newTransaction" style="float: right;">Add New Transaction</a>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                
                    
                            <div class="col-lg-12">                                
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        
                                                        <strong>Full Name : </strong>
                                                            <span><?php echo $this->data['Account']['last_name'].", ".$this->data['Account']['first_name'] ?></span>
                                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <strong>Contact No. : </strong>                                                        
                                                            <span><?php echo $this->data['Account']['mobile_no'] ?></span>                                                         
                                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <strong>Address : </strong>                                                        
                                                            <span><?php echo $this->data['Account']['address'] ?></span> 
                                                        <button style="float: right;" class="btn btn-default" onclick="window.location='/<?php echo $this->params['prefix']; ?>/accounts/edit/<?php echo $this->data['Account']['id']; ?>';" type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                                    </div>
                                                    <!-- .panel-heading -->
                                                   
                                                    <div class="panel-body">
                                                                    
                                                        <div class="panel-group" id="accordion">

                                                            <?php 
                                                            if(!empty($this->data['AccountTransaction'])){
                                                                foreach ($this->data['AccountTransaction'] as $accTkey => $accTvalue) { ?>
                                                                    
                                                                <div class="panel panel-default"  id="<?php echo 'collapse'.$accTkey; ?>">
                                                                    
                                                                    <?php echo $this->Form->create(null,array('id'=>'saveInputform'.$accTkey,'action'=>'edit/'.$this->data['Account']['id']."/".$accTvalue['id'],'controller'=>'account_transactions'));?>

                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $accTkey; ?>"> 
                                                                                <?php echo $this->element('/account_transactions/customerTransactionHeader',array('accTkey'=>$accTkey,'accTvalue'=>$accTvalue,'person_id'=>$person_id,'branches'=>$branches)); ?>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseOne<?php echo $accTkey; ?>" class="panel-collapse collapse <?php if($accTvalue['id'] == $transactionId) echo "in"; ?>">
                                                                        <div class="panel-body">
                                                                            
                                                                            <div class="panel panel-default">
                                                                                <!-- <div class="panel-heading">
                                                                                    &nbsp;
                                                                                </div> -->
                                                                                <!-- /.panel-heading -->
                                                                                <div class="panel-body">
                                                                                   
                                                                                    <?php echo $this->element('/account_transactions/customerTransactionBody',array('accTkey'=>$accTkey,'accTvalue'=>$accTvalue,'branches'=>$branches,'params'=>$params)); ?>
                                                                                   
                                                                                </div>
                                                                                <!-- /.panel-body -->
                                                                            </div>
                                                                            

                                                                        </div>
                                                                        <div style="margin: 10px;" class="row">
                                                                            <button type="submit" class="btn btn-success col-lg-offset-10    col-lg-2" style="">Save</button>
                                                                        </div>
                                                                    </div>
                                                                    <?php echo $this->Form->end();?>                                                            
                                                                </div>
                                                                <?php } ?>

                                                            <?php } else { ?>

                                                                <div class="panel panel-default" id="collapse99">
                                                                    
                                                                    <?php echo $this->Form->create(null,array('id'=>'saveInputform'.$accTkey,'action'=>'edit/'.$this->data['Account']['id'],'controller'=>'account_transactions'));?>

                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $accTkey; ?>"> 
                                                                                <?php echo $this->element('/account_transactions/customerTransactionHeader',array('accTvalue'=>$accTvalue,'branches'=>$branches)); ?>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseOne<?php echo $accTkey; ?>" class="panel-collapse collapse in">
                                                                        <div class="panel-body">
                                                                            
                                                                            <div class="panel panel-default">
                                                                                <!-- <div class="panel-heading">
                                                                                    &nbsp;
                                                                                </div> -->
                                                                                <!-- /.panel-heading -->
                                                                                <div class="panel-body">
                                                                                    <!-- Nav tabs -->
                                                                                    

                                                                                    <!-- Tab panes -->
                                                                                    <div class="tab-content">
                                                                                        <div class="tab-pane fade active in" id="itemTransaction99" style="margin-bottom: 20px;">
                                                                                            <?php echo $this->element('/account_transactions/customerTransactionBody',array('accTkey'=>$accTkey,'accTvalue'=>$accTvalue,'branches'=>$branches,'params'=>$params)); ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.panel-body -->
                                                                            </div>
                                                                            

                                                                        </div>
                                                                        <div style="margin: 10px;" class="row">
                                                                            <button type="submit" class="btn btn-success col-lg-offset-10    col-lg-2" style="">Save</button>
                                                                        </div>
                                                                    </div>

                                                                    <?php echo $this->Form->end();?>                                                            
                                                                </div>

                                                            <?php } ?>
                                                        
                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                    <!-- /.panel-body -->
                                
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>

<div class="modal fade" id="newTransaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">New Transaction</h4>
            </div>
            <div class="modal-body" style="">
                <?php echo $this->Form->create(null,array('id'=>'saveInputform'.$accTkey,'action'=>'edit/'.$this->data['Account']['id'],'controller'=>'account_transactions'));?>
                    <?php echo $this->element('/account_transactions/customerTransactionBody',array('branches'=>$branches,'params'=>$params)); ?>
                    <button type="submit" class="btn btn-success col-lg-offset-8 col-lg-2" style="">Save</button>
                <?php echo $this->Form->end();?>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
    jQuery(document).ready(function(){

        // jQuery('.newTransaction').unbind();
        // jQuery('.newTransaction').click(function(){

            

        //     return false;
        // });

    });
</script>