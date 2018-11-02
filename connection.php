<?php
	// require_once 'config.php';

	$host = 'localhost';
	$dbName = 'customtrip_db';
	$dsn = "mysql:host=$host; dbname=$dbName; charset=utf8mb4";
	$user = 'root';
	$pass = '';
	$opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

	try {
		$conn = new PDO($dsn, $user, $pass, $opt);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
	} catch (PDOException $exception) {
		echo "Connection failed: " . $exception->getMessage();
	}
