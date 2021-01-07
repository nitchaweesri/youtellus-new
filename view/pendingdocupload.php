<?php 
	if(!isset($_SESSION['PHONENO']) ){?><script>window.location='?page=error';</script><?php exit();}
	if(!isset($_SESSION['CURSEL_CAMPAIGNTYPE']) ){?><script>window.location='?page=error';</script><?php exit();}
	if(!isset($_SESSION['OTPVERIFIED']) || ($_SESSION['OTPVERIFIED'] != 1) ){?><script>window.location='?page=error';</script><?php exit();}
	
	$PHONENO = $_SESSION['PHONENO'];
	
	
	$tmpCASEID = $_REQUEST['CASEID'];
	$CASEID = -1;
		
	$SQLStatement = "SELECT * FROM YTU_REQFILE WHERE CASEID = ? AND MOBILENO=? AND RECSTATUS=? AND EXPIRED_DT >= NOW() ORDER BY CASEID ASC";
	$value = array($tmpCASEID, $PHONENO, "A");
	$QueryResult = getQueryResult($conn, $SQLStatement, $value);
	if($QueryResult['numrows'] <= 0){
		errorPage();
		exit();
	}
	$PendingDocInfo = $QueryResult['info'][0];
		
	$CASEID = $PendingDocInfo['CASEID'];
	$FILEDESC = $PendingDocInfo['FILEDESC'];
			
			
	$fileReq = explode("|",$FILEDESC);
?>
<style>
button {
    font-family: 'Mitr-Regular';
}

.topic {
    font-family: 'Mitr-Medium';
    font-size: 20px;
    margin: 0;
}

.detail {
    font-family: 'Mitr-Light';
    font-size: 14px;
}

.form-list {
    /* border-bottom: 1px solid #cecece; */
    padding-bottom: 25px;
    padding-top: 12px;
}
.div-files{
    margin-top: 25px;
}
</style>


<div class="container p-3 mb-5 bg-white pd-top">
    <form id="FRM_UPLOAD_PENDINGDOC" 
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">
		<input type="hidden" name="CASEID" value="<?php print $CASEID;?>"/>
		<input type="hidden" name="FILEDESC" value="<?php print $FILEDESC;?>"/>
        <div class="form-list">
            <p class="topic text-primary"><?php echo constant('อัพโหลดไฟล์เอกสารเพิ่มเติม') . " " . constant('รหัสอ้างอิง') . " " . $CASEID; ?></p>
            <?php foreach ($fileReq as $nFile=>$value) { ?>
                <div class="div-files">
                    <p class="detail text-primary"><?php echo(constant($value)) ?></p>
                    <div class="form-group">
					<?php /*
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile_<?php print $value;?>" name="customFile_<?php print $value;?>">
                            <label class="custom-file-label" for="customFile_<?php print $value;?>">Choose file</label>
                        </div>
						*/?>
						
							<div class="col p-2" style="max-width:180px;">
								<div  id="clear<?php echo $nFile; ?>" class="close"  style="display: none;">
									<span aria-hidden="true">&times;</span>
								</div>
								<div class="image-wrapper" >
									<img  id="file<?php echo $nFile; ?>" src="public/img/plus1.jpg" alt="" />
								</div>
							</div>
							<input type="file" id="upload<?php echo $nFile ?>" name="customFile_<?php print $value;?>"  style="display: none;"> 

					
                    </div>
                </div>
            <?php } ?>
        </div>
       
    </form>
	
		 <button  class="btn btn-primary" id="BTN_UPLOAD_PENDINGDOC"><?php print constant('อัพโหลด');?></button> 
		 
	<div id="DIV_UPLOAD_RESULT"></div>

</div>

<script>

$("#upload-btn").click(function() {
    $("input[id='upload1']").click();
});

