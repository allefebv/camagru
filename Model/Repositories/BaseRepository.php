<?php

namespace Camagru\Model\Repositories;

use \Camagru\Model\Entities\Comment;
use \Camagru\Model\Entities\Image;
use \Camagru\Model\Entities\Layer;
use \Camagru\Model\Entities\Like;
use \Camagru\Model\Entities\User;

abstract class BaseRepository {

	private static $_db;
	private static $_dbDsn = "sqlite:db/";
	private static $_dbName = "camagru";

	private static function setDb() {
		self::$_db = new \PDO(self::$_dbDsn.self::$_dbName);
		self::$_db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
		self::$_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	protected function getDb() {
		if (self::$_db == NULL)
			self::setDb();
		return self::$_db;
	}

	protected function getAll($table, $obj) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' ORDER BY id desc');
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getAllOrderByKeyDesc($table, $obj, $key) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' ORDER BY ' . $key . ' desc');
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getByKey($table, $obj, $key, $value) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE ' . $key . ' = \'' . $value . '\'');
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function countByKey($table, $obj, $key, $value) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT COUNT(*) FROM ' . $table . ' WHERE ' . $key . '=' . $value);
		$req->execute();
		$data = $req->fetch();
		return $data;
		$req->closeCursor();
	}

	protected function updateEntry($table, $updateFieldKey, $updateFieldValue, $idKeyField, $idKeyValue) {
		$req = $this->getDb()->prepare('UPDATE '.$table.
										' SET '.$updateFieldKey.
										'=:updateFieldValue WHERE '.
										$idKeyField.'=:idFieldValue');
		return $req->execute(array('updateFieldValue' => $updateFieldValue,
							'idFieldValue' => $idKeyValue));
	}

	protected function deleteEntry($table, $key, $value) {
		$req = $this->getDb()->prepare('DELETE from ' . $table . ' WHERE ' . $key . '=' . $value);
		return $req->execute();
	}
}

?>
