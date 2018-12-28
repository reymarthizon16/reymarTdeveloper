<?php
class AccountTransactionsController extends AppController {

	var $name = 'AccountTransactions';
	var $uses = array('AccountTransaction','AccountTransactionDetail','AccountType','Branch','Account','User','Brand','Model','Type');
	var $paginate = array('limit' => 9999);
	
	function accounting_index(){
		$this->index();
	}

	function index() {
		$this->AccountTransaction->recursive = 0;
		$this->set('accountTransactions', $this->paginate());

		$this->set('branches',$this->Branch->find('list'));
		$this->set('accountCustomers',$this->getAccountCustomerFulldet());
		$this->set('accountCompanies',$this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('enabled'=>1))));//,'account_type_id'=>array(2,3)

		$this->render('index');
	}

	function accounting_edit($person_id,$id=null){
		$this->edit($person_id,$id);
	}

	function edit($person_id,$id=null) {
		
		if($this->data){
			$this->savewithcompute();
			if( $id == null )
				$this->redirect('edit/'.$person_id.'/'.$this->data['AccountTransaction']['id']);
		}	

		//this->data recompute
		$this->savewithcompute($person_id);		

		$this->set('person_id',$person_id);
		$this->set('transactionId',$id);

		$params['types'] = $this->Type->find('list');
		$params['brands'] = $this->Brand->find('list');
		$params['models'] = $this->Model->find('list');
		$this->set('params',$params);
		$this->set('branches',$this->Branch->find('list'));
		$this->set('users',$this->User->find('list'));
		$this->set('accountCustomers',$this->getAccountCustomerFulldet());
		$this->set('accountCompanies',$this->Account->find('list',array('fields'=>array('id','company'),'conditions'=>array('enabled'=>1,'account_type_id'=>array(2,3)))));
		
		$this->render('edit');
	}

	function savewithcompute($person_id = null){
		$this->log($this->data,'savewithcompute');
		if($person_id != null){
			$this->data = $this->Account->Behaviors->attach('containable');
			$this->data = $this->Account->find('first',array(
				'conditions'=>array('Account.id'=>$person_id),
				'contain'=>array(
					'AccountTransaction'=>array(
						'AccountTransactionDetail'=>array(
							'order'=>array('AccountTransactionDetail.due_date asc','AccountTransactionDetail.payment_date asc')
						),
						'AccountTransactionItem'
					)
				)
			));
			$this->data['AccountTransaction'] = $this->data['AccountTransaction'][0];
		}
			

			if(empty($this->data['AccountTransaction']['id']))
				$this->AccountTransaction->create();
				
				if( empty($this->data['AccountTransaction']['due_date']) ){
					$this->data['AccountTransaction']['due_date'] = null;
				}
				if( empty($this->data['AccountTransaction']['down_payment_date']) ){
					$this->data['AccountTransaction']['down_payment_date'] = null;
				}	
				if( empty($this->data['AccountTransaction']['payment_date']) ){
					$this->data['AccountTransaction']['payment_date'] = null;
				}	

				if( $this->data['AccountTransaction']['collection_type_id'] != 2){ // installment computation

					$this->data['AccountTransaction']['pn_balance'] = null;
					$this->data['AccountTransaction']['not_due'] = null;
					$this->data['AccountTransaction']['current'] = null;
					$this->data['AccountTransaction']['overdue'] = null;
					$this->data['AccountTransaction']['total_interest'] = null;
					$this->data['AccountTransaction']['as_of'] = null;
					$this->data['AccountTransaction']['installment_amount'] = null;
					$this->data['AccountTransaction']['due_date'] = null;
					$this->data['AccountTransaction']['terms'] = null;
					$this->data['AccountTransaction']['ppd'] = null;
					$this->data['AccountTransaction']['total_price'] = null;
					$this->data['AccountTransaction']['transaction_account_number'] = null;					

					if( $this->data['AccountTransaction']['collection_type_id'] == 3){
						$this->data['AccountTransaction']['lcp_af'] = null;
						$this->data['AccountTransaction']['gross'] = null;
					}
				}

				if( $this->data['AccountTransaction']['collection_type_id'] == 1 ) //computation
					$this->data['AccountTransaction']['gross'] = $this->data['AccountTransaction']['total_payment'] - $this->data['AccountTransaction']['lcp_af'];
			if($this->data['AccountTransaction']['collection_type_id']!=0)
			if( $this->AccountTransaction->save($this->data['AccountTransaction']) ){

				$this->data['AccountTransaction']['id'] = $this->AccountTransaction->id;

				if( $this->data['AccountTransaction']['collection_type_id'] == 2){ // installment computation
					$this->data['AccountTransaction']['pn_value'] = $this->data['AccountTransaction']['total_price'] - $this->data['AccountTransaction']['down_payment'];
					// if empty details
					$this->data['AccountTransaction']['as_of'] = date('Y-m-t',strtotime($this->data['AccountTransaction']['due_date']));
				}

				if(!empty($this->data['AccountTransaction']['AccountTransactionDetail']) &&  $this->data['AccountTransaction']['collection_type_id'] == 2){
								
					if( $this->data['AccountTransaction']['collection_type_id'] == 2){ // installment computation								
						//reset
						$this->data['AccountTransaction']['total_payment'] = 0;					
						$this->data['AccountTransaction']['not_due'] = 0;					
						$this->data['AccountTransaction']['total_interest'] = 0;					
						$this->data['AccountTransaction']['overdue'] = 0;
						
						$continue_dueDate = date('Y-m-d',strtotime($this->data['AccountTransaction']['due_date']));

						$this->data['AccountTransaction']['payment_amount'] += $this->data['AccountTransaction']['down_payment'] ;		
						
						$Tnot_due = $this->data['AccountTransaction']['down_payment'];

						$params = array();
						$parentToUpdate = array();
					}

					if(!empty($this->data['AccountTransaction']['AccountTransactionDetail'])){
						$first_due = 0;
						foreach ($this->data['AccountTransaction']['AccountTransactionDetail'] as $acdetkey => $acdetvalue) {			

							if( $this->data['AccountTransaction']['collection_type_id'] == 2){ // installment computation
								//important start
								$acdetvalue['account_transaction_id'] = $this->AccountTransaction->id;

								if( $acdetvalue['parent_id']!=null && $acdetvalue['type']==1){
									//parent_duedate
									$this->AccountTransactionDetail->recursive=-1;
									$parentData = $this->AccountTransactionDetail->findbyId($acdetvalue['parent_id']);								
									$acdetvalue['due_date'] = $parentData['AccountTransactionDetail']['due_date'];
									$acdetvalue['amount_due'] = $parentData['AccountTransactionDetail']['amount_due'];
									$parentToUpdate[$acdetvalue['parent_id']] += $acdetvalue['discount'];
									$parentToUpdate[$acdetvalue['parent_id']] += $acdetvalue['payment_amount'];
								}

								if( empty($acdetvalue['payment_date']) )
									$acdetvalue['payment_date'] = null;

								if($acdetvalue['type']==2){
									if($first_due==0){
										$continue_dueDate = date('Y-m-d',strtotime($continue_dueDate));
										$first_due=1;
									}
									else
										$continue_dueDate = date('Y-m-d',strtotime($continue_dueDate.' +1 month'));
									$acdetvalue['due_date'] = date('Y-m-d',strtotime($continue_dueDate));
								}
								//important end

								//computation start
								$params['payment_amount'] += $acdetvalue['payment_amount']+0;
								$params['discount'] += $acdetvalue['discount']+0;
								$params['interest'] += $acdetvalue['interest']+0;
							}
							//computation end
							if(empty($acdetvalue['AccountTransactionDetail']['id']))
								$this->AccountTransaction->AccountTransactionDetail->create();

							$this->AccountTransaction->AccountTransactionDetail->save($acdetvalue);
						}	

					}

					if( $this->data['AccountTransaction']['collection_type_id'] == 2){ // installment computation
						//update to paid
						$pn_value = $this->data['AccountTransaction']['pn_value'];
						foreach ($parentToUpdate as $parentkey => $parentvalue) {
							$this->AccountTransactionDetail->recursive=-1;
							$parentData = $this->AccountTransactionDetail->findbyId($parentkey);
							if( $parentData['AccountTransactionDetail']['amount_due'] <= $parentvalue){
								$parentData['AccountTransactionDetail']['paid'] = 1;
								$pn_value -= $parentvalue;
								$parentData['AccountTransactionDetail']['balance_amount'] = $pn_value;
							}
							else
								$parentData['AccountTransactionDetail']['paid'] = 0;												

							$this->AccountTransaction->AccountTransactionDetail->save($parentData);
						}
						
						$this->data['AccountTransaction']['as_of'] = date('Y-m-t',strtotime($continue_dueDate));
					}

				}
				
					if( $this->data['AccountTransaction']['collection_type_id'] == 2){ // installment computation

						$termsNotPay = $this->monthDifference($this->data['AccountTransaction']['due_date'],date('Y-m-d')); 					
						// echo($termsNotPay);
						$updated_payment = $this->data['AccountTransaction']['installment_amount'] * $termsNotPay ;

						// $this->pre($updated_payment);

						$this->data['AccountTransaction']['total_interest'] = $params['interest'];
						$current =	$updated_payment - ($params['payment_amount'] + $params['discount']);
						if($current>0){
							$this->data['AccountTransaction']['current'] = $current;
							$this->data['AccountTransaction']['overdue'] = $current;
						}else{
							$this->data['AccountTransaction']['current'] = 0;
							$this->data['AccountTransaction']['overdue'] = 0;
						}
						$this->data['AccountTransaction']['not_due'] = $this->data['AccountTransaction']['current'] + $this->data['AccountTransaction']['overdue'];
						$this->data['AccountTransaction']['pn_balance'] = $this->data['AccountTransaction']['pn_value'] - ($params['payment_amount'] + $params['discount']);
						$this->AccountTransaction->save($this->data['AccountTransaction']);
					}


				if(!empty($this->data['AccountTransaction']['AccountTransactionItem']) &&  $this->data['AccountTransaction']['collection_type_id'] != 3){
					
					foreach ($this->data['AccountTransaction']['AccountTransactionItem'] as $acitemkey => $acitemvalue) {
						
						if(empty($acitemvalue['id']))
							$this->AccountTransaction->AccountTransactionItem->create();

						$acitemvalue['account_transaction_id'] = $this->AccountTransaction->id;
						
						$this->AccountTransaction->AccountTransactionItem->save($acitemvalue);
					}
					
				}
			}
			$this->log($this->AccountTransaction->getDataSource()->getLog(false, false),'superlog');			
		
		if($person_id != null){
			$this->data = $this->Account->Behaviors->attach('containable');
			$this->data = $this->Account->find('first',array(
				'conditions'=>array('Account.id'=>$person_id),
				'contain'=>array(
					'AccountTransaction'=>array(
						'AccountTransactionDetail'=>array(
							'order'=>array('AccountTransactionDetail.due_date asc','AccountTransactionDetail.payment_date asc')
						),
						'AccountTransactionItem'
					)
				)
			));			
		}	
	}

	function accounting_newForm($person_id){
		$this->newForm($person_id);
	}

	function newForm($person_id){

		$this->layout = 'blank';

		$this->set('person_id',$person_id);
		$this->set('branches',$this->Branch->find('list'));

		$this->render('newForm');
	}

	function accounting_addCollection(){
		$this->addCollection();
	}

	function addCollection(){
		$this->log($this->data,'addCollection');
		$result = $this->AccountTransaction->find('first',array(
			'conditions'=>array(
				'or'=>array(
					array('transaction_account_number'=>$this->data['dr_or_accountno']),
					array('transaction_dr_no'=>$this->data['dr_or_accountno'])
				)
			),'recursive'=>-1
		));

		if($result){
			$this->redirect('edit/'.$result['AccountTransaction']['person_account_id'].'/'.$result['AccountTransaction']['id']);
		}else{
			$this->Session->setFlash(__('No Record Found for D.R/Acct.No. '.$this->data['dr_or_accountno'], true));
			$this->redirect('index');
		}
	}

	function accounting_reports(){

		$datenow = Date('Y-m-d');
		
		$enddate = date('Y-m-t',strtotime($this->data['year'].'-'.$this->data['month']));

		$finalReport = $this->AccountTransaction->query("
			select  * from (
				select *,
					(installment_amount*(total_paid - paid)) as due_next,
					(installment_amount*(total_paid - paid)) as total_overDue,
					(total_paid - paid) as overDue_no ,
					(paid) as isnew 
				from (
					select 
						concat( a.last_name,', ',a.first_name ) as fullname,
						b.transaction_account_number,
						b.id,
						b.due_date,
						b.pn_balance,
						b.overdue,
						b.installment_amount,	
						c.type,
						PERIOD_DIFF( DATE_FORMAT('".$enddate."','%Y%m') , DATE_FORMAT(b.due_date,'%Y%m') ) as total_paid,
						if(c.type=2 && c.paid=1,count(c.paid),0) as paid

					 from 
						account_transactions b
					join
						accounts a on a.id = b.person_account_id
					left join
						account_transaction_details c on c.account_transaction_id = b.id and c.type = 2 and c.due_date <= '{$enddate}'				
					where b.collection_type_id = 2
					group by b.id
					order by c.due_date asc
				)Report
			) Final			    
			");
	

		$data = array();
		foreach ($finalReport as $finalkey => $finalvalue) {
			if( $finalvalue['Final']['due_next'] <= 0 && $finalvalue['Final']['isnew'] != 0)
				if( date('Y-m',strtotime($finalvalue['Final']['due_date'])) == date('Y-m',strtotime($enddate)) ){
					$data [0] [ $finalvalue['Final']['id'] ]  = $finalvalue['Final'];
				}else
					$data ['updated'] [ $finalvalue['Final']['id'] ]  = $finalvalue['Final'];
			else{
				if($finalvalue['Final']['overDue_no']>=4)
					$data ['matured'] [ $finalvalue['Final']['id'] ]  = $finalvalue['Final'];
				else{
					$data [$finalvalue['Final']['overDue_no']] [ $finalvalue['Final']['id'] ]  = $finalvalue['Final'];
				}
			}
		}

		$this->set('filterBranches',$this->Branch->find('list'));
		$this->set('data',$data);

		$this->set('month',$this->month());
		$this->set('year',$this->year());
		if($this->data['print']){
			$this->layout = 'pdf';
			$this->render('report_print');
		}else if($this->data['aging']){
			$this->layout = 'pdf';
			$this->render('report_print_aging');
		}
		else
			$this->render('report');
	}


	function accounting_report_daily(){

		$datenow = Date('Y-m-d');
		
		$current = date('Y-m-d',strtotime($this->data['date']));
		$branch_id = $this->data['branch_id'];
		$query = "
			select * from (
				select A.*, BB.* from (
					select 
						'InsUpdate' as 'label_Type',a.person_account_id,b.or_number as 'label_OR',b.payment_amount as 'label_AmountR',b.discount as 'label_AmountPPD',b.payment_date as 'labelpaymentdate','' as 'labelremarks'
					from 
						account_transactions a join account_transaction_details b on a.id = b.account_transaction_id
						where a.collection_type_id = 2 and b.type = 1 and b.payment_date = '{$current}' and a.branch_id = '{$branch_id}'
					union

					select 
						'InsDown' as 'label_Type',a.person_account_id,a.down_payment_or as 'label_OR',a.down_payment as 'label_AmountR',0 as 'label_AmountPPD',a.down_payment_date as 'labelpaymentdate',a.remarks as 'labelremarks'
					from 
						account_transactions a  where a.collection_type_id = 2 and a.down_payment_date = '{$current}' and a.branch_id = '{$branch_id}'
					union

					select 
						'Cash' as 'label_Type',a.person_account_id,a.payment_or as 'label_OR',a.total_payment as 'label_AmountR',0 as 'label_AmountPPD',a.payment_date as 'labelpaymentdate',a.remarks as 'labelremarks'
					from 
						account_transactions a  where a.collection_type_id = 1 and a.payment_date= '{$current}' and a.branch_id = '{$branch_id}'					
					union
					select 
						'Others' as 'label_Type',a.person_account_id,a.payment_or as 'label_OR',a.total_payment as 'label_AmountR',0 as 'label_AmountPPD',a.payment_date as 'labelpaymentdate',a.remarks as 'labelremarks'
					from 
						account_transactions a  where a.collection_type_id = 4 and a.payment_date= '{$current}' and a.branch_id = '{$branch_id}'
					union					

					select 
						'Disbursement' as 'label_Type',a.person_account_id,a.payment_or as 'label_OR',a.total_payment as 'label_AmountR',0 as 'label_AmountPPD',a.payment_date as 'labelpaymentdate',a.remarks as 'labelremarks'
					from 
						account_transactions a  where a.collection_type_id = 5 and a.payment_date= '{$current}' and a.branch_id = '{$branch_id}'
				) A join accounts BB on A.person_account_id = BB.id
			) Final			    
			";

		$finalReport = $this->AccountTransaction->query($query);
	
		$data = array();
		foreach ($finalReport as $finalkey => $finalvalue) {
			$data [$finalvalue['Final']['label_Type']] [ ]  = $finalvalue['Final'];
		}
	
		$this->loadModel('DepositSlip');
		$deposit=$this->DepositSlip->find('all',array(
			'conditions'=>array(
				'branch_id'=>$branch_id,
				'deposit_date'=>$current
				)
			));

		$this->set('filterBranches',$this->Branch->find('list'));
		$this->set('data',$data);
		$this->set('deposit',$deposit);

		if($this->data['print']){
			$this->layout = 'pdf';
			$this->render('report_daily_print');
		}
		else
			$this->render('report_daily');
	}



	function accounting_quickDelete(){
		$this->quickDelete();
	}

	function quickDelete(){

		$data['success'] = false;

		if ($this->AccountTransactionDetail->delete($this->data['AccountTransactionDetail']['id'])) {
			if ($this->AccountTransactionDetail->deleteAll(array('AccountTransactionDetail.parent_id'=>$this->data['AccountTransactionDetail']['id'])))
				$data['success'] = true;
		}

		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}

	function accounting_quickAddInstallment(){
		$this->quickAddInstallment();
	}

	function quickAddInstallment(){
		
		$data['success'] = false;

		for ($i=0; $i < $this->data['loop']; $i++) { 
		$this->log($this->data,'loop');
			$this->AccountTransaction->recursive = -1;
			$firstTransaction=$this->AccountTransaction->find('first',array(
				'conditions'=>array(
					'id'=>$this->data['AccountTransactionDetail']['id'],	
				),			
			));

			$exsistingCount=$this->AccountTransactionDetail->find('count',array(
				'conditions'=>array(
					'account_transaction_id'=>$this->data['AccountTransactionDetail']['id'],	
					'type'=>2,
				),		
			));
			$this->log($exsistingCount,'exsistingCount');
		
			if(!empty($firstTransaction['AccountTransaction']['due_date'])){
				$first_due = date('Y-m-d',strtotime($firstTransaction['AccountTransaction']['due_date'].'+'.($exsistingCount+1).' month'));
		
				if($this->data['AccountTransactionDetail']['id']){
					$data['data']['AccountTransactionDetail'] = array(
						'account_transaction_id'=>$this->data['AccountTransactionDetail']['id'],
						'type'=>2,
						'due_date'=>$first_due,
						'amount_due'=>$firstTransaction['AccountTransaction']['installment_amount']
						);
					$this->AccountTransactionDetail->create();
					if ($this->AccountTransactionDetail->save($data['data'])) {
						$data['success'] = success;
					}
				}
			}
		}
		$this->layout='ajax';
		$this->set('data',$data);
		$this->render('/common/json');
	}
}
