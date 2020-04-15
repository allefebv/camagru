<?php
require_once("database.php");

try {
    echo $_SERVER['DOCUMENT_ROOT'];
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(\Exception $e) {
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
    userId                  INTEGER,
    pathToImage             TEXT NOT NULL,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user(id) ON DELETE CASCADE
);");

$db->query("CREATE TABLE comment (
    id                      INTEGER PRIMARY KEY,
    userId                  INTEGER,
    imageId                 INTEGER,
    publicationDate         TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    commentText             TEXT NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (imageId)   REFERENCES image(id) ON DELETE CASCADE
);");

$db->query("CREATE TABLE like (
    userId                  INTEGER NOT NULL,
    imageId                 INTEGER NOT NULL,
    likeDate                TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (userId)    REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (imageId)   REFERENCES image (id) ON DELETE CASCADE,
    PRIMARY KEY (userId, imageId)
);");

$db->query("CREATE TABLE layer (
    id                      INTEGER PRIMARY KEY,
    pathToLayer             TEXT NOT NULL,
    UNIQUE(pathToLayer)
);");

?>
