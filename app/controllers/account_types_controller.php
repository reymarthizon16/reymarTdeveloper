<?php
class AccountTypesController extends AppController {

	var $name = 'AccountTypes';
	var $uses = array('AccountType');
	var $paginate = array('limit' => 9999);
	
	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->AccountType->recursive = 0;
		$this->set('accountTypes', $this->paginate());
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid account type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('accountType', $this->AccountType->read(null, $id));
	}

	function inventory_add(){
		$this->add();
	}

	function add() {
		if (!empty($this->data)) {
			$this->AccountType->create();
			if ($this->AccountType->save($this->data)) {
				$this->Session->setFlash(__('The account type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.', true));
			}
		}
		$fields = $this->AccountType->query( $this->getTableDescQueryString('account_types',array('id','entry_datetime','user_id')) );
		$this->set('model','AccountType');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->AccountType->validationErrors);
	

		$this->render('/elements/common/defaultform');
	}

	function inventory_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid account type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->AccountType->save($this->data)) {
				$this->Session->setFlash(__('The account type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AccountType->read(null, $id);
		}

		$fields = $this->AccountType->query( $this->getTableDescQueryString('account_types',array('entry_datetime','user_id')) );
		$this->set('model','AccountType');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->AccountType->validationErrors);
		$this->render('/elements/common/defaultform');
	}

	function inventory_delete($id = null){
		$this->delete($id);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for account type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AccountType->delete($id)) {
			$this->Session->setFlash(__('Account type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Account type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
