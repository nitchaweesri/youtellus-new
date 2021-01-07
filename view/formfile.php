

<div class="form-group mt-4">
    <div class="row" style="width: 100%;">
        <div class="col mb-2 mt-2">
            <label for="exampleFormControlInput1"
                class="text-primary h2 Bold"><?php echo constant("เอกสารประกอบข้อร้องเรียน")?></label>
        </div>
    </div>

    <?php if(isset($file)) {?>
        <div class="row mx-auto" >
            <?php foreach ($file as $key => $value) { ?>
                <div class="col-3 p-2">
                    <div class="image-wrapper btn-outline-secondary" >
                        <img src="uploads/file/<?php echo $linkFile[$key]?>" alt="" style="cursor: default !important;"/>
                    </div>
                    <h7 class="Regular"><?php echo $value?></h7>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>
        <!-- <div class="row">
            <div class="col-12" id="">
                <div id="upload-btn" class="btn rounded-pill btn-outline-primary w-100 " >
                    <img src="public/img/upload.svg" class="d-inline text-primary" width="17px" alt=""> 
                    <div class="Regular d-inline ml-2">แนบไฟล์</div>
                </div>
            </div>
        </div> -->
        <div id="uploadmulti" >
            <div class="row mx-auto" >
                <?php for ($i=1; $i <= 4; $i++) { ?>
                    
                    <div class="col p-2">
                        <div  id="clear<?php echo $i ?>" class="close"  style="display: none;">
                            <span aria-hidden="true">&times;</span>
                        </div>
                        <div class="image-wrapper" >
                            <img  id="file<?php echo $i ?>" src="public/img/plus1.jpg" alt="" />
                        </div>
                    </div>
                    <?php if($i == 1){ ?>
                        <input oninvalid="invalid()" type="file" id="upload<?php echo $i ?>" name="file[]"  style="display: none;" required> 
                    <?php } else { ?>
                        <input type="file" id="upload<?php echo $i ?>" name="file[]"  style="display: none;"> 
                    <?php } ?>  

                <?php } ?>

            </div>
            <div class="row mx-auto" >
                <?php for ($i=5; $i <= 8; $i++) { ?>
                    
                    <div class="col p-2">
                        <div  id="clear<?php echo $i ?>" class="close"  style="display: none;">
                            <span aria-hidden="true">&times;</span>
                        </div>
                        <div id="test1" class="image-wrapper" >
                            <img id="file<?php echo $i ?>" src="public/img/plus1.jpg" alt="" />
                        </div>
                    </div>
                    <input type="file" id="upload<?php echo $i ?>" name="file[]"  style="display: none;"> 

                <?php } ?>

            </div>
        </div>
    <?php }?>
</div>


<script>


    // ---------------------------------Custom Input File------------------------------------


$("#upload-btn").click(function() {
    $("input[id='upload1']").click();
});

for (let i = 1; i <= 8; i++) {

    $("#file"+i).click(function() {
        $("input[id='upload"+i+"']").click();
    });

    //readURL -> public/js/uploadimage.js
    $("#upload"+i).change(function() {
        readURL(this,"#file"+i);
        $("#clear"+i).css("display", "block");
    });
    


    $("#clear"+i).on("click", function(){
        document.getElementById("file"+i).src = "public/img/plus1.jpg";
        $("#upload"+i).val('').clone( true );
        $("#clear"+i).css("display", "none");
    });

}

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




// if( document.getElementById("file1").files.length == 0 ){
// }


</script>