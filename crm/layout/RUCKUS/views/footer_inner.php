<div class="bottom-foot">
  
</div>
<div class="footer-main">
<div class="footer-inner">
  <div class="container">
    <?php 

if($user_type=='MVNO_ADMIN'){
  //Get lates property verticle
  $vertical = $db_class1->getValueAsf("SELECT bussiness_type as f FROM exp_mno_distributor WHERE parent_id='$user_distributor' ORDER BY id DESC LIMIT 1");
}else{
  $vertical = $property_business_type;
}

// echo $vertical;
// echo $mno_id.'****';
$vertical_footers = json_decode($db->setVal('VERTICAL_FOOTER', $mno_id));

if(isset($vertical_footers->$vertical)){
?>


                    
                      <a class="call" >
                      <span ><?php echo $vertical_footers->$vertical; ?></span>

                    
<?php
}else{
  ?>

                    <span class="contact">Connect with us</span>

                    
                      <a class="call" >
                      <span class="glyph glyph-phone"></span>
                      <span >&nbsp;Call</span>&nbsp;&nbsp;
                      </a><a class="number" href="tel:<?php echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type); ?>%20%20"><?php echo $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type); ?></a>
                      

                      <!-- <div class="footer-live-chat-link">
                      <a href="#" > <span class="glyph glyph-chat"></span> <span>&nbsp;Live Chat</span>&nbsp;&nbsp;</a>
                    </div> -->

                    


  <?php
}

?>
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
