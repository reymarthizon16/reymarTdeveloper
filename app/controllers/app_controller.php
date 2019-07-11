<?php
class AppController extends Controller {
	var $components = array('Session','Auth','RequestHandler');
	var $helpers = array('Html', 'Form', 'Javascript', 'Session', 'Paginator','MatInflector'); 
	
	var $uses=array();
	
	function getTableDescQueryString($table_name,$notin = array()){

		$notinString = "";
		if(!empty($notin)){
			$implode = "'" . implode ( "', '", $notin ) . "'";
			$notinString = "AND COLUMN_NAME not in (".$implode.")";
			// $notinString = implode("','",$notin);
		}

		$query = "select * from (
			SELECT TABLE_NAME,COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT , COLUMN_KEY
			  FROM INFORMATION_SCHEMA.COLUMNS
			  WHERE table_name = '".$table_name."' AND TABLE_SCHEMA = 'citytrust_test9' 
			  ".$notinString."
			) TableDesc";
		// $this->log($query,'Mainquery');
		return $query;
	}

	function beforeFilter()
	{
		// $this->Auth->allow('*');
		if($this->Auth->user()){
			$this->Session->write('Auth.User.original_role',$this->Auth->user('role'));
			$this->Session->write('User',$this->Auth->user());
		}
		
		if (isset($this->params['prefix']))
		{			

			$this->Auth->logoutRedirect=array('controller'=>'users','action'=>'login');
			$this->Auth->userScope = array('User.enabled'=>1);
			$this->Auth->loginError = "Invalid username/password.";
			$this->Auth->authError = "You are not authorized to access that module.";
			$this->Auth->authorize = 'controller';
				
			$this->Session->write('prefix',$this->params['prefix']);
			
		} else
		{
			
			if ($this->Auth->user())
			{
				
				if ($this->params['action']=='logout')
				{
					//continue
				}
				elseif ( $this->Auth->user('role')==0 )
				{	//admin
					// $this->redirect('/inventory/home/index');
				}
				elseif ( $this->Auth->user('role')==1 )
				{	//inventory			 	
					$this->redirect('/inventory/home/index');
				}
				elseif ( $this->Auth->user('role')==2 )
				{	//inventory			 	
					$this->redirect('/accounting/home/index');
				}
				else{

				}
			}
			
		    
		}

	}

	 function isAuthorized() { 
		
		//if the prefix is setup, make sure the prefix matches their role 
		if( $this->Auth->user('role')==0  ){
			return true;
		}
		else if ($this->params['prefix']=='inventory' && $this->Auth->user('role')==1 ) {
			return true;
		}
		else if ($this->params['prefix']=='accounting' && $this->Auth->user('role')==2 ) {
			return true;
		}

		return false;  
	}

	
	


	function appajax($data){
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function addItemHistory($serial_no,$note,$datetime = null){

		$this->loadModel('ItemHistory');
		$tmpdatetime = date('Y-m-d H:i:s');
		if($datetime)
			$tmpdatetime = date('Y-m-d H:i:s',strtotime($datetime));
		$history['ItemHistory'] = array(
			'serial_no'=>$serial_no,
			'note'=>$note,
			'datetime'=>$tmpdatetime
		);
		$this->ItemHistory->create();
		$this->ItemHistory->save($history);
		$this->log($serial_no.$note,'History');
	}

	function getAccountCustomer(){
		$this->loadModel('ItemHistory');
		$accounts=$this->Account->find('all',array('fields'=>array('id','last_name','first_name'),'conditions'=>array('enabled'=>true,'account_type_id'=>1),'recursive'=>-1));
		// debug($accounts);
		foreach ($accounts as $key => $value) {
			$accountlist[$value['Account']['id']] = $value['Account']['last_name'].', '.$value['Account']['first_name'];
		}
		return $accountlist;
	}

	function getAccountCustomerFulldet(){
		$this->loadModel('ItemHistory');
		$accounts=$this->Account->find('all',array('fields'=>array('id','last_name','first_name','mobile_no','address'),'conditions'=>array('enabled'=>true,'account_type_id'=>1),'recursive'=>-1));
		// debug($accounts);
		foreach ($accounts as $key => $value) {
			$accountlist[$value['Account']['id']]['full_name'] = $value['Account']['last_name'].', '.$value['Account']['first_name'];
			$accountlist[$value['Account']['id']]['mobile_no'] = $value['Account']['mobile_no'];
			$accountlist[$value['Account']['id']]['address'] = $value['Account']['address'];
		}
		return $accountlist;
	}

	function getUserSales(){
		
		$this->loadModel('User');
		$users=$this->User->find('all',array('fields'=>array('id','last_name','first_name'),'conditions'=>array('enabled'=>true,'role'=>3),'recursive'=>-1));
		// debug($users);
		foreach ($users as $key => $value) {
			$userlists[$value['User']['id']] = $value['User']['last_name'].', '.$value['User']['first_name'];			
		}

		return $userlists;
	}

	function monthDifference($start_date,$end_date){
		$date1 = $start_date;
		$date2 = $end_date;

		$ts1 = strtotime($date1);
		$ts2 = strtotime($date2);

		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);

		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);

		$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

		if( $diff < 0)
			$diff = 0;
		
		return $diff;
	}

	function pre($string){
		echo '<pre>'. $string .'</pre>';
	}

	function month(){

		$month = array();
		$month['1'] = "January";
		$month['2'] = "February";
		$month['3'] = "March";
		$month['4'] = "April";
		$month['5'] = "May";
		$month['6'] = "June";
		$month['7'] = "July";
		$month['8'] = "August";
		$month['9'] = "September";
		$month['10'] = "October";
		$month['11'] = "November";
		$month['12'] = "December";

		return $month;
	}

	function year(){

		$year = array();
		$year['2016'] = "2016";
		$year['2017'] = "2017";
		$year['2018'] = "2018";
		$year['2019'] = "2019";
		$year['2020'] = "2020";
		$year['2021'] = "2021";
		$year['2022'] = "2022";
		$year['2023'] = "2023";
		$year['2024'] = "2024";
		$year['2025'] = "2025";		

		return $year;
	}

	function dateNull($date){
		if(empty($data)){
			return null;
		}
		else{
			return date('Y-m-d',strtotime($date));
		}

	}
}	
?>