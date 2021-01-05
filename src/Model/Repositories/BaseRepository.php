<?php

namespace Camagru\Model\Repositories;

use \PDO;
use Camagru\Config;
use Camagru\Model\Entities\Comment;
use Camagru\Model\Entities\Image;
use Camagru\Model\Entities\Layer;
use Camagru\Model\Entities\Like;
use Camagru\Model\Entities\User;

abstract class BaseRepository {

	private static $_db;

	private static function setDb() {
		$config = Config::getInstance();
		self::$_db = new PDO(
			$config->get('db_dsn_exists'),
			$config->get('db_user'),
			$config->get('db_password')
		);
		self::$_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

	protected function getSome($table, $obj, $limit) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' ORDER BY id desc LIMIT ' . $limit);
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

	protected function getSomeOrderByKeyDesc($table, $obj, $key, $limit) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' ORDER BY ' . $key . ' desc LIMIT ' . $limit);
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getSomeOrderByKeyDescUserIs($table, $obj, $key, $limit, $userId) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE userId = ' . $userId . ' ORDER BY ' . $key . ' desc LIMIT ' . $limit);
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getSomeOrderByKeyDescOffsetIdInf($table, $obj, $key, $limit, $offset) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE id < ' . $offset . ' ORDER BY ' . $key . ' desc LIMIT ' . $limit);
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getSomeOrderByKeyDescOffsetIdInfUserIs($table, $obj, $key, $limit, $offset, $userId) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE id < ' . $offset . ' AND userId = ' . $userId . ' ORDER BY ' . $key . ' desc LIMIT ' . $limit);
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getByKey($table, $obj, $key, $value) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE ' . $key . ' = \'' . \htmlspecialchars($value) . '\'');
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function getByKeyOrderByKey($table, $obj, $whereKey, $whereValue, $orderKey, $order)
	{
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' WHERE `' . $whereKey . '` = \'' . \htmlspecialchars($whereValue) . '\' ORDER BY ' . $orderKey . ' ' . $order);
		$req->execute();
		while ($data = $req->fetch())
			$var[] = new $obj($data);
		return $var;
		$req->closeCursor();
	}

	protected function countByKey($table, $obj, $key, $value) {
		$var = NULL;
		$req = $this->getDb()->prepare('SELECT COUNT(*) FROM `' . $table . '` WHERE ' . $key . '=' . \htmlspecialchars($value));
		$req->execute();
		$data = $req->fetch();
		return $data;
		$req->closeCursor();
	}

	protected function getExposedObject($obj) {
		return $obj->expose();
	}

	protected function getExposedObjects(array $objs) {
		foreach($objs as $obj) {
			$var[] = $this->getExposedObject($obj);
		}
		
		return $var;
	}

	protected function updateEntry($table, $updateFieldKey, $updateFieldValue, $idKeyField, $idKeyValue) {
		$req = $this->getDb()->prepare('UPDATE '.$table.
										' SET '.$updateFieldKey.
										'=:updateFieldValue WHERE '.
										$idKeyField.'=:idFieldValue');
		return $req->execute(array('updateFieldValue' => \htmlspecialchars($updateFieldValue),
							'idFieldValue' => $idKeyValue));
	}

	protected function deleteEntry($table, $key, $value) {
		$req = $this->getDb()->prepare('DELETE from ' . $table . ' WHERE ' . $key . '=' . \htmlspecialchars($value));
		return $req->execute();
	}
}

?>
