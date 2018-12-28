<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>

    <title> Inventory System </title>
    
    <!-- Bootstrap Core CSS -->
      <?php echo $html->css('/vendor/bootstrap/css/bootstrap.min.css'); ?>

    <!-- MetisMenu CSS -->
      <?php echo $html->css('/vendor/metisMenu/metisMenu.min.css'); ?>

     <!-- DataTables CSS -->
      <?php echo $html->css('/vendor/datatables-plugins/dataTables.bootstrap.css'); ?>

    <!-- DataTables Responsive CSS -->
      <?php echo $html->css('/vendor/datatables-responsive/dataTables.responsive.css'); ?>

    <!-- Custom CSS -->
      <?php echo $html->css('/dist/css/sb-admin-2.css'); ?>

    <!-- Custom Fonts -->
      <?php echo $html->css('/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type'); ?>

      <?php echo $html->css('/vendor/bootstrap-social/bootstrap-social.css'); ?>

      <?php echo $html->css('custom.css'); ?>
      <?php echo $html->css('/vendor/morrisjs/morris.css'); ?>
        
        <?php echo $html->css('combobox/prism.css')?>
        <?php echo $html->css('combobox/chosen.css')?>
        <?php echo $html->css('/datetimepicker/jquery.datetimepicker.css')?>
        
    <!-- jQuery -->
    <?php //echo $this->Html->script('/vendor/jquery/jquery.min.js');?>
    <?php echo $this->Html->script('/vendor/jquery/jquery.js');?>

    <!-- Bootstrap Core JavaScript -->
    <?php echo $this->Html->script('/vendor/bootstrap/js/bootstrap.min.js');?>

    <!-- Metis Menu Plugin JavaScript -->
    <?php echo $this->Html->script('/vendor/metisMenu/metisMenu.min.js');?>

    <!-- Morris Charts JavaScript -->
    <?php echo $this->Html->script('/vendor/raphael/raphael.min.js');?>
    <?php echo $this->Html->script('/vendor/morrisjs/morris.min.js');?>
    

    <!-- Flot Charts JavaScript -->
    <?php //echo $this->Html->script('/vendor/flot/excanvas.min.js');?>
    <?php echo $this->Html->script('/vendor/flot/jquery.flot.js');?>
    <?php echo $this->Html->script('/vendor/flot/jquery.flot.pie.js');?>
    <?php //echo $this->Html->script('/vendor/flot/jquery.flot.resize.js');?>
    <?php //echo $this->Html->script('/vendor/flot/jquery.flot.time.js');?>
    <?php //echo $this->Html->script('/vendor/flot-tooltip/jquery.flot.tooltip.min.js');?>
    

    <!-- DataTables JavaScript -->
    <?php echo $this->Html->script('/vendor/datatables/js/jquery.dataTables.min.js');?>
    <?php echo $this->Html->script('/vendor/datatables-plugins/dataTables.bootstrap.min.js');?>
    <?php echo $this->Html->script('/vendor/datatables-responsive/dataTables.responsive.js');?>

    <!-- Custom Theme JavaScript -->
    <?php echo $this->Html->script('/dist/js/sb-admin-2.js');?>
    
    <?php echo $this->Javascript->link('combobox/chosen.jquery.js')?>
    <?php echo $this->Javascript->link('combobox/prism.js')?>
    <?php echo $this->Javascript->link('tableExport.js')?>
    <?php echo $this->Javascript->link('/datetimepicker/jquery.datetimepicker.js')?>

	<?php
		
		echo $scripts_for_layout;
	?>
</head>
<body>
	  <div id="wrapper">

        <!-- Navigation -->
        <!--
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="" href="index.html">City Trust Appliances and Furniture Center </a>
            </div>
          -->   

           <?php //echo $this->element('/onlayout/notifications'); ?>
            
        <!-- </nav> -->
      
        <?php echo $this->element('/onlayout/menubar'); ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="sessionFlash" class="" style="color:blue;">  
                            <?php echo $this->Session->flash();?>
                            <?php echo $this->Session->flash('auth');?>
                        </div>
						<?php echo $content_for_layout;?>					
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            
        </div>
        <!-- /#page-wrapper -->
        <div>
			<?php echo $this->element('sql_dump'); ?>
		</div>

    </div>
    	  
    <script>
    
    var prefix = <?php echo $this->Javascript->object($this->Session->read('prefix')); ?>;
    // export excell
    function doExport(selector, params) {
      var options = {
        //ignoreRow: [1,11,12,-2],
        //ignoreColumn: [0,-1],
        //pdfmake: {enabled: true},         
      };

      $.extend(true, options, params);

      $(selector).tableExport(options);
    }
    
    $(document).ready(function() {
        $('.dataTables-example').DataTable({
            responsive: true
        });

        $('#dataTables-example').DataTable({
            responsive: true
        });

        jQuery('.input.text').find('input').addClass('form-control');
        jQuery('.input.select').find('select').addClass('form-control chosen-select');

        jQuery('input').attr('autocomplete','off');
        
        jQuery('.chosen-select').chosen();
                
        setTimeout(function () {                                     
            jQuery('.remove-chosen').chosen('destroy');
            jQuery('.remove-chosen').removeClass('chosen-select');
        }, 500);  
        
        jQuery('.datetimepicker').datetimepicker();
        jQuery('.datepicker').datetimepicker({timepicker:false,format:'Y-m-d'});
        jQuery('.datepicker').css({'width':'100px'});

        jQuery('.myModal').modal({backdrop: 'static', keyboard: false});
    });
    var matDebug;
    </script>
</body>
</html>