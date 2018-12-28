<?php
class MainController extends WorklistAppController {
	var $name="Main";
	var $uses=array();
	var $components = array('RequestHandler','LisService');
	var $helpers = array('Xml','Form','Session');
	
	
	
	function beforeFilter()
	{
		if (isset($this->params['prefix']) && $this->params['prefix']=='phlebotomy' && $this->params['action']=='phlebotomy_windowcheckin') {
			$this->Auth->allow('phlebotomy_windowcheckin');
			
			if(($this->webLISConfiguration = Cache::read('WebLISConfiguration'))===false) {
			
				$this->loadModel('Configuration');
				$this->webLISConfiguration=$this->Configuration->find('list',array(
						'fields'=>array('id','value')
				));
			
				Cache::write('WebLISConfiguration', $this->webLISConfiguration);
			
				if(isset($this->webLISConfiguration['order.emergency_order']))
					$this->set('emergency_order', $this->webLISConfiguration['order.emergency_order']);
			}
		} else 
			parent::beforeFilter();
		
		Configure::load('worklist.core');
		
		
	}	
	
	function phlebotomy_windowcheckin() {
		$this->phlebotomy_checkin();
	}
	
	function phlebotomy_checkin() {
		if ($this->data['Checkin']['window']==1) {
			$data['Checkin'][]=array(
						'date'=>date('Y-m-d',strtotime('now')),
						'time'=>date('H:i:s',strtotime('now')),
						'specimen_id'=>$this->data['Checkin']['specimen_id'],
						'user_id'=>$this->data['Checkin']['id']
			);
			$this->data=$data;
		}
		
		$this->checkin();
	}
	
	function __getwardingtime() {
		$this->loadModel('WardingSchedule');
		$wardingtime=$this->WardingSchedule->find('all',array('conditions'=>array('enabled'=>1),'order'=>array('end_time')));
		
		$newwardingtime[]=array('WardingSchedule'=>array(
				'id'=>-1,
				'name'=>'All',
				'start_time'=>'00:00:00',
				'end_time'=>'00:00:00',
				'enabled'=>1
		));
		
        $newwardingtime[]=array('WardingSchedule'=>array(
        	'id'=>0,
        	'name'=>'Uncollected',
        	'start_time'=>'00:00:00',
        	'end_time'=>'00:00:00',
        	'enabled'=>1
        ));		
        
        foreach($wardingtime as $key=>$value) {
        	$newwardingtime[]=$value;
        }
		
		return $newwardingtime;
	}
	
	function __getlocationfilter() {
		$locationfilters=Configure::read('worklist.phlebotomy.locationfilters');
		
		App::import('Component', 'worklist.'.$locationfilters['component']);
		$componentclass=$locationfilters['class'].'Component';
		$this->$locationfilters['component']= new $componentclass($this);
		
		$method=$locationfilters['method'];
		
		$data=array();
		if (!empty($this->data['Worklist'])) {
			$data=$this->$locationfilters['component']->$method($this->data['Worklist']['filter']);
		} else
			$data=$this->$locationfilters['component']->$method();
		
		return $data;
	}
	
	function __getwarding() {
		$warding=Configure::read('worklist.phlebotomy.warding');
	
		App::import( 'Component', 'worklist.'.$warding['component'] );
		$componentclass=$warding['class'].'Component';
		$this->$warding['component']= new $componentclass($this);
	
		$method=$warding['method'];
	
		$data=array();
		if (!empty($this->data['Worklist'])) {
			$data=$this->$warding['component']->$method($this->data['Worklist']);
		} else
			$data=$this->$warding['component']->$method();
	
		return $data;
	}
	
	function __getwardinglist() {
		
		$warding=Configure::read('worklist.phlebotomy.wardinglist');		
		
		App::import( 'Component', 'worklist.'.$warding['component'] );
		$componentclass=$warding['class'].'Component';
		$this->$warding['component']= new $componentclass($this);
	
		$method=$warding['method'];

		
	
		$data=array();
		if (!empty($this->data['WardList'])) {
			$data=$this->$warding['component']->$method($this->data['WardList']);
		} else
			$data=$this->$warding['component']->$method();
		
	
		return $data;
	}
	
	function __wardinglist() {
		$warding=Configure::read('worklist.phlebotomy.wardinglist');
	
		App::import( 'Component', 'worklist.'.$warding['component'] );
		$componentclass=$warding['class'].'Component';
		$this->$warding['component']= new $componentclass($this);
	
		$method=$warding['method'];
	
		$data=$this->$warding['component']->$method();
		
		
	
		return $data;
		//pdf
	}	
	
