<?php 
if(!isset($_SESSION['PHONENO']) || ($_SESSION['PHONENO'] != 1) ){?><script>window.location='?page=error';</script><?php exit();}
if(!isset($_SESSION['OTPVERIFIED']) || ($_SESSION['OTPVERIFIED'] != 1) ){?><script>window.location='?page=error';</script><?php exit();}

$scb_lang = strtoupper(isset($_SESSION['DEFINE_WEBLANGUAGE']) ? $_SESSION['DEFINE_WEBLANGUAGE'] : 'th');


$SQLStatement = "SELECT * FROM CONFIG_YTU_PRODUCT WHERE COMPLAINTCODE='JP' ORDER BY PRODUCTID";
$value = array();
$QueryResult = getQueryResult($conn, $SQLStatement, $value);
if($QueryResult['numrows'] <= 0){
	errorPage();
	exit();
}

$ProductList = $QueryResult['info'];

?>
<div class="container">
    <div class="p-2 mb-5 bg-white pd-top">
        <div class="row justify-content-center ">
            <div class="col-lg-7 col-md-10 col-sm-12 pt-lg-3 pt-md-3">
                <form
                    action="controllers/createcase.php"
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">

                    
                    <input type="hidden" name="feedtype" value="OC" >
                    <input type="hidden" name="lang" value="<?php echo $scb_lang?>" >
                    <input type="hidden" name="feedsubtype" value="JP" >



                    <?php if(isset($_POST['name'])){ ?>
                        <div class="form-group">
                            <p class="text-primary" style="font-size: 28px; text-align: center;">"<?php echo constant("กรุณาตรวจสอบข้อมูลก่อนกดยืนยัน")?>"</p>
                        </div>
                    <?php } ?>
 
                    <div class="row">
                        <div class="col mb-2">
                            <label for="exampleFormControlInput1" class="text-primary h2 Bold"><?php echo constant("ข้อมูลทั่วไป")?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="<?php echo constant("ชื่อบริษัท/ห้างหุ้นส่วน/องค์กร")?>" required
                            <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="numID" id="numID"
                            placeholder="<?php echo constant("เลขจดทะเบียนนิติบุคคล")?>" required
                            <?php echo $_POST['numID'] = isset($_POST['numID']) ?  " value='".$_POST['numID']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameAuthorizedPerson" id="nameAuthorizedPerson"
                            placeholder="<?php echo constant("ชื่อ-สกุลผู้มีอำนาจลงนาม")?>" required
                            <?php echo $_POST['nameAuthorizedPerson'] = isset($_POST['nameAuthorizedPerson']) ?  " value='".$_POST['nameAuthorizedPerson']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="position" id="position" placeholder="<?php echo constant("ตำแหน่งผู้มีอำนาจลงนาม")?>"
                            required
                            <?php echo $_POST['position'] = isset($_POST['position']) ?  " value='".$_POST['position']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input name="idcard" type="tel" id="idcard" maxlength="13" class="form-control Blod"
                            placeholder="<?php echo constant("หมายเลขบัตรประชาชนผู้มีอำนาจลงนาม")?>" required
                            <?php echo $_POST['idcard'] = isset($_POST['idcard']) ?  " value='".$_POST['idcard']."' readonly"  : "";  ?>
                            pattern="[0-9]{13}" oninput="valid_creditcard(this)">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameAttorneyPerson" id="nameAttorneyPerson"
                            placeholder="<?php echo constant("ชื่อ-สกุลผู้รับมอบอำนาจลงนาม")?>" required
                            <?php echo $_POST['nameAttorneyPerson'] = isset($_POST['nameAttorneyPerson']) ?  " value='".$_POST['nameAttorneyPerson']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input name="idcardAttorneyPerson" type="tel" id="idcardAttorneyPerson" maxlength="13" class="form-control Blod"
                            placeholder="<?php echo constant("หมายเลขบัตรประชาชนผู้รับมอบอำนาจลงนาม")?>" required
                            <?php echo $_POST['idcardAttorneyPerson'] = isset($_POST['idcardAttorneyPerson']) ?  " value='".$_POST['idcardAttorneyPerson']."' readonly"  : "";  ?>
                            pattern="[0-9]{13}" oninput="valid_creditcard1(this)">
                    </div>
                    <div class="form-group">
                        <input name="tel" type="tel" class="form-control Light" id="tel"
                            placeholder="<?php echo constant("หมายเลขโทรศัพท์ที่ติดต่อได้")?>" required
                            <?php echo isset($_SESSION['PHONENO']) ?  " value='".$_SESSION['PHONENO']."' readonly"  : "";?>
                            pattern="^0([8|9|6])([0-9]{8}$)">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="mail" placeholder="<?php echo constant("อีเมล")?>"
                            required
                            <?php echo $_POST['email'] = isset($_POST['email']) ?  " value='".$_POST['email']."' readonly"  : "";?>>
                    </div>
                
                    <div class="form-group mt-4">
                        <label for="textfeedsubtype" class="text-primary h2 Bold mb-3"><?php echo constant('เรื่องร้องเรียน')?></label>
                        <select <?php echo isset($_POST['textfeedsubtype'])? 'disabled': ''?>  name="textfeedsubtype" class="form-control Bold" id="exampleFormControlSelect1" required> 
                            <option value=""> <?php echo constant('เลือก');?></option>
                             <?php foreach ($ProductList as $key => $ProductInfo) {
                                if (isset($_POST['textfeedsubtype']) && $ProductInfo['PRODUCTCODE']== $_POST['textfeedsubtype']) {
                                    echo "<option selected='selected' value='".$ProductInfo['PRODUCTTITLE_'.$scb_lang]."'>".$ProductInfo['PRODUCTTITLE_'.$scb_lang]."</option>";

                                }else{
                                    echo "<option data-text='".$ProductInfo['PRODUCTTITLE_'.$scb_lang]."'  value='".$ProductInfo['PRODUCTTITLE_'.$scb_lang]."'>".$ProductInfo['PRODUCTTITLE_'.$scb_lang]."</option>";

                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="other"  <?php echo isset($_POST['other'])? '': 'style="display: none;"' ?>>
                        <input name="other" type="text" class="form-control Bold" id="other-input"
                            placeholder="<?php echo constant("อื่น ๆ (โปรดระบุ)")?>" 
                            <?php echo $_POST['other'] = isset($_POST['other']) ?  " value='".$_POST['other']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input name="complaintId" type="text" class="form-control Bold" id="complaintId" required
                            placeholder="<?php echo constant("ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน")?>" 
                            <?php echo $_POST['complaintId'] = isset($_POST['complaintId']) ?  " value='".$_POST['complaintId']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="serviceID" id="serviceID"
                            placeholder="<?php echo constant("หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน")?>" required
                            <?php echo $_POST['serviceID'] = isset($_POST['serviceID']) ?  " value='".$_POST['serviceID']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group mt-2">
                        <textarea name="problem" type="text" rows="4" maxlength="3000" class="form-control Bold " required
                            id="validationTextarea" placeholder="<?php echo constant("ปัญหาที่เกิดขึ้น")?>" 
                            <?php echo isset($_POST['problem']) ?  " readonly"  : "";?>><?php echo isset($_POST['problem']) ?  $_POST['problem']  : "";?></textarea>
                        <div id="characters-left" class="characters-left"></div>
                    </div>
                    <div class="form-group mt-2">
                        <textarea name="reqToBank" type="text" rows="4" maxlength="1000" class="form-control Bold " required
                            id="reqToBank" placeholder="<?php echo constant("สิ่งที่ต้องการให้ธนาคารดำเนินการ")?>" 
                            <?php echo isset($_POST['reqToBank']) ?  " readonly"  : "";?>><?php echo isset($_POST['reqToBank']) ?  $_POST['reqToBank']  : "";?></textarea>
                        <div id="characters-left1" class="characters-left"></div>
                    </div>
                    
                    <?php include 'formfile.php' ?>

                    <div class="row mt-4">
                        <div class="col">
                            <h5 class="Bold">
                                <?php echo constant("ธนาคารจะใช้ระยะเวลาดำเนินการในการตอบกลับคำร้องของท่านภายใน 15 วันนับจากวันที่ธนาคารได้รับเอกสารครบถ้วนและได้นำข้อร้องเรียนของท่านเข้าสู่ระบบ โดยธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า 02-777-7777")?>
                            </h5>
                            <h5 class="Bold">
                                <?php echo constant("หมายเหตุ: คำร้องหลัง 17.00 น. จะถูกส่งเข้าระบบในวันทำการถัดไป")?>
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col ">
                            <input type="submit" name="create_case"
                                class="btn btn-primary rounded-pill d-flex justify-content-center Bold col-12 btn-submit-form"
                                value="<?php echo constant("ส่งเรื่องร้องเรียน")?>">
                        </div>
                    </div>

                </form>
                <div class="btn-out">
                    <button class="button-clear" onclick="modalClear()"><img src="public/img/home.png" class="d-inline-block icon-home" loading="lazy"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

// $('select[name ="feedsubtype"]').on('change',function () {
//     $('input[name ="textfeedsubtype"]').val($('select[name ="feedsubtype"] :selected').data('text'));
//     }
// );

$(document).ready(function() {
    $('#idcard').on('keyup', function() {
        if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
            id = $(this).val().replace(/-/g, "");
            var result = Script_checkID(id);
            if (result === false) {
                $('#idcard').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#idcard').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $('span.error').removeClass('true').text('');
        }
    })

    $('#idcardAttorneyPerson').on('keyup', function() {
        if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
            id = $(this).val().replace(/-/g, "");
            var result = Script_checkID(id);
            if (result === false) {
                $('#idcardAttorneyPerson').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#idcardAttorneyPerson').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $('span.error').removeClass('true').text('');
        }
    })
});

function modalClear() {
    $('#modal-clear').on('show.bs.modal', function (event) {
        var modal = $(this)
            modal.find('.modal-title').text('Clear Session')        
        })
    $('#modal-clear').modal('show')
};

// ---------------------------------Custom Input File------------------------------------

function Script_checkID(id) {
    if (!IsNumeric(id)) return false;
    if (id.substring(0, 1) == 0) return false;
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12))) return false;
    return true;
}

