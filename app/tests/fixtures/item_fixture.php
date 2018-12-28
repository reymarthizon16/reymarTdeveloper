<?php
/* Item Fixture generated on: 2018-05-18 12:56:54 : 1526648214 */
class ItemFixture extends CakeTestFixture {
	var $name = 'Item';

	var $fields = array(
		'serial_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'model_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'staus' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'reference_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'receiving_report_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'receiving_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'source_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'srp_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'net_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'sold_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'down_payment_price' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,2'),
		'delivery_receipt_no' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'delivery_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'owner_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'sold_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'serial_no', 'unique' => 1), 'fk_items_models_idx' => array('column' => 'model_id', 'unique' => 0), 'fk_items_types_idx' => array('column' => 'type_id', 'unique' => 0), 'fk_items_source_accounts_idx' => array('column' => 'source_account_id', 'unique' => 0), 'fk_items_owner_accounts_idx' => array('column' => 'owner_account_id', 'unique' => 0), 'fk_items_sold_users_idx' => array('column' => 'sold_by_user_id', 'unique' => 0), 'fk_items_users_idx' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'serial_no' => 'Lorem ip',
			'model_id' => 1,
			'type_id' => 1,
			'staus' => 1,
			'quantity' => 1,
			'reference_no' => 'Lorem ip',
			'receiving_report_no' => 'Lorem ip',
			'receiving_datetime' => '2018-05-18 12:56:54',
			'source_account_id' => 1,
			'srp_price' => 1,
			'net_price' => 1,
			'sold_price' => 1,
			'down_payment_price' => 1,
			'delivery_receipt_no' => 'Lorem ip',
			'delivery_datetime' => '2018-05-18 12:56:54',
			'owner_account_id' => 1,
			'sold_by_user_id' => 1,
			'enabled' => 1,
			'entry_datetime' => '2018-05-18 12:56:54',
			'user_id' => 1
		),
	);
}
