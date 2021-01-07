<?php
	session_start();
	
	$DEFINE_WEBLANGUAGE = "TH";
	
	if(isset($_SESSION['DEFINE_WEBLANGUAGE'])){
		if($_SESSION['DEFINE_WEBLANGUAGE'] == "TH"){
			$DEFINE_WEBLANGUAGE = "TH";
		}else if($_SESSION['DEFINE_WEBLANGUAGE'] == "EN"){
			$DEFINE_WEBLANGUAGE = "EN";
		}
	}
	
	if(isset($_REQUEST['LANG'])){
		if($_REQUEST['LANG'] == "TH"){
			$DEFINE_WEBLANGUAGE = "TH";
		}else if($_REQUEST['LANG'] == "EN"){
			$DEFINE_WEBLANGUAGE = "EN";
		}
	}
	
	$_SESSION['DEFINE_WEBLANGUAGE'] = $DEFINE_WEBLANGUAGE;
	
?>