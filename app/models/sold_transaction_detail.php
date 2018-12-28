<?php
class SoldTransactionDetail extends AppModel {
	var $name = 'SoldTransactionDetail';
	var $validate = array(
		'serial_no' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from_branch_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'SoldTransaction' => array(
			'className' => 'SoldTransaction',
			'foreignKey' => 'sold_transaction_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),		
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'serial_no',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),		
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FromBranch' => array(
			'className' => 'Branch',
			'foreignKey' => 'from_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
