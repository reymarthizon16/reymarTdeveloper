<?php
/* Branch Test cases generated on: 2018-05-18 12:55:29 : 1526648129*/
App::import('Model', 'Branch');

class BranchTestCase extends CakeTestCase {
	var $fixtures = array('app.branch', 'app.user', 'app.account_type', 'app.account', 'app.item', 'app.model', 'app.receiving_transaction_detail', 'app.receiving_transaction', 'app.stock_transfer_transaction_detail', 'app.stock_transfer_transaction', 'app.storage', 'app.type');

	function startTest() {
		$this->Branch =& ClassRegistry::init('Branch');
	}

	function endTest() {
		unset($this->Branch);
		ClassRegistry::flush();
	}

}
