<?php
	$scb_lang = strtolower(isset($_SESSION['DEFINE_WEBLANGUAGE']) ? $_SESSION['DEFINE_WEBLANGUAGE'] : 'th');
	
	if(isset($_SESSION['RECAPTCHAVERIFIED'])){
		unset($_SESSION['RECAPTCHAVERIFIED']);
	}
	
	$campaigntype = "";
	$SQLStatement = "SELECT * FROM CONFIG_YTU_COMPLAINTTYPE ORDER BY SORTINGDESCVAL DESC";
	$value = array();
	$QueryResult = getQueryResult($conn, $SQLStatement, $value);
	if($QueryResult['numrows'] <= 0){
		errorPage();
		exit();
	}

	$ComplaintTypeList = $QueryResult['info'];
	foreach ($ComplaintTypeList as $key => $value) {
         $page_vl = $value['COMPLAINTCODE'];
		 if($page_vl == $_REQUEST['campaigntype']){
			 $campaigntype = $page_vl;
		 }
	}

	if(strlen($campaigntype)<=0){
		errorPage();
		exit();
	}
	
	$_SESSION['CURSEL_CAMPAIGNTYPE'] = $campaigntype;
?>
<div class="container mb-4 mb-5 col-lg-6 col-md-12 col-sm-12" align="center" id="menu" style="margin-top: 70px;">
<div style="height: 195px; padding: 70px 15px;">
	<h3 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('หมายเลขโทรศัพท์สำหรับรับรหัส OTP') ?></h3>
</div>

        <form action="chkrecaptcha.php?campaigntype=<?php print $campaigntype;?>" method="post" class="needs-validation col-lg-7 col-md-12 col-sm-12" id="demo-form" novalidate>
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <input type="hidden" name="action" value="validate_captcha">
        
            <div class="form-group">
                <input name="tel" type="text" class="form-control" id="tell" placeholder="<?php echo constant('หมายเลขโทรศัพท์มือถือ') ?>" required pattern="^0([8|9|6])([0-9]{8}$)">
            </div>
            <?php  if (isset($_REQUEST['msg'])&&$_REQUEST['msg']=='expired') { ?>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-danger" style="float: left;"><?php echo constant('คุณไม่ใส่ OTP ในระยะเวลาที่กำหนด กรุณาทำรายการใหม่อีกครั้ง') ?></label>
                </div> 
            <?php } ?>
            
            <div class="form-group" style="float: center;">
                <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Lf7XhcaAAAAAPT4VUMvdD3R2_WGRN3jbN49PgjB"></div>
            </div>
            
            <div class="row" align="center" style="display: inline;">
                <div class="col-lg-7 col-md-8 col-sm-10">
                    <div class="col d-flex justify-content-center">
                        <button type="submit" id='makesession' class="btn btn-primary rounded-pill Bold col-12 btn-verify"><?php echo constant('ขอรหัส OTP')?></button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    <footer class="footer">
        <p class="txt-policy Bold"><?php echo constant('นโยบายความเป็นส่วนตัวธนาคารไทยพาณิชย์ จำกัด (มหาชน)') ?></p>
		<a href="https://www.scb.co.th/<?php echo $scb_lang; ?>/personal-banking/privacy-notice.html" target="_blank" class="policy Bold"><?php echo constant('คลิก') ?></a>
        <!-- <button class="policy" onclick="policy()">คลิก</button> -->
    </footer>
</div>

<script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $scb_lang; ?> ' async defer ></script>
<script>
$(document).ready(function() {

    // $('#makesession').prop('disabled', true);
    document.getElementById("makesession").style.display = "none";

    $('#mainModal').on('show.bs.modal', function (event) {
            var modal = $(this)
            
			<?php
			if($campaigntype == "JP"){
			?>
			var msgstring = '<?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่').'</br>'.constant('สำเนาบัตรประจำตัวประชาชนของเจ้าของบัญชี').'</br>'.constant('สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ').'</br>'.constant('หนังสือมอบอำนาจ') ?>';
			<?php
			}else if($campaigntype == "OT"){
			?>
			var msgstring = '<?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่').'</br>'.constant('สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม').'</br>'.constant('สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ').'</br>'.constant('สำเนาหนังสือรับรองนิติบุคคล (อายุไม่เกิน 6 เดือน)').'</br>'.constant('หนังสือมอบอำนาจ') ?>';
			<?php
			}else{
			?>
			var msgstring = '<?php echo constant('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่') ?>';
			<?php
			}
			?>
          
           
            modal.find('#icon_modal_error').css('display','none');
			 modal.find('#icon_modal_success').css('display','block');
			 
			 modal.find('.btn_modal_has').css('display','block');
			 modal.find('.btn_modal_closemsg').css('display','none');
			 
            modal.find('.modal-title').text('');
            modal.find('.modal-body').prepend($(`
                    <div class="row">
                        <div class="col">
                            <div class="Bold text-left" style="font-size: 21px;">`+msgstring+`</div>
                        </div>
                    </div>`
                ));
            // modal.find('#one').          
            })
        $('#mainModal').modal('show')
});
function policy() {
    $('#modal-policy').on('show.bs.modal', function (event) {
            var modal = $(this)
            modal.find('.modal-title').text('ข้อกำหนดการใช้บริการและนโยบายความเป็นส่วนตัว')
            })
        $('#modal-policy').modal('show')
};
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


function recaptchaCallback() {
    // $('#makesession').prop('disabled', false);
    document.getElementById("makesession").style.display = "block";
};

</script>