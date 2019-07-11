<?php
class ReceivingTransactionsController extends AppController {

	var $name = 'ReceivingTransactions';

	var $uses = array('ReceivingTransaction','StockTransferTransactionDetail','ReceivingTransactionDetail','Storage','Branch','Model','Type','Account','User','Item','Brand','ItemHistory');

	function inventory_stock_transferin_supplier($id = null){
		$this->stock_transferin_supplier($id);
	}

	function stock_transferin_supplier( $id = null){
		
		if(!empty($this->data)){
			$error = false;
			
			$this->ReceivingTransaction->begin();

			if(!isset($this->data['ReceivingTransaction']['id']))
				$this->ReceivingTransaction->create();

			if( $this->ReceivingTransaction->save($this->data['ReceivingTransaction'],array('validate'=>'only')) ){

				if(!isset($this->data['ReceivingTransaction']['id']))
					$this->data['ReceivingTransaction']['id'] = $this->ReceivingTransaction->id;

				$receivingTransactionId = $this->data['ReceivingTransaction']['id'];

				foreach ($this->data['ReceivingTransactionDetail'] as $rTDkey => &$rTDvalue) {

					$rTDvalue['receiving_transaction_id'] = $receivingTransactionId;
					$rTDvalue['type'] = $this->data['ReceivingTransaction']['type'];

					if(!isset($rTDvalue['id']))
						$this->ReceivingTransaction->ReceivingTransactionDetail->create();

					$this->Model->recursive = -1;
					$getBrand = $this->Model->find('first',array('conditions'=>array('id'=>$rTDvalue['model_id'])));
					if($getBrand){
						$rTDvalue['brand_id'] = $getBrand['Model']['brand_id'];
						$rTDvalue['type_id'] = $getBrand['Model']['type_id'];
					}
					if( $this->ReceivingTransaction->ReceivingTransactionDetail->save($rTDvalue,array('validate'=>'only')) ){

						if(!isset($rTDvalue['id']))
							$rTDvalue['id'] = $this->ReceivingTransaction->ReceivingTransactionDetail->id;

						if(!isset($rTDvalue['confirmed']) && $rTDvalue['confirmed']){							
							$this->confirm_receiving_transaction_details($rTDvalue['id']);
						}

					}else{$error = true;}
				}
				
			}else{$error = true;}

			
			if($error)
				$this->ReceivingTransaction->rollback();
			else
				$this->ReceivingTransaction->commit();

			//for confirm
			foreach ($this->data['ReceivingTransactionDetail'] as $rTDkey => &$rTDvalue) {
			
				if(!isset($rTDvalue['confirmed']) && $rTDvalue['confirmed']){
					$this->confirm_receiving_transaction_details($rTDvalue['id']);
				}
			}

		}

		if(!empty($id)){

			$this->data = $this->ReceivingTransaction->find('first',array('conditions'=>array('ReceivingTransaction.id'=>$id)));
		}


		$accountTypes = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>2)));
		$this->set('sourceAccounts',$accountTypes);
		$customer_sourceAccounts = $this->getAccountCustomer();
		$this->set('customer_sourceAccounts',$customer_sourceAccounts);
		$serviceC_sourceAccounts = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));
		$this->set('serviceC_sourceAccounts',$serviceC_sourceAccounts);
		

		$models = $this->Model->find('list',array(
			'fields'=>array('Model.id','Model.name','Brand.name'),
			'conditions'=>array('Model.enabled'=>true),
			'joins'=>array(
				array(
					'table'=>'brands',
					'alias'=>'Brand',
					'conditions'=>array('Brand.id = Model.brand_id')
				),
				array(
					'table'=>'types',
					'alias'=>'Type',
					'conditions'=>array('Type.id = Model.type_id')
				)
			)
		));		
		$this->set('models',$models);
		
		$types = $this->Type->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('types',$types);
		$brands = $this->Brand->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('brands',$brands);
		$branches = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('fromBranches',$branches);
		$this->set('toBranches',$branches);
		$users = $this->User->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('receivedByUsers',$users);
		$this->set('deliverByUsers',$users);
		$this->render('stock_transferin_supplier');
	}

	function inventory_confirm_receiving_transaction_details($id){

		$data = $this->confirm_receiving_transaction_details($id);

		// $data['success'] = true;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function confirm_receiving_transaction_details($id){

		$data['success'] = true; 
		$models = $this->Model->find('list',array('fields'=>array('id','brand_id'),'conditions'=>array('enabled'=>true)));
		$rtd = $this->ReceivingTransactionDetail->find('first',array('conditions'=>array('id'=>$id),'recursive'=>-1));
		$rt = $this->ReceivingTransaction->find('first',array('conditions'=>array('id'=>$rtd['ReceivingTransactionDetail']['receiving_transaction_id']),'recursive'=>-1));

		$branches = $this->Branch->find('list');
		$accounts = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>2),'recursive'=>-1));

		if( !empty($this->data['serial_no']) || !empty($this->data['to_branch_id']) ){

			$rtd['ReceivingTransactionDetail']['serial_no'] = $this->data['serial_no'];			
			$rtd['ReceivingTransactionDetail']['to_branch_id'] = $this->data['to_branch_id'];			
			$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);

		}


		if( $rtd ) {

			$modelBrands = $this->Model->find('list',array('fields'=>array('id','brand_id'),'conditions'=>array('enabled'=>true)));
			$item_exsisting = $this->Item->find('first',array(
				'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no']),'recursive'=>-1));
			
			if( $rt['ReceivingTransaction']['type'] == 1 ){ // from supplier

				if( empty($item_exsisting) ){

					$tmp['Item'] = array(
						'serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],
						'model_id'=>$rtd['ReceivingTransactionDetail']['model_id'],
						'brand_id'=>$modelBrands[$rtd['ReceivingTransactionDetail']['model_id']],
						'type_id'=>$rtd['ReceivingTransactionDetail']['type_id'],
						'status'=>1,
						'quantity'=>1,
						'reference_no'=>$rt['ReceivingTransaction']['reference_no'],
						'receiving_report_no'=>$rt['ReceivingTransaction']['receiving_report_no'],
						'receiving_datetime'=>$rt['ReceivingTransaction']['receiving_datetime'],
						'source_account_id'=>$rt['ReceivingTransaction']['source_account_id'],
						'srp_price'=>$rtd['ReceivingTransactionDetail']['srp_price'],
						'net_price'=>$rtd['ReceivingTransactionDetail']['net_price'],
						'enabled' => true,
						'entry_datetime'=>date('Y-m-d H:i:s')
					);

					
					if(!empty($rtd['ReceivingTransactionDetail']['old_serial_no'])){ // if may old_serial_no sya
						$tmp['Item']['old_serial_no'] = $rtd['ReceivingTransactionDetail']['old_serial_no'];
					}

					if( $this->Item->save($tmp['Item'],array('validate'=>'only')) ){
											
						$this->addItemHistory($tmp['Item']['serial_no'],'Receiving Items from ('.$accounts[$rt['ReceivingTransaction']['source_account_id']].') to ('.$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']].') using RR# of '.$rt['ReceivingTransaction']['receiving_report_no'],$rt['ReceivingTransaction']['receiving_datetime'] );

					}else{

						$data['success'] = false;
						foreach ($this->Item->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}

					if( !empty($rtd['ReceivingTransactionDetail']['old_serial_no']) ){ // if may old_serial_no sya
						
						$item_replace = $this->Item->find('first',array(
							'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['old_serial_no']),'recursive'=>-1));			
						
						$item_replace['Item'] ['is_replaced'] = 1;
						$item_replace['Item'] ['new_serial_no'] = $rtd['ReceivingTransactionDetail']['serial_no'];

						if( $this->Item->save($item_replace['Item'],array('validate'=>'only')) ){

							$rcdt = date('Y-m-d H:i:s',strtotime($rt['ReceivingTransaction']['receiving_datetime']));
							$this->Item->query("update
													stock_transfer_transactions a join 
													stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id 
													set b.is_replaced = 1 ,b.replaced_datetime ='{$rcdt}', b.replaced_serial_no='".$rtd['ReceivingTransactionDetail']['serial_no']."'
													where b.serial_no='".$item_replace['Item']['serial_no']."' and a.type = 2 and repaired = 0 
												");	
						}

						$itemInStock_replace = $this->Storage->find('first',array(
									'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['old_serial_no']),'recursive'=>-1));

						if( $this->Storage->delete($itemInStock_replace['Storage']['id'],array('validate'=>'only')) ){

						}
					}
					
				}else{
					//if galing sa repair
					if($item_exsisting['Item']['status'] == 6){
						
						$item_exsisting['Item']['status'] = 4;
						$item_exsisting['Item']['is_repair'] = 1;

						if( $this->Item->save($item_exsisting['Item'],array('validate'=>'only')) ){
												
							$this->addItemHistory($item_exsisting['Item']['serial_no'],'Receiving Items from ('.$accounts[$rt['ReceivingTransaction']['source_account_id']].') to ('.$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']].') using RR# of '.$rt['ReceivingTransaction']['receiving_report_no'] ,$rt['ReceivingTransaction']['receiving_datetime']);

							$rcdt = date('Y-m-d H:i:s',strtotime($rt['ReceivingTransaction']['receiving_datetime']));
							$this->Item->query("update
													stock_transfer_transactions a join 
													stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id 
													set b.repaired = 1 ,b.repaired_datetime ='{$rcdt}'
													where b.serial_no='".$item_exsisting['Item']['serial_no']."' and a.type = 2 and repaired = 0 
												");
							
						}else{

							$data['success'] = false;
							foreach ($this->Item->validationErrors as $errorkey => $errorvalue) {
								$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
							}
							
						}

						if($data['success']){

							$rtd['ReceivingTransactionDetail']['confirmed'] = 1;
							$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

							$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
						}
					}

				}

				$itemInStock_exsisting = $this->Storage->find('first',array(
					'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id']),'recursive'=>-1));
				
				if( empty($itemInStock_exsisting) ){

					$tmp['Storage'] = array(
						'serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],
						'status'=>1,
						'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id'],
						'enabled' => true,
						'entry_datetime'=>date('Y-m-d H:i:s')
					);

					if( $this->Storage->save($tmp['Storage'],array('validate'=>'only')) ){

						
					}else{
						
						$data['success'] = false;
						foreach ($this->Storage->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}
					
				}else if($itemInStock_exsisting['Storage']['status'] == 6){

					$itemInStock_exsisting['Storage']['status'] = 4;
					$itemInStock_exsisting['Storage']['entry_datetime'] = date('Y-m-d H:i:s');

					if( $this->Storage->save($itemInStock_exsisting['Storage'],array('validate'=>'only')) ){

						
					}else{
						
						$data['success'] = false;
						foreach ($this->Storage->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}

				}
				else{
					$data['success'] = false;
					$data['errorMessage'] .= " Duplicate Serial No on Storage";
				}

				if($data['success']){

					$rtd['ReceivingTransactionDetail']['confirmed'] = 1;
					$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

					$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
				}

			}
			else if( $rt['ReceivingTransaction']['type'] == 2 ){ // from stock transfer

				$itemInStock_exsisting = $this->Storage->find('first',array(
					'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],'branch_id'=>$rtd['ReceivingTransactionDetail']['from_branch_id'],'status'=>2),'recursive'=>-1));
				//
				if( !empty($item_exsisting) && !empty($itemInStock_exsisting) ){

					$itemInStock_exsisting['Storage']['status'] = 1;
					if( !empty($itemInStock_exsisting['Storage']['secondary_status']) ){
						$itemInStock_exsisting['Storage']['status'] = $itemInStock_exsisting['Storage']['secondary_status'];
						$itemInStock_exsisting['Storage']['secondary_status'] = null;
					}
					$itemInStock_exsisting['Storage']['branch_id'] = $rtd['ReceivingTransactionDetail']['to_branch_id'];
					$itemInStock_exsisting['Storage']['entry_datetime'] = date('Y-m-d H:i:s');

					if( $this->Storage->save($itemInStock_exsisting,array('validate'=>'only')) ){
						
						$branches = $this->Branch->find('list');
						$this->addItemHistory($item_exsisting['Item']['serial_no'],"Item is successfully transfer to  ( ".$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']]." ) from (".$branches[$rtd['ReceivingTransactionDetail']['from_branch_id']].") using RR# of ".$rt['ReceivingTransaction']['receiving_report_no'],$rt['ReceivingTransaction']['receiving_datetime']);
						$item_exsisting['Item']['status'] = 1;
						if( !empty($item_exsisting['Item']['secondary_status']) ){
							$item_exsisting['Item']['status'] = $item_exsisting['Item']['secondary_status'];
							$item_exsisting['Item']['secondary_status'] = null;
						}
						if( $this->Item->save($item_exsisting['Item'],array('validate'=>'only')) ){

							$rtd['ReceivingTransactionDetail']['confirmed'] = 1;
							$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

							$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
						}

						$this->StockTransferTransactionDetail->updateAll(
						    array('StockTransferTransactionDetail.received'=>1),
						    array('StockTransferTransactionDetail.received'=>0,'StockTransferTransactionDetail.serial_no' => $item_exsisting['Item']['serial_no'])
						);
					}

				}
			}

			else if( $rt['ReceivingTransaction']['type'] == 4 ){ // from Customer

				if( !empty($item_exsisting) ){

					$tmp['Storage'] = array(
						'serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],
						'status'=>4,
						'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id'],
						'enabled' => true,
						'entry_datetime'=>date('Y-m-d H:i:s')
					);

					if( $this->Storage->save($tmp['Storage'],array('validate'=>'only')) ){

						$branches = $this->Branch->find('list');
						$customer_sourceAccounts = $this->getAccountCustomer();
						$this->addItemHistory($item_exsisting['Item']['serial_no'],"Item is successfully back to  ( ".$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']]." ) from (".$customer_sourceAccounts[$rt['ReceivingTransaction']['source_account_id']].") using RR# of ".$rt['ReceivingTransaction']['receiving_report_no'],$rt['ReceivingTransaction']['receiving_datetime']);

						$item_exsisting['Item']['status'] = 4;

						if( $this->Item->save($item_exsisting['Item'],array('validate'=>'only')) ){

							$rtd['ReceivingTransactionDetail']['confirmed'] = 1;
							$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

							$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
						}

						
					}else{
						
						$data['success'] = false;
						foreach ($this->Storage->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}
					
				}else{
					$data['success'] = false;
					$data['errorMessage'] .= " Duplicate Serial No on Storage";
				}

				
			}

			else if( $rt['ReceivingTransaction']['type'] == 5 ){ // from Customer Reposes

				if( !empty($item_exsisting) ){

					$tmp['Storage'] = array(
						'serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],
						'status'=>1,
						'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id'],
						'enabled' => true,
						'entry_datetime'=>date('Y-m-d H:i:s')
					);

					if( $this->Storage->save($tmp['Storage'],array('validate'=>'only')) ){

						$branches = $this->Branch->find('list');
						$customer_sourceAccounts = $this->getAccountCustomer();
						$this->addItemHistory($item_exsisting['Item']['serial_no'],"Item is successfully Reposes to  ( ".$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']]." ) from (".$customer_sourceAccounts[$rt['ReceivingTransaction']['source_account_id']].") using RR# of ".$rt['ReceivingTransaction']['receiving_report_no'],$rt['ReceivingTransaction']['receiving_datetime']);

						$item_exsisting['Item']['status'] = 1;
						$item_exsisting['Item']['is_reposes'] = 1;
						$item_exsisting['Item']['net_price'] = $rtd['ReceivingTransactionDetail']['net_price'];
						$item_exsisting['Item']['srp_price'] = $rtd['ReceivingTransactionDetail']['srp_price'];
						$item_exsisting['Item']['sold_price'] = null;

						if( $this->Item->save($item_exsisting['Item'],array('validate'=>'only')) ){

							$rcdt = date('Y-m-d H:i:s',strtotime($rt['ReceivingTransaction']['receiving_datetime']));
							$this->Item->query("update
													sold_transactions a join 
													sold_transaction_details b on a.id = b.sold_transaction_id 
													set b.reposes = 1 ,b.reposes_datetime ='{$rcdt}'
													where b.serial_no='".$item_exsisting['Item']['serial_no']."' 
												");

							$rtd['ReceivingTransactionDetail']['confirmed'] = 1;
							$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

							$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
						}

						
					}else{
						
						$data['success'] = false;
						foreach ($this->Storage->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}
					
				}else{
					$data['success'] = false;
					$data['errorMessage'] .= " Duplicate Serial No on Storage";
				}

				
			}

			

		}

		return $data;
	}

	function inventory_unconfirm_receiving_transaction_details($id){

		$data = $this->unconfirm_receiving_transaction_details($id);

		// $data['success'] = true;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function unconfirm_receiving_transaction_details($id){

		$data['success'] = true; 
		$data['successCount'] = 0; 
		$models = $this->Model->find('list',array('fields'=>array('id','brand_id'),'conditions'=>array('enabled'=>true)));
		$rtd = $this->ReceivingTransactionDetail->find('first',array('conditions'=>array('id'=>$id),'recursive'=>-1));
		$rt = $this->ReceivingTransaction->find('first',array('conditions'=>array('id'=>$rtd['ReceivingTransactionDetail']['receiving_transaction_id']),'recursive'=>-1));

		$branches = $this->Branch->find('list');
		$accounts = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>2),'recursive'=>-1));

		if( !empty($this->data['serial_no']) || !empty($this->data['to_branch_id']) ){

			$rtd['ReceivingTransactionDetail']['serial_no'] = $this->data['serial_no'];			
			$rtd['ReceivingTransactionDetail']['to_branch_id'] = $this->data['to_branch_id'];			
			$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);

		}


		if( $rtd ) {

			$modelBrands = $this->Model->find('list',array('fields'=>array('id','brand_id'),'conditions'=>array('enabled'=>true)));
			$item_exsisting = $this->Item->find('first',array(
				'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no']),'recursive'=>-1));
			
			if( $rt['ReceivingTransaction']['type'] == 1 ){ // from supplier

				$itemInStock_exsisting = $this->Storage->find('first',array(
					'conditions'=>array('serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id'],'status'=>1),'recursive'=>-1));

				if( !empty($itemInStock_exsisting) ){					

					if( $this->Storage->delete($itemInStock_exsisting['Storage']['id'],array('validate'=>'only')) ){

						$data['successCount'] ++;

						if( !empty($item_exsisting) ){				
							$this->ItemHistory->query("delete from item_histories where serial_no = '{$item_exsisting['Item']['serial_no']}'");
							if( $this->Item->delete($item_exsisting['Item']['serial_no'],array('validate'=>'only')) ){									
								$data['successCount'] ++;

							}else{

								$data['success'] = false;
								foreach ($this->Item->validationErrors as $errorkey => $errorvalue) {
									$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
								}
								
							}
							
						}	

					}else{
						
						$data['success'] = false;
						foreach ($this->Storage->validationErrors as $errorkey => $errorvalue) {
							$data['errorMessage'] .= $errorkey." ".$errorvalue." ";
						}
						
					}
					
				}else{
					$data['success'] = false;
					$data['errorMessage'] .= " Unable to remove from the storage";
				}											

				if($data['successCount'] == 2){

					$rtd['ReceivingTransactionDetail']['confirmed'] = 0;
					$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = $this->Auth->user('id');

					$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
				}

			}
			else if( $rt['ReceivingTransaction']['type'] == 2 ){
				 // from stock transfer

				$itemInStock_exsisting = $this->Storage->find('first',array(
					'conditions'=>array(
						'serial_no'=>$rtd['ReceivingTransactionDetail']['serial_no'],'branch_id'=>$rtd['ReceivingTransactionDetail']['to_branch_id'],'status'=>1),'recursive'=>-1));
				//
				if( !empty($item_exsisting) && !empty($itemInStock_exsisting) ){

					$itemInStock_exsisting['Storage']['status'] = 2;					
					$itemInStock_exsisting['Storage']['branch_id'] = $rtd['ReceivingTransactionDetail']['from_branch_id'];
					$itemInStock_exsisting['Storage']['entry_datetime'] = date('Y-m-d H:i:s');

					if( $this->Storage->save($itemInStock_exsisting['Storage'],array('validate'=>'only')) ){
						
						$branches = $this->Branch->find('list');
						$this->addItemHistory($item_exsisting['Item']['serial_no']," Item is has UNDO from ( ".$branches[$rtd['ReceivingTransactionDetail']['to_branch_id']]." ) to (".$branches[$rtd['ReceivingTransactionDetail']['from_branch_id']].") using RR# of ".$rt['ReceivingTransaction']['receiving_report_no'],$rt['ReceivingTransaction']['receiving_datetime']);
						
						$item_exsisting['Item']['status'] = 2;
						
						if( $this->Item->save($item_exsisting['Item'],array('validate'=>'only')) ){

							$rtd['ReceivingTransactionDetail']['confirmed'] = 0;
							$rtd['ReceivingTransactionDetail']['confirmed_by_user_id'] = null;

							$this->ReceivingTransactionDetail->save($rtd['ReceivingTransactionDetail']);
						}

						$this->StockTransferTransactionDetail->updateAll(
						    array('StockTransferTransactionDetail.received'=>0),
						    array('StockTransferTransactionDetail.received'=>1,'StockTransferTransactionDetail.serial_no' => $item_exsisting['Item']['serial_no'])
						);
					}

				}
			
			}

			

		}

		return $data;
	}

	function inventory_stock_transferin_supplier_list(){
		
		debug($this->data);
		$conditions = array();
		
		if($this->data['filter'] || true){
			if(!empty($this->data['filter']['receiving_report_no']))
				$conditions['ReceivingTransaction.receiving_report_no'] = $this->data['filter']['receiving_report_no'];

			if( !empty($this->data['filter']['start_date']) && !empty($this->data['filter']['end_date']) ){
				$conditions['ReceivingTransaction.receiving_datetime >='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['start_date']." 00:00:01"));
				$conditions['ReceivingTransaction.receiving_datetime <='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['end_date']." 23:59:59"));
			}else{
				$conditions['ReceivingTransaction.receiving_datetime >='] = $this->data['filter']['start_date'] = date('Y-m-d',strtotime("now -1 days 00:00:01"));
				$conditions['ReceivingTransaction.receiving_datetime <='] = $this->data['filter']['end_date'] = date('Y-m-d',strtotime("now 23:59:59"));
			}

			$conditions['ReceivingTransaction.type'] = $this->data['filter']['type'];
			if(isset($this->data['filter']['type']))
				$_SESSION['type'] =  $this->data['filter']['type'];
			else
				$_SESSION['type'] = 1;
		}
		$print = $this->data;		
		$this->set('filter',$this->data['filter']);

		$this->data=$this->ReceivingTransaction->find('all',array(
			'conditions'=>$conditions,
			'order'=>'receiving_datetime desc'
		));
		
		$this->set('models',$this->Model->find('list'));
		$this->set('brands',$this->Brand->find('list'));
		$this->set('types',$this->Type->find('list'));
		$this->set('users',$this->User->find('list'));
		$this->set('branches',$this->Branch->find('list'));

		if(isset($print['print'])){
			$this->layout='pdf';
			$this->render('receiving_transaction_print');
		}
	}

}
?>