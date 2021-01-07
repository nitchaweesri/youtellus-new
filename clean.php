<?php
	session_start();
/*	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	include "configure/config.php";
	include "dbfunc.php";
	
	
	function get_client_ip() {

        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
	
	if(isset($_REQUEST['errormsg'])){
		if($_REQUEST['errormsg'] == "otpattemptexceed"){
			// NEED TO WRITE DATABASE //
			
			$ip_block = get_client_ip();
			$phone_block = $_SESSION['PHONENO'];
			//$expired = time() +(60* TIME_BLOCK_EXPIRE);
			
			
			$SQLStatement = "INSERT INTO YTU_BLOCK (BLOCKIP, BLOCKTEL, STATUS, EXPIRED_DT) VALUES (?, ?, ?, NOW() + INTERVAL " . (TIME_BLOCK_EXPIRE*60) . " SECOND)";
			$value = array($ip_block, $phone_block, "3T");
			executeSQL($conn, $SQLStatement, $value);


		}
	}
	
	include "processcleansession.php";
	
	include "view/errormsg.php";
	
	
	
	if(isset($_REQUEST['BANPERIOD'])){
		if(is_numeric($_REQUEST['BANPERIOD'])){
			$tmpBANPERIOD = $_REQUEST['BANPERIOD'] + 1;
			$BANPERIOD = $tmpBANPERIOD-1;
			$errormsg .= "&BANPERIOD=" . intval($BANPERIOD);
		}
	}
	header("Location: index.php?page=home&errormsg=" . $errormsg);
?> 