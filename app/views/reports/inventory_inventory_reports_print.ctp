 <style>
    @page{
        margin: 2%;
    }
    table{
        border-collapse: collapse;
    }
    .table{
        width: 100%;
    }
</style>
 <table class="table table-striped table-bordered table-hover" style="font-size:10px;border-collapse: collapse;width: 100%;" border="1">
    <thead class="thcenter">
        <tr>
            <th colspan="<?php echo 2+count($branches)+3+count($branches)+3; ?>" style="text-align: center;font-size: 20px;">
                Inventory Report ( <?php echo $filterBranches[$this->data['branch_id']] ?> )
            </th>
        </tr>
        <tr>
            <th colspan="<?php echo 2+count($branches)+3+count($branches)+3; ?>" style="text-align: center;font-size: 12px;">
                Start Date : <?php echo $this->data['start_date']; ?> &nbsp; &nbsp; &nbsp; End Date : <?php echo $this->data['end_date']; ?>        
            </th>
        </tr>
        <tr>
            <th></th>
            <th colspan="<?php echo count($branches)+3; ?>" >STOCK IN FROM</th>
            <th colspan="<?php echo count($branches)+3; ?>" >STOCK IN TO</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="<?php echo count($branches); ?>" >BRANCH</th>
            <th colspan="3" >Customer</th>
            <th colspan="<?php echo count($branches); ?>" >BRANCH</th>
            <th></th>
        </tr>
        <tr>
            <th>Model</th>     
            <th>Prev</th>
            <th>Customer(repo)</th>
            <th>Delivered</th>
            <?php foreach ($branches as $brancheskey => $branchesvalue) {
                echo "<th>".$branchesvalue."</th>";
            } ?>

            <th>Cash</th>
            <th>INSTALL</th>
            <th>COOP</th>

            <?php foreach ($branches as $brancheskey => $branchesvalue) {
                echo "<th>".$branchesvalue."</th>";
            } ?>
            <th>Ending</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $models_id => $modelsvalue) { 
            $out = 0;
            $in = 0;
            if( isset($thisModelOnly[$models_id])) {
            ?>                          
            <tr>
                <td><?php echo $modelsvalue; ?></td>
                <td><?php echo $data['prevStock'][$models_id]['total']; $in += $data['prevStock'][$models_id]['total']; ?></td>                                
                <td><?php echo $data['repoStock'][$models_id]['total']; $in += $data['repoStock'][$models_id]['total']; ?></td>
                <td><?php echo $data['deliveryStock'][$models_id]['total']; $in += $data['deliveryStock'][$models_id]['total']; ?></td>

                <?php foreach ($branches as $branch_id => $branchesvalue) {
                    echo "<td>".$data['stockInFromBranch'][$models_id][$branch_id]['total']."</td>";
                    $in += $data['stockInFromBranch'][$models_id][$branch_id]['total'];
                } ?>

                <td ><?php echo $data['stockInToCustomer'][$models_id][1]['total']; $out += $data['stockInToCustomer'][$models_id][1]['total']; ?></td>
                <td ><?php echo $data['stockInToCustomer'][$models_id][2]['total']; $out += $data['stockInToCustomer'][$models_id][2]['total']; ?></td>
                <td ><?php echo $data['stockInToCustomer'][$models_id][3]['total']; $out += $data['stockInToCustomer'][$models_id][3]['total']; ?></td>

                <?php foreach ($branches as $branch_id => $branchesvalue) {
                    echo "<td>".$data['stockInToBranch'][$models_id][$branch_id]['total']."</td>";
                    $out += $data['stockInToBranch'][$models_id][$branch_id]['total'];
                } ?>
                <td><?php echo $in - $out; ?></td>
            </tr>
        <?php } ?>
        <?php } ?>
        
    </tbody>
</table>