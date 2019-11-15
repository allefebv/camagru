<?php
require_once("database.php");

try {
$db = new PDO($DB_DSN.$DB_NAME);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

$db->query("CREATE TABLE IF NOT EXISTS comments (
    id            INTEGER         PRIMARY KEY AUTOINCREMENT,
    comment       VARCHAR( 250 ),
    created       DATETIME
);");

$db->query("CREATE TABLE IF NOT EXISTS users (
    id              INTEGER         PRIMARY KEY AUTOINCREMENT,
    username        VARCHAR( 20 ),
    userpassword    VARCHAR( 250 )
);");

$stmt = $db->prepare("INSERT INTO comments (comment, created) VALUES (:comment, :created)");
$content = $stmt->execute(array(
    'comment'         => "top com",
    'created'       => date("Y-m-d H:i:s")
));

?>
