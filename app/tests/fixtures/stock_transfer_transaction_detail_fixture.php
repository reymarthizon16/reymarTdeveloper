<?php
/* StockTransferTransactionDetail Fixture generated on: 2018-05-18 12:58:44 : 1526648324 */
class StockTransferTransactionDetailFixture extends CakeTestFixture {
	var $name = 'StockTransferTransactionDetail';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'stock_transfer_transaction_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'serial_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'model_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'staus' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'srp_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'net_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'sold_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_sttd_models_idx' => array('column' => 'model_id', 'unique' => 0), 'fk_sttd_types_idx' => array('column' => 'type_id', 'unique' => 0), 'fk_sttd_stt_idx' => array('column' => 'stock_transfer_transaction_id', 'unique' => 0), 'fk_sttd_users_idx' => array('column' => 'user_id', 'unique' => 0), 'fk_sttd_items' => array('column' => 'serial_no', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'stock_transfer_transaction_id' => 1,
			'serial_no' => 'Lorem ip',
			'model_id' => 1,
			'type_id' => 1,
			'staus' => 1,
			'quantity' => 1,
			'srp_price' => 1,
			'net_price' => 1,
			'sold_price' => 1,
			'enabled' => 1,
			'entry_datetime' => '2018-05-18 12:58:44',
			'user_id' => 1
		),
	);
}
