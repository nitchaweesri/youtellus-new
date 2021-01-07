<?php
	if(isset($_SESSION['PHONENO'])){
		unset($_SESSION['PHONENO']);
	}
	if(isset($_SESSION['RECAPTCHAVERIFIED'])){
		unset($_SESSION['RECAPTCHAVERIFIED']);
	}
	if(isset($_SESSION['OTPVERIFIED'])){
		unset($_SESSION['OTPVERIFIED']);
	}
	if(isset($_SESSION['OTPATTEMPCOUNT'])){
		unset($_SESSION['OTPATTEMPCOUNT']);
	}

	session_destroy();
?>