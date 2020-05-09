<?php

namespace Camagru\Service;

class ViewGenerator {

	const TEMPLATE = 'src/View/Pages/template.php';
	private $_file;
	private $_title;

	public function __construct($action)
	{
		$this->_file = 'src/View/Pages/View' . $action . '.php';
	}

	public function generate(array $data)
	{
		//Corps de la vue, partie specifique
		$content = $this->generateFile($this->_file, $data);
		$header = $this->generateHeader();
		//Template qui reutilise le corps ($content + $title)
		$view = $this->generateFile(self::TEMPLATE,
			array('title' => $this->_title,
				'content' => $content,
				'header' => $header));
		echo $view;
	}

	private function generateFile(string $file, array $data)
	{
		if (file_exists($file))
		{
			extract($data);
			ob_start();
			require $file;
			return ob_get_clean();
		}
		else {
			throw new \Exception('Fichier '.$this->_file.' Introuvable');
		}
	}

	private function generateHeader()
	{
		ob_start();
		require dirname(__DIR__) . '/View/Pages/ViewHeader.php';
		return ob_get_clean();
	}
}

?>
