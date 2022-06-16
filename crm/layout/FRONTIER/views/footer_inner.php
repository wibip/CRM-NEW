<div class="footer-main">
<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row1">

        <?php echo $db_class1->setVal('footer_copy','ADMIN'); ?>

      </div>

      <div class="row2">

        &copy; <?php
          $d = new DateTime('now');
          echo $d->format('Y');
          ?> Frontier Communications Corporation. All rights reserved.

      </div>


      <style>
       .faq_link{
        color:#e9e9e9 !important;
       } 
       .footer-inner .span12{

          font-size: 26px !important;
          font-family: Regular !important;
          text-align: center;
          line-height: 40px;
       }

       .footer-main .row1{
          width: 20%;
          float: left;
          font-size: 12px !important;
          font-family: Regular !important;
       }

       .footer-main .row2{
          width: 80%;
          float: right;
          text-align: right;
          font-size: 12px !important;
          font-family: Regular !important;
       }

       .not-mob{
        display: inline-block;
       }

       .mob{
        display: none;
       }

       @media (max-width: 979px){
          .footer-main .row1, .footer-main .row2{
            width: 100%;
            text-align: left;
            float: left;
            padding-bottom: 5px;
          }
          .mob{
            /*display: block;*/
          }
          .not-mob{
            display: none;
          }
          .footer-inner .span12{
            /*line-height: 20px;*/
            font-size: 18px !important;
          }
       }

       @media (max-width: 520px){
        .footer-inner .span12{
            line-height: 20px;
            font-size: 18px !important;
          }
       }

</style>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /extra-inner --> 
</div>
<!-- /extra -->
</div>
<!-- /footer main --> 
