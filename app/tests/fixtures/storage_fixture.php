<?php
/* Storage Fixture generated on: 2018-05-18 12:59:08 : 1526648348 */
class StorageFixture extends CakeTestFixture {
	var $name = 'Storage';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'staus' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'serial_no' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'branch_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_storages_branches_idx' => array('column' => 'branch_id', 'unique' => 0), 'fk_storages_items' => array('column' => 'serial_no', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'staus' => 1,
			'serial_no' => 'Lorem ip',
			'branch_id' => 1,
			'enabled' => 1,
			'entry_datetime' => '2018-05-18 12:59:08',
			'user_id' => 1
		),
	);
}
