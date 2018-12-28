<?php
class TypesController extends AppController {

	var $name = 'Types';
	var $uses = array('Type');
	var $paginate = array('limit' => 9999);
	
	function accounting_index(){
		$this->index();
	}

	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->Type->recursive = 0;
		$this->set('types', $this->paginate());
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('type', $this->Type->read(null, $id));
	}

	function accounting_add(){
		$this->add();
	}

	function inventory_add(){
		$this->add();
	}

	function add() {

		if (!empty($this->data)) {
			$this->Type->create();
			if ($this->Type->save($this->data)) {
				$this->Session->setFlash(__('The type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The type could not be saved. Please, try again.', true));
			}
		}
		
		$fields = $this->Type->query( $this->getTableDescQueryString('types',array('id','entry_datetime','user_id')) );
		$this->set('model','Type');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Type->validationErrors);
	
		$this->render('/elements/common/defaultform');
	}

	function accounting_edit($id = null){
		$this->edit($id);
	}

	function inventory_edit($id = null){
		$this->edit($id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Type->save($this->data)) {
				$this->Session->setFlash(__('The type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Type->read(null, $id);

		}

		$fields = $this->Type->query( $this->getTableDescQueryString('types',array('entry_datetime','user_id')) );
		$this->set('model','Type');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Type->validationErrors);
		$this->render('/elements/common/defaultform');
	}

	function accounting_delete($id = null){
		$this->delete($id);
	}

	function inventory_delete($id = null){
		$this->delete($id);
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Type->delete($id)) {
			$this->Session->setFlash(__('Type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
