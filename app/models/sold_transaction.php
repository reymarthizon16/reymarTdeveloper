<?php
class SoldTransaction extends AppModel {
	var $name = 'SoldTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'OwnedAccount' => array(
			'className' => 'Account',
			'foreignKey' => 'owner_account_id',
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
		'SoldByUser' => array(
			'className' => 'User',
			'foreignKey' => 'sold_by_user_id',
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
		'SoldTransactionDetail' => array(
			'className' => 'SoldTransactionDetail',
			'foreignKey' => 'sold_transaction_id',
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
