<?php

namespace Camagru\View;

class View {

	private $_file;
	private $_title;

	public function __construct($action) {
		$this->_file = 'View/View' . $action . '.php';
	}

	public function generate($data) {

		//Corps de la vue, partie specifique
		$content = $this->generateFile($this->_file, $data);
		$header = $this->generateHeader();
		//Template qui reutilise le corps ($content + $title)
		$view = $this->generateFile('View/template.php',
			array('title' => $this->_title,
				'content' => $content,
				'header' => $header));
		echo $view;
	}

	private function generateFile($file, $data) {
		if (file_exists($file))
		{
			extract($data);
			ob_start();
			require $file;
			return ob_get_clean();
		}
		else
			throw new \Exception('Fichier '.$file.' Introuvable');
	}

	private function generateHeader() {
		ob_start();
		require 'ViewHeader.php';
		return ob_get_clean();
	}
}

?>
