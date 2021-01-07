<?php
	session_start();
	
	include "../configure/config.php";
	
	if(isset($_SESSION['DEFINE_WEBLANGUAGE'])){
		include "../language/lang_".$_SESSION['DEFINE_WEBLANGUAGE'].".php";
	}else{
		include "../language/lang_th.php";
	}
?>