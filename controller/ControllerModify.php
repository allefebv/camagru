<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerModify {

	private $_view;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		$this->generateModifyView();
	}

	private function generateModifyView() {
		$this->_view = new View('Modify');
		$this->_view->generate(array());
	}
}

?>
