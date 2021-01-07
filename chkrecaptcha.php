<?php
session_start();

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

if($_REQUEST['campaigntype'] != $_SESSION['CURSEL_CAMPAIGNTYPE']){
	header("Location: index.php?page=error");
	exit();
}

$PHONENO = $_REQUEST['tel'];
$grecaptcharesp = $_REQUEST['g-recaptcha-response'];


// CHECK BLOCKED PHONENO //
include "configure/config.php";
include "dbfunc.php";


$SQLStatement = "SELECT TIMESTAMPDIFF(SECOND, NOW(), EXPIRED_DT) AS BANPERIOD FROM YTU_BLOCK WHERE BLOCKTEL=? AND EXPIRED_DT > NOW()";
$value = array($PHONENO);
$QueryResult = getQueryResult($conn, $SQLStatement, $value);
if($QueryResult['numrows'] > 0){
	$BANPERIOD = $QueryResult['info'][0]['BANPERIOD'];
?>
<script>
	window.location='clean.php?errormsg=banphone&BANPERIOD=<?php print $BANPERIOD;?>';
</script>
<?php
	exit();
}

	
// VERIFY RESPONSE WITH GOOGLE //
$_SESSION['RECAPTCHAVERIFIED'] = 1;

$_SESSION['PHONENO'] = $PHONENO;

header("Location: index.php?page=otp&campaigntype=" . $_SESSION['CURSEL_CAMPAIGNTYPE']);
?>