function IsNumeric(input) {
    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    return (RE.test(input));
}


function valid_creditcard(obj) {
    var pattern_otp =
        /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    if (!obj.value.match(pattern_otp)) {
        obj.setCustomValidity('invalid');
    }
    if (obj.value.substring(0, 1) == 0) {
        obj.setCustomValidity('invalid');
    }
    if (obj.length != 13) {
        obj.setCustomValidity('invalid');
    }
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(obj.value.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(obj.value.charAt(12))) {
        obj.setCustomValidity('invalid');
    } else {
        obj.setCustomValidity('');
    }


    // obj.setCustomValidity(obj.value.match(pattern_otp)?"":"invalid");

}

function valid_creditcard1(obj) {
    var pattern_otp =
        /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    if (!obj.value.match(pattern_otp)) {
        obj.setCustomValidity('invalid');
    }
    if (obj.value.substring(0, 1) == 0) {
        obj.setCustomValidity('invalid');
    }
    if (obj.length != 13) {
        obj.setCustomValidity('invalid');
    }
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(obj.value.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(obj.value.charAt(12))) {
        obj.setCustomValidity('invalid');
    } else {
        obj.setCustomValidity('');
    }


    // obj.setCustomValidity(obj.value.match(pattern_otp)?"":"invalid");

}

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

