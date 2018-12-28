<?php
class ReceivingTransactionDetailsController extends AppController {

	var $name = 'ReceivingTransactionDetails';

	var $uses = array('ReceivingTransaction','ReceivingTransactionDetail','Storage','Branch','Model','Type','Account','User');

	function inventory_delete($id){

		$data = $this->delete($id);

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function delete($id){
			
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for model', true));
			$data['success'] = false;
		}
		if ($this->ReceivingTransactionDetail->delete($id)) {
			$data['success'] = true;
		}

		return $data;
	}


	
}
?>