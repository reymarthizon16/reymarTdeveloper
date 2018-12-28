<?php
class AccountsController extends AppController {

	var $name = 'Accounts';
	var $uses = array('Account','AccountType');
	var $paginate = array('limit' => 9999);
	
	function accounting_index(){
		$this->index();
	}

	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->Account->recursive = 0;
		$this->set('accounts', $this->paginate());

		$accountTypes = $this->AccountType->find('list');
		$this->set('accountTypes',$accountTypes);
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid account', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('account', $this->Account->read(null, $id));
	}

	function inventory_add(){
		$this->add();
	}

	function accounting_add(){
		$this->add();
	}

	function add() {

		if (!empty($this->data)) {
			$this->Account->create();
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The account has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true));

			}
		}
		
		$fields = $this->Account->query( $this->getTableDescQueryString('accounts',array('id','entry_datetime','user_id')) );
		$this->set('model','Account');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Account->validationErrors);
		$this->render('management');
	}

	function accounting_quickadd($type){
		$this->quickadd($type);
	}

	function inventory_quickadd($type){
		$this->quickadd($type);
	}

	function quickadd($type){
		
		$data['success'] = false;

		if (!empty($this->data)) {
			$this->Account->create();
			if ($this->Account->save($this->data)) {
				$data['success'] = true;
				
			} else {
				$data['success'] = false;

			}
		}

		if($type == 1)
			$accounts = $this->getAccountCustomer();

		if($type == 2 || $type == 3)
			$accounts = $this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>$type)));

		$data['Account'] = $accounts;

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');	

	}

	function accounting_edit($id = null){
		$this->edit($id);
	}

	function inventory_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid account', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The account has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Account->read(null, $id);

		}

		$fields = $this->Account->query( $this->getTableDescQueryString('accounts',array('entry_datetime','user_id')) );
		$this->set('model','Account');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Account->validationErrors);		
		$this->render('management');
	}

	function accounting_delete($id = null){
		$this->delete($id);
	}

	function inventory_delete($id = null){
		$this->delete($id);
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for account', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Account->delete($id)) {
			$this->Session->setFlash(__('Account deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Account was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
