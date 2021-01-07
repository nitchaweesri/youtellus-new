<?php
	//$errormsg = "";
	
	if(!isset($errormsg)){
		$errormsg =  "";
	}
	if(isset($_REQUEST['errormsg'])){
		switch($_REQUEST['errormsg']){
			case "otpsilence":
				$errormsg = "otpsilence";
				break;
			case "otpattemptexceed":
				$errormsg = "otpattemptexceed";
				break;
			case "banphone":
				$errormsg = "banphone";
				break;
		}
	}
	
	
?>