<?php
class StockTransferTransactionsController extends AppController {

	var $name = 'StockTransferTransactions';

	var $uses = array('StockTransferTransaction','StockTransferTransactionDetail','ReceivingTransactionDetail','Storage','Branch','Model','Type','Account','User','Item');

	function inventory_stock_transferin_branchtobranch($id = null){
		$this->stock_transferin_branchtobranch($id);
	}

	function stock_transferin_branchtobranch($id = null){
		
		if($this->data){

			if(isset($this->data['StockTransferTransaction'])){

				$error = false;
				
				$this->StockTransferTransaction->begin();

				if(!isset($this->data['StockTransferTransaction']['id']))
					$this->StockTransferTransaction->create();

				$this->data['StockTransferTransaction']['entry_datetime'] = date('Y-m-d H:i:s');
				$this->data['StockTransferTransaction']['user_id'] = $this->Auth->user('id');
				
				if( $this->StockTransferTransaction->save($this->data['StockTransferTransaction'],array('validate'=>'only')) ){

					if(!isset($this->data['StockTransferTransaction']['id']))
						$this->data['StockTransferTransaction']['id'] = $this->StockTransferTransaction->id;

					
					$this->StockTransferTransaction->StockTransferTransactionDetail->deleteAll(array(						
								'StockTransferTransactionDetail.stock_transfer_transaction_id'=>$this->data['StockTransferTransaction']['id'],
								'NOT'=>array('StockTransferTransactionDetail.serial_no'=>$this->data['StockTransferTransaction']['StockTransferTransactionDetail']),
								'StockTransferTransactionDetail.confirm'=>0,
							));
					
					foreach ($this->data['StockTransferTransaction']['StockTransferTransactionDetail'] as $rTDkey => &$rTDvalue) {

						$existing=$this->StockTransferTransaction->StockTransferTransactionDetail->find('first',array(
							'conditions'=>array(
								'StockTransferTransactionDetail.stock_transfer_transaction_id'=>$this->data['StockTransferTransaction']['id'],
								'StockTransferTransactionDetail.serial_no'=>$rTDvalue,
							),'recursive'=>-1));
						
						$tmp = array();

						if(empty($existing)){
							$this->StockTransferTransaction->StockTransferTransactionDetail->create();
							$tmp['StockTransferTransactionDetail'] = array(
									'serial_no'=>$rTDvalue,
									'status'=>1,
									'stock_transfer_transaction_id'=>$this->data['StockTransferTransaction']['id'],
									'quantity'=>1,
									'entry_datetime'=>date('Y-m-d H:i:s'),
									'user_id'=>$this->Auth->user('id')
									);
						}

						if($tmp)
							if( $this->StockTransferTransaction->StockTransferTransactionDetail->save($tmp,array('validate'=>'only')) ){								
							}else{$error = true;}

						
					}
				
					
				}else{$error = true;}
				
				if($error)
					$this->StockTransferTransaction->rollback();
				else
					$this->StockTransferTransaction->commit();
				
				if(!empty($this->data['StockTransferTransaction']['id']))
					$id = $this->data['StockTransferTransaction']['id'];
			}
		}


		if(!empty($id)){

			$this->data = $this->StockTransferTransaction->find('first',array('conditions'=>array('StockTransferTransaction.id'=>$id)));
		}

		debug($this->data);

	
		$serviceAccountId = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));
		$this->set('serviceAccounts',$serviceAccountId);
		$customer_sourceAccounts = $this->getAccountCustomer();
		$this->set('customerAccounts',$customer_sourceAccounts);
		$branches = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));		
		$this->set('toBranches',$branches);
		$this->set('fromBranches',$branches);
		$users = $this->User->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('preparedByUsers',$users);
		$this->set('approvedByUsers',$users);

		$this->render('stock_transferin_branchtobranch');
	}

	function inventory_confirm_stock_transfer_transaction_details($id){

		$error = false;

		$existing=$this->StockTransferTransactionDetail->find('first',array(
							'conditions'=>array(
								'StockTransferTransactionDetail.id'=>$this->data['id'],
								'StockTransferTransactionDetail.serial_no'=>$this->data['serial_no'],
							),'recursive'=>-1));

		$mainStockTransfer = $this->StockTransferTransaction->find('first',array('conditions'=>array('id'=>$existing['StockTransferTransactionDetail']['stock_transfer_transaction_id']),'recursive'=>-1));
		$branches = $this->Branch->find('list');

		if($existing && $existing['StockTransferTransactionDetail']['confirm'] == 0){
			
			if($mainStockTransfer['StockTransferTransaction']['type'] == 1){

				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>array(1,4,5))
				));
				if($storage){
					if( $storage['Storage']['status'] == 4 || $storage['Storage']['status'] == 5)
						$storage['Storage']['secondary_status'] =  $storage['Storage']['status'];

					$storage['Storage']['status'] = 2;
					if( ! $this->Storage->save($storage) ){
						$error = true;
					}
				}

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>array(1,4,5))
				));
				if($item){
					
					if( $item['Item']['status'] == 4 || $item['Item']['status'] == 5)
						$item['Item']['secondary_status'] =  $item['Item']['status'];

					$this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$branches[$mainStockTransfer['StockTransferTransaction']['to_branch_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					$item['Item']['status'] = 2;
					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

			}

			if($mainStockTransfer['StockTransferTransaction']['type'] == 2){

				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>4)
				));
				if($storage){
					$storage['Storage']['status'] = 6;
					if( ! $this->Storage->save($storage) ){
						$error = true;
					}
				}

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>4)
				));
				if($item){
					$serviceAccountId = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));

					$this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$serviceAccountId[$mainStockTransfer['StockTransferTransaction']['service_account_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					$item['Item']['status'] = 6;
					$item['Item']['repair_on_account_id'] = $mainStockTransfer['StockTransferTransaction']['service_account_id'];
					$item['Item']['repair_datetime'] = Date('Y-m-d H:i:s');
					$item['Item']['is_repair'] = 0;

					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

				$existing['StockTransferTransactionDetail']['received'] = 1;
			}	

			if($mainStockTransfer['StockTransferTransaction']['type'] == 3){

				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>4)
				));

				if($storage){
					
					if( ! $this->Storage->delete($storage['Storage']['id']) ){
						$error = true;
					}
				}

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>4)
				));
				if($item){
						
					$customerAccountId = $this->Account->find('list',array('fields'=>array('id','last_name'),'conditions'=>array('account_type_id'=>1)));

					$this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$customerAccountId[$mainStockTransfer['StockTransferTransaction']['customer_account_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					$item['Item']['status'] = 3;
					$item['Item']['owner_account_id'] = $mainStockTransfer['StockTransferTransaction']['customer_account_id'];
					$item['Item']['repair_on_account_id'] = null;
					$item['Item']['repair_datetime'] = null;
					$item['Item']['is_repair'] = 0;

					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

				$existing['StockTransferTransactionDetail']['received'] = 1;
			}			

			if(!$error){
				$existing['StockTransferTransactionDetail']['confirm'] = 1;
			
				if( $this->StockTransferTransactionDetail->save($existing,array('validate'=>'only')) ){								
				}else{$error = true;}
			}

		}
		// $this->log($existing,'confirm');				
		
		$data['success'] = true;

		$this->appajax($data);
	}

	function inventory_unconfirm_stock_transfer_transaction_details($id){

		$error = false;

		$existing=$this->StockTransferTransactionDetail->find('first',array(
							'conditions'=>array(
								'StockTransferTransactionDetail.id'=>$this->data['id'],
								'StockTransferTransactionDetail.serial_no'=>$this->data['serial_no'],
							),'recursive'=>-1));

		$mainStockTransfer = $this->StockTransferTransaction->find('first',array('conditions'=>array('id'=>$existing['StockTransferTransactionDetail']['stock_transfer_transaction_id']),'recursive'=>-1));
		$branches = $this->Branch->find('list');

		if($existing && $existing['StockTransferTransactionDetail']['confirm'] == 1){
			
			if($mainStockTransfer['StockTransferTransaction']['type'] == 1){

				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>array(2))
				));
				if($storage){
					$storage['Storage']['status'] = 1;
					if( $storage['Storage']['secondary_status'] == 4 || $storage['Storage']['secondary_status'] == 5)
						$storage['Storage']['status'] =  $storage['Storage']['secondary_status'];
					$storage['Storage']['secondary_status'] =  null;

					if( ! $this->Storage->save($storage) ){
						$error = true;
					}
				}

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>array(2))
				));
				if($item){
					
					$item['Item']['status'] = 1;
					if( $item['Item']['secondary_status'] == 4 || $item['Item']['secondary_status'] == 5)
						$item['Item']['status'] =  $item['Item']['secondary_status'];
					$item['Item']['secondary_status'] =  null;

					// $this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$branches[$mainStockTransfer['StockTransferTransaction']['to_branch_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

			}

			if($mainStockTransfer['StockTransferTransaction']['type'] == 2){

				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>6)
				));
				if($storage){
					$storage['Storage']['status'] = 4;
					if( ! $this->Storage->save($storage) ){
						$error = true;
					}
				}

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>6)
				));
				if($item){
					$serviceAccountId = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));

					// $this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$serviceAccountId[$mainStockTransfer['StockTransferTransaction']['service_account_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					$item['Item']['status'] = 4;
					$item['Item']['repair_on_account_id'] = null;
					$item['Item']['repair_datetime'] = null;
					// $item['Item']['is_repair'] = 0;

					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

				$existing['StockTransferTransactionDetail']['received'] = 0;
			}	

			if($mainStockTransfer['StockTransferTransaction']['type'] == 3){

				/*
				$storage=$this->Storage->find('first',array('recursive'=>-1,
					'conditions'=>array('Storage.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>4)
				));

				if($storage){
					
					if( ! $this->Storage->delete($storage['Storage']['id']) ){
						$error = true;
					}
				}
				*/

				$item=$this->Item->find('first',array('recursive'=>-1,
					'conditions'=>array('Item.serial_no'=>$existing['StockTransferTransactionDetail']['serial_no'],'status'=>3)
				));
				if($item){
						
					$customerAccountId = $this->Account->find('list',array('fields'=>array('id','last_name'),'conditions'=>array('account_type_id'=>1)));

					// $this->addItemHistory($item['Item']['serial_no'],'Stock Transfered from Branch ('.$branches[$mainStockTransfer['StockTransferTransaction']['from_branch_id']].') to ('.$customerAccountId[$mainStockTransfer['StockTransferTransaction']['customer_account_id']].') using ST# of '.$mainStockTransfer['StockTransferTransaction']['stock_transfer_no'],$mainStockTransfer['StockTransferTransaction']['stock_transfer_datetime'] );

					$item['Item']['status'] = 4;
					// $item['Item']['owner_account_id'] = $mainStockTransfer['StockTransferTransaction']['customer_account_id'];
					// $item['Item']['repair_on_account_id'] = null;
					// $item['Item']['repair_datetime'] = null;
					// $item['Item']['is_repair'] = 0;

					if( ! $this->Item->save($item) ){
						$error = true;
					}
				}

				$existing['StockTransferTransactionDetail']['received'] = 0;
			}			

			if(!$error){
				$existing['StockTransferTransactionDetail']['confirm'] = 0;
			
				if( $this->StockTransferTransactionDetail->save($existing,array('validate'=>'only')) ){								
				}else{$error = true;}
			}

		}
		// $this->log($existing,'confirm');				
		
		$data['success'] = true;

		$this->appajax($data);
	}

	function inventory_stock_transferin_branchtobranch_list(){
		
		$conditions = array();
		
		if($this->data['filter'] || true){
			if(!empty($this->data['filter']['stockT_no']))
				$conditions['StockTransferTransaction.stock_transfer_no'] = $this->data['filter']['stockT_no'];

			if( !empty($this->data['filter']['start_date']) && !empty($this->data['filter']['end_date']) ){
				$conditions['StockTransferTransaction.stock_transfer_datetime >='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['start_date']." 00:00:01"));
				$conditions['StockTransferTransaction.stock_transfer_datetime <='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['end_date']." 23:59:59"));
			}else{
				$conditions['StockTransferTransaction.stock_transfer_datetime >='] = $this->data['filter']['start_date'] = date('Y-m-d',strtotime("now -1 days 00:00:01"));
				$conditions['StockTransferTransaction.stock_transfer_datetime <='] = $this->data['filter']['end_date'] = date('Y-m-d',strtotime("now 23:59:59"));
			}

			if(isset($this->data['filter']['type']))
				$_SESSION['type'] =  $this->data['filter']['type'];
			else
				$_SESSION['type'] = 1;
			$conditions['StockTransferTransaction.type'] = $this->data['filter']['type'];
			
		}
		$print = $this->data;		
		$this->set('filter',$this->data['filter']);

		$this->data=$this->StockTransferTransaction->find('all',array(
			'conditions'=>array($conditions),
			'order'=>'stock_transfer_datetime desc'
		));

		$items = array();
		$itemm = $this->Item->find('all',array('recursive'=>-1));
		foreach ($itemm as $key => $value) {
			$items [ $value['Item']['serial_no'] ] = $value['Item'];
		}
		$this->set('items',$items);
		$this->set('models',$this->Model->find('list'));
		$this->set('types',$this->Type->find('list'));
		$this->set('users',$this->User->find('list'));
		$this->set('branches',$this->Branch->find('list'));

		if(isset($print['print'])){
			$this->layout='pdf';
			$this->render('stocktransfer_print');
		}
	}

	function inventory_getItems(){

		$tmpdata=$this->StockTransferTransaction->find('all',array(
			'conditions'=>array('stock_transfer_no'=>$this->data['stock_transfer_no']),
			'order'=>'stock_transfer_datetime desc'
		));

		$data['StockTransferTransactionDetail'] = array();
		
		foreach ($tmpdata as $key => $value) {
			if($value['StockTransferTransactionDetail'])
				foreach ($value['StockTransferTransactionDetail'] as $akey => $avalue) {
					if($avalue['received'] == 0)
						$data['StockTransferTransactionDetail'][$avalue['serial_no']]['serial_no'] = $avalue['serial_no'];
				}
		}
		

		$data['success'] = true;

		$this->appajax($data);
	}

	
}
?>