	function createwardinglist() {
	
		$data['success'] = true;
		
		$specimenids=array();
		foreach($this->data['WardingList'] as $key=>$value) {
			if ($value['include'])
				$specimenids[]=$value['specimen_id'];
		}
		
		if (count($specimenids)) {
				
			$wardingschedule=array();
				
			$wardinglist=array();
				
			if ($this->data['Worklist']['time']==1){ //scheduled
				$this->loadModel('WardingSchedule');
				$wardingschedule=$this->WardingSchedule->find('first',array('conditions'=>array('id'=>$this->data['Worklist']['time'])));
		
				$wardinglist['type']=1;				
				$wardinglist['start_date'] = date('Y-m-d',strtotime($this->data['Worklist']['start_date']));
				$wardinglist['end_date'] = date('Y-m-d',strtotime($this->data['Worklist']['end_date']));
				
			} else {
				if ($this->data['Worklist']['time']==0) { //uncollected
					$wardinglist['type']=0;
				} else
				if ($this->data['Worklist']['time']==2) { //frontdesk list
					$wardinglist['type']=2;
				}
				else { // all
					$wardinglist['type']=-1;
				}
			}
				
			$this->loadModel('WardingList');
			$this->loadModel('WardingDetail');
			//$this->WardingList->begin();
			//$this->WardingList->create();
				
			$wardinglist['warding_id'] =  $this->LisService->getNewWardingID();
			$wardinglist['entry_datetime']=date('Y-m-d H:i:s');
			$wardinglist['user_id']=$this->Auth->user('id');
				
			$data['success']=$this->WardingList->save($wardinglist);
				
			if ($data['success']) {
				foreach($this->data['WardingList'] as $key=>$value) {
					if ($value['include']) {
						$this->WardingDetail->create();
		
						$wardingdetail=array();
						$wardingdetail['warding_list_id']=$this->WardingList->id;
						$wardingdetail['specimen_id']=$value['specimen_id'];
						$wardingdetail['uncollected']=$value['uncollected'];
						if ($value['uncollected'])
							$wardingdetail['uncollected_warding_id']=$value['uncollected_warding_id'];
						$wardingdetail['entry_datetime']=date('Y-m-d H:i:s');
						$wardingdetail['user_id']=$this->Auth->user('id');
		
						$data['success']=$this->WardingDetail->save($wardingdetail);
		
						if (!$data['success'])
							break;
					}
				}
				
				if ($data['success'] && Configure::read('worklist.phlebotomy.barcodeoncreatewardinglist')) {
					//foreach($this->data['WardingList'] as $key=>$value) {
					//	$this->__barcode($value['specimen_id'],$this->data['Worklist']['printer_id']);
					//}

					for($i = count($this->data['WardingList'])-1;$i>=0;$i--) {
						$value=$this->data['WardingList'][$i];
						$this->__barcode($value['specimen_id'],$this->data['Worklist']['printer_id']);
					}
				}	
			}
				
			if ($data['success']) {
				$data['success']=true;
				$data['warding_id']=$wardinglist['warding_id'];
			} else
				$data['success']=false;
		
			//debug($this->WardingList->getDataSource()->getLog(false,false));
				
			//if ($data['success']) {
			//	$this->WardingList->commit();
			//} else
			//	$this->WardingList->rollback();
		} else
			$data['success'] = false;
		
		
		$this->set('data',$data);
		$this->layout='ajax';
		$this->render('/common/json');
	}
	
	function phlebotomy_createwardinglist() {
		$this->createwardinglist();
	}
	
