<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include "configure/config.php";
	include "sessionmanager.php";
	include "pagemanager.php";
	include "dbfunc.php";
	
	if(isset($_SESSION['DEFINE_WEBLANGUAGE'])){
		include "language/lang_".$_SESSION['DEFINE_WEBLANGUAGE'].".php";
	}else{
		include "language/lang_th.php";
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<title>SCB : You tell US</title>
    	<meta content="Youtellus ได้รับการออกแบบมาเพื่อให้ลูกค้าทุก ท่านสามารถบอกระดับความพึงพอใจ ให้กับ SCB" name="descriptison">
    	<meta content="SCB,Youtellus,ธนาคารไทยพาณิชย์" name="keywords">
  		<link href="public/img/favicon.png" rel="icon">
  		<link href="public/img/favicon.png" rel="apple-touch-icon">

		<link rel="stylesheet" href="public/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="public/css/custom.css">
		<script src="public/vendor/jquery/jquery-3.5.1.min.js"></script>
		<script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>-->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>-->
		

		
        
        <!-- <script src="public/js/uploadimage.js"></script> -->
		
    </head>
	 <body>
        <nav class="navbar navbar-light fixed-top test pl-0" style="background-color:#ffffff; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
			<div class="container col-lg-7">
				<div class="logo">
					&nbsp;
				</div>

				<div class="logo mx-auto">
					<img src="public/img/icon.png" width="" height="40" class="d-inline-block align-top" alt="" loading="lazy" style="cursor:pointer;" onClick="
						$('#modal-clear').on('show.bs.modal', function (event) {
							var modal = $(this)
								modal.find('.modal-title').text('Clear Session')        
							})
						$('#modal-clear').modal('show')
					">
				</div>
			</div>
		</nav>
		
		<div id="DIV_MAINCONTENT">
			<?php include "view/" . $DEFINE_INCVIEW;?>
		</div>
		
		
		
		<?php include 'view/modal.php'; ?>
		
    </body>
	
</html>