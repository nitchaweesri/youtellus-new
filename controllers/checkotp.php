<?php

	include "inc.php";
	
	if(!isset($_SESSION['PHONENO']) ){?><script>window.location='index.php?page=error';</script><?php exit();}
	if(!isset($_SESSION['RECAPTCHAVERIFIED']) || ($_SESSION['RECAPTCHAVERIFIED'] != 1) ){
?>
<script>
	window.location='index.php?page=error';
</script>
<?php
		exit();
	}

	if($_SESSION['OTPRESULT'] != $_REQUEST['OTPVAL']){
		$_SESSION['OTPATTEMPCOUNT']++;
?>
<span class="text-danger"><?php print constant('รหัส OTP ไม่ถูกต้อง');?></span>
<?php		
		if($_SESSION['OTPATTEMPCOUNT'] > POSSIBLE_ERROR_OTP){
			// OTP ATTEMPT EXCEED //
?>
<script>
	window.location='clean.php?errormsg=otpattemptexceed';
</script>
<?php
		}
		
		exit();
	}
	
	$_SESSION['OTPVERIFIED'] = 1;
	
	
	if($_REQUEST['campaigntype'] != $_SESSION['CURSEL_CAMPAIGNTYPE']){
?>
<script>
	window.location='index.php?page=error';
</script>
<?php
		exit();
	}
	$campaigntype = $_SESSION['CURSEL_CAMPAIGNTYPE'];
	
	
	// CHECK PENDING //
	include "../dbfunc.php";
	
	$PHONENO = $_SESSION['PHONENO'];
	
	
	$SQLStatement = "SELECT COUNT(*) AS NUMCOUNT FROM YTU_REQFILE WHERE MOBILENO=? AND RECSTATUS=?";
	$value = array($PHONENO, "A");
	$QueryResult = getQueryResult($conn, $SQLStatement, $value);
	if($QueryResult['numrows'] <= 0){
?>
<script>
	window.location='index.php?page=error';
</script>
<?php
		exit();
	}

	$NUMPENDINGCOUNT = $QueryResult['info'][0]['NUMCOUNT'];
	
	
?>
<script>
<?php
	if($NUMPENDINGCOUNT > 0){
		// HAS PENDING DOCUMENT //
?>
		window.location='index.php?page=menuupload&campaigntype=<?php print $campaigntype;?>';
<?php
	}else{
		// HAS NO PENDING DOCUMENT //
?>
		window.location='index.php?page=form_<?php print $campaigntype;?>';
<?php
	}
	
?>	
	//alert('1');
	//window.location='index.php?page=form_' . $campaigntype;
	//setTimeout(function(){window.location='index.php?page=form_<?php print $campaigntype;?>';}, 1000);
</script>