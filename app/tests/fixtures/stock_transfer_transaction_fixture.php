<?php
/* StockTransferTransaction Fixture generated on: 2018-05-18 12:58:34 : 1526648314 */
class StockTransferTransactionFixture extends CakeTestFixture {
	var $name = 'StockTransferTransaction';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'stock_transfer_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'stock_transfer_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'from_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'to_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'prepared_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'approved_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_stt_from_accounts_idx' => array('column' => 'from_account_id', 'unique' => 0), 'fk_stt_to_accounts_idx' => array('column' => 'to_account_id', 'unique' => 0), 'fk_stt_prepared_users_idx' => array('column' => 'prepared_by_user_id', 'unique' => 0), 'fk_stt_approved_users_idx' => array('column' => 'approved_by_user_id', 'unique' => 0), 'fk_stt_user_users_idx' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'stock_transfer_no' => 'Lorem ip',
			'stock_transfer_datetime' => '2018-05-18 12:58:34',
			'from_account_id' => 1,
			'to_account_id' => 1,
			'prepared_by_user_id' => 1,
			'approved_by_user_id' => 1,
			'entry_datetime' => '2018-05-18 12:58:34',
			'user_id' => 1
		),
	);
}
