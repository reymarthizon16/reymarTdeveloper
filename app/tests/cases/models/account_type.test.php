<?php
/* AccountType Test cases generated on: 2018-05-18 12:54:36 : 1526648076*/
App::import('Model', 'AccountType');

class AccountTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.account_type', 'app.user', 'app.branch', 'app.account', 'app.item', 'app.model', 'app.receiving_transaction_detail', 'app.receiving_transaction', 'app.stock_transfer_transaction_detail', 'app.stock_transfer_transaction', 'app.storage', 'app.type');

	function startTest() {
		$this->AccountType =& ClassRegistry::init('AccountType');
	}

	function endTest() {
		unset($this->AccountType);
		ClassRegistry::flush();
	}

}
