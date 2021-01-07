<?php
	if(!isset($_SESSION['PHONENO']) ){?><script>window.location='?page=error';</script><?php exit();}
	if(!isset($_SESSION['CURSEL_CAMPAIGNTYPE']) ){?><script>window.location='?page=error';</script><?php exit();}
	if(!isset($_SESSION['OTPVERIFIED']) || ($_SESSION['OTPVERIFIED'] != 1) ){?><script>window.location='?page=error';</script><?php exit();}
	
	$PHONENO = $_SESSION['PHONENO'];
	$campaigntype = $_SESSION['CURSEL_CAMPAIGNTYPE'];
?>
<style>
    .menu {
        background-image: url("public/img/thankyou_smile.png");
        background-repeat: no-repeat;
        background-size: 200px;
    } 
</style>
<div style="height:80px"></div>
<div class="container menu mb-4 col-lg-7 col-md-12 col-sm-12" id="menu">
    <div class="row justify-content-end">
        <div class="col-8 ">
            <h3 class="text-secondary text-right mt-5 Regular mb-4"><?php echo constant('เมนูหลัก') ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h6 class="">

            </h6>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col mb-2">
	
<?php		
$SQLStatement = "SELECT * FROM YTU_REQFILE WHERE MOBILENO=? AND RECSTATUS=? AND EXPIRED_DT >= NOW() ORDER BY CASEID ASC";
$value = array($PHONENO, "A");
$QueryResult = getQueryResult($conn, $SQLStatement, $value);
if($QueryResult['numrows'] > 0){
	$PendingDocList = $QueryResult['info'];
	foreach($PendingDocList as $nDoc=>$DocInfo){
?>
			<div class="mt-3 mb-2">
				<a href="?page=pendingdocupload&CASEID=<?php print $DocInfo['CASEID'];?>"
							class="btn btn-lg btn-primary rounded d-flex justify-content-center Regular" style="color: #fff !important; padding: 17px;"><?php echo constant('อัพโหลดไฟล์เอกสาร');?> <?php echo constant('รหัสอ้างอิง');?> (<?php print $DocInfo['CASEID'];?>)</a>
			</div>
<?php
	}
}
	


?>	
            
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col ">
            <a href="?page=form_<?php print $campaigntype;?>"
                class="btn btn-lg btn-primary rounded d-flex justify-content-center Regular" style="color: #fff !important; padding: 17px;"><?php echo constant('ร้องเรียน') ?></a>
        </div>
    </div>
</div>