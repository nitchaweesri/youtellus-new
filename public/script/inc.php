<?php 
session_start();

if(isset($_REQUEST['lang']) && !empty($_REQUEST['lang'])){
    $_SESSION['lang'] = $_REQUEST['lang'];
   
    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_REQUEST['lang']){
     echo "<script type='text/javascript'> location.reload(); </script>";
    }
}
   // Include Language file
   
   
if(isset($_SESSION['lang'])){
    include "resources/lang/lang_".$_SESSION['lang'].".php";
}else{
    include "resources/lang/lang_th.php";
}
?>



