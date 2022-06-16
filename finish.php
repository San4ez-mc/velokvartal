<?php
	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';

	require_once 'config.php';
	
	$dbhost = DB_HOSTNAME;
	$dbuser = DB_USERNAME;
	$dbpass = DB_PASSWORD;
	$dbdatabase = DB_DATABASE;
	$dbprefix = DB_PREFIX;
	
	if (defined('DB_PORT')) {
		$dbport = DB_PORT;
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase, $dbport);
	} else 	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
	
	if (mysqli_connect_errno()) {
		echo 'Unable connect to the database. See config.php';
	}
		
	$table = $dbprefix . "suppler";
		
	if (!getColumnName($conn, $dbdatabase, $table, "bonus")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `bonus` VARCHAR(64) NOT NULL";
		$retval = $conn->query($query);
	}	
	if (!getColumnName($conn, $dbdatabase, $table, "bprice")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `bprice` VARCHAR(3) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "ddesc")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `ddesc` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "ffile")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `ffile` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "idcat")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `idcat` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "jopt")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `jopt` int(2) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "kmenu")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `kmenu` VARCHAR(3) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "main")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `main` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "metka")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `metka` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "newproduct")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `newproduct` VARCHAR(5) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "onoff")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `onoff` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "opt_fotos")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `opt_fotos` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "opt_prices")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `opt_prices` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "optsku")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `optsku` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "parsq")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `parsq` VARCHAR(3) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "placeq")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `placeq` VARCHAR(5) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "plusopt")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `plusopt` VARCHAR(1) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "pointq")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `pointq` VARCHAR(64) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "qu_discount")) {
		$query = "ALTER TABLE `".$dbprefix."suppler` ADD `qu_discount` VARCHAR(128) NOT NULL";
		$retval = $conn->query($query);
	}
	if (!getColumnName($conn, $dbdatabase, $table, "ratek")) {
		$query = "ALTER TABLE `".$dbprefix."suppl