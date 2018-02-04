<?php
	// This script connects us to the database
	define('DB_DSN', 'mysql:host=localhost;dbname=websiteserver;charset=utf8');
	define('DB_USER','serveruser');
    define('DB_PASS','password');

	try {
		$db = new PDO(DB_DSN, DB_USER, DB_PASS);

	} catch (PDOException $e)
	{
		print "Error: " . $e->getMessage();
		die();
	}
?>