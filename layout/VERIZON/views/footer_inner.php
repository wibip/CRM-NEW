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
        background: #000;
        color: #7A7A7A;
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
            font-family: ars-maquette-web, sans-serif;
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
          width: 30%;
    float: left;
    text-align: right;
    font-size: 12px !important;
    font-family: ars-maquette-web, sans-serif !important;
       }

       .footer-main .row2{
              width: 15%;
    float: right;

    font-size: 12px !important;
    font-family: ars-maquette-web, sans-serif !important;
       }

       .not-mob{
        display: inline-block;
       }

       .mob{
        display: none;
       }

       @media (max-width: 979px){
          .footer-main .row1, .footer-main .row2{
            width: 90%;
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

         @media (max-width: 520px){
            .footer-main .row1{
                margin-left: 0px !important;
            }
            .footer-main .row2{
                margin-left: 0px !important;
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
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <!--<div class="row">
        <strong ><span class="span12" style="text-align: left !important;font-size: 20px !important;">Contact WOW! at:<span class="ar-right"><?php //echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package); ?></span></span>
          </strong>
      </div>-->
      <div class="">
        <div class=""> 
        
          <div class="row1" style="margin-left: 20px">

        &copy; Verizon <?php
                $d = new DateTime('now');
                echo $d->format('Y');
              ?>
              &nbsp;&nbsp;&nbsp;<span><a href="https://www.verizon.com/about/privacy/privacy-policy-summary">Privacy Policy</a></span>
              &nbsp;&nbsp;&nbsp;<span><a href="https://www.verizonwireless.com/support/my-verizon-terms/">Terms & Conditions</a></span>

      </div>

      <div class="row2" style="margin-left: 20px">

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
