<?php
class StockTransferTransaction extends AppModel {
	var $name = 'StockTransferTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
	);
	var $belongsTo = array(
		'FromAccount' => array(
			'className' => 'Branch',
			'foreignKey' => 'from_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToAccount' => array(
			'className' => 'Branch',
			'foreignKey' => 'to_branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToServiceCenter' => array(
			'className' => 'Account',
			'foreignKey' => 'service_account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToCustomer' => array(
			'className' => 'Account',
			'foreignKey' => 'customer_account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PreparedByUser' => array(
			'className' => 'User',
			'foreignKey' => 'prepared_by_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ApprovedByUser' => array(
			'className' => 'User',
			'foreignKey' => 'approved_by_user_id',
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
		)
	);

	var $hasMany = array(
		'StockTransferTransactionDetail' => array(
			'className' => 'StockTransferTransactionDetail',
			'foreignKey' => 'stock_transfer_transaction_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
