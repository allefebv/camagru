<?php
require_once("database.php");

try {
    echo $_SERVER['DOCUMENT_ROOT'];
    $db = new PDO($DB_DSN.$DB_NAME);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

$db->query("CREATE TABLE user (
    id                      INTEGER PRIMARY KEY,
    username                TEXT NOT NULL,
    email                   DATE NOT NULL,
    password                TEXT NOT NULL,
    registrationDate        TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);");

$db->query("CREATE TABLE image (
    id                      INTEGER PRIMARY KEY,
    user_id                 INTEGER,
    pathToImage             TEXT NOT NULL,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id)   REFERENCES user(id)
);");

$db->query("CREATE TABLE comment (
    id                      INTEGER PRIMARY KEY,
    user_id                 INTEGER,
    image_id                INTEGER,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    commentText             TEXT NOT NULL,
    FOREIGN KEY (user_id)   REFERENCES user(id),
    FOREIGN KEY (image_id)  REFERENCES image(id)
);");

$db->query("CREATE TABLE like (
    id                      INTEGER PRIMARY KEY,
    user_id                 INTEGER,
    image_id                INTEGER,
    likeDate                TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id)   REFERENCES user (id),
    FOREIGN KEY (image_id)  REFERENCES image (id)
);");

$db->query("CREATE TABLE layer (
    id                      INTEGER PRIMARY KEY,
    pathToLayer             TEXT NOT NULL,
    UNIQUE(pathToLayer)
);");

?>
