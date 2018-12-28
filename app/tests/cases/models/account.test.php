<?php
/* Account Test cases generated on: 2018-05-18 12:55:47 : 1526648147*/
App::import('Model', 'Account');

class AccountTestCase extends CakeTestCase {
	var $fixtures = array('app.account', 'app.account_type', 'app.user', 'app.branch', 'app.storage', 'app.item', 'app.model', 'app.receiving_transaction_detail', 'app.receiving_transaction', 'app.stock_transfer_transaction_detail', 'app.stock_transfer_transaction', 'app.type');

	function startTest() {
		$this->Account =& ClassRegistry::init('Account');
	}

	function endTest() {
		unset($this->Account);
		ClassRegistry::flush();
	}

}