<?php
	foreach ($fileReq as $nFile=>$value) {
?>

    $("#file<?php print $nFile;?>").click(function() {
        $("input[id='upload<?php print $nFile;?>']").click();
    });

    //readURL -> public/js/uploadimage.js
    $("#upload<?php print $nFile;?>").change(function() {
        readURL(this,"#file<?php print $nFile;?>");
        $("#clear<?php print $nFile;?>").css("display", "block");
    });
    


    $("#clear<?php print $nFile;?>").on("click", function(){
        document.getElementById("file<?php print $nFile;?>").src = "public/img/plus1.jpg";
        $("#upload<?php print $nFile;?>").val('').clone( true );
        $("#clear<?php print $nFile;?>").css("display", "none");
    });


<?php
}
?>


function readURL(input, which) {

    ValidateSingleInput(input); // public/js/uploadimage.js

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var file = input.files[0];
        var filsSize = file.size / 1000000;
        var fileSizeAllow = '<?php  echo FILE_SIZE_ALLOW?>' / 1000000;
        reader.onload = function (e) {
            if (filsSize > fileSizeAllow) {
                // alert(filsSize)
                $('#mainModal').on('show.bs.modal', function (event) {
                    var modal = $(this)
                    modal.find('#error').css('display','block')
                    modal.find('.modal-title').text('Error').addClass("text-danger")
                    modal.find('.modal-body').html($(` 
                <div class="row">
                    <div class="col">
                        <div class="Bold" style="font-size: 19px;"><?php print constant("ERR_FILESIZEEXCEED");?> (` + fileSizeAllow + `MB)</div>
                    </div>
                </div>`
                    ));
                    modal.find('.modal-footer').text('')
                });
                $('#mainModal').modal('show')


            } else if (filsSize <= fileSizeAllow) {
                $(which).attr('src', e.target.result);
                $('#upload-btn').css("display", "none");
                $('#uploadmulti').css("display", "block");
                $('#file1').css({'border':'1.7px solid #28a745'});
            }

        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}




function ValidateSingleInput(oInput) {


    var extensionAllow = '<?php echo json_encode(EXTENSION_ALLOW) ?>'.replace('[','').replace(']','').replace(/['"]+/g, '');
    var _validFileExtensions = extensionAllow.split(",");

    

    if (oInput.type == "file") {
        var sFileName = oInput.value;

        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = '.'+_validFileExtensions[j];

                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                // alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));

                $('#mainModal').on('show.bs.modal', function (event) {
                    var modal = $(this)
                    modal.find('#error').css('display','block')
                    modal.find('.modal-title').text('Error').addClass("text-danger")
                    modal.find('.modal-body').html($(` 
                        <div class="row">
                            <div class="col">
                                <div class="Bold" style="font-size: 19px;"><?php print constant("ERR_INVALIDFILETYPE");?></div>
                            </div>
                        </div>`
                    ));
                    modal.find('.modal-footer').text('')
                });
                $('#mainModal').modal('show')

                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}


function invalid() {
    $('#file1').css({'border':'1.7px solid #dc3545'});

}

	
	$("#FRM_UPLOAD_PENDINGDOC").submit(function(e)
	{
		$("#DIV_UPLOAD_RESULT").html(".... Please Wait ....");

		var formObj = $(this);
		var formURL = "controllers/uploadpendingdoc.php";
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
				$("#DIV_UPLOAD_RESULT").html(jqXHR.responseText);
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert('request failed ' + textStatus + "--" + errorThrown + "----" + jqXHR.responseText);
			}          
		});
		e.preventDefault(); //Prevent Default action. 
		//e.unbind();
	}); 
	

	$('#BTN_UPLOAD_PENDINGDOC').click(function(){
		$("#FRM_UPLOAD_PENDINGDOC").submit(); //Submit the form
	});

/*	
	$("#FRM_UPLOAD_PENDINGDOC").submit(function(e)
	{
		$("#DIV_UPLOAD_RESULT").html(".... Please Wait ....");
alert('1');
		var formObj = $(this);
		var formURL = "controllers/uploadpendingdoc.php";
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
				$("#DIV_UPLOAD_RESULT").html(jqXHR.responseText);
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert('request failed ' + textStatus + "--" + errorThrown + "----" + jqXHR.responseText);
			}          
		});
		e.preventDefault(); //Prevent Default action. 
		//e.unbind();
	}); 
*/
</script>