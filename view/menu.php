<?php 
//include 'controllers/case.php';
//$result = ytu_complainttype();
// session_start();

include "processcleansession.php";

$SQLStatement = "SELECT * FROM CONFIG_YTU_COMPLAINTTYPE ORDER BY SORTINGDESCVAL DESC";
$value = array();
$QueryResult = getQueryResult($conn, $SQLStatement, $value);
if($QueryResult['numrows'] <= 0){
	errorPage();
	exit();
}

$ComplaintTypeList = $QueryResult['info'];

?>
<style>
.bt-unset {
    position: absolute;
    bottom: 0px;
    right: 0px;
}

a.textunset {
    color: #EEE;
    text-decoration: none;
    background-color: transparent;
    text-transform: none;
}
</style>
<div style="height:70px"></div>
<div class="container mb-4 col-lg-6 col-md-12 col-sm-12" id="menu">
    <div class="row justify-content-end">
        <div class="col-lg-8 col-md-11 col-sm-11" style="height: 195px; padding: 70px 15px;">
            <h1 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('กรุณาระบุ')?> </h1>
            <h1 class="text-secondary text-right Bold txt-menu-topic"><?php echo constant('ประเภทการร้องเรียน')?> </h1>
        </div>
    </div>
    <div class="container-btn-menu">
        <?php
        foreach ($ComplaintTypeList as $key => $value) {
            $page_vl = $value['COMPLAINTCODE'];
            $name_vl = $value['COMPLAINTTITLE_'.strtoupper(isset($_SESSION['DEFINE_WEBLANGUAGE']) ? $_SESSION['DEFINE_WEBLANGUAGE'] : 'th')];
        ?>
        <div class="row mt-3 justify-content-md-center justify-content-sm-center">
            <div class="col-lg-11 col-md-8 col-sm-10 mb-2">
                <a 
                    class="btn btn-lg rounded d-flex justify-content-center Bold btn-menu suw-btn-seltype" data-campaigntype="<?php print $page_vl;?>">
                    <?php echo $name_vl?>
                </a>
            </div>
        </div>


        <?php } ?>
    </div>


</div>

<?php
	include "view/errormsg.php";
?>


<script>
	$('.suw-btn-seltype').click(function(){
		var campaigntype = $(this).data('campaigntype');
		window.location='?page=verify&campaigntype=' + campaigntype;
	});
	
	
<?php
	if(strlen($errormsg)>0){
		if($errormsg == "banphone"){
			$BANPERIOD = 0;
			if(isset($_REQUEST['BANPERIOD'])){
				if(is_numeric($_REQUEST['BANPERIOD'])){
					$tmpBANPERIOD = $_REQUEST['BANPERIOD'] + 1;
					$BANPERIOD = intval($tmpBANPERIOD-1);
				}
			}
			
			$DISPERRORMSG  = constant('กรุณารอ แล้วจึงทำรายการใหม่อีกครั้ง');
			$DISPERRORMSG = str_replace("[SUW]", gmdate("i:s", $BANPERIOD), $DISPERRORMSG);
		}else{
			$DISPERRORMSG = constant('errormsg_' . $errormsg);
		}
?>
$(document).ready(function() {
	$('#mainModal').on('show.bs.modal', function (event) {
		var modal = $(this)
		
		var msgstring = '<?php echo $DISPERRORMSG; ?>';
	   
		modal.find('#icon_modal_error').css('display','block');
		modal.find('#icon_modal_success').css('display','none');
	 
		modal.find('.btn_modal_has').css('display','none');
		modal.find('.btn_modal_closemsg').css('display','block');
	 
		modal.find('.modal-title').text('');
		modal.find('.modal-body').prepend($(`
				<div class="row">
					<div class="col">
						<div class="Bold text-left" style="font-size: 21px;">`+msgstring+`</div>
					</div>
				</div>`
			));       
	});
	$('#mainModal').modal('show');
});
<?php
	}
?>
</script>
