<div class="footer-main">
<div class="extra">
  <div class="extra-inner">
    <div class="container">

      <!--<strong ><span class="">Contact WOW! at:<span class="ar-right"><?php //echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package); ?></span></span>
          </strong>-->
      


      <style>

      .ar-right{
        position: relative;
        margin-left: 20px;
      }

      body .footer-inner{
        padding: 15px 0;
        font-size: 12px;
        background-color: rgb(204, 204, 204);
        color: #1d1d1d;
        background-size: cover;
        background-position: bottom;
      }

      .ar-right::before{
                content: "";
                position: absolute;
                bottom: 5px;
                left: 0;
                margin-left: -15px;
                width: 0;
                height: 0;
                border-top: 6px solid transparent;
                border-bottom: 6px solid transparent;
                border-left: 12px solid black;
      }

      .footer-main .extra-inner{
            font-size: 15px;
            color: black;
            background: #e5e5ea;
            font-weight: 600 !important;
            font-family: poppinsregular, sans-serif;
      }
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
          width: 80%;
    float: left;
    text-align: left;
    font-size: 12px !important;
   font-family: poppinsregular, sans-serif !important;
       }

       .footer-main .row2{
              width: 20%;
    float: right;
    text-align: right;
    font-size: 12px !important;
    font-family: poppinsregular, sans-serif !important;
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
            display: block;
          }
          .not-mob{
            display: none;
          }
          .footer-inner .span12{
            line-height: 20px;
            font-size: 18px !important;
          }
          .extra-inner .ar-right{
            display: block;
          }
          .extra-inner .ar-right::before{
            margin-left: -20px;
          }
       }

       .extra{
          border-top: none !important;
          border-bottom: none !important;
       }

       .footer {
            border-top: none !important;
        }

        .extra-inner{
          padding: 0px !important;
        }

</style>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /extra-inner --> 
</div>
<!-- /extra -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <!--<div class="row">
        <strong ><span class="span12" style="text-align: left !important;font-size: 20px !important;">Contact WOW! at:<span class="ar-right"><?php //echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package); ?></span></span>
          </strong>
      </div>-->
      <div class="row">
        <div class="span12"> 
        
          <div class="row1">

        &copy; 2019 Digicelgroup.com All Rights Reserved.

      </div>

      <div class="row2">

        <?php echo $db_class1->setVal('footer_copy','ADMIN'); ?>

      </div>
        
        </div>
        
        
        
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
</div>
<!-- /footer main --> 
