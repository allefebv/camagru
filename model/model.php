<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/autoloader.php');

abstract class Model {

	private static $_db;
	private static $_dbDsn = "sqlite:db/";
	private static $_dbName = "camagru";

	private static function setDb() {
		self::$_db = new PDO(self::$_dbDsn.self::$_dbName);
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
		$req = $this->getDb()->prepare('SELECT COUNT(*) FROM ' . $table . ' WHERE ' . $key . ' = \'' . $value . '\'');
		$req->execute();
		$data = $req->fetch();
		return $data;
		$req->closeCursor();
	}

/*	protected function convertKey() {

	}

	protected function snakeToCamel($string, $capitalizeFirstChar = false) {
		$str = str_replace('-', '', ucwords($string, '-'));
		if (!$capitalizeFirstChar)
			$str = lcfirst($str);
		return $str;
	} */
}

?>
