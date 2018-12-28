<?php
class BmcComponent extends Object
{
	var $controller;
	function __construct(&$con) {
		$this->controller=$con;
	}
	
	function getorders($queryfilter=null) {
		//for the meantime
		$date = date('Y-m-d',strtotime('now -7 days'));
		

		$status=0;
		if (isset($this->controller->webLISConfiguration['weblis.specimen_checkin']) && $this->controller->webLISConfiguration['weblis.specimen_checkin'] == "1")
			$status=8; //wait for specimen checkin
		
		$filtercondition="
			TestOrder.status = {$status} and PatientOrder.date_requested >= '{$date}' and
			(LocationGroup.id in (2,21) or PatientOrder.location_id is null or TestResult.order_type=1 or TestGroup.department_id = 26) 
			
		";
		
		if ($queryfilter) {
			switch($queryfilter['filter']) {
				case 1:
					$filtercondition="
						TestOrder.status = {$status} and PatientOrder.date_requested >= '{$date}' and 
						LocationGroup.id = 21";
					break;
				case 2:
					$filtercondition="
						TestOrder.status = {$status} and PatientOrder.date_requested >= '{$date}' and 
						(LocationGroup.id = 2 or PatientOrder.location_id is null)
						";
					break;
				case 3:
					$filtercondition="
						TestOrder.status = {$status} and PatientOrder.date_requested >= '{$date}' and 
						TestResult.order_type=2
						";
					break;
				/*case 4:
					$filtercondition="
						TestOrder.status = {$status} and PatientOrder.date_requested >= '{$date}' and
						TestGroup.department_id = 30
					";
					break;
				*/
					
			}
				
			
		}
		
		
		$query="
		select distinct PatientOrder.specimen_id, Patient.last_name, Patient.first_name, PatientOrder.comments,
				Patient.middle_name, Patient.birthdate, Location.id, Location.name, 
				PatientOrder.date_requested, PatientOrder.time_requested, PatientOrder.patient_type
		from
			patient_orders PatientOrder join
			test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id left join
			locations Location on Location.id = PatientOrder.location_id left join
			location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
			location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
			test_results TestResult on TestResult.test_order_id = TestOrder.id join
			patients Patient on Patient.id = PatientOrder.patient_id join
			test_groups TestGroup on TestResult.test_group_id = TestGroup.id 
		where
			{$filtercondition}
		order by
			TestResult.order_type desc, PatientOrder.date_requested, PatientOrder.time_requested
		";
		

		$this->controller->loadModel('PatientOrder');
		
		$data=$this->controller->PatientOrder->query($query);
		
		foreach($data as $key=>&$value) {
			$value['PatientOrder']['patient_type']=3;
			
			if ($value['Location']['id']==2 || !$value ['Location'] ['id'] ) // OPD
				$value['PatientOrder']['patient_type']=2;
			elseif ($value['Location']['id']==179) //ER
				$value['PatientOrder']['patient_type']=1;
			
			
			$testresults=$this->controller->PatientOrder->query("
					select 
						TestResult.id, TestResult.order_type, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details 
					from
					 	test_results TestResult join test_orders TestOrder on TestOrder.id = TestResult.test_order_id join
						test_groups TestGroup on TestGroup.id = TestResult.test_group_id
					where
						TestOrder.specimen_id = '{$value['PatientOrder']['specimen_id']}'
			");
		
			
			
			foreach($testresults as $trkey=>&$testresult) {
				if ($testresult['TestGroup']['show_warding_details']) {

					$testorderdetails=$this->controller->PatientOrder->query("
							select TestOrderDetail.id, TestCode.name, TestCode.short_code, TestGroup.id, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details from
								test_order_details TestOrderDetail left join test_codes TestCode on TestCode.id = TestOrderDetail.test_id left join
								test_groups TestGroup on TestGroup.id = TestOrderDetail.panel_test_group_id
							where 
								TestOrderDetail.order_status = 0 and
								TestOrderDetail.test_result_id = {$testresult['TestResult']['id']}  
					");
					
					$testresult['TestOrderDetails']=$testorderdetails;
					
				}
			}
			
			$value['TestResults']=$testresults;
		}
		
		//$this->log($data,'newcheckin');
		return $data;
	}
	
	function phlebolog($queryfilter=null) {
		// for the meantime
		$date = date ( 'Y-m-d' );
		$date24 = date ( 'Y-m-d', strtotime ( 'now -1 day ' ) );
		$time24 = date ( 'H:i:s', strtotime ( 'now -1 day ' ) );
		
		//$status = 0;
		//if (isset ( $this->controller->webLISConfiguration ['weblis.specimen_checkin'] ) && $this->controller->webLISConfiguration ['weblis.specimen_checkin'] == "1")
		//	$status = 8; // wait for specimen checkin
		
		$filtercondition = "
		(TestResultSpecimen.checkin_date = '{$date}' or (TestResultSpecimen.checkin_date = '{$date24}' and TestResultSpecimen.checkin_time >= '{$time24}'))
		";
		
		if ($queryfilter) {
			switch ($queryfilter ['filter']) {
				case 1 :
					$filtercondition = "
					(TestResultSpecimen.checkin_date = '{$date}' or (TestResultSpecimen.checkin_date = '{$date24}' and TestResultSpecimen.checkin_time >= '{$time24}')) and
					LocationGroup.id = 21";
					break;
				case 2 :
					$filtercondition = "
					(TestResultSpecimen.checkin_date = '{$date}' or (TestResultSpecimen.checkin_date = '{$date24}' and TestResultSpecimen.checkin_time >= '{$time24}')) and
					(LocationGroup.id = 2 or PatientOrder.location_id is null)
					";
					break;
				case 3 :
					$filtercondition = "
					(TestResultSpecimen.checkin_date = '{$date}' or (TestResultSpecimen.checkin_date = '{$date24}' and TestResultSpecimen.checkin_time >= '{$time24}')) and
					TestResult.order_type=2
					";
					break;
			}
		}
		
		$query = "
		select distinct PatientOrder.specimen_id, Patient.last_name, Patient.first_name, PatientOrder.comments,
			Patient.middle_name, Patient.birthdate, Location.id, Location.name,
			PatientOrder.date_requested, PatientOrder.time_requested,PatientOrder.patient_type, 
			TestResultSpecimen.checkin_date, TestResultSpecimen.checkin_time, TestResultSpecimen.checkin_user_id,
			User.last_name, User.first_name, User.initials
		from
			patient_orders PatientOrder join
			test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id left join
			locations Location on Location.id = PatientOrder.location_id left join
			location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
			location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
			patients Patient on Patient.id = PatientOrder.patient_id join
			test_results TestResult on TestResult.test_order_id = TestOrder.id join
			test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id left join
			users User on User.id = TestResultSpecimen.checkin_user_id
		where
			{$filtercondition}
		order by
			TestResult.order_type desc, PatientOrder.date_requested, PatientOrder.time_requested
		";
		
		$this->controller->loadModel ( 'PatientOrder' );
		
		$data = $this->controller->PatientOrder->query ( $query );
		
		
		
		foreach ( $data as $key => &$value ) {
			$value['PatientOrder']['patient_type']=3;
			
			if ($value ['Location'] ['id'] == 2 || !$value ['Location'] ['id'] ) // OPD
				$value ['PatientOrder'] ['patient_type'] = 2;
			elseif ($value ['Location'] ['id'] == 21) // ER
				$value ['PatientOrder'] ['patient_type'] = 1;
			
			$testresults=$this->controller->PatientOrder->query("
					select
					TestResult.id, TestResult.order_type, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details
					from
					test_results TestResult join test_orders TestOrder on TestOrder.id = TestResult.test_order_id join
					test_groups TestGroup on TestGroup.id = TestResult.test_group_id
					where
					TestOrder.specimen_id = '{$value['PatientOrder']['specimen_id']}'
			");			
			
			foreach($testresults as $trkey=>&$testresult) {
				if ($testresult['TestGroup']['show_warding_details']) {

					$testorderdetails=$this->controller->PatientOrder->query("
							select TestOrderDetail.id, TestCode.name, TestCode.short_code, TestGroup.id, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details from
								test_order_details TestOrderDetail left join test_codes TestCode on TestCode.id = TestOrderDetail.test_id left join
								test_groups TestGroup on TestGroup.id = TestOrderDetail.panel_test_group_id
							where 
								TestOrderDetail.order_status = 0 and
								TestOrderDetail.test_result_id = {$testresult['TestResult']['id']}  
					");
					
					$testresult['TestOrderDetails']=$testorderdetails;
					
				}
			}
			
			$value['TestResults']=$testresults;
		}
		
		//$this->log ( $data, 'newcheckin' );
		return $data;
	}
	
	function locationfilters($queryfilter=null) {
		$this->controller->loadModel('LocationGroup');
		$data=$this->controller->LocationGroup->find('list',array('conditions'=>array('enabled'=>1,'id not'=>array(2,21))));
		return $data;
	}
	
	
	
	function warding($queryfilter=null) {
		$this->controller->loadModel('PatientOrder');
		
		
		$querycondition="";
		$locationgroupids="";
		
		if (isset($this->controller->data['Worklist']['filter'])) {
			foreach($this->controller->data['Worklist']['filter'] as $key=>$value) {
				$locationgroupids.=$value.",";
			}
				
			$locationgroupids=substr($locationgroupids,0,-1);
			
			$querycondition.=" and LocationGroup.id in ({$locationgroupids})";
		}  else {
			$locations=$this->locationfilters();
			foreach($locations as $key=>$value) {
				$locationgroupids.=$key.",";
			}
			
			$locationgroupids=substr($locationgroupids,0,-1);
				
			$querycondition.=" and LocationGroup.id in ({$locationgroupids})";
		}
		
		
		$uncollected=array();
		$unward=array();
		
		if ($this->controller->data['Worklist']['time']==-1 || !isset($this->controller->data['Worklist']['time']))  { //all
			$uncollected=$this->controller->PatientOrder->query("
			select
				distinct PatientOrder.specimen_id,
				PatientOrder.date_requested,
				PatientOrder.time_requested,
				PatientOrder.comments,
				Patient.id,
				Patient.last_name,
				Patient.first_name,
				Patient.middle_name,
				Patient.birthdate,
				Location.id,
				Location.name,
				LocationGroup.id,
				LocationGroup.name,
				TestOrder.id,
				TestOrder.status
			from
				patient_orders PatientOrder join
				test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id join
				test_results TestResult on TestResult.test_order_id = TestOrder.id join
				test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id join
				patients Patient on Patient.id = PatientOrder.patient_id left join
				locations Location on Location.id = PatientOrder.location_id left join
				location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
				location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
				warding_details WardingDetail on WardingDetail.specimen_id = PatientOrder.specimen_id left join
				warding_lists WardingList on WardingList.id = WardingDetail.warding_list_id and WardingDetail.id = (select max(a.id) from warding_details a where a.specimen_id = PatientOrder.specimen_id) left join
				users WardingUser on WardingUser.id = WardingList.user_id
			where
				TestOrder.status = 8 and
				TestResultSpecimen.checkin_date is null and WardingList.id is not null {$querycondition}
				order by WardingList.warding_id, LocationGroup.name, Patient.last_name, Patient.first_name, PatientOrder.date_requested, PatientOrder.time_requested
			");
			
			$unward=$this->controller->PatientOrder->query("
					select
						distinct PatientOrder.specimen_id,
						PatientOrder.date_requested,
						PatientOrder.time_requested,
						PatientOrder.comments,
						Patient.id,
						Patient.last_name,
						Patient.first_name,
						Patient.middle_name,
						Patient.birthdate,
						Location.id,
						Location.name,
						LocationGroup.id,
						LocationGroup.name,
						TestOrder.id,
						TestOrder.status
					from 
						patient_orders PatientOrder join 
						test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id join 
						test_results TestResult on TestResult.test_order_id = TestOrder.id join 
						test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id join 
						patients Patient on Patient.id = PatientOrder.patient_id left join 
						locations Location on Location.id = PatientOrder.location_id left join 
						location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join 
						location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join 
						warding_details WardingDetail on WardingDetail.specimen_id = PatientOrder.specimen_id left join 
						warding_lists WardingList on WardingList.id = WardingDetail.warding_list_id left join 
						users WardingUser on WardingUser.id = WardingList.user_id  join
						test_groups TestGroup on TestResult.test_group_id = TestGroup.id 
					where 
						TestOrder.status = 8 and
						TestResultSpecimen.checkin_date is null and WardingList.id is null {$querycondition} 
						order by LocationGroup.name, Patient.last_name, Patient.first_name, PatientOrder.date_requested, PatientOrder.time_requested and
						TestGroup.department_id <> 26
					");			
		} 
		
		
		if ($this->controller->data['Worklist']['time']==0) { //uncollected only
			$uncollected=$this->controller->PatientOrder->query("
					select
						distinct PatientOrder.specimen_id,
						PatientOrder.date_requested,
						PatientOrder.time_requested,
						PatientOrder.comments,
						Patient.id,
						Patient.last_name,
						Patient.first_name,
						Patient.middle_name,
						Patient.birthdate,
						Location.id,
						Location.name,
						LocationGroup.id,
						LocationGroup.name,
						TestOrder.id,
						TestOrder.status
					from
						patient_orders PatientOrder join
						test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id join
						test_results TestResult on TestResult.test_order_id = TestOrder.id join
						test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id join
						patients Patient on Patient.id = PatientOrder.patient_id left join
						locations Location on Location.id = PatientOrder.location_id left join
						location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
						location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
						warding_details WardingDetail on WardingDetail.specimen_id = PatientOrder.specimen_id left join
						warding_lists WardingList on WardingList.id = WardingDetail.warding_list_id and WardingDetail.id = (select max(a.id) from warding_details a where a.specimen_id = PatientOrder.specimen_id) left join
						users WardingUser on WardingUser.id = WardingList.user_id
					where
						TestOrder.status = 8 and
						TestResultSpecimen.checkin_date is null and WardingList.id is not null {$querycondition}
						order by WardingList.warding_id, LocationGroup.name, Patient.last_name, Patient.first_name, PatientOrder.date_requested, PatientOrder.time_requested
					");
		}
		
		if ($this->controller->data['Worklist']['time'] > 0) { 
			$this->controller->loadModel('WardingSchedule');
			$wardingschedule=$this->controller->WardingSchedule->find('first',array('conditions'=>array('id'=>$this->controller->data['Worklist']['time'])));
			
			if ($wardingschedule['WardingSchedule']['start_time'] > $wardingschedule['WardingSchedule']['end_time']) {
				$datenow = date('Y-m-d');
				$datetommorow = date('Y-m-d',strtotime('+1 day'));
				$querycondition.=" and ((PatientOrder.date_requested = '{$datenow}' and PatientOrder.time_requested >= '{$wardingschedule['WardingSchedule']['start_time']}') or (PatientOrder.date_requested = '{$datetommorow}' and PatientOrder.time_requested <= '{$wardingschedule['WardingSchedule']['end_time']}')) ";
			} else {
				$datenow = date('Y-m-d');
				$querycondition.=" and PatientOrder.date_requested = '{$datenow}' and PatientOrder.time_requested >= '{$wardingschedule['WardingSchedule']['start_time']}' and PatientOrder.time_requested <= '{$wardingschedule['WardingSchedule']['end_time']}' ";
			}
			
			$unward=$this->controller->PatientOrder->query("
					select
						distinct PatientOrder.specimen_id,
						PatientOrder.date_requested,
						PatientOrder.time_requested,
						PatientOrder.comments,
						Patient.id,
						Patient.last_name,
						Patient.first_name,
						Patient.middle_name,
						Patient.birthdate,
						Location.id,
						Location.name,
						LocationGroup.id,
						LocationGroup.name,
						TestOrder.id,
						TestOrder.status
					from
						patient_orders PatientOrder join
						test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id join
						test_results TestResult on TestResult.test_order_id = TestOrder.id join
						test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id join
						patients Patient on Patient.id = PatientOrder.patient_id left join
						locations Location on Location.id = PatientOrder.location_id left join
						location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
						location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
						warding_details WardingDetail on WardingDetail.specimen_id = PatientOrder.specimen_id left join
						warding_lists WardingList on WardingList.id = WardingDetail.warding_list_id left join
						users WardingUser on WardingUser.id = WardingList.user_id join
						test_groups TestGroup on TestResult.test_group_id = TestGroup.id 
					where
						TestOrder.status = 8 and
						TestResultSpecimen.checkin_date is null and WardingList.id is null {$querycondition}
						order by LocationGroup.name, Patient.last_name, Patient.first_name, PatientOrder.date_requested, PatientOrder.time_requested and
						TestGroup.department_id <> 26
					");
		} 
		
		
		$data=$uncollected;
		
		foreach($unward as $key=>$value) {
			$data[]=$value;
		}
		
		foreach ( $data as $key => &$value ) {
			if ($value ['Location'] ['id'] == 2 || !$value ['Location'] ['id'] ) // OPD
				$value ['PatientOrder'] ['patient_type'] = 2;
			elseif ($value ['Location'] ['id'] == 21) // ER
				$value ['PatientOrder'] ['patient_type'] = 1;
				
			
			$testresults=$this->controller->PatientOrder->query("
				select TestResult.id, TestResult.order_type, TestGroup.id, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details from test_results TestResult join test_groups TestGroup on TestGroup.id = TestResult.test_group_id where test_order_id = {$value['TestOrder']['id']}
			");
			
			
			
			
			
			foreach($testresults as $trkey=>&$trvalue) {
				if ($trvalue ['TestGroup'] ['show_warding_details']) {
					$testorderdetails = $this->controller->PatientOrder->query ( "
							select TestOrderDetail.id, TestOrderDetail.panel_test_group_id, TestCode.name, TestCode.short_code, PanelTestGroup.id, PanelTestGroup.name, PanelTestGroup.short_code,PanelTestGroup.show_warding_details from
							test_order_details TestOrderDetail join test_codes TestCode on TestCode.id = TestOrderDetail.test_id left join
							test_groups PanelTestGroup on PanelTestGroup.id = TestOrderDetail.panel_test_group_id
							where
							TestOrderDetail.order_status = 0 and
							TestOrderDetail.test_result_id = {$trvalue['TestResult']['id']}		
							"
					);
					
					$trvalue ['TestOrderDetails'] = $testorderdetails;
					
				}				
			}
			
			$value['TestResults']=$testresults;
			

			
			$wardinglist=$this->controller->PatientOrder->query("
				select WardingList.id, WardingList.warding_id, WardingList.entry_datetime, WardingUser.id, WardingUser.last_name, WardingUser.first_name, WardingUser.initials
				from warding_lists WardingList join users WardingUser on WardingList.user_id = WardingUser.id join 
					warding_details WardingDetail on WardingDetail.warding_list_id = WardingList.id
				where WardingDetail.specimen_id = '{$value['PatientOrder']['specimen_id']}'
				order by WardingList.entry_datetime desc
				limit 1
			");
			
			if (isset($wardinglist[0])) {
				$value['WardingList']=$wardinglist[0]['WardingList'];
				$value['WardingUser']=$wardinglist[0]['WardingUser'];
			}

		}
		
		$data=array('WardingDetail'=>$data);
		
		
		return $data;
	}
	
	function wardinglist($queryfilter) {
		if (isset($queryfilter['warding_id'])) {
			
			$this->controller->loadModel('PatientOrder');
			
			$data=$this->controller->PatientOrder->query("
					select distinct
						PatientOrder.specimen_id,
						PatientOrder.date_requested,
						PatientOrder.time_requested,
						PatientOrder.comments,
						Patient.id,
						Patient.last_name,
						Patient.first_name,
						Patient.middle_name,
						Patient.birthdate,
						Location.id,
						Location.name,
						LocationGroup.id,
						LocationGroup.name,
						TestOrder.id,
						TestOrder.status
					from patient_orders PatientOrder join
						test_orders TestOrder on PatientOrder.specimen_id = TestOrder.specimen_id join
						test_results TestResult on TestResult.test_order_id = TestOrder.id join
						test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id join
						patients Patient on Patient.id = PatientOrder.patient_id left join
						locations Location on Location.id = PatientOrder.location_id left join
						location_group_details LocationGroupDetail on LocationGroupDetail.location_id = Location.id left join
						location_groups LocationGroup on LocationGroup.id = LocationGroupDetail.location_group_id left join
						warding_details WardingDetail on WardingDetail.specimen_id = PatientOrder.specimen_id left join
						warding_lists WardingList on WardingList.id = WardingDetail.warding_list_id
						and WardingDetail.id = (select max(a.id) from warding_details a where a.specimen_id = PatientOrder.specimen_id) left join
						users WardingUser on WardingUser.id = WardingList.user_id
					where
						TestOrder.order_status = 0 and 
						WardingList.warding_id = '{$queryfilter['warding_id']}'
					order by
						LocationGroup.name, Patient.last_name
			
					");
			
			
				foreach ( $data as $key => &$value ) {
					if ($value ['Location'] ['id'] == 2 || ! $value ['Location'] ['id']) // OPD
						$value ['PatientOrder'] ['patient_type'] = 2;
					elseif ($value ['Location'] ['id'] == 21) // ER
						$value ['PatientOrder'] ['patient_type'] = 1;
				
					$testresults = $this->controller->PatientOrder->query ( "
									select TestResult.id, TestResult.order_type, TestGroup.id, TestGroup.name, TestGroup.short_code, TestGroup.show_warding_details from test_results TestResult join test_groups TestGroup on TestGroup.id = TestResult.test_group_id where test_order_id = {$value['TestOrder']['id']}
									" );
				
					foreach ( $testresults as $trkey => &$trvalue ) {
						if ($trvalue ['TestGroup'] ['show_warding_details']) {
							$testorderdetails = $this->controller->PatientOrder->query ( "
														select TestOrderDetail.id, TestOrderDetail.panel_test_group_id, TestCode.name, TestCode.short_code, PanelTestGroup.id, PanelTestGroup.name, PanelTestGroup.short_code,PanelTestGroup.show_warding_details from
														test_order_details TestOrderDetail join test_codes TestCode on TestCode.id = TestOrderDetail.test_id left join
														test_groups PanelTestGroup on PanelTestGroup.id = TestOrderDetail.panel_test_group_id
														where
														TestOrderDetail.order_status = 0 and
														TestOrderDetail.test_result_id = {$trvalue['TestResult']['id']}
								" );
							
							$trvalue ['TestOrderDetails'] = $testorderdetails;
						}
					}
				
					$value ['TestResults'] = $testresults;
					
					$testresultspecimens=$this->controller->PatientOrder->query("
							select
								TestResultSpecimen.*
							from
								test_results TestResult join test_result_specimens TestResultSpecimen on TestResultSpecimen.test_result_id = TestResult.id
							where
								TestResult.test_order_id = {$value['TestOrder']['id']}
					");
		
					$value['TestResultSpecimens']=$testresultspecimens;
				
					$wardinglist = $this->controller->PatientOrder->query ( "
										select WardingList.id, WardingList.warding_id, WardingList.entry_datetime, WardingUser.id, WardingUser.last_name, WardingUser.first_name, WardingUser.initials
										from warding_lists WardingList join users WardingUser on WardingList.user_id = WardingUser.id join
										warding_details WardingDetail on WardingDetail.warding_list_id = WardingList.id
										where WardingDetail.specimen_id = '{$value['PatientOrder']['specimen_id']}'
										order by WardingList.entry_datetime desc
										limit 1
										" );
				
					if (isset ( $wardinglist [0] )) {
						$value ['WardingList'] = $wardinglist [0] ['WardingList'];
						$value ['WardingUser'] = $wardinglist [0] ['WardingUser'];
					}
				}
			
			$this->controller->loadModel('WardingList');
			$this->controller->loadModel('User');
			
			$wardinglist=$this->controller->WardingList->find('first',array('conditions'=>array('warding_id'=>$queryfilter['warding_id'])));
			$wardinguser=$this->controller->User->find('first',array('conditions'=>array('id'=>$wardinglist['WardingList']['user_id'])));
			$wardinglist['WardingUser']=$wardinguser['User'];
			
			$data=$wardinglist+array('WardingDetail'=>$data);
			
			return $data;
		}
	}
}
?>