// -------------------------------------------------------------------------------------


var textarea = document.getElementById('validationTextarea');
window.onload = textareaLengthCheck();

function textareaLengthCheck() {
    var textArea = textarea.value.length;
    var charactersLeft = 3000 - textArea;
    var count = document.getElementById('characters-left');
    count.innerHTML = "<?php echo constant("ระบุได้อีก")?>" + charactersLeft + "<?php echo constant("ตัวอักษร")?>";
}

textarea.addEventListener('keyup', textareaLengthCheck, false);
textarea.addEventListener('keydown', textareaLengthCheck, false);


var textarea1 = document.getElementById('reqToBank');
window.onload = textareaLengthCheck1();

function textareaLengthCheck1() {
    var textArea1 = textarea1.value.length;
    var charactersLeft1 = 1000 - textArea1;
    var count1 = document.getElementById('characters-left1');
    count1.innerHTML = "<?php echo constant("ระบุได้อีก")?>" + charactersLeft1 + "<?php echo constant("ตัวอักษร")?>";
}

textarea1.addEventListener('keyup', textareaLengthCheck1, false);
textarea1.addEventListener('keydown', textareaLengthCheck1, false);


// -------------------------------------------------------------------------------------

$("#exampleFormControlSelect1").change(function(){
    var select = $('#exampleFormControlSelect1 option');
    if(select.filter(':selected').text() == select.filter('option:last').text() ){
        $('#other').css("display", "block");
        $("#other-input").attr("required",true); 
    }else{
        $('#other').css("display", "none");
        $("#other-input").removeAttr("required"); 
    }
});

var select = $('#exampleFormControlSelect1 option');
if(select.filter(':selected').text() != select.filter('option:last').text() ){
    $('#other').css("display", "none");
    
}
</script>