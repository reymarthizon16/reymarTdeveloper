<?php
class StoragesController extends AppController {

	var $name = 'Storages';
	var $uses = array('Storage','Branch','Model','Type','Item','Brand','Account');

	function inventory_index(){
		$this->index();
	}

	function index() {
		debug($this->data);
		$additional_conditions = array();
		
		if( isset($this->data['branch_filter']['print']) )
			$branches = $this->Branch->find('list',array('conditions'=>array('enabled'=>true,'id'=>$this->data['branch_filter']['print'])));
		else
			$branches = $this->Branch->find('list',array('conditions'=>array('enabled'=>true)));

		$models = $this->Model->find('list',array('conditions'=>array('enabled'=>true)));
		$modelBrands = $this->Model->find('list',array('fields'=>array('id','brand_id'),'conditions'=>array('enabled'=>true)));
		$types = $this->Type->find('list',array('conditions'=>array('enabled'=>true)));
		$brands = $this->Brand->find('list',array('conditions'=>array('enabled'=>true)));
		$serviceAccountId = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));

		$storages = array();
		foreach ($branches as $key => $value) {

			$additional_conditions = array();
			if(!empty($this->data['branch_filter'][$key])){
				$additional_conditions = $this->data['branch_filter'][$key];
				unset($additional_conditions['branch_id']);
			}

			$storages[$key] = $this->Storage->find('all',array('conditions'=>array('Storage.branch_id'=>$key,$additional_conditions)));
		}
		// debug($storages);



		$this->set('storages',$storages);	
		$this->set('models',$models);	
		$this->set('modelBrands',$modelBrands);	
		$this->set('brands',$brands);	
		$this->set('types',$types);	
		$this->set('serviceAccountId',$serviceAccountId);	
		$this->set('branches',$branches);
		if( isset($this->data['branch_filter']['print']) ) {
			$this->layout = 'pdf';
			$this->render('print_storage');
		}else
			$this->render('index');
	}

	function inventory_getItemOnBranch( $id ){
		$this->getItemOnBranch($id);
	}

	function getItemOnBranch( $id ){

		$data = array();
		
		$this->loadModel('StockTransferTransactionDetail');
		$exsisting = $this->StockTransferTransactionDetail->find('list',array('recursive'=>-1,
			'conditions'=>array('StockTransferTransactionDetail.stock_transfer_transaction_id'=>$this->data['stock_transfer_id']),
			'fields'=>array('serial_no','serial_no'),
		));
		
		$items = $this->Storage->find('all',array('conditions'=>array(			
			'OR'=>array(
				array('Storage.branch_id'=>$id,'Storage.status'=>array(1,4,5)),
				// array('Storage.branch_id'=>$id,'Storage.status'=>4),
				// array('Storage.branch_id'=>$id,'Storage.status'=>5),
				array('Storage.serial_no'=>$exsisting)
			)
		)));

		
		if($items){
			foreach ($items as $itemkey => &$itemvalue) {
			
				$itemdesc=$this->Item->find('first',array('conditions'=>array('Item.serial_no'=>$itemvalue['Item']['serial_no']),'recursive'=>-1));
				$itemModel=$this->Model->find('first',array('conditions'=>array('Model.id'=>$itemvalue['Item']['model_id']),'recursive'=>-1));
				$itemType=$this->Type->find('first',array('conditions'=>array('Type.id'=>$itemvalue['Item']['type_id']),'recursive'=>-1));
				$itemBrand=$this->Brand->find('first',array('conditions'=>array('Brand.id'=>$itemvalue['Item']['brand_id']),'recursive'=>-1));

				$itemvalue['ItemDesc'] = $itemdesc['Item'];
				$itemvalue['ItemModel'] = $itemModel['Model'];
				$itemvalue['ItemType'] = $itemType['Type'];
				$itemvalue['itemBrand'] = $itemBrand['Brand'];

				$data[] =  $itemvalue;
			}
		}
		$sample = $this->Item->status;
		$this->log($sample,'statuss');
		$newData = array();
		foreach ($data as $key => $value) {
			$newData[$value['ItemType']['name']." ( ".$value['itemBrand']['name']." ) ".$value['ItemModel']['name']] [ $value['Item']['serial_no'] ] =  $value['Item']['serial_no'] ;
		}
		$data = $newData;
		// debug($data);

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
		
	}

	function inventory_getItem(){
		$this->getItem();
	}

	function getItem(){		

		$serial_no = explode(",", $this->data['serial_no']);

		$this->Item->Behaviors->attach('containable');

		$items = $this->Item->find('all',array(
			'conditions'=>array('Item.serial_no'=>$serial_no),
			'contain'=>array('Model','Type','Brand')
		));

		$data = $items;
		

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	function inventory_getItemDetails(){

		if( !empty($this->data['serial_no']) ){

			if( $this->data['type'] == 1 ){
				$exsisting = $this->Item->find('first',array(
					'conditions'=>
						array('serial_no'=>$this->data['serial_no'])
					,'recursive'=>-1));
				
				if($exsisting)
					$data['exsisting'] = true;
				else
					$data['exsisting'] = false;

				$onRepair = $this->Item->find('first',array(
					'conditions'=>
						array('serial_no'=>$this->data['serial_no'],'status'=>6)
					,'recursive'=>-1));

				if($onRepair){
					$onBranch = $this->Storage->find('first',array(
						'conditions'=>
							array('serial_no'=>$this->data['serial_no'],'status'=>6)
						,'recursive'=>-1));

					$data['StockTransaction']['to_branch_id'] = $onBranch['Storage']['branch_id'];

					$data['onRepair'] = true;
					$data['Item']=$onRepair['Item'];
					$type = $this->Type->findById($onRepair['Item']['type_id']);
					$brand = $this->Brand->findById($onRepair['Item']['brand_id']);
					$data['Type']= $type['Type'];
					$data['Brand']= $brand['Brand'];
					$data['exsisting'] = false;
				}

				
			}

			if( $this->data['type'] == 2 ){
				$exsisting = $this->Storage->find('first',array('conditions'=>array('serial_no'=>$this->data['serial_no']),'recursive'=>-1));
				$iteminstance = $this->Item->find('first',array('conditions'=>array('serial_no'=>$this->data['serial_no']),'recursive'=>-1));
				if($exsisting){

					$data['exsisting'] = true;

					$data['Item']=$iteminstance['Item'];
					$type = $this->Type->findById($iteminstance['Item']['type_id']);
					$brand = $this->Brand->findById($iteminstance['Item']['brand_id']);
					$data['Type']= $type['Type'];
					$data['Brand']= $brand['Brand'];
					$this->loadModel('StockTransferTransaction');
					$this->loadModel('StockTransferTransactionDetail');
					$stransfer =$this->StockTransferTransaction->find('first',array('conditions'=>array('stock_transfer_no'=>$this->data['stock_transfer_id']),'recursive'=>-1));
					
					$stransferdet =$this->StockTransferTransactionDetail->find('first',array('conditions'=>array('serial_no'=>$this->data['serial_no'],'stock_transfer_transaction_id'=>$stransfer['StockTransferTransaction']['id']),'recursive'=>-1));
					if( empty($stransferdet) || empty($stransfer)  )
						$data['exsisting'] = false;

					$data['StockTransactionDetails']=$stransferdet['StockTransferTransactionDetail'];
					$data['StockTransaction']=$stransfer['StockTransferTransaction'];

				}
				else
					$data['exsisting'] = false;
			}

			if( $this->data['type'] == 5 ||  $this->data['type'] == 4 ){
				$exsisting = $this->Item->find('first',array('conditions'=>array('serial_no'=>$this->data['serial_no']),'recursive'=>-1));
				$exsistingOnBranch = $this->Storage->find('first',array('conditions'=>array('serial_no'=>$this->data['serial_no']),'recursive'=>-1));
				if(!$exsistingOnBranch){
					$data['Item']=$exsisting['Item'];
					$model = $this->Model->findById($exsisting['Item']['model_id']);
					$type = $this->Type->findById($exsisting['Item']['type_id']);
					$brand = $this->Brand->findById($exsisting['Item']['brand_id']);
					$data['Model']= $model['Model'];
					$data['Type']= $type['Type'];
					$data['Brand']= $brand['Brand'];
					$data['exsisting'] = true;
				}
				else
					$data['exsisting'] = false;
			}

			if(empty($this->data['type'])){
				$exsisting = $this->Item->find('first',array(
					'conditions'=>
						array('serial_no'=>$this->data['serial_no'])
					,'recursive'=>-1));
				
				if($exsisting)
					$data['exsisting'] = true;
				else
					$data['exsisting'] = false;
			}
			
		}
		

		$data['success'] = true;

		$this->appajax($data);
	}

	
}
