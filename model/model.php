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
		$req = $this->getDb()->prepare('SELECT * FROM ' . $table . ' ORDER BY id desc');
		$req->execute();
		while ($data = $req->fetch())
		{
			$var[] = new $obj($data);
			$var[0]->author();
		}
		return $var;
		$req->closeCursor();
	}
}

?>
