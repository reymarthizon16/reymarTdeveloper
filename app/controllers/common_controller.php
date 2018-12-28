<?php
class CommonController extends AppController {

	var $uses = array('Storage','Model','Brand','Type','Branch','Account');

	function accounting_getInputs(){
		$this->getInputs();
	}

	function inventory_getInputs(){
		$this->getInputs();
	}

	function getInputs(){

		$data = array();		
		$data['success'] = true;
		

		$this->log($this->data['Model'],'ManageModel');

		$this->data['Model'] = str_replace(' ', '', $this->data['Model']);
		$model = $this->data['Model'];		
		$modelOnQuery = $this->data['Model'];		

		// $this->log($this->data['Model'],'ManageModel');
		
		if($model == 'Branch') // for plural es
			$modelOnQuery = $modelOnQuery.'e';

		if($model == 'RepairOnAccount'){
			$model = 'Account';
			$modelOnQuery = 'account';
			$fields = $this->$model->query( $this->getTableDescQueryString(lcfirst($modelOnQuery."s"),array('last_name','first_name','middle_name','entry_datetime','user_id')) );
		}

		// $this->log($model,'ManageModel');
		if(!$fields)
			$fields = $this->$model->query( $this->getTableDescQueryString(lcfirst($modelOnQuery."s"),array('entry_datetime','user_id')) );
		
		// $this->log($fields,'ManageModel');		

		$this->set('model',$model);
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->$model->validationErrors);
		$this->layout=false;
		$this->render('/elements/common/addform');

	}

	function accounting_saveInputs($model){
		$this->saveInputs($model);
	}

	function inventory_saveInputs($model){
		$this->saveInputs($model);
	}

	function saveInputs($model){
		
		if( $model =='Repair On Account' ){
			$model = 'Account';
		}

		if (!empty($this->data)) {
			$this->$model->create();
			if ($this->$model->save($this->data)) {
				$data['success'] = true;		
			} else {				
				$data['success'] = false;
			}
		}

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function accounting_listInputs($model){
		$this->listInputs($model);
	}

	function inventory_listInputs($model){
		$this->listInputs($model);
	}

	function listInputs($model){

		if( $model =='Repair On Account' ){
			
			$data = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));
		}
		
		if(!$data)
			$data = $this->$model->find('list');
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
}
?>