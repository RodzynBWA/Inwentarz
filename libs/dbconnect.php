<?php
	$mysql_host = 'localhost';
	$username = 'Inwerter';
	$password = 'ptakilatajakluczem';
	$database = 'Inwentarz';

	try {
		$baza = new PDO("mysql:host=$mysql_host;dbname=$database", $username, $password);
		$baza->query('SET NAMES utf8');
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>