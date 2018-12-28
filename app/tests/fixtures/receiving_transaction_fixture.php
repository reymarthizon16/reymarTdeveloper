<?php
/* ReceivingTransaction Fixture generated on: 2018-05-18 12:57:07 : 1526648227 */
class ReceivingTransactionFixture extends CakeTestFixture {
	var $name = 'ReceivingTransaction';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'reference_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'stock_transfer_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'receiving_report_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'receiving_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'source_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'to_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'received_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'deliver_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'confirmed_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_rt_accounts_idx' => array('column' => 'source_account_id', 'unique' => 0), 'fk_rt_to_accounts_idx' => array('column' => 'to_account_id', 'unique' => 0), 'fk_rt_deliver_users_idx' => array('column' => 'deliver_by_user_id', 'unique' => 0), 'fk_rt_received_users_idx' => array('column' => 'received_by_user_id', 'unique' => 0), 'fk_rt_confirmed_users_idx' => array('column' => 'confirmed_by_user_id', 'unique' => 0), 'fk_rt_user_users_idx' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'reference_no' => 'Lorem ip',
			'stock_transfer_no' => 'Lorem ip',
			'receiving_report_no' => 'Lorem ip',
			'receiving_datetime' => '2018-05-18 12:57:07',
			'source_account_id' => 1,
			'to_account_id' => 1,
			'received_by_user_id' => 1,
			'deliver_by_user_id' => 1,
			'confirmed_by_user_id' => 1,
			'entry_datetime' => '2018-05-18 12:57:07',
			'user_id' => 1
		),
	);
}
