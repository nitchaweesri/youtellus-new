<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if(file_exists('config.php')){
	include_once('config.php');
}else if(file_exists('../config.php')){
	include_once('../config.php');
}else if(file_exists('../../config.php')){
	include_once('../../config.php');
}


$conn = new mysqli(DATABASE_HOSTNAME, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DBNAME , DATABASE_HOSTPORT);
mysqli_set_charset($conn, "utf8");
date_default_timezone_set("Asia/Bangkok");

if ($conn->connect_error) {
	//die("Database Connection failed: " . $conn->connect_error);
	dir("Critical Error! Please retry the operation later");
}

function executeSQL($mysqli, $SQLStatement, $value = null)
{

$StartTime = microtime(true);	
/*
	// CREATE CONNECTION //
	$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME);
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') '	. mysqli_connect_error());
	}

	$stmt_code = $mysqli->prepare('SET NAMES utf8mb4');
	$stmt_code->execute();
	mysqli_stmt_close($stmt_code);
*/
	$stmt = $mysqli->prepare($SQLStatement);

	$types = str_repeat("s", count($value));

	if (strnatcmp(phpversion(),'5.3') >= 0)
	{
		
		$bind = array();
		foreach($value as $key => $val)
		{
			$bind[$key] = &$value[$key];
		}

	} else {

		$bind = $value;
	}
	//print_r($bind);

	array_unshift($bind, $types);
	call_user_func_array(array($stmt, 'bind_param'), $bind);
	
	$stmt->execute();

	mysqli_stmt_close($stmt);

	mysqli_close($mysqli);

$ProcesingTime = microtime(true) - $StartTime;
//file_put_contents("log/log_suwich/" . date("YmdH") . "-SQL.txt", date("i:s") . " - " . $SQLStatement . " - " . json_encode($value) . " - " . $ProcesingTime . "\r\n", FILE_APPEND); 

	return true;
}