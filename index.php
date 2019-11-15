<?php

$title = "MaPage";

require_once("config/setup.php");

$stmt = $db->prepare("SELECT * FROM comments WHERE comment = :comment");
$stmt->execute(array('comment' => 'Lorem ipsum'));
$content = $stmt->fetchAll();
print_r($content);

require_once("./view/template.php");

?>
