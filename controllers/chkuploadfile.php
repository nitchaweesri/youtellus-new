<?php
	
	if(file_exists("config.php")){
		include_once('config.php');
	}else if(file_exists("../config.php")){
		include_once('../config.php');
	}else if(file_exists("../../config.php")){
		include_once('../../config.php');
	}
	
	 
	$FILEUPLOADARR = array();
	
	$errors = []; // Store errors here
	$fileExtensionsAllowed = EXTENSION_ALLOW; 
  
    foreach( $_FILES['file']['name'] as $i => $value ) {
		if ($_FILES['file']['name'][$i] !="" ) {
			$fileName = $_FILES['file']['name'][$i];
			$fileSize = $_FILES['file']['size'][$i] / 1000000;
			$fileTmpName  = $_FILES['file']['tmp_name'][$i];
			$fileType = $_FILES['file']['type'][$i];

			$fileExtension = strtolower(explode('/',$_FILES['file']['type'][$i])[1]);
			// $fileExtension = strtolower(explode('.',$fileName)[1]);

			$fileExtension = str_replace(' ', '', $fileExtension);

			if (! in_array($fileExtension,$fileExtensionsAllowed)) {
				$errors[] = constant("ERR_INVALIDFILETYPE");
			}
			
			$filesizeallow = FILE_SIZE_ALLOW / 1000000;

			if ($fileSize > $filesizeallow) {
				$errors[] = constant("ERR_FILESIZEEXCEED") . " (" . $filesizeallow . "MB)";
			}
			
			$FILEUPLOADARR[] = array("FILENAME"=>$fileName, "FILECONTENT"=>base64_encode(file_get_contents($fileTmpName) ));
			
			if(!empty($errors)){
				
				foreach($errors as $nErr=>$errtxt){
?>
<div class="text-danger"><?php print $errtxt;?></div>
<?php
				}
				exit();
			}
			
			
			
		}

	}
	  
    
?>