<?php
class DepositSlipsController extends AppController {

	var $name = 'DepositSlips';
	var $uses = array('DepositSlip','Branch');
	var $paginate = array('limit' => 9999);
	
	function accounting_index(){
		$this->index();
	}

	function index() {
		$this->DepositSlip->recursive = 0;
		$this->set('depositSlips', $this->paginate());

		$branches = $this->Branch->find('list',array('conditions'=>array('enabled'=>true)));	
		$this->set('branches',$branches);

		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Deposit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('depositSlip', $this->DepositSlip->read(null, $id));
	}

	function accounting_add(){
		$this->add();
	}

	function add() {
		if (!empty($this->data)) {
			$this->DepositSlip->create();
			if ($this->DepositSlip->save($this->data)) {
				$this->Session->setFlash(__('The Deposit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Deposit could not be saved. Please, try again.', true));
			}
		}
		$fields = $this->DepositSlip->query( $this->getTableDescQueryString('deposit_slips',array('id','deposit_date','date_deposited','entry_datetime','user_id')) );
		$this->set('model','DepositSlip');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->DepositSlip->validationErrors);	

		// $this->render('/elements/common/defaultform');
	}

	function accounting_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Deposit', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->DepositSlip->save($this->data)) {
				$this->Session->setFlash(__('The Deposit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Deposit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->DepositSlip->read(null, $id);
		}

		$fields = $this->DepositSlip->query( $this->getTableDescQueryString('deposit_slips',array('id','deposit_date','date_deposited','entry_datetime','user_id')) );
		$this->set('model','DepositSlip');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->DepositSlip->validationErrors);
		// $this->render('/elements/common/defaultform');
	}

	function accounting_delete($id = null){
		$this->delete($id);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Deposit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->DepositSlip->delete($id)) {
			$this->Session->setFlash(__('Deposit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Deposit was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
