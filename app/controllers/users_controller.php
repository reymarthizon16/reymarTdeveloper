<?php
class UsersController extends AppController {
	var $name='Users';
	var $uses = array('User','Branch');
	var $helpers = array('Javascript','Session','Html','Form');
	var $paginate = array('limit' => 9999);

	var $components=array();
	
	function beforeFilter()
	{
		$this->Auth->allow('logout','add');
		parent::beforeFilter();
		
	}

	function inventory_login()
	{
		$this->login();
	}

	function login()
	{
		if ($this->Auth->user())
		{
			
			if ($this->params['action']=='logout')
			{
				//continue
			}
			elseif ( $this->Auth->user('role')==0 )
			{	//admin
				$this->redirect('/inventory/home/index');
			}
			elseif ( $this->Auth->user('role')==1 )
			{	//inventory			 	
				$this->redirect('/inventory/home/index');
			}else{

			}
		}
		
		$this->layout  = 'login';
	}
	
	function authenticated()
	{
		
	}

	function inventory_index(){
		$this->index();
	}

	function accounting_index(){
		$this->index();
	}
	
	function index() {
		$branches = $this->Branch->find('list');
		$this->set('branches',$branches);
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$this->render('index');
	}
	
	function logout()
	{
		$this->Auth->logout();
		$this->redirect('/users/login');
	}

	function inventory_add(){
		$this->add();
	}

	function accounting_add(){
		$this->add();
	}

	function add() {
		debug($this->data);
		if (!empty($this->data)) {
			
			$this->User->begin();
			$error = false;
			if(!$this->User->saveAll($this->data['User'], array('validate'=>'only')))
			{
				$this->Session->setFlash('Error saving user.');
				$error = true;
			}else{
				$this->User->save($this->data['User']);
				$this->User->commit();
			}

		
		}
			
		$fields = $this->User->query( $this->getTableDescQueryString('users',array('id','entry_datetime','user_id')) );
		$this->set('model','User');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->User->validationErrors);

	}

	function inventory_edit($id){
		$this->edit($id);
	}

	function accounting_edit($id){
		$this->edit($id);
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {

			if( $this->data['User']['password_change'] == 0 )
				unset($this->data['User']['password']);

			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);

		}

		$fields = $this->User->query( $this->getTableDescQueryString('users',array('entry_datetime','user_id')) );
		$this->set('model','User');
		$this->set('modelfields',$fields);
		$this->set('modelfieldErrors',$this->User->validationErrors);
		// $this->render('/elements/common/defaultform');
	}

	function inventory_delete($id = null){
		$this->delete($id);
	}

	function accounting_delete($id = null){
		$this->delete($id);
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>