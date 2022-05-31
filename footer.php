<?php 

$footer_inner = 'layout/'.$camp_layout.'/views/footer_inner.php';

  if (($new_design=='yes') && file_exists($footer_inner)) {
        include_once $footer_inner;
  } 
  else{

 ?>

<div class="footer-main">
<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row">

        <?php
            $json = $db->setVal('footer_link','ADMIN');
            $objs = json_decode($json, true);
            //print_r($objs);

            $count = count($objs);
            $span = 12/$count;

            foreach($objs as $obj => $til){
                echo '<div class="span'.intval($span).'">';
                echo '<h4>'.$til[title].'</h4>';
                echo '<ul>';
                //print_r($til[link_list]);
                foreach($til[link_list] as $key => $value){
                    //print_r($value);
                    echo '<li><a href="'.$value[link].'">'.$value[name].'</a></li>';
                }
                echo '</ul>';
                echo '</div>';
            }



        ?>


<style>
       .faq_link{
       	color:#e9e9e9 !important;
       } 
</style>
<?php
//print_r($access_modules_list);
 if(in_array('faq',$access_modules_list)){
?>
                    <div class="span5">
                        <h4>
                        <?php 
                        
                        //$footerq="SELECT * FROM `exp_footer` WHERE `distributor`='$mno_id'";
                        
                        //$footer_results1=mysql_query($footerq);
                        
//                         while($rowf=mysql_fetch_array($footer_results1)){
                        	 
//                         	$editftype=$rowf[footer_type];
//                         	$editgtitle=$rowf[group_title];
//                         	$editlinktitle=$rowf[link_title];
//                         	$editfurl=$rowf[url];
                        	                         	 
//                         }
                        
                        //$num_rows = mysql_num_rows($footer_results1);
                        
						 if($num_rows>0){?>    
                        
                        <?php
                        //echo $editgtitle;
                        
                        ?>
                        </h4>
                        <ul>
                        
                        <!--<li><a class="faq_link" href="<?php //echo $editfurl; ?>"><?php //echo $editlinktitle; ?></a></li>  -->
                            
                        </ul>
                        
                        
                        <?php }else{ ?>
     					<!-- Need Help -->
                             
                        </h4>
                        <ul>
                           <!-- <li><a class="faq_link" href="faq<?php //echo $extension; ?>">FAQ</a></li> --> 
                        </ul>                   
                        
                        
                        <?php }?>
                    </div>

<?php }  ?>

<!-- 
                    <div class="span4">
                        <h4>
                            Support
                        </h4>
                        <ul>
                            <li><a href="javascript:;">Submit A Ticket</a></li>
                            <li><a href="javascript:;">Live Chat</a></li>
                        </ul>
                    </div>
 -->
                </div>
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
      <div class="row">
        <div class="span12"> 
        

        <?php echo $db->setVal('footer_copy','ADMIN'); ?>
        <!-- 
        <br>The use of this platform is granted as per acceptance of the <a href="javascript:void();" onclick="preview_popup();">
        <?php // echo $db->textTitle('AGREEMENT','ADMIN'); ?>
        </a> of the platfrom trial agreement during the account verification and activation process.
         -->
        
        </div>
        
        
        
         <script type="text/javascript"> 
   
		function preview_popup(){ //2
			
		$(document).ready(function() {
		   		
		
		         $.fancybox({
		            width: '70%',
		            height: '90%',
		            //'autoScale': true,
					// 'fitToView' : false,
		            //'transitionIn': 'fade',
		            //'transitionOut': 'fade',
					href: 'agreement.php?',
		            type: 'iframe',
					padding : 5
					
		
		        });
		
		        return false;
		    });
		
		}
		
		
		
		</script>
        
        
        
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

<?php } ?>

