<?php
/* Positions Test cases generated on: 2016-08-24 03:21:24 : 1472008884*/
App::import('Controller', 'Positions');

class TestPositionsController extends PositionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PositionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.position', 'app.employee', 'app.company');

	function startTest() {
		$this->Positions =& new TestPositionsController();
		$this->Positions->constructClasses();
	}

	function endTest() {
		unset($this->Positions);
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
