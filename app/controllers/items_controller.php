<?php
class ItemsController extends AppController {

	var $name = 'Items';
	var $uses = array('Item','ItemIncrement','Type','Model','ItemHistory','Brand','Account','Branch','Storage');
	var $paginate = array('limit' => 99999);
	
	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->Item->recursive = 0;
		
		if(empty($this->data['item_filter'])){
			$this->data['item_filter']['Item.status'][0] = 1;			
		}

		if(!empty($this->data['item_filter'])){
			$conditions['conditions'] = $this->data['item_filter'];
			$conditions['limit']=99999;
			$this->paginate = $conditions;
		}

		$this->set('items', $this->paginate());
		$brands = $this->Brand->find('list');
		$this->set('brands',$brands);
		$this->render('index');
	}

	function inventory_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			/*
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash(__('The item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The item could not be saved. Please, try again.', true));
			}*/
			
			$started_branch_idUpdate='';
			if(!empty($this->data['Item']['started_branch_id']) && $this->data['Item']['change_branch'] == 1 )
				$started_branch_idUpdate=" b.branch_id='".$this->data['Item']['started_branch_id']."' ,  a.started_branch_id='".$this->data['Item']['started_branch_id']."', ";

			$updateSerial="
				update
					items a
					left join storages b on a.serial_no = b.serial_no
					left join receiving_transaction_details c on a.serial_no = c.serial_no
					left join stock_transfer_transaction_details d on a.serial_no = d.serial_no
					left join sold_transaction_details e on a.serial_no = e.serial_no
					left join items fold on a.serial_no = fold.old_serial_no
					left join receiving_transaction_details rtfold on a.serial_no = rtfold.old_serial_no
					left join stock_transfer_transaction_details stfold on a.serial_no = stfold.replaced_serial_no
					left join items fnew on a.serial_no = fnew.new_serial_no
					set
						
						{$started_branch_idUpdate}
						a.serial_no = '{$this->data['Item']['serial_no']}',
						a.model_id = '{$this->data['Item']['model_id']}',
						a.brand_id = '{$this->data['Item']['brand_id']}',
						a.type_id = '{$this->data['Item']['type_id']}',
						a.srp_price = '{$this->data['Item']['srp_price']}',
						a.net_price = '{$this->data['Item']['net_price']}',
						a.is_reposes = '{$this->data['Item']['is_reposes']}',

						b.serial_no = '{$this->data['Item']['serial_no']}',

						c.serial_no = '{$this->data['Item']['serial_no']}',
						c.model_id = '{$this->data['Item']['model_id']}',
						c.brand_id = '{$this->data['Item']['brand_id']}',
						c.type_id = '{$this->data['Item']['type_id']}',
						c.srp_price = '{$this->data['Item']['srp_price']}',
						c.net_price = '{$this->data['Item']['net_price']}',

						d.serial_no = '{$this->data['Item']['serial_no']}',
						e.serial_no = '{$this->data['Item']['serial_no']}',
						fold.old_serial_no = '{$this->data['Item']['serial_no']}',
						rtfold.old_serial_no = '{$this->data['Item']['serial_no']}',
						fnew.new_serial_no = '{$this->data['Item']['serial_no']}',
						stfold.replaced_serial_no = '{$this->data['Item']['serial_no']}'

					where a.serial_no ='{$this->data['Item']['original_serial_no']}';			
			";
			
			$this->log($updateSerial);
			$this->Item->query('set foreign_key_checks = 0');
			$this->Item->query($updateSerial);
			$this->Item->query('set foreign_key_checks = 1');

			$this->Session->setFlash(__('The item has been saved', true));
			$this->redirect(array('action' => 'index'));
		}

		if (empty($this->data)) {
			$this->data = $this->Item->find('first', array('conditions'=>array('serial_no'=>$id)));
			if(empty($this->data)){
				$this->Session->setFlash(__('Invalid item', true));
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set('originalSerialNo',$id);

		$fields = $this->Item->query( $this->getTableDescQueryString('items',array('status','quantity','reference_no','receiving_report_no','receiving_datetime','source_account_id','sold_price','down_payment_price','delivery_receipt_no','delivery_datetime','owner_account_id','sold_by_user_id','enabled','entry_datetime','user_id','repair_on_account_id','repair_datetime','is_repair','secondary_status','is_replaced','old_serial_no','new_serial_no','started_branch_id')) );

		$branches = $this->Branch->find('list',array('conditions'=>array('enabled'=>true)));	
		$this->set('startedBranches',$branches);

		$this->set('model','Item');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Item->validationErrors);
		// $this->render('/elements/common/defaultform');
	}	

	function inventory_getItemIncrement(){
		$this->getItemIncrement();
	}

	function getItemIncrement() {

		
		$prefixType="";
		if(isset($this->data['type_id'])){
			$typeInstance=$this->Type->find('first',array('conditions'=>array('id'=>$this->data['type_id']),'recursive'=>-1));
			$prefixType = $typeInstance['Type']['name'][0];
		}
		$prefixModel="";
		if(isset($this->data['model_id'])){
			$typeInstance=$this->Model->find('first',array('conditions'=>array('id'=>$this->data['model_id']),'recursive'=>-1));
			$prefixModel = $typeInstance['Model']['name'][0];
		}

		if(!empty($typeInstance['Model']['prefix'])){
			$prefix = $typeInstance['Model']['prefix'].date('mdy');
		}else{

			$prefix = $prefixType.$prefixModel;
			$prefix = $prefix.date('mdy');
		}
		
		$count = $this->ItemIncrement->find('count',array('conditions'=>array('prefix'=>$prefix)));
		
		$data['ItemIncrement'] = array(
			'prefix'=>$prefix,
			'entry_datetime'=>date('Y-m-d H:i:s')
		);

		$this->ItemIncrement->save($data);
		
		$data = array();
		$data['serial_no'] = $prefix.$count;
		$data['success'] = true;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');

	}

	function inventory_getHistory(){
		
		$histories=$this->ItemHistory->find('all',array('recursive'=>-1,'conditions'=>array('ItemHistory.serial_no'=>$this->data['serial_no'])));
		$data = $histories;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function inventory_printhistory($serial_no){
		
		$histories=$this->ItemHistory->find('all',array('recursive'=>-1,'conditions'=>array('ItemHistory.serial_no'=>$serial_no)));
		$data = $histories;
		$item = $this->Item->find('first',array('conditions'=>array('Item.serial_no'=>$serial_no)));
		$this->log($item,'item');
		$this->set('item',$item);
		$this->set('serial_no',$serial_no);
		$this->set('data',$data);

		$this->layout='pdf';
	}

	function inventory_add(){

		if (!empty($this->data)) {
			$this->Item->create();

			$this->data['Item']['entry_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['Item']['entry_datetime']));
			$this->data['Item']['started_branch_id'] = $this->data['Item']['branches'];
			$this->data['Item']['enabled'] = true;

			if ($this->Item->save($this->data)) {

				$entry_datetime = date('Y-m-d H:i:s',strtotime($this->data['Item']['entry_datetime']));
				$tmp['Storage'] = array(
						'serial_no'=>$this->data['Item']['serial_no'],
						'status'=>$this->data['Item']['status'],
						'branch_id'=>$this->data['Item']['branches'],
						'enabled' => true,
						'entry_datetime'=>$entry_datetime
					);

				$this->Storage->save($tmp['Storage']);

				$this->addItemHistory($this->data['Item']['serial_no'],"Manual Add by the user",$entry_datetime);

				$this->Session->setFlash(__('The item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The item could not be saved. Please, try again.', true));

			}
		}


		$fields = $this->Item->query( $this->getTableDescQueryString('items',array('status','quantity','reference_no','receiving_report_no','receiving_datetime','source_account_id','sold_price','down_payment_price','delivery_receipt_no','delivery_datetime','owner_account_id','sold_by_user_id','enabled','user_id','repair_on_account_id','repair_datetime','is_repair','secondary_status','is_replaced','old_serial_no','new_serial_no','entry_datetime','started_branch_id')) );

		$branches = $this->Branch->find('list',array('conditions'=>array('enabled'=>true)));	
		$this->set('branches',$branches);

		$this->set('model','Item');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Item->validationErrors);

	}

	function inventory_repair($id){
		
		if (!empty($this->data)) {
			
			if( $this->data['Item']['is_repair'] ){
				$this->data['Item']['serial_no'] = $this->data['Item']['original_serial_no'];
				$this->data['Item']['repair_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['Item']['repair_datetime']));
				$this->data['Item']['status'] = 4;

				if ($this->Item->save($this->data)) {

					$repair_datetime = date('Y-m-d H:i:s',strtotime($this->data['Item']['repair_datetime']));
					$tmp['Storage'] = array(
							'serial_no'=>$this->data['Item']['serial_no'],
							'status'=>4,						
						);

					$this->Storage->save($tmp['Storage']);

					$serviceCenter=$this->Account->find('first',array('conditions'=>array('Account.id'=>$this->data['Item']['repair_on_account_id']),'recursive'=>-1));

					$this->addItemHistory($this->data['Item']['serial_no']," Repaired by ".$serviceCenter['Account']['company'],$repair_datetime);
					/*
					$rcdt = date('Y-m-d H:i:s',strtotime($this->data['Item']['repair_datetime']));
					$this->Item->query("update
											stock_transfer_transactions a join 
											stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id 
											set b.is_replaced = 1 ,b.replaced_datetime ='{$rcdt}', b.replaced_serial_no='".$this->data['Item']['serial_no']."'
											where b.serial_no='".$this->data['Item']['serial_no']."' and a.type = 2 and repaired = 0 
										");	
					*/
					$this->Session->setFlash(__('The item has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The item could not be saved. Please, try again.', true));

				}
			}
		}

		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
			if(	$this->data['Item']['is_repair'] == 1 || $this->data['Item']['status'] != 4 ){
				$this->Session->setFlash(__('Invalid item', true));
				$this->redirect(array('action' => 'index'));
			}
			$this->set('originalSerialNo',$id);
		}


		$fields = $this->Item->query( $this->getTableDescQueryString('items',array('status','quantity','reference_no','receiving_report_no','receiving_datetime','source_account_id','sold_price','down_payment_price','delivery_receipt_no','delivery_datetime','owner_account_id','sold_by_user_id','enabled','user_id','secondary_status','is_replaced','old_serial_no','new_serial_no','entry_datetime','repair_datetime','srp_price','net_price')) );		

		$readOnly['model_id'] = true;
		$readOnly['type_id'] = true;
		$readOnly['brand_id'] = true;
		$readOnly['serial_no'] = true;

		$this->set('model','Item');
		$this->set('modelfields',$fields);
		$this->set('modelfieldsreadOnly',$readOnly);
		$this->set('modelfieldErrors',$this->Item->validationErrors);

	}

	function inventory_needrepair($id){
		
		if (!empty($this->data)) {
					
			$this->data['Item']['serial_no'] = $this->data['Item']['original_serial_no'];				
			$this->data['Item']['status'] = 4;

			if ($this->Item->save($this->data)) {

				$storage=$this->Storage->find('first',array('conditions'=>array('serial_no'=>$this->data['Item']['serial_no']),'recursive'=>-1));
				$storage['Storage']['status'] = 4;

				$this->Storage->save($storage['Storage']);

				$now = date('Y-m-d H:i:s',strtotime('now'));
				$this->addItemHistory($this->data['Item']['serial_no']," Mark as Defect by the User",$now);
				/*
				$rcdt = date('Y-m-d H:i:s',strtotime($this->data['Item']['repair_datetime']));
				$this->Item->query("update
										stock_transfer_transactions a join 
										stock_transfer_transaction_details b on a.id = b.stock_transfer_transaction_id 
										set b.is_replaced = 1 ,b.replaced_datetime ='{$rcdt}', b.replaced_serial_no='".$this->data['Item']['serial_no']."'
										where b.serial_no='".$this->data['Item']['serial_no']."' and a.type = 2 and repaired = 0 
									");	
				*/
				$this->Session->setFlash(__('The item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The item could not be saved. Please, try again.', true));

			}
			
		}

		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
			if(	$this->data['Item']['status'] != 1 ){
				$this->Session->setFlash(__('Invalid item', true));
				$this->redirect(array('action' => 'index'));
			}
			$this->set('originalSerialNo',$id);
		}


		$fields = $this->Item->query( $this->getTableDescQueryString('items',array('status','quantity','reference_no','receiving_report_no','receiving_datetime','source_account_id','sold_price','down_payment_price','delivery_receipt_no','delivery_datetime','owner_account_id','sold_by_user_id','enabled','user_id','secondary_status','is_replaced','old_serial_no','new_serial_no','entry_datetime','repair_datetime','srp_price','net_price','repair_on_account_id','is_repair')) );		

		$readOnly['model_id'] = true;
		$readOnly['type_id'] = true;
		$readOnly['brand_id'] = true;
		$readOnly['serial_no'] = true;

		$this->set('model','Item');
		$this->set('modelfields',$fields);
		$this->set('modelfieldsreadOnly',$readOnly);
		$this->set('modelfieldErrors',$this->Item->validationErrors);

	}

	function inventory_delete($id = null){
		$this->delete($id);
	}

	function delete($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($id)) {
						
			$this->Item->query('set foreign_key_checks = 0');
				
				$updateSerial="delete from items where serial_no='$id'";
					$this->Item->query($updateSerial);

				$updateSerial="delete from storages where serial_no='$id'";
					$this->Item->query($updateSerial);

				$updateSerial="delete from item_histories where serial_no='$id'";
					$this->Item->query($updateSerial);

				$updateSerial="delete from receiving_transaction_details where serial_no='$id'";
					$this->Item->query($updateSerial);

				$updateSerial="delete from sold_transaction_details where serial_no='$id'";
					$this->Item->query($updateSerial);

				$updateSerial="delete from stock_transfer_transaction_details where serial_no='$id'";
					$this->Item->query($updateSerial);

			$this->Item->query('set foreign_key_checks = 1');

			$this->Session->setFlash(__('The item has been deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		
	}	
}
