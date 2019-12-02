<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/View.php');

class ControllerEditor {

	private $_view;

	public function __construct($url) {
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else if (!isset($_SESSION['logged']))
			throw new Exception('Section Autorisée aux utilisateurs connectés');
		else
			$this->editor();
	}

	private function editor() {
		$this->_view = new View('Editor');
		$this->_view->generate(array('images' => $images));
	}

	//Page d'accueil = header (connexion etc) + gallerie + footer

}

?>
