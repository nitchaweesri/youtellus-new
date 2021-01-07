<?php
	include "processcleansession.php";
?>

<style>
    @media (min-width: 992px){
        .lg-custom-thanks {
            padding: 0 25% !important;
        }
    }
    #main-thanks {
        background-image: url(public/img/bg-thanks.png);
        background-repeat: no-repeat;
        background-size: 245px;
        height: 100vh;
        background-position-x: right;
        background-position-y: bottom;
        padding-top: 45px;
    }
    h2{
        font-family: 'Mitr-Medium' ,Fallback, sans-serif;
    }
    h5,a{
        font-family: 'Mitr-Regular', Fallback, sans-serif;
    }
    #finish{
        text-decoration: revert;
        font-family: 'Kittithada-Bold';
        font-size: 25px;
    }
    .footer-thanks {
        text-align: center;
        position: absolute;
        bottom: 0;
        width: 100%;
        font-family: 'Mitr-Regular';
        font-size: 13px;
        padding-bottom: 6px;
        color: #495057;
        background-color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 58px;
        padding: 0 10px;
    }
    .txt-bottom-thanks{
        font-size: 17px;
        margin-bottom: 3px;
        font-weight: 800;
        font-size: 24px;
    }

    .txt-thanks-topic{
        font-family: 'Kittithada-Bold';
        font-size: 52px;
    }
    .txt-thanks{
        font-family: 'Kittithada-Bold';
        font-size: 28px;
    }

</style>

    <div class="container col-lg-6 col-md-12 col-sm-12" id="main-thanks">
        <div class="row mt-4">
            <div class="col">
                <h2 class="text-primary text-center txt-thanks-topic"><?php echo constant('ขอบคุณค่ะ') ?></h2>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <h5 class="text-primary text-center txt-thanks"><?php echo constant('เราได้รับข้อมูลของคุณเรียบร้อยแล้ว') ?></h5> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="index.php?page=home" class="text-primary d-flex justify-content-center" id="finish"><?php echo constant('กลับหน้าแรก') ?></a>
            </div>
        </div>
    </div>
    <div>
        <footer class="footer-thanks lg-custom-thanks">
                <img src="public/img/icon.png" height="33" class="d-inline-block align-top" loading="lazy">
                <p class="text-primary txt-bottom-thanks" style="margin-bottom: 3px;"><?php echo constant('ทุก ๆ ความคิดเห็น ...เป็นเรื่องสำคัญ') ?></p>
        </footer>
    </div>
