<!-- Modal -->
<style>
  .close{
    text-align: end;
    padding: 10px 20px 0 0 !important;
  }
</style>

<div class="modal fade" id="mainModal" tabindex="-1" aria-labelledby="mainModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content m-5 text-center">
        <img id="icon_modal_error" class="mx-auto" src="public/img/icon-warning.png" width="110px" style="margin-top:-50px;display:none" alt="">
        <img id="icon_modal_success" class="mx-auto" src="public/img/very-good.png" width="100px" style="margin-top:-50px;display:none" alt="">
        <div class="modal-header border-0 justify-content-center text-primary">
        <h3 class="modal-title Bold" id="exampleModalLabel">Modal title</h3>
        
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body border-0">
      </div>
      <div class="modal-footer border-0 justify-content-center" >
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
        <div class="row col-12">
                <div class="col btn_modal_has" id="one"> 
                    <a href="?page=home" id="upload-btn" class="btn rounded-pill btn-outline-primary Bold w-100" style="font-size: 20px;"><?php echo constant("ไม่มี")?></a>
                </div>
                <div class="col btn_modal_has" id="two">
                    <a id="upload-btn" class="btn rounded-pill btn-primary Bold w-100" data-dismiss="modal" aria-label="Close" style="font-size: 20px;"><?php echo constant("มี")?></a>
                </div>
				
				<div class="col btn_modal_closemsg" id="btn_closemsg">
                    <a class="btn rounded-pill btn-primary Bold w-100" data-dismiss="modal" aria-label="Close" style="font-size: 20px;">Close</a>
                </div>
          </div>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="modal-policy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-header border-0 justify-content-center text-primary" style="font-size: 16px; text-align: center;">
        <label class="modal-title Regular" id="exampleModalLabel">Modal title</label>
      </div>
      <div class="modal-body border-0">
        <p>These Terms and Conditions constitute a legally binding agreement made between you, whether personally or on behalf of an entity (“you”) and [business entity name] (“we,” “us” or “our”), concerning your access to and use of the [website name.com] website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto (collectively, the “Site”).</p>
        <p>You agree that by accessing the Site, you have read, understood, and agree to be bound by all of these Terms and Conditions. If you do not agree with all of these Terms and Conditions, then you are expressly prohibited from using the Site and you must discontinue use immediately.</p>
        <p>Supplemental terms and conditions or documents that may be posted on the Site from time to time are hereby expressly incorporated herein by reference. We reserve the right, in our sole discretion, to make changes or modifications to these Terms and Conditions at any time and for any reason.</p>
        <p>It is your responsibility to periodically review these Terms and Conditions to stay informed of updates. You will be subject to, and will be deemed to have been made aware of and to have accepted, the changes in any revised Terms and Conditions by your continued use of the Site after the date such revised Terms and Conditions are posted.</p>
        <p>Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the “Content”) and the trademarks, service marks, and logos contained therein (the “Marks”) are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws and various other intellectual property rights and unfair competition laws of the United States, foreign jurisdictions, and international conventions.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-clear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content m-5 text-center">
      <div class="modal-header border-0 justify-content-center text-primary">
        <!-- <h5 class="modal-title Regular" id="exampleModalLabel">Modal title</h5> -->
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body border-0 modal-clear Bold"  style="font-size: 21px;">
        หากกลับสู่หน้าเมนูหลักขั้นตอนทุกอย่างจะถูกยกเลิกและท่านจะต้องรับรหัส OTP ใหม่อีกครั้ง ต้องการจะกลับเมนูหลักหรือไม่
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary btn-clear-session" data-dismiss="modal"><?php echo constant("ยกเลิก")?></button>
        <a href="index.php?re_session=unset">
          <button type="button" class="btn btn-primary btn-clear-session"><?php echo constant("ยืนยัน")?></button>
        </a>
      </div>
    </div>
  </div>
</div>