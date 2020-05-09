<?php

namespace Camagru\Model\Repositories;

use Camagru\Model\Entities\Layer;

require("config/database.php");

class LayerRepository extends BaseRepository {

	private function add(Layer $layer) {
		$req = $this->getDb()->prepare('INSERT IGNORE INTO layer(pathToLayer) VALUES(:pathToLayer)');
		$req->execute(array('pathToLayer' => $layer->pathToLayer()));
	}

	public function getLayers() {
		return $this->getAll('layer', Layer::class);
	}

	public function getLayerById($id) {
		return $this->getByKey('layer', Layer::class, 'id', $id);
	}
}

?>
