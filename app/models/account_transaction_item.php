<?php
class AccountTransactionItem extends AppModel {
	var $name = 'AccountTransactionItem';
	var $validate = array(
		/*
		'account_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'account_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		*/
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	// var $virtualFields = array('customer_fullname' => 'CONCAT(Account.last_name,", ", Account.first_name," ",IFNULL(Account.middle_name," "))');

	var $belongsTo = array(
		'AccountTransaction' => array(
			'className' => 'AccountTransaction',
			'foreignKey' => 'account_transaction_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	
	);
}
