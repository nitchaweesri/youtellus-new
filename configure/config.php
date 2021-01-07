<?php
	////////////////////////  dev  //////////////////////////
    if (!defined('DATABASE_HOSTNAME')) define('DATABASE_HOSTNAME', 'devscbdb01');
    if (!defined('DATABASE_USER')) define('DATABASE_USER', 'tvssapp');
    if (!defined('DATABASE_DBNAME')) define('DATABASE_DBNAME', 'scbtvss_dev');
    if (!defined('DATABASE_HOSTPORT')) define('DATABASE_HOSTPORT', '9306');
	
	$encstr = 'PhBRVJ48OaJXIp+Dd94+zg==';
	$iv = '19-L4aw7r8]l5T2U';

    //////////////////     localhost     //////////////////
    // if (!defined('DATABASE_HOSTNAME')) define('DATABASE_HOSTNAME', 'localhost');
    // if (!defined('DATABASE_USER')) define('DATABASE_USER', 'root');
    // if (!defined('DATABASE_DBNAME')) define('DATABASE_DBNAME', 'scbytu_dev');
    // if (!defined('DATABASE_HOSTPORT')) define('DATABASE_HOSTPORT', '3306');

    if (!defined('TIME_OTP')) define('TIME_OTP', 120); // second
    if (!defined('TIME_BLOCK_EXPIRE')) define('TIME_BLOCK_EXPIRE', 10); // minute
    if (!defined('POSSIBLE_ERROR_OTP')) define('POSSIBLE_ERROR_OTP', 3); //time


    if (!defined('EXTENSION_ALLOW')) define('EXTENSION_ALLOW', ['jpeg','jpg','JPG','png','doc','docx','pdf']);  // no space bar
    if (!defined('FILE_SIZE_ALLOW')) define('FILE_SIZE_ALLOW', 10000000); //// B 


    if (!defined('TVSS_WEBHOOK')) define('TVSS_WEBHOOK', 'https://clonld01.tellvoice.com/TVSSCRAWLER3/youtellus/webhook_suwich.php');
	if (!defined('TVSS_UPLOADPENDINGDOC')) define('TVSS_UPLOADPENDINGDOC', 'https://clonld01.tellvoice.com/TVSSCRAWLER3/youtellus/uploadpendingdoc_suwich.php');
	
	
?>