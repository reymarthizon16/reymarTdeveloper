<?php
class SoldTransactionsController extends AppController {

	var $name = 'SoldTransactions';

	var $uses = array('SoldTransaction','SoldTransactionDetail','Storage','Branch','Model','Type','Account','User','Item','Brand','CollectionType');

	
	function inventory_sold_items($id = null)	{
	
		if($this->data){
			$error = false;
			$this->SoldTransaction->begin();

			if(!isset($this->data['SoldTransaction']['id']))
				$this->SoldTransaction->create();

			if(!empty($this->data['SoldTransaction']['delivery_datetime']))
				$this->data['SoldTransaction']['delivery_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['SoldTransaction']['delivery_datetime']));
			else
				$this->data['SoldTransaction']['delivery_datetime'] = null;

			if(!empty($this->data['SoldTransaction']['cancel_datetime']))
				$this->data['SoldTransaction']['cancel_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['SoldTransaction']['cancel_datetime']));
			else
				$this->data['SoldTransaction']['cancel_datetime'] = null;

			if( $this->SoldTransaction->save($this->data['SoldTransaction'],array('validate'=>'only')) ){

				if(!isset($this->data['SoldTransaction']['id']))
					$this->data['SoldTransaction']['id'] = $this->SoldTransaction->id;

				$soldTransactionId = $this->data['SoldTransaction']['id'];

				foreach ($this->data['SoldTransactionDetail'] as $rTDkey => &$rTDvalue) {

					$rTDvalue['sold_transaction_id'] = $soldTransactionId;					

					if(!isset($rTDvalue['id']))
						$this->SoldTransaction->SoldTransactionDetail->create();

					if( $this->SoldTransaction->SoldTransactionDetail->save($rTDvalue,array('validate'=>'only')) ){

						if(!isset($rTDvalue['id']))
							$rTDvalue['id'] = $this->SoldTransaction->SoldTransactionDetail->id;

						$this->log($this->data,'wheoe');
						if( $this->data['SoldTransaction']['cancel'] == 1 ){
							if(!empty($rTDvalue['serial_no']))
								$this->markUnSold($rTDvalue['from_branch_id'],$rTDvalue['serial_no'],$rTDvalue['sold_price'],$this->data);
						}
						else{
							
							if(!empty($rTDvalue['serial_no']))
								$this->markSold($rTDvalue['from_branch_id'],$rTDvalue['serial_no'],$rTDvalue['sold_price'],$this->data);	
						}

					}else{$error = true;}
				}
			}

			if($error)
				$this->SoldTransaction->rollback();
			else
				$this->SoldTransaction->commit();
		}

		if(!empty($id)){

			$this->data = $this->SoldTransaction->find('first',array('conditions'=>array('SoldTransaction.id'=>$id)));

			foreach ($this->data['SoldTransactionDetail'] as $key => &$value) {				

				$itemdesc=$this->Item->find('first',array('conditions'=>array('Item.serial_no'=>$value['serial_no']),'recursive'=>-1));
				$itemModel=$this->Model->find('first',array('conditions'=>array('Model.id'=>$itemdesc['Item']['model_id']),'recursive'=>-1));
				$itemType=$this->Type->find('first',array('conditions'=>array('Type.id'=>$itemdesc['Item']['type_id']),'recursive'=>-1));
				$itemBrand=$this->Brand->find('first',array('conditions'=>array('Brand.id'=>$itemdesc['Item']['brand_id']),'recursive'=>-1));

				$value['ItemDesc'] = $itemdesc['Item'];
				$value['ItemModel'] = $itemModel['Model'];
				$value['ItemType'] = $itemType['Type'];
				$value['ItemBrand'] = $itemBrand['Brand'];
			}
		}			

		$this->set('ownerAccounts',$this->getAccountCustomer());	
		$users=$this->User->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('soldByUsers',$users);		
		$this->set('deliverByUsers',$users);		
		$branches = $this->Branch->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('fromBranches',$branches);
		$collectionTypes = $this->CollectionType->find('list',array('fields'=>array('id','name'),'conditions'=>array('enabled'=>true)));
		$this->set('CollectionTypes',$collectionTypes);
	}

	function inventory_getItemByBranches(){

		$items = $this->Storage->find('list',array('fields'=>array('serial_no','serial_no'),'conditions'=>array('status'=>1,'branch_id'=>$this->data['branch_id'])));
		
		$data['data'] = $items;
		$data['success'] = true;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function markSold($branch_id,$serial_no,$sold_price = 0, $data = array() ){
			
		$storage=$this->Storage->find('first',array('recursive'=>-1,'conditions'=>array('branch_id'=>$branch_id,'serial_no'=>$serial_no)));

		if($storage){			
			$this->addItemHistory($serial_no,'Item mark as sold so It will be deleted on Storage DR #'.$data['SoldTransaction']['delivery_receipt_no'],$data['SoldTransaction']['delivery_datetime']);
			$this->Storage->delete($storage['Storage']['id']);
		}

		$items = $this->Item->find('first',array('recursive'=>-1,'conditions'=>array('serial_no'=>$serial_no)));
		$this->addItemHistory($serial_no,'Item mark as sold Updating Sold Price of '.$sold_price.' DR # '.$data['SoldTransaction']['delivery_receipt_no'],$data['SoldTransaction']['delivery_datetime']);
		$items['Item']['status'] = 3;
		$items['Item']['sold_price'] = $sold_price;
		$items['Item']['delivery_receipt_no'] = $data['SoldTransaction']['delivery_receipt_no'];
		$items['Item']['delivery_datetime'] = $data['SoldTransaction']['delivery_datetime'];
		$items['Item']['repair_on_account_id'] = null;
		$items['Item']['repair_datetime'] = null;
		$items['Item']['is_repair'] = 0;

		if( !empty($data['SoldTransaction']['owner_account_id']) )
			$items['Item']['owner_account_id'] = $data['SoldTransaction']['owner_account_id'];

		if( !empty($data['SoldTransaction']['owner_account_id']) )
			$items['Item']['sold_by_user_id'] = $data['SoldTransaction']['sold_by_user_id'];

		$this->Item->save($items);

	}

	function markUnSold($branch_id,$serial_no,$sold_price =0, $data = array() ){
			
		$storage=$this->Storage->find('first',array('recursive'=>-1,'conditions'=>array('branch_id'=>$branch_id,'serial_no'=>$serial_no)));

		if(!$storage){			
			$this->addItemHistory($serial_no,'Item mark as un sold so It will be create on Storage DR # '.$data['SoldTransaction']['delivery_receipt_no'],$data['SoldTransaction']['cancel_datetime']);
			$tmp['Storage'] = array(
						'serial_no'=>$serial_no,
						'status'=>1,
						'branch_id'=>$branch_id,
						'enabled' => true,
						'entry_datetime'=>date('Y-m-d H:i:s')
					);

			$this->Storage->save($tmp['Storage']);
		}

		$items = $this->Item->find('first',array('recursive'=>-1,'conditions'=>array('serial_no'=>$serial_no)));
		$this->addItemHistory($serial_no,'Item mark as un sold Updating Item info DR # '.$data['SoldTransaction']['delivery_receipt_no'],$data['SoldTransaction']['cancel_datetime']);
		$items['Item']['status'] = 1;
		$items['Item']['sold_price'] = null;
		$items['Item']['delivery_receipt_no'] = null;
		$items['Item']['delivery_datetime'] = null;
		$items['Item']['repair_on_account_id'] = null;
		$items['Item']['repair_datetime'] = null;
		$items['Item']['is_repair'] = 0;

		// if( !empty($data['SoldTransaction']['owner_account_id']) )
			$items['Item']['owner_account_id'] = null;

		// if( !empty($data['SoldTransaction']['owner_account_id']) )
			$items['Item']['sold_by_user_id'] = null;

		$this->Item->save($items);

	}

	function inventory_sold_index(){
		
		$conditions = array();
		
		if($this->data['filter'] || true){
			if(!empty($this->data['filter']['deliveryT_no']))
				$conditions['SoldTransaction.delivery_receipt_no'] = $this->data['filter']['deliveryT_no'];

			if( !empty($this->data['filter']['start_date']) && !empty($this->data['filter']['end_date']) ){
				$conditions['SoldTransaction.delivery_datetime >='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['start_date']." 00:00:01"));
				$conditions['SoldTransaction.delivery_datetime <='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['end_date']." 23:59:59"));
			}else{
				$conditions['SoldTransaction.delivery_datetime >='] = $this->data['filter']['start_date'] = date('Y-m-d',strtotime("now -1 days 00:00:01"));
				$conditions['SoldTransaction.delivery_datetime <='] = $this->data['filter']['end_date'] = date('Y-m-d',strtotime("now 23:59:59"));
			}
			
		}
		$print = $this->data;		
		$this->set('filter',$this->data['filter']);

		$this->data=$this->SoldTransaction->find('all',array(
			'conditions'=>array($conditions),
			'order'=>'delivery_datetime desc'
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
		$this->set('accounts',$this->Account->find('list'));
		$this->set('collectionTypes',$this->CollectionType->find('list'));

		if(isset($print['print'])){
			$this->layout='pdf';
			$this->render('inventory_sold_index_print');
		}
	}
}
?>