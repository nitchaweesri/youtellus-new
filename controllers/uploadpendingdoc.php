<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
 
include "inc.php";
include "../dbfunc.php";
	

if(!isset($_SESSION['PHONENO']) ){?><script>window.location='index.php?page=error';</script><?php exit();}
if(!isset($_SESSION['RECAPTCHAVERIFIED']) || ($_SESSION['RECAPTCHAVERIFIED'] != 1) ){
?>
<script>
	window.location='index.php?page=error';
</script>
<?php
	exit();
}
if(!isset($_SESSION['OTPVERIFIED']) || ($_SESSION['OTPVERIFIED'] != 1) ){
?>
<script>
	window.location='index.php?page=error';
</script>
<?php
	exit();
}

$FILEUPLOADARR = array();

$errors = []; // Store errors here
$fileExtensionsAllowed = EXTENSION_ALLOW; 

include_once('crypt.php') ;

$CASEID = $_POST['CASEID'];
$FILEDESC = $_POST['FILEDESC'];

$fileReq = explode("|",$FILEDESC);
 
//print_r($_FILES);
foreach($_FILES as $FILENAME=>$FileInfo){
	//print $FILENAME . " -- ";print_r($FileInfo); print "<br/><br/>";
	if($FileInfo['error'] != 0){
?>
<div class="text-danger">Please upload all required files</div>
<?php
		exit();
	}
	
	$fileName = $FileInfo['name'];
	$fileTmpName  = $FileInfo['tmp_name'];
	$fileSize = $FileInfo['size'] / 1000000;
	
	$fileExtension = strtolower(explode('/',$FileInfo['type'])[1]);
	// $fileExtension = strtolower(explode('.',$fileName)[1]);

	$fileExtension = str_replace(' ', '', $fileExtension);

	  // str_replace("world","Peter","Hello world!")
	  //$uploadPath = str_replace("controllers","",$currentDirectory) . $uploadDirectory . $fileName;

	  if (! in_array($fileExtension,$fileExtensionsAllowed)) {
		$errors[] = constant("ERR_INVALIDFILETYPE");

	  }
	  
	  
	  $filesizeallow = FILE_SIZE_ALLOW / 1000000;

	  if ($fileSize > $filesizeallow) {
		$errors[] = constant("ERR_FILESIZEEXCEED") . " (" . $filesizeallow . "MB)";
	  }
	  
	  $FILEUPLOADARR[] = array("FILENAME"=>$fileName, "FILECONTENT"=>base64_encode(file_get_contents($fileTmpName) ));
}

if (!empty($errors)) {
	foreach($errors as $errmsg){
?>
<div class="text-danger"><?php print $errmsg;?></div>
<?php		
	}
	exit();
}




$url = TVSS_UPLOADPENDINGDOC; 
$ch = curl_init( $url );




///////////// set json data ////////////
$ParamArr = array(  "caseid"=> $CASEID
					,"fileul"=>$FILEUPLOADARR
				);
$payload = json_encode( $ParamArr);

curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);

//print $url;
//print "RESULT = " . $result;
/*

$sql = "SELECT ATTACHMENT FROM ONLINECOMPLAINT WHERE CASEID=" . $CASEID;
$result = mysqli_query($conn, $sql);
if (!$result) {
	//printf("Error: %s\n", mysqli_error($conn));
	print "Database error";
	exit();
}

$row = mysqli_fetch_assoc($result);
$data = $row;

$CURATTACHMENTArr = json_decode($data['ATTACHMENT'], true);
$FILENO = intval(count($CURATTACHMENTArr)/2); // ZERO INDEX 
foreach($NEWPENDINGDOCArr as $DocInfo){
	$CURATTACHMENTArr["file" . $FILENO] = $DocInfo['FILENAME'];
	$CURATTACHMENTArr["linkFile" . $FILENO] = "https://devytuapp.tellvoice.com/youtellus/uploads/file/" . $DocInfo['NEWFILENAME'];

	$FILENO++;
}

$SQLStatement = "UPDATE ONLINECOMPLAINT SET ATTACHMENT=? WHERE CASEID=?";
$value = array(json_encode($CURATTACHMENTArr), $CASEID);
executeSQL($conn, $SQLStatement, $value);

$SQLStatement = "UPDATE YTU_REQFILE SET RECSTATUS=? WHERE CASEID=? AND RECSTATUS=? ";
$value = array('F', $CASEID, 'A');
executeSQL($conn, $SQLStatement, $value);
*/

//print_r($value);
//header("Location: ../index.php?page=thanks");

//print "DONE";
 ?>
 <script>
 window.location='index.php?page=thanks';
 </script>