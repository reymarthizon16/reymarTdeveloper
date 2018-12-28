<?php
class MatInflectorHelper extends AppHelper {

	var $uses = array('User','AccountType','Brand','Branch','Brand','Model','Account','DepositSlip');

	function camelize($input, $lower = true)
	{
	    $result    = '';
	    $words     = explode('_', $input);
	    $wordCount = count($words);
	    for ($i = 0; $i < $wordCount; $i++) {
	        $word = $words[$i];
	        if (!($i === 0 && $lower === false)) {
	            $word = ucfirst($word);
	        } else {
	            $word = strtolower($word);
	        }
	        $result .= $word." ";
	    }

	    $result = str_replace('Id', '', $result);
	    
	    return $result;
	}

	function getOptions($model,$column_name){
		
		$data = array();

		$data['success'] = false;

		if($model == 'Account'){

			if($column_name == 'account_type_id'){
				
				$data['success'] = true;

				$new = new AccountType;
				
				$data['options'] = $new->find('list');				
			}
		}

		if($model == 'Model'){

			if($column_name == 'brand_id'){
				
				$data['success'] = true;

				$new = new Brand;
				
				$data['options'] = $new->find('list');

			}

			if($column_name == 'type_id'){
				
				$data['success'] = true;

				$new = new Type;
				
				$data['options'] = $new->find('list');
			}			
			
		}
		
		if($model == 'User'){

			if($column_name == 'branch_id'){
				
				$data['success'] = true;

				$new = new Branch;
				
				$data['options'] = $new->find('list');				
			}

			if($column_name == 'role'){
				
				$data['success'] = true;				
				
				$data['options'] = array(0=>'Admin',1=>'Inventory',2=>'Accounting',3=>'SalesMan');				
			}
		}

		if($model == 'Item'){

			if($column_name == 'model_id'){
				
				$data['success'] = true;

				$new = new Model;
				
				$data['options'] = $new->find('list');

			}

			if($column_name == 'brand_id'){
				
				$data['success'] = true;

				$new = new Brand;
				
				$data['options'] = $new->find('list');

			}

			if($column_name == 'type_id'){
				
				$data['success'] = true;

				$new = new Type;
				
				$data['options'] = $new->find('list');
			}

			if($column_name == 'repair_on_account_id'){
				
				$data['success'] = true;

				$new = new Account;
				
				$data['options'] = $new->find('list',array('fields'=>array('id','company'),'conditions'=>array('account_type_id'=>3)));
			}		
		}

		if($model == 'DepositSlip'){

			if($column_name == 'branch_id'){
				
				$data['success'] = true;

				$new = new Branch;
				
				$data['options'] = $new->find('list');				
			}
			
		}

		return $data;
	}
}
?>