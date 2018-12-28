<?php
class BranchesController extends AppController {

	var $name = 'Branches';
	var $uses = array('Branch');
	var $paginate = array('limit' => 9999);
	
	function inventory_index(){
		$this->index();
	}

	function accounting_index(){
		$this->index();
	}

	function index() {
		$this->Branch->recursive = 0;
		$this->set('branches', $this->paginate());
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('branch', $this->Branch->read(null, $id));
	}

	function inventory_add(){
		$this->add();
	}

	function accounting_add(){
		$this->add();
	}

	function add() {
		if (!empty($this->data)) {
			$this->Branch->create();
			if ($this->Branch->save($this->data)) {
				$this->Session->setFlash(__('The branch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The branch could not be saved. Please, try again.', true));
			}
		}
		$fields = $this->Branch->query( $this->getTableDescQueryString('branches',array('id','entry_datetime','user_id')) );
		$this->set('model','Branch');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Branch->validationErrors);
		
		$this->render('/elements/common/defaultform');
	}

	function inventory_edit($id = null){
		$this->edit($id);
	}

	function accounting_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Branch->save($this->data)) {
				$this->Session->setFlash(__('The branch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The branch could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Branch->read(null, $id);
		}
		
		$fields = $this->Branch->query( $this->getTableDescQueryString('branches',array('entry_datetime','user_id')) );
		$this->set('model','Branch');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Branch->validationErrors);
		$this->render('/elements/common/defaultform');
	}

	function inventory_delete($id = null){
		$this->delete($id);
	}

	function accounting_delete($id = null){
		$this->delete($id);
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Branch->delete($id)) {
			$this->Session->setFlash(__('Branch deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Branch was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
