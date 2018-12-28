<?php
/* Companies Test cases generated on: 2016-08-24 03:21:06 : 1472008866*/
App::import('Controller', 'Companies');

class TestCompaniesController extends CompaniesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CompaniesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.company', 'app.employee');

	function startTest() {
		$this->Companies =& new TestCompaniesController();
		$this->Companies->constructClasses();
	}

	function endTest() {
		unset($this->Companies);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
