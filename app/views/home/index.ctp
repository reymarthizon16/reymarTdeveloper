<?php echo $this->Html->script('/data/morris-data.js');?>
<?php echo $this->Html->script('/data/flot-data.js');?>
<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>    
</div> -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Stock Status</h1>
    </div>
  
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['StorageStatus'][5]['total']; ?></div>
                        <div>Reposes !</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

     <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['StorageStatus'][2]['total']; ?></div>
                        <div>On Delivery !</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bug fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['StorageStatus'][4]['total']; ?></div>
                        <div>Need to Repair !</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
  <!--   <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-wrench fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['StorageStatus'][6]['total']; ?></div>
                        <div>Repair !</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div> -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-wrench fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $data['StorageStatus'][6]['total']; ?></div>
                        <div>Under Repair !</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

    <div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Bar Chart Example
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-bar-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="749" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 749px; height: 400px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 111px; text-align: center;">12/05</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 221px; text-align: center;">12/07</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 332px; text-align: center;">12/09</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 443px; text-align: center;">12/11</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 554px; text-align: center;">12/13</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 93px; top: 382px; left: 665px; text-align: center;">12/15</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 369px; left: 21px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 316px; left: 2px; text-align: right;">1000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 264px; left: 2px; text-align: right;">2000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 211px; left: 2px; text-align: right;">3000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 158px; left: 2px; text-align: right;">4000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 105px; left: 2px; text-align: right;">5000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 53px; left: 2px; text-align: right;">6000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 2px; text-align: right;">7000</div></div></div><canvas class="flot-overlay" width="749" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 749px; height: 400px;"></canvas></div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
       
        <div class="panel panel-default">
            <div class="panel-heading">
                Stock Percentage per Item Type
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-pie-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="749" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 749px; height: 400px;"></canvas><canvas class="flot-overlay" width="749" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 749px; height: 400px;"></canvas><div class="legend"><div style="position: absolute; width: 57px; height: 64px; top: 5px; right: 5px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:5px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,194,64);overflow:hidden"></div></div></td><td class="legendLabel">Series 0</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(175,216,248);overflow:hidden"></div></div></td><td class="legendLabel">Series 1</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(203,75,75);overflow:hidden"></div></div></td><td class="legendLabel">Series 2</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(77,167,77);overflow:hidden"></div></div></td><td class="legendLabel">Series 3</td></tr></tbody></table></div></div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-4 -->
</div>
<?php 
//debug($data['pieChart']);
    $i=1;
    foreach ($data['pieChart'] as $barkey => $barvalue) {
        $data['barChartTicks'][$i] = $barvalue['label'];
        $data['barChart'][] = array(
            'label' => $barvalue['label'],
            'data'=>array(array($i,intval($barvalue['data']))),
            'bars'=>array('show'=>true,'barWidth'=>0.1), 
        );
        $i++;
    }
     /*
 debug( $data['barChart']);
    $data['barChart'] = array();
    $data['barChart'] [0] =array(
        'label'=>'mat',
            'data'=>array(            
                array(1,1),
                array(2,2),
                array(3,3),
                array(4,3),
            ),
            // 'lines'=>array('show'=>true),'points'=>array('show'=>true),
            'bars'=>array('show'=>true,'barWidth'=>0.1), 
    );  
debug( $data['barChart']);
    
    $data['barChart'] [1] =array(
        'label'=>'mab',
            'data'=>array(            
                array(1,1),
                array(2,2),
                array(3,3),
                array(4,3),
            ),
            // 'lines'=>array('show'=>true),'points'=>array('show'=>true),
            'bars'=>array('show'=>true,'barWidth'=>0.1), 
    );
    $data['barChart'] [2] =array(
        'label'=>'mab3',
            'data'=>array(            
                array(1,6),
                array(2,3),
                array(3,10),
                array(4,11),
            ),
            // 'lines'=>array('show'=>true),'points'=>array('show'=>true),
            'bars'=>array('show'=>true,'barWidth'=>0.1), 
    );
    */
 ?>

<script>
    var piedata = <?php echo $this->Javascript->object($data['pieChart']);?>;
    var bardata = <?php echo $this->Javascript->object($data['barChart']);?>;
    var barticks = <?php echo $this->Javascript->object($data['barChartTicks']);?>;
    jQuery(document).ready(function(){

        //Flot Pie Chart
        $(function() {

            var piedatadata = piedata;

            var plotObj = $.plot($("#flot-pie-chart"), piedatadata, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        });

    });
    
      var data,data1,options,chart;
      
      data1 = [ [1,5],[2,5],[3,6],[4,9],[5,7],[6,6],[7,2],[8,1],[9,3] ];
      
      var data2 = [], 
            data3=[];

      for(var i = 1; i < 10; i++) { data2.push([i,i * 2])}
      for(var i = 1; i < 10; i++) { data3.push([i,10 * Math.random()])}

      data = [
            { data:data1, label:"fixed", lines:{show:true} }
            ,{ data:data2, label:"linear", lines:{show:true}, points:{show:true} }
            ,{ data:data3, label:"random", bars:{ show:true, barWidth:0.5} }
            ];
    console.log(barticks);
    console.log(bardata);
      options = {
        // legend:{position:"nw"},
        xaxis: {
            // ticks: barticks,
            autoscaleMargin: 0.10,

        },
        series: {
             bars: {
                 show: 'bars',
                 barWidth: 1,
                 align: 'center'
             },
         },


    };

      $(document).ready(function(){
        chart = $.plot($("#flot-bar-chart"),bardata,options);
      });

</script>