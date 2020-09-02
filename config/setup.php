<?php

require_once("database.php");

try {
    $db = new PDO($DB_DSN_EXISTS, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("DROP DATABASE camagru");
} catch (\Exception $e) {
    echo $e->getMessage();
}

$db = new PDO($DB_DSN_CREATE, $DB_USER, $DB_PASSWORD);
$db->query("CREATE DATABASE IF NOT EXISTS " . $DB_NAME);
$db->query("use " . $DB_NAME);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->query("CREATE TABLE `user` (
    id                      INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username                TEXT NOT NULL,
    email                   TEXT NOT NULL,
    password                TEXT NOT NULL,
    registrationDate        TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    activated               BOOLEAN DEFAULT 0 NOT NULL,
    notifications           BOOLEAN DEFAULT 1 NOT NULL,
    activationKey           CHAR(32) NOT NULL
);");

$db->query("CREATE TABLE `image` (
    id                      INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userId                  INTEGER NOT NULL,
    pathToImage             VARCHAR(255) NOT NULL UNIQUE,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user(id) ON DELETE CASCADE
);");

$db->query("CREATE TABLE comment (
    id                      INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userId                  INTEGER NOT NULL,
    imageId                 INTEGER NOT NULL,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    commentText             TEXT NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (imageId)   REFERENCES image(id) ON DELETE CASCADE
);");

$db->query("CREATE TABLE `like` (
    userId                  INTEGER NOT NULL,
    imageId                 INTEGER NOT NULL,
    likeDate                TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (imageId)   REFERENCES image (id) ON DELETE CASCADE,
    PRIMARY KEY (userId, imageId)
);");

$db->query("CREATE TABLE layer (
    id                      INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pathToLayer             VARCHAR(255) NOT NULL UNIQUE
);");

$layers = scandir(dirname(__DIR__) . '/public/layers/');
$req = $db->prepare("INSERT IGNORE INTO layer(pathToLayer) VALUES(:pathToLayer)");
foreach($layers as $layer) {
    if (strpos($layer, '.png') !== FALSE) {
        $req->execute(array('pathToLayer' => '/public/layers/' . $layer));
    }
}

?>
