<?php
class BrandsController extends AppController {

	var $name = 'Brands';
	var $uses = array('Brand');
	var $paginate = array('limit' => 9999);
		
	function accounting_index(){
		$this->index();
	}

	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->Brand->recursive = 0;
		$this->set('brands', $this->paginate());
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid brand', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('brand', $this->Brand->read(null, $id));
	}

	function accounting_add(){
		$this->add();
	}

	function inventory_add(){
		$this->add();
	}

	function add() {

		if (!empty($this->data)) {
			$this->Brand->create();
			if ($this->Brand->save($this->data)) {
				$this->Session->setFlash(__('The brand has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.', true));
			}
		}
		
		$fields = $this->Brand->query( $this->getTableDescQueryString('brands',array('id','entry_datetime','user_id')) );
		$this->set('model','Brand');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Brand->validationErrors);
	

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
			$this->Session->setFlash(__('Invalid brand', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Brand->save($this->data)) {
				$this->Session->setFlash(__('The brand has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Brand->read(null, $id);

		}

		$fields = $this->Brand->query( $this->getTableDescQueryString('brands',array('entry_datetime','user_id')) );
		$this->set('model','Brand');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Brand->validationErrors);
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
			$this->Session->setFlash(__('Invalid id for brand', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Brand->delete($id)) {
			$this->Session->setFlash(__('Brand deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Brand was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