	function phlebotomy_warding() {
		//$data=$this->__phlebologs();
		//$data=null;
		//$this->set('data',$this->data);
		//$queryfilters=Configure::read('worklist.phlebotomy.queryfilters');
		//$queryfilters=array('Ward1','Ward2','Ward3','Ward4');
		//debug($this->data);
		$mode=0; //0 - warding creation, 1 - warding viewing
		$queryfilters=$this->__getlocationfilter();
		$wardingtime=$this->__getwardingtime();
		$departments = Configure::read('weblis.department_grouping');
		$departmentfilter = array();
		foreach($departments as $departmentkey=>$department)
			$departmentfilter[$departmentkey]=$department['label'];
		
		//debug($departmentfilter);
		if(isset($this->data['Worklist']['start_date']) && !empty($this->data['Worklist']['start_date']))
			$this->data['Worklist']['start_date'] = date('Y-m-d', strtotime($this->data['Worklist']['start_date']));
		else
			$this->data['Worklist']['start_date'] = date('Y-m-d');
		
		if(isset($this->data['Worklist']['end_date']) && !empty($this->data['Worklist']['end_date']))
			$this->data['Worklist']['end_date'] = date('Y-m-d', strtotime($this->data['Worklist']['end_date']));
		else
			$this->data['Worklist']['end_date'] = date('Y-m-d');
		
		if (!isset($this->data['Worklist']['time']))
			$this->data['Worklist']['time']=-1;
			
		if(!isset($this->data['Worklist']['filter']) && empty($this->data['Worklist']['filter']))
			$this->data['Worklist']['filter'] = array_keys($queryfilters);
			
		//if(!isset($this->data['Worklist']['department']) && empty($this->data['Worklist']['department']))
		//	$this->data['Worklist']['department'] = 0;
		
			
		$type=0;
		if (!empty($this->data['WardList'])) {
			if ($this->data['WardList']['action']==2) { //pdf
	
				$data=$this->__getwardinglist();
				
				$this->loadModel('Branch');
	
				$branch=$this->Branch->find('first',array('recursive'=>-1));
	
				// $this->log($data,'data');
				$this->set('data',$data);
				$this->set('branch',$branch);
				$this->set('wardingelement',Configure::read('worklist.phlebotomy.wardinglistelement'));
				$this->layout="pdf";
				$this->render('phlebotomy_wardinglist');
				return;
			} else {
				$mode=2;
				$type=1;
				$data=$this->__getwardinglist();
			}
				
				
		} else
			$data=$this->__getwarding();
		
		if (isset($this->data['Worklist']['department'])) {
			$this->Session->write('Worklist.filter_warding_department_id',$this->data['Worklist']['department']);
		}
		
		if (isset($this->data['Worklist']['branch'])) {
			$this->Session->write('Worklist.filter_warding_branch_id',$this->data['Worklist']['branch']);
		}
		
		$this->loadModel('Branch');
		$branches=$this->Branch->find('list');
		
		$this->set('branches',$branches);
		$this->set('departmentfilter',$departmentfilter);	
		$this->data['Worklist']['start_date'] = date('m/d/Y', strtotime($this->data['Worklist']['start_date']));
		$this->data['Worklist']['end_date'] = date('m/d/Y', strtotime($this->data['Worklist']['end_date']));
		$this->set('data',$data);
		$this->set('type',$type);
		$this->set('wardingelement',Configure::read('worklist.phlebotomy.wardingelement'));
		$this->set('wardingtime',$wardingtime);
		$this->set('queryfilters',$queryfilters);
		$this->render('phlebotomy_warding');
	}
	
	
	
	function warding() {
		$this->phlebotomy_warding();
	}
	
	function checkinlog() {
		$this->phlebotomy_checkinlog();
	}
	
	function phlebotomy_checkinlog() {
		$data=$this->__phlebologs();
		
		$this->set('data',$data);	
		$queryfilters=Configure::read('worklist.phlebotomy.queryfilters');
		$this->set('queryfilters',$queryfilters);
		$this->render('phlebotomy_checkinlog');		
	}
	
	function phlebotomy_getlogs() {
		$this->getlogs();
	}

