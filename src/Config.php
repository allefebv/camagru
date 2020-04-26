<?php

namespace Camagru;

class Config {

    const CONFIG_FILE_PATH = '/config/database.php';

    private static $_instance;

    public $_config;

    public static function getInstance()
    {
        return self::$_instance ?? self::$_instance = new Config();
    }

    public function __construct()
    {
        require dirname(__DIR__) . Config::CONFIG_FILE_PATH;
        $this->_config = array(
            'db_host' => $DB_HOST,
            'db_port' => $DB_PORT,
            'db_name' => $DB_NAME,
            'db_user' => $DB_USER,
            'db_password' => $DB_PASSWORD,
            'db_dsn_exists' => $DB_DSN_EXISTS,
            'db_dsn_create' => $DB_DSN_CREATE,
        );
    }

    public function get(string $key)
    {
        return $this->config[$key] ?? null;
    }

}