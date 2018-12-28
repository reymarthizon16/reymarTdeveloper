<?php
class ReceivingTransaction extends AppModel {
	var $name = 'ReceivingTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'SourceAccount' => array(
			'className' => 'Account',
			'foreignKey' => 'source_account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReceivedByUser' => array(
			'className' => 'User',
			'foreignKey' => 'received_by_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DeliverByUser' => array(
			'className' => 'User',
			'foreignKey' => 'deliver_by_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ConfirmedByUser' => array(
			'className' => 'User',
			'foreignKey' => 'confirmed_by_user_id',
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
		'ReceivingTransactionDetail' => array(
			'className' => 'ReceivingTransactionDetail',
			'foreignKey' => 'receiving_transaction_id',
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