	function getlogs() {
		$data=$this->__phlebologs();
	
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	function __phlebologs() {
		$getorders=Configure::read('worklist.phlebotomy.log');
		
		App::import( 'Component', 'worklist.'.$getorders['component'] );
		$componentclass=$getorders['class'].'Component';
		$this->$getorders['component']= new $componentclass($this);
		
		$method=$getorders['method'];

		$data=array();
		if (!empty($this->data['Worklist'])) {
			$data=$this->$getorders['component']->$method($this->data['Worklist']['filter']);
		} else
			$data=$this->$getorders['component']->$method();
		
		return $data;
	}
	
	function addSpecimenHistory($data)
	{
		$error = false;
		$data['action_date'] = date('Y-m-d');
		$data['action_time'] = date('H:i:s');
			
		$this->TestOrder->PatientOrder->PatientOrderHistory->create();
		if(!$this->TestOrder->PatientOrder->PatientOrderHistory->save($data))
			$error = true;
	
		return $error;
	}
	
	function __barcode($specimenid,$printer_id=1) {
		$this->loadModel('OnePrintingQueue');
		
		$barcode=array();
		$barcode['printer_id']=$printer_id;//Configure::read('worklist.phlebotomy.default_barcode_id');
		$barcode['specimen_id']=$specimenid;
		$barcode['requested_datetime']=date('Y-m-d H:i:s');
		$barcode['copies']=1;
		$barcode['requesting_user_id']=$this->Auth->user('id');
		$barcode['printed']=0;
		
		$this->OnePrintingQueue->create();
		$this->OnePrintingQueue->save($barcode);
	}
	
	function phlebotomy_barcode() {
		$this->barcode();
	}
	
	function phlebotomy_setbarcode() {
		$data['sucess']=true;
		
		$this->Session->write('Worklist.barcode_printer_id',$this->data['Worklist']['printer_id']);
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	function barcode() {
		$data['success']=true;
		$printer_id=Configure::read('worklist.phlebotomy.default_barcode_id');
		
		if ($this->data['Barcode']['printer_id']) {
			$printer_id=$this->data['Barcode']['printer_id'];
			unset($this->data['Barcode']['printer_id']);
		}
		
		if ($this->data['Worklist']['printer_id']) {
			$printer_id=$this->data['Worklist']['printer_id'];
			unset($this->data['Barcode']['printer_id']);
		}
		
		if (!empty($this->data['Barcode'])) {
			foreach($this->data['Barcode'] as $key=>$value) {
				$this->__barcode($value['specimen_id'],$printer_id);
			}
		} else
			$data['sucess']=false;
		
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');			
	}
	
	function _afterCheckin($specimen_id)
	{
	
		$this->loadModel('Plugin');
		$afterReleasePlugins=$this->Plugin->find('all',array(
				'conditions'=>array('type'=>'phlebo.afterCheckin','enabled'=>1)
		));
	
		if ($afterReleasePlugins)
		{
			$loadedPlugins=array();
			foreach($afterReleasePlugins as $key=>$plugin)
			{
	
				if (!isset($loadedPlugins["{$plugin['Plugin']['plugin']}.{$plugin['Plugin']['class']}"]))
				{
					App::import('Controller',"{$plugin['Plugin']['plugin']}.{$plugin['Plugin']['class']}");
					$class="{$plugin['Plugin']["class"]}Controller";
					$loadedPlugins["{$plugin['Plugin']['plugin']}.{$plugin['Plugin']['class']}"]=new $class();
	
					if ($plugin['Plugin']['construct_classes'])
					{
						//not yet supported
						//$pluginInstance->constructClasses();
						//$pluginInstance->params = $this->params;
					}
				}
	
				$return=$loadedPlugins["{$plugin['Plugin']['plugin']}.{$plugin['Plugin']['class']}"]->$plugin['Plugin']["method"]($specimen_id);
	
				if ($return===true) {
					$return=array();
					$return['specimen_id']=$specimen_id;
					$return['success']=true;
				}
			}
	
		} else {
			$return['specimen_id']=$specimen_id;
			$return['success']=true;
		}
		
		return $return;
	}
	
	function checkin() {
		$specimenids=array();
		$specimens=array();
		$data['success']=true;
		
		// $this->log($this->data,'checkin');
		
		if (isset($this->data['Checkin'][0])) {
			$this->loadModel('TestOrder');
			
			$windowcheckinid=0;

			foreach($this->data['Checkin'] as $key=>&$value) {
				
				if (!isset($value['datetime'])) {
					$value['datetime'] = $value['date']. ' '.$value['time']; 
				}
				
				$specimenids[$value['specimen_id']]=$value['specimen_id'];
				$specimens[$value['specimen_id']]=$value;
				
				if ($value['user_id'])
					$windowcheckinid=$value['user_id'];
			}
			
			$testorders=$this->TestOrder->find('all',array(
				'recursive'=>-1,
				'conditions'=>array('TestOrder.specimen_id'=>$specimenids),
				'joins'=>array(
						array(
								'table'=>'patient_orders',
								'alias'=>'PatientOrder',
								'conditions'=>array('PatientOrder.specimen_id = TestOrder.specimen_id')
						)
				)
			));
			
			
			$processedtestorders=array();
			foreach($testorders as $key=>$testorder) {
				if ($testorder['TestOrder']['status']==8) {
					
					$testresults=$this->TestOrder->TestResult->find('all',array(
						'recursive'=>-1,
						'fields'=>array('*'),
						'conditions'=>array('test_order_id'=>$testorder['TestOrder']['id']),
						'joins'=>array(
							array(
								'table'=>'test_result_specimens',
								'alias'=>'TestResultSpecimen',
								'conditions'=>array('TestResultSpecimen.test_result_id = TestResult.id')
							)
						)	
					));
					
					$testorder['TestResults']=$testresults;
					$processedtestorders[]=$testorder;
				} else {
					$data['specimens'][]=array('specimen_id'=>$testorder['TestOrder']['specimen_id'],'success'=>false);
				}
			}
			
			if (count($processedtestorders)>0) {
				
				foreach($processedtestorders as $key=>$value) {
					$this->TestOrder->begin();
					//save only what is necessary
					$testorder=array();
					$testorder['id']=$value['TestOrder']['id'];
					
					
					if ($this->webLISConfiguration['weblis.medtech_specimen_checkin']==1)
						$testorder['status']=9;
					else
						$testorder['status']=0;
					
					$data['success']=$this->TestOrder->save($testorder);
					
					if (!$data['success'])
						break;
					

						
					if (!$data['success'])
						break;
					
					$patientorder=array();
					$patientorder['specimen_id']=$value['TestOrder']['specimen_id'];
					$patientorder['comments']=$value['PatientOrder']['comments'].$specimens[$value['TestOrder']['specimen_id']]['remarks'];
						
					$data['success']=$this->TestOrder->PatientOrder->save($patientorder);
					
					if (!$data['success'])
						break;
					
					foreach($value['TestResults'] as $key1=>$testresult) {
						$labnote = array(
								'id'=>$testresult['TestResult']['id'],
								'lab_notes'=>$specimens[$value['TestOrder']['specimen_id']]['labnotes']
						);
						
						$data['success']=$this->TestOrder->TestResult->save($labnote);
						if (!$data['success'])
							break;
						
						if ($windowcheckinid)
							$testresultspecimen = array(
									'id'=>$testresult['TestResultSpecimen']['id'],
									'status'=>2,
									'extract_date'=>date('Y-m-d',strtotime($specimens[$value['TestOrder']['specimen_id']]['datetime'])),
									'extract_time'=>date('H:i:s',strtotime($specimens[$value['TestOrder']['specimen_id']]['datetime'])),
									'extracting_user_id'=>$windowcheckinid,
									'checkin_date'=>date('Y-m-d',strtotime('now')),
									'checkin_time'=>date('H:i:s',strtotime('now')),
									'checkin_user_id'=>$windowcheckinid
							);
						else
							$testresultspecimen = array(
									'id'=>$testresult['TestResultSpecimen']['id'],
									'status'=>2,
									'extract_date'=>date('Y-m-d',strtotime($specimens[$value['TestOrder']['specimen_id']]['datetime'])),
									'extract_time'=>date('H:i:s',strtotime($specimens[$value['TestOrder']['specimen_id']]['datetime'])),
									'extracting_user_id'=>$this->Auth->user('id'),
									'checkin_date'=>date('Y-m-d',strtotime('now')),
									'checkin_time'=>date('H:i:s',strtotime('now')),
									'checkin_user_id'=>$this->Auth->user('id')
							);
						
						if ($this->webLISConfiguration['weblis.medtech_specimen_checkin']!=1) {
							$testresultspecimen['accepted_date']=date('Y-m-d',strtotime('now'));
							$testresultspecimen['accepted_time']=date('H:i:s',strtotime('now'));
							
							if ($value['user_id'])
								$testresultspecimen['accepting_user_id']=$windowcheckinid;
							else
								$testresultspecimen['accepting_user_id']=$this->Auth->user('id');
						} else {
							$testresultspecimen['status']=1;
						}
						
						$data['success']=$this->TestOrder->TestResult->TestResultSpecimen->save($testresultspecimen);
						
						if (!$data['success'])
							break;
												

					}
					

					if ($data['success']) {
						$specimenhistory['history'] = "{$value['TestOrder']['specimen_id']} has been checked in";
						$specimenhistory['module_name'] = 'phlebotomy';
						$specimenhistory['specimen_id'] = $value['TestOrder']['specimen_id'];
						$this->addSpecimenHistory($specimenhistory);
						
						if ($this->data['Barcode']['barcode']) {
							$printer_id=Configure::read('worklist.phlebotomy.default_barcode_id');
							if ($this->data['Barcode']['printer_id'])
								$printer_id=$this->data['Barcode']['printer_id'];
							$this->__barcode($value['TestOrder']['specimen_id'],$printer_id);
						}
						
						$data['success']=true;
						$this->TestOrder->commit();
						
						$return=$this->_afterCheckin($value['TestOrder']['specimen_id']);
						
						$data['specimens'][]=$return;
					}else {
						$data['success']=false;
						$data['specimens'][]=array('success'=>false,'specimen_id'=>$value['TestOrder']['specimen_id']);
						$this->TestOrder->rollback();
					}
				}				
			} else
				$data['success']=false;
		}
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	function phlebotomy_saveremarks()
	{
		$this->saveremarks();
	}
	
	function saveremarks()
	{
		$error = false;
		if($this->data)
		{
			$this->loadModel('PatientOrder');
			$this->PatientOrder->begin();
			foreach($this->data['Checkin'] as $key=>$value)
			{
				$value['comments'] = $value['remarks'];
				if(!$this->PatientOrder->save($value))
					$error = true;
			}
						
			if($error)
				$this->PatientOrder->rollback();
			else
				$this->PatientOrder->commit();
		}
		
		$this->autoRender = false;
		$this->layout = false;
	}
	
	
	function phlebotomy_getdatetime() {
		$this->getdatetime();
	}
	
	function getdatetime() {
		$data['datetime']=date('Y-m-d H:i:s');
		$data['date']=date('Y-m-d');
		$data['time']=date('h:i:s');
		$data['success']=true;
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	function phlebotomy_index() {
		
		if (!empty($this->data['Worklist'])) {
			$data=$this->__getorders($this->data['Worklist']['filter']);
		} else
			$data=$this->__getorders();
		
		$this->set('data',$data);
		$queryfilters=Configure::read('worklist.phlebotomy.queryfilters');
		$departments = Configure::read('weblis.department_grouping');
		
		
		$departmentfilter = array();
		foreach($departments as $departmentkey=>$department)
			$departmentfilter[$departmentkey]=$department['label'];
		
		$this->loadModel('Branch');
		$branches=$this->Branch->find('list');

		
		if (isset($this->data['Worklist']['department'])) {
			$this->Session->write('Worklist.filter_department_id',$this->data['Worklist']['department']);
		}
		
		if (isset($this->data['Worklist']['branch'])) {
			$this->Session->write('Worklist.filter_branch_id',$this->data['Worklist']['branch']);
		}
		
		
		$this->set('branches',$branches);
		$this->set('departmentfilter',$departmentfilter);
		$this->set('queryfilters',$queryfilters);
		$this->render('phlebotomy_index');
	}
	
	
	function index() {
		$this->phlebotomy_index();
	}
	
	function getorders() {
		$data=$this->__getorders();
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');		
	}
	
	function searchorders() {
		
		$data=$this->__searchorders();
	
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
	
	
	function phlebotomy_getorders() {
		$this->getorders();
	}
	
	function phlebotomy_searchorders() {
		$this->searchorders();
	}
	
	function __getorders() {
		
		$getorders=Configure::read('worklist.phlebotomy.getorders');
		
		App::import( 'Component', 'worklist.'.$getorders['component'] );
		$componentclass=$getorders['class'].'Component';
		$this->$getorders['component']= new $componentclass($this);
		
		$method=$getorders['method'];
		
		
		$data=$this->$getorders['component']->$method($this->data['Worklist']);
		return $data;
	}
	
	function __searchorders() {
	
		$getorders=Configure::read('worklist.phlebotomy.searchorders');
	
		App::import( 'Component', 'worklist.'.$getorders['component'] );
		$componentclass=$getorders['class'].'Component';
		$this->$getorders['component']= new $componentclass($this);
	
		$method=$getorders['method'];
	
		$data=$this->$getorders['component']->$method($this->data['Worklist']);
		return $data;
	}
	
	function phlebotomy_getworklist() {
		$this->loadModel('WardingDetail');
		$this->loadModel('WardingList');
		
		$wardinglist=$this->WardingList->find('first',array(
			'conditions'=>array('warding_id'=>$this->data['Worklist']['warding_id'])
		));
		
		$data['success']=false;
		
		if ($wardinglist) {
			$data['success']=true;
			$tmpdata=$this->WardingDetail->find('all',array(
				'recursive'=>-1,
				'conditions'=>array('warding_list_id'=>$wardinglist['WardingList']['id'])
			));

			$data['worklist']=array();
			foreach($tmpdata as $key=>$value) {
				$data['worklist'][]=$value['WardingDetail']['specimen_id'];
			}
		}
		
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');		
	}
	
	function getworklist() {
		$this->phlebotomy_getworklist();
	}
	
	function orderstatus()
	{
		$this->phlebotomy_orderstatus();
	}
	
	function phlebotomy_orderstatus()
	{
		
		//$this->layout = 'phlebotomy';
		$this->loadModel('PatientOrder');
		$this->set('physicianlist',$this->PatientOrder->PatientOrderPhysician->Physician->find('list', array(
			'conditions'=>array('Physician.enabled'=>1),
			'fields'=>array('id','name'),
			'order'=>array('name ASC'),
			'recursive'=>-1
		)));
		
		$this->loadModel('Department');
		$this->set('departmentlist', $this->Department->find('list', array(
			'fields'=>array('id','name'),
			'order'=>array('name ASC'),
			'recursive'=>-1
		)));
		
		$this->set('locationlist', $this->PatientOrder->Location->LocationGroupDetail->LocationGroup->find('list', array(
			'conditions'=>array('enabled'=>1),
			'fields'=>array('id','name'),
			'order'=>array('name ASC'),
			'recursive'=>-1
		)));
		
		$locations = array();
		if(isset($this->data['Search']['group_location_id']) && !empty($this->data['Search']['group_location_id']))
		{
			$locations = $this->PatientOrder->Location->LocationGroupDetail->find('list', array(
				'conditions'=>array('location_group_id'=>$this->data['Search']['group_location_id']),
				'fields'=>array('id','location_id'),
				'recursive'=>-1
			));
		}
		
		if($this->data)
		{
			$this->loadModel('Patient');
			$this->loadModel('TestOrder');
							
			if(!empty($this->data['Search']['first_name']))
				$conditions[] = array('Patient.first_name LIKE'=>"%".$this->data['Search']['first_name']."%");
			if(!empty($this->data['Search']['last_name']))
				$conditions[] = array('Patient.last_name LIKE'=>"%".$this->data['Search']['last_name']."%");
			if(!empty($this->data['Search']['specimen_id']))
				$conditions[] = array('PatientOrder.specimen_id LIKE'=>"%".$this->data['Search']['specimen_id']."%");
			if(!empty($this->data['Search']['patient_id']))
				$conditions[] = array('PatientOrder.patient_id LIKE'=>"%".$this->data['Search']['patient_id']."%");
			if(!empty($this->data['Search']['physician_id']))
				$conditions[] = array('PatientOrderPhysician.physician_id'=>$this->data['Search']['physician_id']);
			if(!empty($locations))
				$conditions[] = array('PatientOrder.location_id'=>$locations);
			if(!empty($this->data['Search']['start_date']))
				$conditions[] = array('TestResult.release_date >='=>date('Y-m-d',strtotime($this->data['Search']['start_date'])));
			if(!empty($this->data['Search']['end_date']))
				$conditions[] = array('TestResult.release_date <='=>date('Y-m-d',strtotime($this->data['Search']['end_date'])));
				
				
			if(!empty($this->data['Search']['department_id']))
			{		
				$departmenttest = $this->TestOrder->TestResult->TestGroup->find('list', array(
					'conditions'=>array(
						'TestGroup.department_id'=>$this->data['Search']['department_id']
					),
					'fields'=>array(
						'TestGroup.id',
					)
				));	
			
				
				$conditions[] = array('TestResult.test_group_id'=>$departmenttest);
			}
			
			
			$searchedSpecimen = $this->Patient->find('list',array(
					'fields'=>array('PatientOrder.specimen_id','PatientOrder.specimen_id'),
					'conditions'=>$conditions,
					'joins'=>array(
						array(
							'table'=>'patient_orders',
							'alias'=>'PatientOrder',
							'conditions'=>array(
								"Patient.id = PatientOrder.patient_id"
							)
						),
						array(
							'table'=>'test_orders',
							'alias'=>'TestOrder',
							'conditions'=>array(
								'TestOrder.specimen_id = PatientOrder.specimen_id'
							)									
						),
						array(
							'table'=>'test_results',
							'alias'=>'TestResult',
							'conditions'=>array(
								'TestResult.test_order_id = TestOrder.id'
							)
						),				
						array(
							'table'=>'test_order_details',
							'alias'=>'TestOrderDetail',
							'type'=>'right',
							'conditions'=>array(
								'TestOrderDetail.specimen_id = PatientOrder.specimen_id'
							)
						),
						array(
							'table'=>'patient_order_physicians',
							'alias'=>'PatientOrderPhysician',
							'type'=>'left',
							'conditions'=>array(
								'PatientOrderPhysician.specimen_id = PatientOrder.specimen_id'
							)
						)
					),
					'recursive'=>-1
				)
			);
			
			$this->TestOrder->Behaviors->attach('containable');
			$tmpsearchDetails = $this->TestOrder->find('all', array(
						'fields'=>array(
							'TestOrder.id',
							'TestOrder.specimen_id',
							'TestOrder.test_count',
							'TestOrder.completed_test_count',
							'TestOrder.status',
							'TestOrder.release_date',
							'TestOrder.release_time'
						),
						'conditions'=>array(
								'TestOrder.specimen_id'=>$searchedSpecimen
						),
						'order'=>array('TestOrder.release_date DESC', 'TestOrder.release_time DESC'),
						'contain'=>array(
							'PatientOrder'=>array(
								'fields'=>array(
									'PatientOrder.specimen_id',
									'PatientOrder.date_requested',
									'PatientOrder.time_requested',
								),
								'Location'=>array(
									'LocationGroupDetail'=>array(
										'LocationGroup'
									)
								),
								'order'=>array('PatientOrder.date_requested DESC','PatientOrder.time_requested DESC'),
								'Patient'=>array(
									'fields'=>array(
										'Patient.first_name',
										'Patient.last_name',
										'Patient.middle_name',
										'Patient.id'
									)
								)
							),
							'TestResult'=>array(
								'TestResultSpecimen'=>array(
									'fields'=>array(
										'TestResultSpecimen.extract_date',
										'TestResultSpecimen.extract_time',
										'TestResultSpecimen.extracting_user_id',
										'TestResultSpecimen.checkin_date',
										'TestResultSpecimen.checkin_time',
										'TestResultSpecimen.checkin_user_id',
										'TestResultSpecimen.accepted_date',
										'TestResultSpecimen.accepted_time',
										'TestResultSpecimen.accepting_user_id',
									)	
								),
								'TestOrderDetail'=>array(
									'fields'=>array(
										'TestOrderDetail.id',
										'TestOrderDetail.specimen_id',
										'TestOrderDetail.test_id',
										'TestOrderDetail.panel_test_group_id'
									),
									'TestCode'=>array(
										'fields'=>array(
											'TestCode.name'
										)
									)
								)
							)
						)
					)				
				);
				
				$tmptestgroups = $this->TestOrder->TestResult->TestGroup->find('all',array(
					'fields'=>array(
						'TestGroup.id',
						'TestGroup.name',
						'TestGroup.show_warding_details',
						'TestGroup.show_barcode_details',
						'TestGroup.primary_test_group_id'
					),
					'recursive'=>-1
				));
				
				$testgroups = array();
				
				foreach($tmptestgroups as $tmptestgroupkey=>$tmptestgroupvalue)
					$testgroups[$tmptestgroupvalue['TestGroup']['id']] = $tmptestgroupvalue['TestGroup'];
					
					
				$searchDetails = array();
				foreach($tmpsearchDetails as $patientorderkey=>$patientorder)
				{
					
					
					$tmptestresult = array();
					foreach($patientorder['TestResult'] as $testresultkey=>$testresult)
					{
						
						$tmptestresult[$testresultkey] = $testresult;
						$tmptestresult[$testresultkey]['TestOrderDetail'] = array();
						foreach($testresult['TestOrderDetail'] as $testorderdetailkey=>$testorderdetail)
						{
							if(!empty($testorderdetail['panel_test_group_id']))
							{
								if(!isset($tmptestresult[$testresultkey]['TestOrderDetail'][$testorderdetail['panel_test_group_id']]))
									$tmptestresult[$testresultkey]['TestOrderDetail'][$testorderdetail['panel_test_group_id']]['TestCode']['name'] = $testorderdetail['TestCode']['name'];
								else
									$tmptestresult[$testresultkey]['TestOrderDetail'][$testorderdetail['panel_test_group_id']]['TestCode']['name'] = $testgroups[$testorderdetail['panel_test_group_id']]['name'];
							}else
							{
								if($testgroups[$testresult['test_group_id']]['show_warding_details'])
									$tmptestresult[$testresultkey]['TestOrderDetail'][$testorderdetail['test_id']]['TestCode']['name'] = $testorderdetail['TestCode']['name'];
								elseif(!isset($testresult[$testresultkey]['TestOrderDetail'][$testresult['test_group_id']]))
									$tmptestresult[$testresultkey]['TestOrderDetail'][$testresult['test_group_id']]['TestCode']['name'] = $testgroups[$testresult['test_group_id']]['name'];
							}
						}
					}
					
					$searchDetails[$patientorderkey] = array(
						'TestOrder'=>$patientorder['TestOrder'],
						'PatientOrder'=>$patientorder['PatientOrder'],
						'TestResult'=>$tmptestresult
					);
				}				
			
				$this->set('viewType', $this->webLISConfiguration['dashboard.view_type']);				
				$this->set('testOrders',$searchDetails);
				
				$this->loadModel('User');
				$this->set('user',$this->User->find('list', array(
						'fields'=>array('id','name'),
						'recursive'=>-1
				)));
		}
		
		
		if(isset($this->data['Search']['start_date']) && !empty($this->data['Search']['start_date']))
			$this->data['Search']['start_date'] = date('m/d/Y', strtotime($this->data['Search']['start_date']));
		if(isset($this->data['Search']['end_date']) && !empty($this->data['Search']['end_date']))
			$this->data['Search']['end_date'] = date('m/d/Y', strtotime($this->data['Search']['end_date']));
		
	}
	
	function phlebotomy_checkinwindow() {
	
		$this->layout='checkinwindow';
	}
}
?>