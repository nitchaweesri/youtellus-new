<?php

if(!isset($_SESSION['RECAPTCHAVERIFIED']) || ($_SESSION['RECAPTCHAVERIFIED'] != 1) ){
?>
<script>
	window.location='?page=error';
</script>
<?php
	exit();
}
			
if($_REQUEST['campaigntype'] != $_SESSION['CURSEL_CAMPAIGNTYPE']){
?>
<script>
	window.location='?page=error';
</script>
<?php
	exit();
}
$campaigntype = $_SESSION['CURSEL_CAMPAIGNTYPE'];

if(isset($_SESSION['OTPVERIFIED'])){
	unset($_SESSION['OTPVERIFIED']);
}
	
if(!isset($_SESSION['OTPATTEMPCOUNT'])){
	$_SESSION['OTPATTEMPCOUNT'] = 0;
}

$_SESSION['OTPATTEMPCOUNT']++;
if($_SESSION['OTPATTEMPCOUNT'] > POSSIBLE_ERROR_OTP){
	// OTP ATTEMPT EXCEED //
?>
<script>
	window.location='clean.php?errormsg=otpattemptexceed';
</script>
<?php
	exit();
}

// SENT OTP HERE AND STORE OTP RESULT //
$_SESSION['OTPRESULT'] = "1234";

?>
<style>
    a { color: black; font-size: 13px; color: #495057; }
    .img-refresh-otp { width: 13px; height: 13px; margin-bottom: 3px; }
    .text-alert { display: none; font-size: 14px; }
</style>
<div style="height:70px"></div>
<div class="container mb-4 mb-5 col-lg-6 col-md-12 col-sm-12 rounded" align="center" id="menu">
    <div style="height: 195px; padding: 70px 15px;">
        <h3 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('กรอกรหัส OTP') ?></h3>
    </div>
    <div class="col-lg-7 col-md-12 col-sm-12">
        <div class="form-group">
		 <form id="FRM_CHKOTP" 
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <input type="text" class="form-control mb-2" id="otp" name="OTPVAL" placeholder="<?php echo constant('รหัส OTP') ?>" required>
                 
            <div class="col-lg-12 col-md-12 col-sm-12 p-0 justify-content-between" style="text-align: end; display: block;">
                <?php  if (isset($_REQUEST['msg'])&&$_REQUEST['msg']=='pwd'){ ?>
                    <label for="exampleInputEmail1" class="text-danger txt-wrong-otp Bold"><?php echo constant('รหัส OTP ไม่ถูกต้อง') ?></label>
                <?php }?>
                <a id="countdown" class="text-primary txt-count-otp Bold"></a>
            </div>
        </form>
        </div>
        <div class="row pt-5" align="center">
            <div class="col">
                <button id="BTN_RESENTOTP" class="btn rounded-pill Bold col-12 btn-re-otp"><?php echo constant('ขอรหัส OTP อีกครั้ง') ?></button>
            </div>
        	<div class="col">
                <button id="BTN_SUBMITOTP" class="btn btn-primary rounded-pill Bold col-12 btn-submit-otp d-none"><?php echo constant('ถัดไป') ?></button>
            </div>
        </div>
		<div class="mt-10" id="DIV_CHKOTP_RESULT"></div>
    </div>    
</div>


<footer class="footer">
    <p class="txt-policy Bold"><?php echo constant('นโยบายความเป็นส่วนตัวธนาคารไทยพาณิชย์ จำกัด (มหาชน)') ?></p>
    <button class="policy Bold" onclick="policy()"><?php echo constant('คลิก') ?></button>
</footer>


<script>
	//alert('1');
	$('#otp').keyup(function(){
		if($(this).val().length > 0){
			$('#BTN_SUBMITOTP').removeClass('d-none');
		}else{
			$('#BTN_SUBMITOTP').addClass('d-none');
		}
	});
	
	$('#BTN_RESENTOTP').click(function(){
		location.reload();
	});
	
	$('#BTN_SUBMITOTP').click(function(){
		

		$("#FRM_CHKOTP").submit(); //Submit the form

	});
	
	
	$("#FRM_CHKOTP").submit(function(e)
	{
		$("#DIV_CHKOTP_RESULT").html(".... Please Wait ....");

		var formObj = $(this);
		var formURL = "controllers/checkotp.php?campaigntype=<?php print $campaigntype;?>";
		var formData = new FormData(this);
		
		actionurl = '';

		

		$.ajax({
			url: formURL,
			type: 'POST',
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
			success: function(data, textStatus, jqXHR)
			{

				$("#DIV_CHKOTP_RESULT").html(jqXHR.responseText);
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert("request failed " + textStatus + "--" + errorThrown + "----" + jqXHR.responseText);
			}          
		});


		e.preventDefault(); //Prevent Default action. 
		//e.unbind();
	}); 
	
var allowotpsec = <?php echo TIME_OTP?>;
var otpTimer = setInterval(function(){
	allowotpsec--;
	document.getElementById("countdown").innerHTML = "<?php echo constant('โปรดใส่รหัสก่อน') ?> " +allowotpsec + " <?php echo constant('วินาที') ?>" ;
	
	if(allowotpsec <= 0){
		window.location='clean.php?errormsg=otpsilence';
	}
}, 1000);
	
</script>
