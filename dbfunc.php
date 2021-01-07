<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$saltkey = 'pass:P@ssw0rd';
$dec_password = openssl_decrypt($encstr, 'AES-256-CBC', $saltkey, 0, $iv);
define('DATABASE_PASSWORD', $dec_password); 

$conn = new mysqli(DATABASE_HOSTNAME, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DBNAME , DATABASE_HOSTPORT);
mysqli_set_charset($conn, "utf8");
date_default_timezone_set("Asia/Bangkok");

if ($conn->connect_error) {
	//die("Database Connection failed: " . $conn->connect_error);
	dir("Critical Error! Please retry the operation later");
}


class iimysqli_result
{
    public $stmt, $nCols, $fields;
}    

function iimysqli_stmt_get_result($stmt)
{
    /**    EXPLANATION:
     * We are creating a fake "result" structure to enable us to have
     * source-level equivalent syntax to a query executed via
     * mysqli_query().
     *
     *    $stmt = mysqli_prepare($conn, "");
     *    mysqli_bind_param($stmt, "types", ...);
     *
     *    $param1 = 0;
     *    $param2 = 'foo';
     *    $param3 = 'bar';
     *    mysqli_execute($stmt);
     *    $result _mysqli_stmt_get_result($stmt);
     *        [ $arr = _mysqli_result_fetch_array($result);
     *            || $assoc = _mysqli_result_fetch_assoc($result); ]
     *    mysqli_stmt_close($stmt);
     *    mysqli_close($conn);
     *
     * At the source level, there is no difference between this and mysqlnd.
     **/
    $metadata = mysqli_stmt_result_metadata($stmt);
    $ret = new iimysqli_result;
    if (!$ret) return NULL;

    $ret->nCols = mysqli_num_fields($metadata);
	$ret->fields = mysqli_fetch_fields($metadata);
    $ret->stmt = $stmt;

    mysqli_free_result($metadata);
    return $ret;
}

function iimysqli_result_fetch_array(&$result)
{
    $ret = array();
    $code = "return mysqli_stmt_bind_result(\$result->stmt ";

    for ($i=0; $i<$result->nCols; $i++)
    {
        $ret[$i] = NULL;
        $code .= ", \$ret['" .$i ."']";
    };

    $code .= ");";
    if (!eval($code)) { return NULL; };

    // This should advance the "$stmt" cursor.
    if (!mysqli_stmt_fetch($result->stmt)) { return NULL; };

    // Return the array we built.
	
	// ADDED BY SUWICH //
	$ret2 = array();
	foreach($ret as $nItem=>$retdata){
		$ret2[$nItem] = $retdata;
		$fldname = $result->fields[$nItem]->name;
		$ret2[$fldname] = $retdata;
	}
	
	
	
    return $ret2;
}


function getQueryResult($mysqli, $SQLStatement, $value = null){

	$ReturnResultArray = array();
	$ReturnResultArray["result"] = -1;

$StartTime = microtime(true);	
/*		
	// CREATE CONNECTION //
	$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, DBCONFIG_DBNAME);
	//$mysqli = new mysqli(DBCONFIG_SERVER, DBCONFIG_USER, DBCONFIG_PASSWORD, "lionmaster");
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') '	. mysqli_connect_error());
	}
	//mysqli_select_db($mysqli, "lionmaster");
*/
	$stmt_code = $mysqli->prepare('SET NAMES utf8mb4');
	$stmt_code->execute();
	mysqli_stmt_close($stmt_code);

	$stmt = $mysqli->prepare($SQLStatement);

	$types = str_repeat("s", count($value));

	if (strnatcmp(phpversion(),'5.3') >= 0)
	{
		
		$bind = array();
		if(count($value) > 0){
			foreach($value as $key => $val)
			{
				$bind[$key] = &$value[$key];
			}
		}

	} else {

		$bind = $value;
	}

	array_unshift($bind, $types);
	if(count($value) > 0){
		call_user_func_array(array($stmt, 'bind_param'), $bind);
	}
/*
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try { 
     $stmt->execute();
     $res = $stmt->get_result();
   } catch (mysqli_sql_exception $e) { 
      print_r( $e); 
   } 
	
return $ReturnResultArray;
	$ReturnResultArray["result"] = 1;
	$ReturnResultArray["numrows"] = $res->num_rows;
	
	$ResultList = array();
	while($row = $res->fetch_assoc()){
		//print_r($row);print "<BR/><BR/>";
		//var_dump($row);
		$ResultList[] = $row;
	}

*/
$stmt->execute();
$res = iimysqli_stmt_get_result($stmt);
		$ReturnResultArray["result"] = 1;
		
		
		$numrow = 0;
		$ResultList = array();
		while($row = iimysqli_result_fetch_array($res)){
			//print_r($row);print "<BR/><BR/>";
			//var_dump($row);
			$ResultList[] = $row;
			$numrow++;
		}
		
		$ReturnResultArray["numrows"] = $numrow;
		
	mysqli_stmt_close($stmt);

	mysqli_close($mysqli);

$ProcesingTime = microtime(true) - $StartTime;
//file_put_contents("log/log_suwich/" . date("YmdH") . "-SQL.txt", date("i:s") . " - " . $SQLStatement . " - " . json_encode($value) . " - " . $ProcesingTime . "\r\n", FILE_APPEND); 

	$ReturnResultArray["info"] = $ResultList;
	return $ReturnResultArray;

	
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

