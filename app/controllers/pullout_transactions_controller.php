<?php
class PulloutTransactionsController extends AppController {

	var $name = 'PulloutTransactions';

	var $uses = array('PulloutTransaction','PulloutTransactionDetail','Storage','Branch','Model','Type','Account','User','Item','Brand','CollectionType');

	
	function inventory_sold_items($id = null)	{
	
		if($this->data){
			$error = false;
			$this->PulloutTransaction->begin();

			if(!isset($this->data['PulloutTransaction']['id']))
				$this->PulloutTransaction->create();

			if(!empty($this->data['PulloutTransaction']['delivery_datetime']))
				$this->data['PulloutTransaction']['delivery_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['PulloutTransaction']['delivery_datetime']));
			else
				$this->data['PulloutTransaction']['delivery_datetime'] = null;

			if(!empty($this->data['PulloutTransaction']['cancel_datetime']))
				$this->data['PulloutTransaction']['cancel_datetime'] = date('Y-m-d H:i:s',strtotime($this->data['PulloutTransaction']['cancel_datetime']));
			else
				$this->data['PulloutTransaction']['cancel_datetime'] = null;

			if( $this->PulloutTransaction->save($this->data['PulloutTransaction'],array('validate'=>'only')) ){

				if(!isset($this->data['PulloutTransaction']['id']))
					$this->data['PulloutTransaction']['id'] = $this->PulloutTransaction->id;

				$soldTransactionId = $this->data['PulloutTransaction']['id'];

				foreach ($this->data['PulloutTransactionDetail'] as $rTDkey => &$rTDvalue) {

					$rTDvalue['sold_transaction_id'] = $soldTransactionId;					

					if(!isset($rTDvalue['id']))
						$this->PulloutTransaction->PulloutTransactionDetail->create();

					if( $this->PulloutTransaction->PulloutTransactionDetail->save($rTDvalue,array('validate'=>'only')) ){

						if(!isset($rTDvalue['id']))
							$rTDvalue['id'] = $this->PulloutTransaction->PulloutTransactionDetail->id;

						$this->log($this->data,'wheoe');
						if( $this->data['PulloutTransaction']['cancel'] == 1 ){
							if(!empty($rTDvalue['serial_no']))
								$this->markUnPullout($rTDvalue['from_branch_id'],$rTDvalue['serial_no'],$rTDvalue['sold_price'],$this->data);
						}
						else{
							
							if(!empty($rTDvalue['serial_no']))
								$this->markPullout($rTDvalue['from_branch_id'],$rTDvalue['serial_no'],$rTDvalue['sold_price'],$this->data);	
						}

					}else{$error = true;}
				}
			}

			if($error)
				$this->PulloutTransaction->rollback();
			else
				$this->PulloutTransaction->commit();
		}

		if(!empty($id)){

			$this->data = $this->PulloutTransaction->find('first',array('conditions'=>array('PulloutTransaction.id'=>$id)));

			foreach ($this->data['PulloutTransactionDetail'] as $key => &$value) {				

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

	function markPullout($branch_id,$serial_no,$sold_price = 0, $data = array() ){
			
		$storage=$this->Storage->find('first',array('recursive'=>-1,'conditions'=>array('branch_id'=>$branch_id,'serial_no'=>$serial_no)));

		if($storage){			
			$this->addItemHistory($serial_no,'Item mark as sold so It will be deleted on Storage DR #'.$data['PulloutTransaction']['delivery_receipt_no'],$data['PulloutTransaction']['delivery_datetime']);
			$this->Storage->delete($storage['Storage']['id']);
		}

		$items = $this->Item->find('first',array('recursive'=>-1,'conditions'=>array('serial_no'=>$serial_no)));
		$this->addItemHistory($serial_no,'Item mark as sold Updating Pullout Price of '.$sold_price.' DR # '.$data['PulloutTransaction']['delivery_receipt_no'],$data['PulloutTransaction']['delivery_datetime']);
		$items['Item']['status'] = 3;
		$items['Item']['sold_price'] = $sold_price;
		$items['Item']['delivery_receipt_no'] = $data['PulloutTransaction']['delivery_receipt_no'];
		$items['Item']['delivery_datetime'] = $data['PulloutTransaction']['delivery_datetime'];
		$items['Item']['repair_on_account_id'] = null;
		$items['Item']['repair_datetime'] = null;
		$items['Item']['is_repair'] = 0;

		if( !empty($data['PulloutTransaction']['owner_account_id']) )
			$items['Item']['owner_account_id'] = $data['PulloutTransaction']['owner_account_id'];

		if( !empty($data['PulloutTransaction']['owner_account_id']) )
			$items['Item']['sold_by_user_id'] = $data['PulloutTransaction']['sold_by_user_id'];

		$this->Item->save($items);

	}

	function markUnPullout($branch_id,$serial_no,$sold_price =0, $data = array() ){
			
		$storage=$this->Storage->find('first',array('recursive'=>-1,'conditions'=>array('branch_id'=>$branch_id,'serial_no'=>$serial_no)));

		if(!$storage){			
			$this->addItemHistory($serial_no,'Item mark as un sold so It will be create on Storage DR # '.$data['PulloutTransaction']['delivery_receipt_no'],$data['PulloutTransaction']['cancel_datetime']);
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
		$this->addItemHistory($serial_no,'Item mark as un sold Updating Item info DR # '.$data['PulloutTransaction']['delivery_receipt_no'],$data['PulloutTransaction']['cancel_datetime']);
		$items['Item']['status'] = 1;
		$items['Item']['sold_price'] = null;
		$items['Item']['delivery_receipt_no'] = null;
		$items['Item']['delivery_datetime'] = null;
		$items['Item']['repair_on_account_id'] = null;
		$items['Item']['repair_datetime'] = null;
		$items['Item']['is_repair'] = 0;

		// if( !empty($data['PulloutTransaction']['owner_account_id']) )
			$items['Item']['owner_account_id'] = null;

		// if( !empty($data['PulloutTransaction']['owner_account_id']) )
			$items['Item']['sold_by_user_id'] = null;

		$this->Item->save($items);

	}

	function inventory_sold_index(){
		
		$conditions = array();
		
		if($this->data['filter'] || true){
			if(!empty($this->data['filter']['deliveryT_no']))
				$conditions['PulloutTransaction.delivery_receipt_no'] = $this->data['filter']['deliveryT_no'];

			if( !empty($this->data['filter']['start_date']) && !empty($this->data['filter']['end_date']) ){
				$conditions['PulloutTransaction.delivery_datetime >='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['start_date']." 00:00:01"));
				$conditions['PulloutTransaction.delivery_datetime <='] = date('Y-m-d H:i:s',strtotime($this->data['filter']['end_date']." 23:59:59"));
			}else{
				$conditions['PulloutTransaction.delivery_datetime >='] = $this->data['filter']['start_date'] = date('Y-m-d',strtotime("now -1 days 00:00:01"));
				$conditions['PulloutTransaction.delivery_datetime <='] = $this->data['filter']['end_date'] = date('Y-m-d',strtotime("now 23:59:59"));
			}
			
		}
		$print = $this->data;		
		$this->set('filter',$this->data['filter']);

		$this->data=$this->PulloutTransaction->find('all',array(
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