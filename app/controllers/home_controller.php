<?php
class HomeController extends AppController {

	var $uses = array('Storage');

	function login(){
		$this->layout = 'login';
	}

	function accounting_index(){
		$this->index();
	}

	function inventory_index(){
		$this->index();
	}

	function index(){
		
			// $this->Session->setFlash('Error saving user.');

		$stock_status = $this->Storage->query("
			select * from (
				select 
					b.status , count(1) as total, b.serial_no
				from 
				storages a join items b on a.serial_no = b.serial_no

				group by status ) StorageStatus
			");

		$data['StorageStatus'] = array();
		if($stock_status)
			foreach ($stock_status as $stock_statuskey => $stock_statusvalue) {
				$data['StorageStatus'][$stock_statusvalue['StorageStatus']['status']] = array(
					'status'=>$stock_statusvalue['StorageStatus']['status'],
					'total'=>$stock_statusvalue['StorageStatus']['total'],
				);
			}
		

		$graph=$this->Storage->query("
			select * from (
			select c.name, count(1) as total from storages a 
				join items b on a.serial_no = b.serial_no
				join types c on c.id = b.type_id
			where a.`status` = 1
			group by c.id ) Graph
			");

		$data['pieChart'] = array();

		if($graph)
			foreach ($graph as $graphkey => $graphvalue) {
				$data['pieChart'][] = array(
					'label'=>$graphvalue['Graph']['name'],
					'data'=>$graphvalue['Graph']['total'],
				);
			}
		
		$this->set('data',$data);
		$this->render('index');
	}
	
	function accounting_models(){

	}

	function inventory_models(){

	}

	function types(){

	}

	function branches(){

	}

	function warehouse(){

	}

	function accounts(){

	}

	function account_profile( $id ){
		
	}

	function account_supplier_profile( $id ){
		
	}
	

	function stock_transferin_supplier(){

	}

	function stock_transferin_branchtobranch(){

	}
	
	function stock_transferin_branchtobranchconfirm(){

	}

	function stock_transferout_servicecenter(){

	}

	function stock_transferin_servicecenter(){

	}
	
}
?>