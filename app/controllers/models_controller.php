<?php
class ModelsController extends AppController {

	var $name = 'Models';
	var $uses = array('Model','Brand','Type');
	var $paginate = array('limit' => 9999);
	
	function accounting_index(){
		$this->index();
	}

	function inventory_index(){
		$this->index();
	}

	function index() {
		$this->Model->recursive = 0;
		$this->set('models', $this->paginate());
		$brands = $this->Brand->find('list');
		$this->set('brands',$brands);
		$types = $this->Type->find('list');
		$this->set('types',$types);
		$this->render('index');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid model', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('model', $this->Model->read(null, $id));
	}

	function accounting_add(){
		$this->add();
	}

	function inventory_add(){
		$this->add();
	}

	function add() {

		if (!empty($this->data)) {
			$this->Model->create();
			if ($this->Model->save($this->data)) {
				$this->Session->setFlash(__('The model has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {				
				$this->Session->setFlash(__('The model could not be saved. Please, try again.', true));
			}
		}
		
		$fields = $this->Model->query( $this->getTableDescQueryString('models',array('id','entry_datetime','user_id')) );
		$this->set('model','Model');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Model->validationErrors);
	
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
			$this->Session->setFlash(__('Invalid model', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Model->save($this->data)) {
				$this->Session->setFlash(__('The model has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The model could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Model->read(null, $id);

		}

		$fields = $this->Model->query( $this->getTableDescQueryString('models',array('entry_datetime','user_id')) );
		$this->set('model','Model');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->Model->validationErrors);
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
			$this->Session->setFlash(__('Invalid id for model', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Model->delete($id)) {
			$this->Session->setFlash(__('Model deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Model was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function accounting_getModel(){
		$this->getModel();
	}

	function inventory_getModel(){
		$this->getModel();
	}

	function getModel(){		

		$model_id = explode(",", $this->data['model_id']);

		$models = $this->Model->find('all',array('conditions'=>array('Model.id'=>$model_id)));
		foreach ($models as $key => &$value) {
			$itemType=$this->Type->find('first',array('conditions'=>array('Type.id'=>$value['Model']['type_id']),'recursive'=>-1));
			$itemBrand=$this->Brand->find('first',array('conditions'=>array('Brand.id'=>$value['Model']['brand_id']),'recursive'=>-1));		
			$value['Type'] = $itemType['Type'];
			$value['Brand'] = $itemBrand['Brand'];
		}
		
		$data =  $models;	

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function accounting_getInputs(){
		$this->getInputs();
	}

	function inventory_getInputs(){
		$this->getInputs();
	}

	function getInputs(){

		$data = array();		
		$data['success'] = true;
		
		$model = $this->data['Model'];		

		$fields = $this->$model->query( $this->getTableDescQueryString(lcfirst($model."s"),array('entry_datetime','user_id')) );
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

		$data = $this->$model->find('list');
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}


	
}
