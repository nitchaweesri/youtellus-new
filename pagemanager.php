<?php
$DEFINE_CURPAGE = "home";
if(isset($_REQUEST['page'])){
	switch($_REQUEST['page']){
		case "home":
			$DEFINE_CURPAGE = "home";
			break;
		case "thanks":
			$DEFINE_CURPAGE = "thanks";
			break;
		case "verify":
			$DEFINE_CURPAGE = "verify";
			break;
		case "otp":
			$DEFINE_CURPAGE = "otp";
			break;
		case "form_GN":
			$DEFINE_CURPAGE = "form_GN";
			break;
		case "form_OT":
			$DEFINE_CURPAGE = "form_OT";
			break;
		case "form_JP":
			$DEFINE_CURPAGE = "form_JP";
			break;
		case "menuupload":
			$DEFINE_CURPAGE = "menuupload";
			break;	
		case "pendingdocupload":
			$DEFINE_CURPAGE = "pendingdocupload";
			break;
		default:
			$DEFINE_CURPAGE = "error";
			break;
	}
}

$DEFINE_INCVIEW = "";
if($DEFINE_CURPAGE == "home"){
	$DEFINE_INCVIEW = "menu.php";
}else if($DEFINE_CURPAGE == "thanks"){
	$DEFINE_INCVIEW = "thanks.php";
}else if($DEFINE_CURPAGE == "verify"){
	$DEFINE_INCVIEW = "verify.php";
}else if($DEFINE_CURPAGE == "menuupload"){
	$DEFINE_INCVIEW = "menuupload.php";
}else if($DEFINE_CURPAGE == "pendingdocupload"){
	$DEFINE_INCVIEW = "pendingdocupload.php";
}else if($DEFINE_CURPAGE == "otp"){
	$DEFINE_INCVIEW = "error.php";
	
	if(isset($_SESSION['RECAPTCHAVERIFIED'])){
		if($_SESSION['RECAPTCHAVERIFIED'] == 1){
			// REQUIRE RECAPTCHA VERIFICATION //
			$DEFINE_INCVIEW = "otp.php";
		}
	}
	
}else if(($DEFINE_CURPAGE == "form_GN") || ($DEFINE_CURPAGE == "form_JP") || ($DEFINE_CURPAGE == "form_OT")){
	$DEFINE_INCVIEW = "error.php";
	
	if(isset($_SESSION['OTPVERIFIED'])){
		if($_SESSION['OTPVERIFIED'] == 1){
			// REQUIRE OTP VERIFICATION //
			if($DEFINE_CURPAGE == "form_GN"){$DEFINE_INCVIEW = "form_GN.php";}
			if($DEFINE_CURPAGE == "form_JP"){$DEFINE_INCVIEW = "form_JP.php";}
			if($DEFINE_CURPAGE == "form_OT"){$DEFINE_INCVIEW = "form_OT.php";}
		}
	}
	
}else{
	$errormsg = "systemerror";
	$DEFINE_INCVIEW = "error.php";
}


if($DEFINE_INCVIEW == "error.php"){
	$errormsg = "systemerror";
	$DEFINE_INCVIEW = "menu.php";
}

function errorPage(){
?>
<script>
	window.location="?page=error";
</script>
<?php	
}
?>