<div class="bottom-foot">
  
</div>
<div class="footer-main">
<div class="footer-inner">
  <div class="container">
                  <span class="contact">Connect with us</span>

                    
                      <a class="call" >
                      <span class="glyph glyph-phone"></span>
                      <span >&nbsp;Call</span>&nbsp;&nbsp;
                      <!-- </a><a class="number" href="tel:1-866-611-3434%20%20">1-866-611-3434  </a> -->
                      </a><a class="number" href="tel:<?php echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type); ?>%20%20"><?php echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type); ?></a>

                      <!-- <div class="footer-live-chat-link">
                      <a href="#" > <span class="glyph glyph-chat"></span> <span>&nbsp;Live Chat</span>&nbsp;&nbsp;</a>
                    </div> -->

                    <div class="footer-version">
                       <?php echo $db_class1->setVal('footer_copy','ADMIN'); ?>
                    </div>
                  
                 </div>
                 </div>
</div>

<style type="text/css">
  .footer-version{
    float: right;
  }

  @media (max-width: 767px){
    .footer-version{
      float: none;
      margin-top: 12px;
    }
  }
</style>
