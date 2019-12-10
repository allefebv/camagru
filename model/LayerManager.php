<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

class LayerManager extends Model {

	//table DB 'layer' et classe 'Layer'
	public function __construct() {
		$layers = scandir($_SERVER['DOCUMENT_ROOT'].'/public/layers/');
		foreach($layers as $layer) {
			if (strpos($layer, '.png') !== FALSE)
				$this->add(new Layer(array('pathToLayer' => '/public/layers/' . $layer)));
		}
	}

	private function add(Layer $layer) {
		$req = $this->getDb()->prepare('INSERT OR IGNORE INTO layer(pathToLayer) VALUES(:pathToLayer)');
		$req->execute(array('pathToLayer' => $layer->pathToLayer()));
	}

	public function getLayers() {
		return $this->getAll('layer', 'Layer');
	}

	public function getLayerById($id) {
		return $this->getByKey('layer', 'Layer', 'id', $id);
	}
}

?>
