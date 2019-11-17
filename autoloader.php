<?php

spl_autoload_register(function($className) {
	$file = $_SERVER['DOCUMENT_ROOT']. '\\model\\' . $className . '.php';
	$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
	//echo $file;
	if (file_exists($file)) {
		include $file;
	}
});

?>
