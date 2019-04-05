<?php
class ReportsController extends AppController {

	var $name = 'Reports';

	var $uses = array('Storage','Branch','Model','Type','Account','User','Item','Brand');

	function inventory_inventory_reports(){
		
		$branchId = $this->data['branch_id'];
		$startDate = $this->data['start_date']." 00:00:00";
		$endDate = $this->data['end_date']." 23:59:59";

		$data = array();
		$thisModelOnly = array();

		$checking_model = '231';
		$b_model_checkString = '';
		$c_model_checkString = '';
		if($checking_model){
			$b_model_checkString = " and b.model_id = '{$checking_model}' ";
			$c_model_checkString = " and c.model_id = '{$checking_model}' ";

			$b_model_checkString = " and b.model_id in (87,98,109) ";
			$c_model_checkString = " and c.model_id in (87,98,109) ";
		}
	
		$repoQuery = "
		select * from (
			
			select 
				b.model_id,concat('-',b.is_reposes,'-'),count( b.serial_no ) as total
			 from 
			 	
				 items b 
				join models c on c.id = b.model_id 
				join branches d on d.id = b.started_branch_id
			where 
				( b.started_branch_id = '{$branchId}' and is_reposes = 1 and b.entry_datetime >= '{$startDate}' and b.entry_datetime <= '{$endDate}' {$b_model_checkString} )				
			group by b.model_id

		)Reports
		";		
	$this->log($repoQuery,'repoQuery');
		$repoStock = $this->Model->query($repoQuery);

		foreach ($repoStock as $tmpkey => $tmpvalue) {

			$data['repoStock'] [ $tmpvalue['Reports']['model_id'] ] ['total']+= $tmpvalue['Reports']['total'];

			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}
	
		$deliveryQueryPrev = "
		select * from (
			select 
				is_reposes,model_id,branch_id,sum(if(statuss = 'plus', total, 0) - if(statuss = 'minus', total, 0) ) as total
			from (

				select 
					#b.model_id,a.from_branch_id as branch_id,count( b.serial_no ) as total
					b.is_reposes,b.model_id,a.to_branch_id as branch_id,'plus' as statuss ,count( b.serial_no ) as total,rand()
				 from 
					receiving_transaction_details a 
					join receiving_transactions aa on a.receiving_transaction_id = aa.id
					join items b on a.serial_no = b.serial_no 
					join models c on c.id = b.model_id 
					join branches d on d.id = a.to_branch_id
				where 
					a.confirmed = 1 and a.to_branch_id = '{$branchId}' 
					and aa.type = 1 and aa.receiving_datetime < '{$startDate}'
					{$b_model_checkString}
				group by b.model_id,a.from_branch_id,b.is_reposes
				
			union

				select 
					#b.model_id,a.from_branch_id as branch_id,count( b.serial_no ) as total
					b.is_reposes,b.model_id,a.to_branch_id as branch_id,'plus' as statuss ,count( b.serial_no ) as total,rand()
				 from 
					receiving_transaction_details a 
					join receiving_transactions aa on a.receiving_transaction_id = aa.id
					join items b on a.serial_no = b.serial_no 
					join models c on c.id = b.model_id 
					join branches d on d.id = a.to_branch_id
				where 
					a.confirmed = 1 and a.to_branch_id = '{$branchId}' 
					and aa.type = 2 and aa.receiving_datetime < '{$startDate}'
					{$b_model_checkString}
				group by b.model_id,a.from_branch_id,b.is_reposes
				
			union
				
				select 
					c.is_reposes,c.model_id,a.from_branch_id as branch_id,'minus' as statuss ,count( b.serial_no ) as total,rand()
					from 
					stock_transfer_transactions a 
					join stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id
					join items c on c.serial_no = b.serial_no
				where 

					a.type = 1 and a.from_branch_id ='{$branchId}' and b.confirm = 1
					and a.stock_transfer_datetime < '{$startDate}' 
					{$c_model_checkString}
				group by c.model_id,a.from_branch_id,c.is_reposes
				
			union
				
				select 
					c.is_reposes,c.model_id,b.from_branch_id as branch_id,'minus' as statuss ,count( b.serial_no ) as total,rand()
					from 
					sold_transactions a 
					join sold_transaction_details b on a.id = b.sold_transaction_id
					join items c on c.serial_no = b.serial_no
				where 

					a.cancel = 0 and a.delivery_datetime < '{$startDate}' 
					and b.from_branch_id = '{$branchId}'
					{$c_model_checkString}
				group by c.model_id,b.from_branch_id,c.is_reposes

			union

				select 
					b.is_reposes,b.model_id, b.started_branch_id as branch_id,'plus' as statuss,count( b.serial_no ) as total, rand()
				 from 
				 	
					 items b 
					join models c on c.id = b.model_id 
					join branches d on d.id = b.started_branch_id
				where 
					( b.started_branch_id = '{$branchId}' and b.entry_datetime < '{$startDate}' and b.is_reposes = 1 {$b_model_checkString} )
				group by b.model_id,b.is_reposes,b.started_branch_id

			union

				select 
					b.is_reposes,b.model_id, b.started_branch_id as branch_id,'plus' as statuss,count( b.serial_no ) as total, rand()
				 from 
				 	
					 items b 
					join models c on c.id = b.model_id 
					join branches d on d.id = b.started_branch_id
				where 
					( b.started_branch_id = '{$branchId}' and b.entry_datetime <= '{$endDate}' and b.is_reposes = 0 {$b_model_checkString} )
				group by b.model_id,b.is_reposes,b.started_branch_id

			)Rep group by model_id,is_reposes
		)Reports
		";

	$this->log($deliveryQueryPrev,'deliveryQueryPrev');
		$deliveryStockPrev = $this->Model->query($deliveryQueryPrev);
	// $this->log($deliveryStockPrev,'deliveryQueryPrev');

		foreach ($deliveryStockPrev as $tmpkey => $tmpvalue) {

			if(	$tmpvalue['Reports']['is_reposes'] == 1	)
				$data['prevRepo'] [ $tmpvalue['Reports']['model_id'] ] ['total'] += $tmpvalue['Reports']['total'];
			else
				$data['prevStock'] [ $tmpvalue['Reports']['model_id'] ] ['total'] += $tmpvalue['Reports']['total'];

			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$deliveryQuery = "
		select * from (
			select 
				b.model_id,a.from_branch_id as branch_id,count( b.serial_no ) as total
			 from 
				receiving_transaction_details a 
				join receiving_transactions aa on a.receiving_transaction_id = aa.id
				join items b on a.serial_no = b.serial_no 
				join models c on c.id = b.model_id 
				join branches d on d.id = a.to_branch_id
			where 
				a.confirmed = 1 and a.to_branch_id = '{$branchId}'
				and aa.type = 1 and aa.receiving_datetime >= '{$startDate}' and aa.receiving_datetime <= '{$endDate}'
				{$b_model_checkString}
			group by b.model_id,a.from_branch_id
		)Reports
		";
$this->log($deliveryQuery,'deliveryQuery');
		$deliveryStock = $this->Model->query($deliveryQuery);

		foreach ($deliveryStock as $tmpkey => $tmpvalue) {
			$data['deliveryStock'] [ $tmpvalue['Reports']['model_id'] ] ['total'] = $tmpvalue['Reports']['total'];
			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}

		$stockInFromBranchQuery = "
		select * from (
			select 
				b.model_id,a.from_branch_id as branch_id,count( b.serial_no ) as total
			 from 
				receiving_transaction_details a 
				join receiving_transactions aa on a.receiving_transaction_id = aa.id
				join items b on a.serial_no = b.serial_no 
				join models c on c.id = b.model_id 
				join branches d on d.id = a.to_branch_id
			where 
				a.confirmed = 1 and a.to_branch_id = '{$branchId}'
				and aa.type = 2 and aa.receiving_datetime >= '{$startDate}' and aa.receiving_datetime <= '{$endDate}'
				{$b_model_checkString}
			group by b.model_id,a.from_branch_id
		)Reports
		";

		$stockInFromBranch = $this->Model->query($stockInFromBranchQuery);

		foreach ($stockInFromBranch as $tmpkey => $tmpvalue) {
			$data['stockInFromBranch'] [ $tmpvalue['Reports']['model_id'] ] [ $tmpvalue['Reports']['branch_id'] ]['total'] = $tmpvalue['Reports']['total'];
			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}

		$stockInToCustomerQuery = "			
		select * from (
			select 
				b.collection_type_id,model_id,b.delivery_datetime,count( c.serial_no ) as total
			from 
				sold_transaction_details a 
			    join sold_transactions b on a.sold_transaction_id = b.id
			    join items c on c.serial_no = a.serial_no
			    join models d on d.id = c.model_id
			where
				b.cancel = 0 and b.delivery_datetime >= '{$startDate}' and b.delivery_datetime <= '{$endDate}'
				and a.from_branch_id = '{$branchId}'
				{$c_model_checkString}
			group by model_id,collection_type_id
		)Reports
			";
			// $this->log($stockInToCustomerQuery,'stockInToCustomerQuery');
		$stockInToCustomer = $this->Model->query($stockInToCustomerQuery);

		foreach ($stockInToCustomer as $tmpkey => $tmpvalue) {
			$data['stockInToCustomer'] [ $tmpvalue['Reports']['model_id'] ]  [ $tmpvalue['Reports']['collection_type_id'] ] ['total'] = $tmpvalue['Reports']['total']; 
			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}

		$stockInToBranchQuery = "
		select * from (
			select 
				b.model_id,aa.to_branch_id as branch_id,count( b.serial_no ) as total
			 from 
				stock_transfer_transaction_details a join
			    items b on a.serial_no = b.serial_no join
				models c on c.id = b.model_id join
			    stock_transfer_transactions aa on aa.id = a.stock_transfer_transaction_id join
				branches d on d.id = aa.to_branch_id 
			    
			where 
				a.confirm = 1 and aa.from_branch_id = '{$branchId}'
				and aa.stock_transfer_datetime >= '{$startDate}' and aa.stock_transfer_datetime <= '{$endDate}'
				{$b_model_checkString}
			group by b.model_id,aa.to_branch_id
		)Reports
		";
		$stockInToBranch = $this->Model->query($stockInToBranchQuery);

		
		foreach ($stockInToBranch as $tmpkey => $tmpvalue) {
			$data['stockInToBranch'] [ $tmpvalue['Reports']['model_id'] ] [ $tmpvalue['Reports']['branch_id'] ] ['total'] = $tmpvalue['Reports']['total'];
			$thisModelOnly[ $tmpvalue['Reports']['model_id'] ] = $tmpvalue['Reports']['model_id'] ;
		}

		
		$this->set('models',$this->Model->find('list',array('conditions'=>array('enabled'=>true),'fields'=>array('id','name'))));
		$this->set('types',$this->Type->find('list'));		
		$branch_ids = $this->Branch->find('list',array('fields'=>array('id','code'),'conditions'=>array('enabled'=>true)));
		$branch_idNs = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('branches',$branch_ids);
		$this->set('accounts',$this->Account->find('list'));

		$this->set('filterBranches',$branch_idNs);
// $this->log($data,'datadata');
		$this->set('data',$data);
		$this->set('thisModelOnly',$thisModelOnly);

		if(isset($this->data['print'])){
			$this->layout='pdf';
			$this->render('inventory_inventory_reports_print');
		}
	}

	function inventory_inventory_report_details(){
		
		$branchId = $this->data['branch_id'];
		$startDate = $this->data['start_date']." 00:00:00";
		$endDate = $this->data['end_date']." 23:59:59";

		$data = array();
		$thisModelOnly = array();
		$Serials = array();
		// Recieved from Supplier
		$query1 ="
		select * from (
			select 
				a.receiving_datetime,if(a.type=1,a.reference_no,a.stock_transfer_no) as reference_no,a.receiving_report_no,a.source_account_id,c.company,e.name,d.serial_no,d.net_price
			 from 
				receiving_transactions a 
			    join receiving_transaction_details b on a.id = b.receiving_transaction_id 
			    join accounts c on c.id = a.source_account_id
			    join items d on d.serial_no = b.serial_no
			    join models e on e.id = d.model_id
				where a.type = 1 and b.to_branch_id ='{$branchId}' and b.confirmed = 1 
					and a.receiving_datetime >= '{$startDate}' and a.receiving_datetime <= '{$endDate}'
				order by e.name asc
		) Final
		";

		$final1 = $this->Model->query($query1);

		foreach ($final1 as $final1key => $final1value) {
			
			$indexx = $final1value['Final']['receiving_datetime'].$final1value['Final']['reference_no'].$final1value['Final']['receiving_report_no'];
			
			$data['from_supplier'][$indexx] ['receiving_datetime'] = $final1value['Final']['receiving_datetime'];	
			$data['from_supplier'][$indexx] ['reference_no'] = $final1value['Final']['reference_no'];	
			$data['from_supplier'][$indexx] ['receiving_report_no'] = $final1value['Final']['receiving_report_no'];	
			$data['from_supplier'][$indexx] ['company'] = $final1value['Final']['company'];	
			$data['from_supplier'][$indexx] ['model'] = $final1value['Final']['name'];	
			$data['from_supplier'][$indexx] ['Serials'][$final1value['Final']['serial_no']]['model'] = $final1value['Final']['name'];	
			$data['from_supplier'][$indexx] ['Serials'][$final1value['Final']['serial_no']]['serial_no'] = $final1value['Final']['serial_no'];	
			$data['from_supplier'][$indexx] ['Serials'][$final1value['Final']['serial_no']]['net_price'] = $final1value['Final']['net_price'];	

			$Serials[] = $final1value['Final']['serial_no'];
		}

		ksort($data['from_supplier']);
		// Receive from Branch
		$query2 ="
		select * from (
			select 
				a.receiving_datetime,if(a.type=1,a.reference_no,a.stock_transfer_no) as reference_no,a.receiving_report_no,a.source_account_id,c.name as branch,e.name as model,d.serial_no,d.net_price
			 from 
				receiving_transactions a 
			    join receiving_transaction_details b on a.id = b.receiving_transaction_id 
			    join branches c on c.id = b.from_branch_id
			    join items d on d.serial_no = b.serial_no
			    join models e on e.id = d.model_id
				where a.type = 2 and b.to_branch_id ='{$branchId}' and b.confirmed = 1
					and a.receiving_datetime >= '{$startDate}' and a.receiving_datetime <= '{$endDate}'
				order by e.name asc
		) Final
		";

		$final2 = $this->Model->query($query2);

		foreach ($final2 as $final2key => $final2value) {
			
			$indexx = $final2value['Final']['receiving_datetime'].$final2value['Final']['reference_no'].$final2value['Final']['receiving_report_no'];

			$data['from_branch'][$indexx] ['receiving_datetime'] = $final2value['Final']['receiving_datetime'];	
			$data['from_branch'][$indexx] ['reference_no'] = $final2value['Final']['reference_no'];	
			$data['from_branch'][$indexx] ['receiving_report_no'] = $final2value['Final']['receiving_report_no'];	
			$data['from_branch'][$indexx] ['branch'] = $final2value['Final']['branch'];	
			$data['from_branch'][$indexx] ['model'] = $final2value['Final']['model'];	
			$data['from_branch'][$indexx] ['Serials'][$final2value['Final']['serial_no']]['model'] = $final2value['Final']['model'];	
			$data['from_branch'][$indexx] ['Serials'][$final2value['Final']['serial_no']]['serial_no'] = $final2value['Final']['serial_no'];	
			$data['from_branch'][$indexx] ['Serials'][$final2value['Final']['serial_no']]['net_price'] = $final2value['Final']['net_price'];	

			$Serials[] = $final2value['Final']['serial_no'];

		}
		ksort($data['from_branch']);

		$modelS = $this->Model->find('list');
		
		//from previous
		// $this->Storage->recursive = -1;
		/*
		$serial_no=$this->Storage->find('all',array('conditions'=>array(
			'Storage.branch_id'=>$branchId,
			'NOT' => array('Storage.serial_no' => $Serials ,'Storage.entry_datetime'<=$endDate) )) );

		
		foreach ($serial_no as $serial_no2key => $serial_no2value) {
			$data['from_previous'][$serial_no2key] ['model'] = $modelS[$serial_no2value['Item']['model_id']];	
			$data['from_previous'][$serial_no2key] ['serial'] = $serial_no2value['Item']['serial_no'];				
			$data['from_previous'][$serial_no2key] ['net'] = $serial_no2value['Item']['net_price'];				
		}
		*/

		// Stock Transfer Out
		$query3 ="
		select * from (
			select 
				a.stock_transfer_datetime,a.stock_transfer_no,c.name as branch,e.name as model,d.serial_no,a.type
			from 
				stock_transfer_transactions a 
			    join stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id 
			    join branches c on c.id = a.to_branch_id
			    join items d on d.serial_no = b.serial_no
			    join models e on e.id = d.model_id
			where a.type = 1 and a.from_branch_id ='{$branchId}' and b.confirm = 1
				and a.stock_transfer_datetime >= '{$startDate}' and a.stock_transfer_datetime <= '{$endDate}'
				order by e.name asc
		) Final
		";

		$final3 = $this->Model->query($query3);

		$stockOut = array();
		foreach ($final3 as $final3key => $final3value) {
			$stockOut[$final3value['Final']['serial_no']]['stock_datetime'] = $final3value['Final']['stock_transfer_datetime'];
			$stockOut[$final3value['Final']['serial_no']]['stock_transfer_no'] = $final3value['Final']['stock_transfer_no'];
			$stockOut[$final3value['Final']['serial_no']]['branch'] = $final3value['Final']['branch'];
			$stockOut[$final3value['Final']['serial_no']]['type'] = 1;
			$stockOut[$final3value['Final']['serial_no']]['model'] = $final3value['Final']['model'];
			$stockOut[$final3value['Final']['serial_no']]['serial_no'] = $final3value['Final']['serial_no'];
		}

		// Sold
		$query4 ="
		select * from (
			select 
				a.delivery_datetime,a.delivery_receipt_no,concat(c.last_name,', ',c.first_name) as owner,e.name,d.serial_no,e.name as model,d.net_price
		 	from 
				sold_transactions a 
			    join sold_transaction_details b on a.id = b.sold_transaction_id 
			    join accounts c on c.id = a.owner_account_id
			    join items d on d.serial_no = b.serial_no
			    join models e on e.id = d.model_id
				where b.from_branch_id ='{$branchId}' and a.cancel = 0
					and a.delivery_datetime >= '{$startDate}' and a.delivery_datetime <= '{$endDate}'
				order by e.name asc
		) Final
		";

		$final4 = $this->Model->query($query4);

		foreach ($final4 as $final4key => $final4value) {
			$stockOut[$final4value['Final']['serial_no']]['stock_datetime'] = $final4value['Final']['delivery_datetime'];
			$stockOut[$final4value['Final']['serial_no']]['stock_transfer_no'] = $final4value['Final']['delivery_receipt_no'];
			$stockOut[$final4value['Final']['serial_no']]['branch'] = $final4value['Final']['owner'];
			$stockOut[$final4value['Final']['serial_no']]['type'] = 2;

			$stockOut[$final4value['Final']['serial_no']]['serial_no'] = $final4value['Final']['serial_no'];
			$stockOut[$final4value['Final']['serial_no']]['model'] = $final4value['Final']['model'];
			$stockOut[$final4value['Final']['serial_no']]['net_price'] = $final4value['Final']['net_price'];
		}

	
	// sort($stockOut);
	
		// $stockOut=Set::sort($stockOut,'{n}.stock_datetime','asc');
	

		$this->set('models',$this->Model->find('list',array('conditions'=>array('enabled'=>true),'fields'=>array('id','name'))));
		$this->set('types',$this->Type->find('list'));		
		$branch_ids = $this->Branch->find('list',array('fields'=>array('id','code'),'conditions'=>array('enabled'=>true)));
		$branch_idNs = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('branches',$branch_ids);
		$this->set('accounts',$this->Account->find('list'));

		$this->set('filterBranches',$branch_idNs);
	$this->log($data,'dataa');
		$this->set('data',$data);
		$this->set('stockOut',$stockOut);
		$this->set('thisModelOnly',$thisModelOnly);

		if(isset($this->data['print'])){
			$this->layout='pdf';
			$this->render('inventory_inventory_report_details_print');
		}
	}

	function inventory_sales_report(){
		
		$branchId = $this->data['branch_id'];
		$startDate = $this->data['start_date']." 00:00:00";
		$endDate = $this->data['end_date']." 23:59:59";

		$data = array();
		$thisModelOnly = array();
		$Serials = array();
		
		$soldTransactions = "			
		
		select * from (
			select 
				b.delivery_receipt_no,b.delivery_datetime,c.serial_no,d.name as model_name,f.name as type_name,e.name as collection_types,a.sold_price
				,concat(g.first_name,' ',g.last_name) as full_name
			from 
				sold_transaction_details a 
				join sold_transactions b on a.sold_transaction_id = b.id
				join items c on c.serial_no = a.serial_no
				join models d on d.id = c.model_id
				join collection_types e on e.id = b.collection_type_id
				join types f on f.id = c.type_id
				join accounts g on g.id = b.owner_account_id
			where
				b.cancel = 0 and b.delivery_datetime >= '{$startDate}' and b.delivery_datetime <= '{$endDate}'
				and a.from_branch_id = '{$branchId}'
			order by b.delivery_receipt_no
		)Reports
			";
			
		$data = $this->Model->query($soldTransactions);

		$this->set('models',$this->Model->find('list',array('conditions'=>array('enabled'=>true),'fields'=>array('id','name'))));
		$this->set('types',$this->Type->find('list'));		
		$branch_ids = $this->Branch->find('list',array('fields'=>array('id','code'),'conditions'=>array('enabled'=>true)));
		$branch_idNs = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('branches',$branch_ids);
		$this->set('accounts',$this->Account->find('list'));

		$this->set('filterBranches',$branch_idNs);
	$this->log($data,'dataa');
		$this->set('data',$data);		

		if(isset($this->data['print'])){
			$this->layout='pdf';
			$this->render('inventory_sales_report_print');
		}
	}
}
?>