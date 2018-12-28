<?php
/* Type Fixture generated on: 2018-05-18 12:53:24 : 1526648004 */
class TypeFixture extends CakeTestFixture {
	var $name = 'Type';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'entry_datetime' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'enabled' => 1,
			'entry_datetime' => '2018-05-18 12:53:24',
			'user_id' => 1
		),
	);
}
