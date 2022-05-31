
<style type="text/css">

.mainnav ul li.subLi{
	color: #b7b7b7;
    padding: 8px 12px;
    padding-bottom: 10px;
    font-family: NHGrotesk-reg,helvetica,arial,sans-serif;
    font-size: 12px;
    font-weight: normal;
    border: none;
    line-height: 15px;							
	}
	hr.divid{
		background: #a9a9a9;
		border:none;
		height: 1px;
		margin-top: 5px;
		margin-left: 20px;
		margin-right: 20px;
		margin-bottom: 0px;
	}
	.mainnav ul li.subLi div{
		/* margin-left:10px; */
		word-break: break-word;
	}
	.mainnav ul li.subLi div::before {
		/* content: "\f0a4";
		font-family: FontAwesome;
		margin-right: 5px; */
	}

	/*imported from introPage*/

 html{
 	min-height: 100%;
    position: relative;
 }

 body {
    margin-bottom: 70px;
    background-color: #e9e9e9;
}

.footer-main .extra {
    position: absolute;
    bottom: 0;
    width: 100%;
    margin-bottom: 71px;
}

.footer-main .footer {
    position: absolute;
    bottom: 0px;
    width: 100%;
    
}

.widget{
	margin-bottom: 0px;
}

 .form-actions{
 	background-color: transparent;
    border-top: 1px solid #fff;
	margin-top: 0px;
	padding-left: 0px !important;
 }

    @supports (-webkit-overflow-scrolling: touch) { /* CSS specific to iOS devices */ body{ cursor:pointer; } }

 
 .main .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]){
    background: #d9d9d6;
    margin-bottom: 20px;

    <?php if($introMnoPage=='NO'){ ?>
	margin-top: 60px; 
	<?php } ?>
        /*border-bottom: 3px solid #0066e3;*/
}

.main .nav-tabs{
	background: #fff;
	width: 960px ;
    margin: auto;
    box-sizing: border-box;
    /*text-align: center;*/
    padding-left: 0px ;
}


.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]), #myTabContentDASH {
	width: auto;
}

.nav-tabs>li{
	display: inline;
	float: none ;
}

#myTabDash li>a{
	margin-right: 0px ;
}

.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li>a{
	display: inline-block;
    float: none ;
    border-left: 1px solid #6d6e6f;
    padding: 35px;
    margin-right: -4px;
    background: none ;
    color: #000 ;
    border-radius: 0px 0px 0 0 ;
}

  .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li.active>a::before{
    content: "";
    width: 0px;
    height: 0px;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    position: absolute;
    bottom: -12px;
    left: 50%;
    margin-left: -10px;
    border-top: 12px solid #b7b7b7;
    display: none;
  }

.nav-tabs>li>a{
	display: inline-block;
    float: none ;
}

body .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>.active>a, body .nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>.active>a:hover{
	border-left: 1px solid #6d6e6f;
	background-color: transparent ;
        position: relative;
        color: #0066e3 ;
}
.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-last-child(1)>a{
	border-right: 1px solid black;
}

h1.head {
    padding: 50px;
    width: 100% !important;
    margin: auto;
    font-size: 43px;
	text-align: left;
	padding-left: 18px;
    color: #000;
    font-family: 'NHaasGroteskDSStd-75Bd' ;
    box-sizing: border-box;
}

h1.head span{
	    display: inline-block;
}

h1.head span:nth-child(1){
	    margin-left: -10px;
}

.alert {
	box-sizing: border-box;
}


@media (max-width: 979px) and (min-width: 768px){

}

@media (max-width: 767px){
	.extra, .footer {
	    margin-right: 0px ;
	    margin-left: 0px ;
	}

	input.span5, textarea.span5, .uneditable-input.span5, input[class*="span"], div[class*="span4"], select[class*="span"], textarea[class*="span"], .uneditable-input{
		width: 280px ;
	}

	.footer-inner .container{
		text-align: center;
	}

	.footer-inner .contact{
		display: block;
        margin: auto;
        margin-bottom: 10px;
	}

}



@media (max-width: 480px){

	.footer-live-chat-link{
		margin-left : 0px ;
		display: block ;
		margin-top: 8px;
	}

	html{
		    overflow-x: hidden;
	}
	.parent_intro .intro-content p{
		font-size: 15px ;
	}

	.intro-content{
    padding-right: 50px ;
	}

	.resize_charts{
		    margin-left: -20px ;
           margin-right: -20px ;
    }

    .tree_graph{
    	padding-left: 0px 
    }

    h1.head{
    	    padding-right: 25px ;
    	    padding-left: 25px ;
    }

}
@media (max-width: 341px){
	.footer-inner{
		padding-bottom: 0px ;
    	padding-top: 5px ;
	}
}


@media (max-width: 979px){


	.form-horizontal .form-actions{
		margin: auto;
    padding-left: 0px;
    padding-right: 0px
	}

	body div.inline-btn, body select.inline-btn, body input.inline-btn, body button.inline-btn, body a.inline-btn{
		margin-left: 0px ;
    	margin-top: 5px ;
    	    display: block ;
	}

	.alert {
	    top: 21px ;
	    box-sizing: border-box;
	}


	 .main .nav-tabs{
		width: 100%;
		
    	left: 0;
    	z-index: 801;

	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li>a{
		padding: 0px ;
	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-last-child(1)>a{
		border-right:none;
	}
	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li:nth-child(1)>a{
		border-left:none;
	}

	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"])>li.active>a::before{
		display: none;
	}

	.logo_img{
		/*max-width: 70% ;
		margin-top: 5px;*/
	}

	#myTabDash, #myTabContentDASH{
		margin-left: 0px ;
	}
	.nav-tabs:not(.zg-ul-select):not(#myQuickTab):not([id^="myTabDASHBO"]), #myTabContentDASH {
	width: 100% ;
}

	.main .cf .nav-tabs{
		width: 150px;
    	position: absolute;
    	margin-right: 0px;
    	top: 25px;
    	right: -15px;
	}

	#myTabContentDASH .widget-header{
		left: -28px;
	}

	h1.head{
    	width: auto;
    	padding-top: 10px ;
    	    font-size: 28px ;
	}

	.form-horizontal .controls{

		
    	margin: auto;
	}

	.tab-pane{
		padding-top: 20px ;
	}

	#myTabContentDASH .widget, .stat{
		margin-bottom: 0px ;
	}

	.tab-content .nav-tabs>li>a, .tab-content .nav-pills>li>a{
		padding-right: 0px ;
		padding-left: 0px ;
	}

	.main .cf .nav-tabs:not(#myQuickTab){
		margin-top: 0px ;
	}
}


.intro-content p{
		color: #000000;
		font-weight: bold ;
	}

 	.intro-content a{
 		    font-size: 18px;
    bottom: 15px;
 	}

 	.intro-content{
 		position: absolute;
 	}


@media (min-width: 980px){
	.subnavbar{
		    position: fixed;
    		top: 0px;
    		width: 100%;
    		z-index: 99999999999999999999;
	}

	.intro_page{
    z-index:-1;
	}

}

.subnavbar .dropdown .dropdown-menu{
	    border-radius: 0px;
    border: 1px solid #fff;
}

.subnavbar .dropdown .dropdown-menu a{
    color: #fff ;
}

.main .fixed-nav{
	position: fixed;
	padding-bottom: 15px;
	padding-top: 15px;
	top: 105px;
	border-top: 1px solid #fff;
	border-bottom: none;
	z-index: 2222;
}

.mainnav ul{
	box-shadow: rgba(0, 0, 0, 0.173) 0px 6px 12px 0px;
	    width: auto;
    text-align: left;
    box-sizing: border-box;
    min-width: 100%;
    padding-top: 10px;
    padding-bottom: 10px;
    height: auto;
}

.mainnav ul li{
	float: none ;
	/*padding: 10px 15px;*/
	margin-top: 0px ;
}

/*iend of mported from introPage*/

	.no_arrow .glyph-angle-down{
		display: none;
	}
	@media (max-width: 979px){
		.navbar-fixed-top {
			display: block !important;
		}

		.navbar.navbar-fixed-top .btn, .navbar.navbar-fixed-top .btn-group{
			margin-top: 8px !important;
		}
    
    .dropdown-menu li a{
        font-size: 25px !important;
        font-weight: normal !important;
        font-family: "NHaasGroteskDSStd-75Bd";
        white-space: nowrap;
        padding-bottom: 8px !important;
        padding-top: 8px !important;
    }
    .dropdown-toggle{
        font-size: 25px !important;
        font-family: "NHaasGroteskDSStd-75Bd";
    }

    .nav .dropdown-toggle .icon-user{
        display: none !important;
    }

    .navbar-fixed-top, .navbar-inner{
     
    }
	}

  @media screen and (max-width: 979px) and (min-width: 521px) {
    .logo_img{
      max-height: 100px !important;
      max-width: 115px !important;
	  margin-top: 0px !important;
	  padding: 5px 8px 11px !important;
    }

    .newTabs{
      margin-top: 20px !important;
    }
}

@media screen and (max-width: 767px) and (min-width: 521px) {

}

@media (max-width: 979px){
  .logo_img{
      max-height: 100px !important;
      max-width: 115px !important;
	  margin-top: 0px !important;
	  padding: 5px 8px 11px !important;
    }
}

	.subnavbar .dropdown-menu::before, .subnavbar .dropdown-menu::after{
		content: none ;
	}
	.dropdown{
		display: table;
    
	}

	.subnavbar .dropdown .dropdown-toggle{
		    vertical-align: middle;
    padding-left: 30px;
    display: table-cell;
   /* background : url('layout/<?php //echo $camp_layout ?>/img/user2.png');*/
    background-size: 22px;
    background-repeat: no-repeat ;
    background-position: 0px 16px ;
    margin-top: 0px ;
    position: relative;
    padding-right: 20px;
	}

	.glyph-angle-down:before {
    content: "\eA12";
}



	.dropdown .glyph{
        position: absolute;
		top: 25px;
		right: 0;
		display: inline-block ;
		line-height: 60px;
	}

.glyph{
        position: relative;
    top: 5px;
    display: inline-block;
    font-family: 'glyphs';
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    margin-right: -10px;
}

.subnavbar .container>ul>li>a:hover{
  color: #000;
}

.subnavbar .container>ul>li>ul{
  margin-left: 0px !important; 
}

.subnavbar .container>ul>li>ul:not(.dropdown-menu){
  padding-bottom: 20px;
  
}

/*.subnavbar .container>ul>li>ul:not(.dropdown-menu){
  padding: 0px 0px 0px 80px;
  opacity: 1;
  transition: padding .3s,opacity .9s;
}*/

.subnavbar .container>ul>li>ul:not(.dropdown-menu)>li{
    position: relative;
    left: 84px;
    margin: auto;
    width: 180px;
}

<?php 
if($user_type=='MNO'){
	echo ".subnavbar .container>ul>li>ul:not(.dropdown-menu)>li{ left: 127px; }";

}elseif($user_type=='SUPPORT'){
	echo ".subnavbar .container>ul>li>ul:not(.dropdown-menu)>li{ left: 10px; }";
}elseif($user_type=='MVNO_ADMIN'){
	echo ".subnavbar .container>ul>li>ul:not(.dropdown-menu)>li{ left: 217px; }";
}
?>

.subnavbar .container>ul>li>ul .new{
    padding-bottom: 0px !important;
    font-size: 14px;
}

.subnavbar .container>ul>li>ul:not(.dropdown-menu)>li>ul>li>a:hover{
  /*border-bottom: 1px solid #d52b1e;*/
  font-family: "NHaasGroteskDSStd-75Bd";
  color: #d52b1e;
}

.subnavbar .container>ul>li>a>span{
  vertical-align: middle;

}

.dropdown.open .dropdown-toggle{
  background: #fff;
}

.subnavbar .dropmenu_new{
  border: 1px solid #dadada;
  border-bottom: 0px;
  padding: 0px;
}

.subnavbar .dropmenu_new li{
  padding: 10px 8px 7px 8px;
  border-bottom: 1px solid #dadada;
  height: 25px;
  border-left: 4px solid #fff;
}

.subnavbar  .container>ul>li>ul.dropmenu_new>li>a.new{
	font-family: NHGrotesk-reg,helvetica,arial,sans-serif !important;
	line-height: 22px;
	color: #767676 !important;
	font-size: 14px !important;
}

.subnavbar .dropmenu_new li:hover{
 
  border-left: 4px solid #000;

}

.subnavbar .dropmenu_new li a:hover{
  background-color: #fff !important;
  color: #767676 !important;
  text-decoration: none;
}

.subnavbar .dropdown a{
    font-size: 14px !important;
}

.subnavbar .dropdown a:focus{
    text-decoration: none;
}

.nav-tabs.newTabs{
  padding-left: 0px !important;
}

.sysmenu1 .dropdown-menu{
  display: none;
}

.sysmenu1 .dropdown-toggle{
  font-size: 25px !important;
    font-family: "NHaasGroteskDSStd-75Bd";
}

.dropdown-div{
    position: absolute;
    z-index: 10;
    background-color: #fff;
   /* border-top: 1px solid black;*/

}

.dropmenu_new{
  position: relative !important;
  top: 0px !important;
}

#sami_pro:hover .drop_new{
      border-top: solid 1px #d8dada;
      border-left: solid 1px #d8dada;
      border-right: solid 1px #d8dada;
      width: 120px !important;
}

#sami_pro:hover .glyph-angle-down:before{
      content: "\eA14";
}

#sami_proa{
  
  
}

#sami_pro:hover #sami_proa{
  opacity: 0;
  transition: opacity 3s;
  transition-delay: 1s;
  
}

#sami_pro:hover #sami_proa{
  opacity: 1;
  
}

.subnavbar .container>ul>li>ul:not(.dropdown-menu)>li{
  margin-left: 15px;
}


</style>



<div class="navbar navbar-fixed-top"  <?php if($top_menu=='bottom'){ ?> style="display: none;" <?php } ?>>
  <div class="navbar-inner">


    <div id="container_id" class="container">

    <?php 

    $log_img = '<img class="logo_img" style="max-height: 100px;max-width:47%;float: left;" src="layout/'.$camp_layout.'/img/top_logo.png" border="0">';
    
    if($top_menu=='bottom'){ 
		echo '<a href="intro">'.$log_img.'</a>';
    echo '<img src="layout/'.$camp_layout.'/img/left-arrow.png" class="glyphicon" id="bk_btn" style="display:none;position: relative;top: 8px;left:5px;width: 20px"></span><a style="display:none;position: relative;left: 10px;top: 12px;color:#000;font-size:16px" id=""></a>';
	}
		?>
    <a class="btn btn-navbar toggle_ico" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    <span class="icon-bar show"></span>
    </a>

    <!-- <button type="button" id="fa-close" class="close" aria-label="Close" style="display: none">
      <span aria-hidden="true">&times;</span>
    </button> -->

    <img src="layout/<?php echo $camp_layout; ?>/img/close2.png" id="fa-close" style="display: none;float: right;width: 30px">

    <hr class="sm-hr" style="display: none;">

         <?php 

         //$page_names = $package_functions->getOptions('HEADER_PAGE_NAMES',$system_package);

          //$page_names_arr = json_decode($page_names,true);

        
		/// PAGE TITLE IS HERE ?>

                    <?php
                   
                 
                    

                    if($top_menu!="bottom"){

						echo $log_img;
						echo $logo_title;
					}

                    ?>



             <?php /// END PAGE TITLE ?>








  <?php /// MENU STARTING ?>


      <div class="nav-collapse">

             <ul class="nav pull-right">

         	<?php

         $menutype = $db_class1->setVal('menu_type','ADMIN'); //echo NOW ONLY HAVE SUB MENU ;?>

		 


          <?php

			   $tab_links = $package_functions->getOptions('TAB_LINKS',$system_package);
			   $tab_links = json_decode($tab_links,true);

          if($menutype=="SUB_MENU"){

          	$count_sami = -1;

          	foreach ($main_mod_array as $keym => $valuem){

              $count_sami = $count_sami + 1;

          		if($main_menu_clickble=="NO"){

          			$main_menu_name2 = $valuem['name'];
          			$modarray = $valuem['module'];

          			ksort($modarray);


          			foreach ($modarray as $keyZ => $valueZ){

          				if(strlen($link_main_m_multy)==0)
          				 $link_main_m_multy =  $valueZ['link'];
          				 $sub_menu_new_link =  $valueZ['nw_link'];
          			}

					    if(strlen($page_names_arr[$main_menu_name2])>0){
						$main_menu_name2 = $page_names_arr[$main_menu_name2];
					}

				
				
				if($sub_menu_new_link==1){
          			echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';
				}
				else{
						echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.$extension.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';
					
				}

           			echo '<div><ul class="dropdown-menu">';

          			$link_main_m_multy = '';

          			foreach ($modarray as $keyY => $valueY){
          				$sub_menu_link = $valueY['link'];
          				$sub_menu_name = $valueY['name'];
          				$sub_menu_new_link =  $valueY['nw_link'];

          				if(strlen($page_names_arr[$sub_menu_name])>0){
							$sub_menu_name = $page_names_arr[$sub_menu_name];
						}
          				
          				if($sub_menu_new_link==1){
          				echo '<li><a href="'.$sub_menu_link.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			
          				else{
          				echo '<li><a href="'.$sub_menu_link.$extension.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			}
          			echo '</ul></div>';

                	echo '<li>';

          		}
          		else{

          			/// Single Item

          		if(sizeof($valuem['module'])==1){
          			foreach ($valuem['module'] as $keyY => $valueY){
          				$link_main_m =  $valueY['link'];
          				$menu_item_row_id = $valueY['menu_item'];
          			}
          			$main_menu_name = $valuem['name'];

          			if(strlen($page_names_arr[$main_menu_name])>0){
						$main_menu_name = $page_names_arr[$main_menu_name];
					}

          				echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
          				<a href="'.$link_main_m.$extension.'" class="dropdown-toggle" > '.$main_menu_name.'</a></li>';
          		}

          		/// Multy Item


          		else{
          			$main_menu_name2 = $valuem['name'];
          			$modarray = $valuem['module'];

          			ksort($modarray);


          			foreach ($modarray as $keyZ => $valueZ){

          				if(strlen($link_main_m_multy)==0)
          				 $link_main_m_multy =  $valueZ['link'];
          			}


          			if(strlen($page_names_arr[$main_menu_name2])>0){
						$main_menu_name2 = $page_names_arr[$main_menu_name2];
					}?>

                  <script type="text/javascript">
                    $(document).ready(function() {
                        $('<?php echo "#sysmenu".$keym.""; ?>').click(function(event) {
                            
                            $('.dropdown-toggle').css("display", "none");
                            $('<?php echo "#div".$keym.""; ?>').css({"display": "block","height":"800px"});
                            $('.dropdown-menu').css({"display": "block","height":"800px","margin-top":"30px"});
                            $('.drop_sm').css("display", "none");
                            // $('.navbar-fixed-top').css({"height":"100%"});
                            $('.logo_img').css({"display":"none"});
                            $('#bk_btn').css("display", "inline-block");
                            $('.toggle_ico').css("display","none");
                            $('#fa-close').css("display", "inline-block");
                            $('.glyphicon').css("display", "inline-block");
                            $('.glyphicon').css("display", "inline-block");
                            $('.sm-hr').css("display", "block");

                        });

                        $('#bk_btn').click(function(event) {
                            
                            $('.dropdown-toggle').css("display","block");
                            $('<?php echo "#div".$keym.""; ?>').css("display","none");
                            //$('.dropdown-menu').css("display":"none");
                            $('.logo_img').css("visibility","hidden");
                            $('.logo_img').css("display","inline-block");
                            $('#bk_btn').css("display","none");
                            $('.toggle_ico').css("display","none");
                            $('#fa-close').css("display", "block");
                            $('.glyphicon').css("display","none");
                            $('.drop_sm').css("display", "block");
                            $('.sm-hr').css("display", "none");

                        });

                        $('#fa-close').click(function(event) {
                            
                            $('.dropdown-toggle').css("display","block");
                            $('<?php echo "#div".$keym.""; ?>').css("display","none");
                            //$('.dropdown-menu').css("display":"none");
                            $('.logo_img').css("visibility","visible");
                            $('.logo_img').css("display","inline-block");
                            $('#bk_btn').css("display","none");
                            $('.toggle_ico').css("display","block");
                            $('#fa-close').css("display", "none");
                            $('.glyphicon').css("display","none");
                            $('.nav-collapse').removeClass("in");
                            $('.nav-collapse').hide();
                            $('.drop_sm').css("display", "block");
                            $('.sm-hr').css("display", "none");

                        });

                        $('.toggle_ico').click(function(event) {

                            $('.nav-collapse').show();
                            $('.dropdown-menu').css({"height":"800px"});
                            $('.logo_img').css({"visibility":"hidden"});
                            $('.toggle_ico').css("display","none");
                            $('#fa-close').css("display","block");
                        });

                        /*$('.toggle_ico').click(function(event) {

                          if ($('.navbar-inner').height() == 100%){
                            
                            $('.navbar-fixed-top').css("height","100%");
                            $('.navbar-inner').css("height","auto"); 

                            }else{
                              $('.navbar-fixed-top').css("height","100%");
                              $('.navbar-inner').css("height","100%"); 
                            } 

                        });*/

                        
                    });
                </script>


          			<?php echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.$extension.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';


           			echo '<div class="dropdown-div" style="display:none" id="div'.$keym.'"><ul class="dropdown-menu">';

          			$link_main_m_multy = '';

          			foreach ($modarray as $keyY => $valueY){
          				$sub_menu_link = $valueY['link'];
          				$sub_menu_name = $valueY['name'];
          				$sub_menu_new_link =  $valueY['nw_link'];


          				if(strlen($page_names_arr[$sub_menu_name])>0){
							$sub_menu_name = $page_names_arr[$sub_menu_name];
						}
          				
          				if($sub_menu_new_link==1){
          				echo '<li><a href="'.$sub_menu_link.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			else{
          				echo '<li><a href="'.$sub_menu_link.$extension.'"  class="new" style="padding:5px;">'.$sub_menu_name.'</a></li>';
          				}
          			}
          			echo '</ul></div>';

                	echo '<li>';
          		}
          	}

          	}
          }

            $full_name = 'Profile';

    		$full_name1 = 'Profile';
          

          
          ?>





          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="icon-user"></i> <?php  echo $full_name; ?> <b class="caret"></b></a>

            <ul class="dropdown-menu">
				<?php

				if($script!='verification'){
					//if(!(isset($_SESSION['p_token']))){
          if(!(isset($_SESSION['p_token'])) && $user_type != 'MVNO' ){
  						if($no_profile != '1'){
  					?>
                <li class="drop_sm"><a href="profile<?php echo $extension; ?>">Profile</a></li>
  				<?php } 
            //}
					}
				}?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li class="drop_sm"><a href="#" id="logout_1">Logout</a></li>

              <?php } ?>
			  <script type="text/javascript">
																				$(document).ready(function() {
																					$("#logout_1").click(function(event) {
																						$('#logout-check-div').show();
																						$('#sess-front-div').show();
																						//clearInterval(intrval_func);
																						//window.location = 'logout.php?doLogout=true';
																					 });
																					});
																				</script>
			  
              <?php if($_SESSION['s_token']){ ?>

              <li class="drop_sm">
				  <a href="support<?php echo $extension; ?>?back_sup=true">Back to Support</a></li>

              <?php } ?>
			  
			  <?php 
			  
			  if(isset($_SESSION['p_token'])){ ?>

              <li class="drop_sm">
				  <a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a></li>

              <?php } ?>
			  
            </ul>


          </li>
        </ul>

      </div>
      <!--/.nav-collapse -->
    </div>
    <!-- /container -->
  </div>
  <!-- /navbar-inner -->
</div>


<?php if($script!='verification'){ ?>

<div class="subnavbar" id="subnavbar_id">
  <div class="subnavbar-inner-top"></div>
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav" style="text-align: center;direction: rtl;">

<?php

if($top_menu=='bottom'){

	$full_name = trim($full_name);

	if(strlen($full_name) > 15){

			//$full_name1 = str_replace(" ","<br>",$full_name); 
			$full_name1_arr = explode(" ",$full_name);

			if(sizeof($full_name1_arr) == 2){

				$full_name1 = $full_name1_arr[0].'<br>'.$full_name1_arr[1];

			}
			else{

				$full_name1 = substr_replace($full_name,"<br>",13,0);
								
			}

			

			

          	$li_style = "float: right; ";
          	$a_style = "text-align: left;padding-right: 0px;margin-top: 10px";
          	$b_style = "margin-top: -2px;margin-left: 8px;";
    }
    else{
          	$full_name1 = $full_name;
          	$li_style = "float: right; line-height: 60px;";
          	$a_style = "text-align: left;padding-right: 0px";
          	$b_style = "margin-top: 28px;margin-left: 8px;";
    }

    $full_name = 'Profile';

    $full_name1 = 'Profile';
?>

	<?php /*echo '<li id="sami_pro" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.';float: right" '.$scrpt_active_status.'>
            <a id="hot_a" style="cursor: default">
      <span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;"><span>'.$full_name1.'</span></span> '; 

      echo '<ul id="sami_proa" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);'.$style_tag1.'">';*/

      ?>

<!--<li class="dropdown" style="<?php //echo $li_style; ?>"><a style="<?php //echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown"><span><span>
           <?php //echo $full_name1; ?> </span></span></a>

            <ul id="sami_proa" class="dropdown-menu" style="left: -30px">-->

              <!--<li class="dropdown" style="<?php //echo $li_style; ?>;margin-right: 50px;"><a style="<?php //echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">-->
      <li class="" id="sami_pro" onmouseover="mOver(this)" onmouseout="mOut(this)" style="<?php echo $li_style; ?>;margin-right: 50px;position: absolute;top: 0px;"><a style="<?php echo $a_style; ?>;margin-top: 25px;height: 50px;width: 80px;font-size: 14px;" href="#" class="dropdown-toggle drop_new" data-toggle="dropdown">
           <?php echo $full_name1; ?> <span class="glyph glyph-angle-down" style="position: relative;top: -42px;right: 20px;text-align: right;"></span></a>

           <!-- <ul class="dropdown-menu" style="width: 130px" > -->
            <ul id="sami_proa" class="dropdown-menu dropmenu_new" style="width: 120px" >
				<?php

				if($script!='verification'){
				if(!(isset($_SESSION['p_token']))){        
          
  					if($no_profile != '1'){
              
  				?>
                		<li style="width: '.$width_li.';'.$css_right.';"><a href="profile<?php echo $extension; ?>" style="padding: 0px;color: #000">Profile</a></li>
  				<?php }
            
					}
				}
				?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li style="'.$style_tag1.'"><a href="#" id="logout_2" class="new '.$add_class.'" style="padding:0px !important;'.$style_tag2.'">Logout</a></li>

              <?php } ?>
			  <!-- <li><a href="javascript:void();" id="logout_1">Logout</a></li> -->
			  <script type="text/javascript">
																				$(document).ready(function() {
																					$("#logout_2").click(function(event) {
																						$('#logout-check-div').show();
																						$('#sess-front-div').show();
																						
																						//window.location = 'logout.php?doLogout=true';
																					 });
																					});
																				</script>

              <?php if($_SESSION['s_token']){ ?>

              <li style="'.$style_tag1.'">
				  <a href="support<?php echo $extension; ?>?back_sup=true" class="new '.$add_class.'" style="padding:0px !important;'.$style_tag2.'">Back to Support</a></li>

              <?php } ?>
              
              <?php if($_SESSION['p_token']){ ?>

              <li style="'.$style_tag1.'">
				  <a href="properties<?php echo $extension; ?>?back_master=true" class="new '.$add_class.'" style="padding:0px !important;margin-top: -10px;background-color: transparent !important;'.$style_tag2.'">Back to Properties Page</a></li>
              
			  <?php } 
			 if($user_type=="MVNO"){

				$query="SELECT `property_id`,`parent_id`  FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";

				$query=$db_class1->selectDB($query);
				foreach ($query['data'] as $row) {
					$parent_id = $row['parent_id'];
					$property_id = $row['property_id'];
				}

				echo '<li class="subLi">Property ID  <div>'.$property_id.'</div></li>';
				echo '<li class="subLi" style="padding-top: 0px;">Business ID <div>'.$parent_id.'</div></li>';
			  }elseif($user_type=="MVNO_ADMIN"){

				echo '<li class="subLi">Business ID  <div>'.$user_distributor.'</div></li>';
			  } 
			  ?>
            </ul>


          </li>

          <?php } 

$menutype = $db_class1->setVal('menu_type','ADMIN');
if($menutype=="SUB_MENU"){

	if($top_menu=="bottom"){
				echo '<li class="no_arrow" style="line-height:60px; margin-right: 10px"><a href="intro" style="line-height: 60px !important;text-align:left !important">'.$log_img.'</a></li>';
				echo '<style> .logo_img{ max-height: 100px;max-width:85%;margin-top: 28px; float: none !important; } </style>';
	}

	$mod_size_arr = sizeof($main_mod_array);

	if($mod_size_arr <5){
		$mod_size_arr =5;
	}
	if($mod_size_arr >6){
		$mod_size_arr = 6;
	}


	if($top_menu=="bottom"){
		$mod_size_arr = $mod_size_arr + 2;

		if($mod_size_arr == 7){
			$mod_size_arr = $mod_size_arr + 0.5;
		}
	}

	$width_li = intval(99)/$mod_size_arr.'%';
	//$width_li = intval(99)/intval(sizeof($main_mod_array));

/* 	if($user_type=="MNO" || $user_type=="ADMIN"){
		$width_li = "19.8%";
	}
	else{
		$width_li = "16.5%";
	} */


	if($style_type != 'light')
		$camp_theme_color = '#fff';

	$numItems = count($main_mod_array);
	$i = 0;

	$main_mod_array = array_reverse($main_mod_array);
	foreach ($main_mod_array as $keym => $valuem){
		if(++$i === $numItems) {
			//$css_right = 'border-right: 1px solid #d9d9d9;';
		}
		if(strlen($valuem['active'])){
			$scrpt_active_status = ' class="active"';
		}
		else{
			$scrpt_active_status = '';
		}

		if($main_menu_clickble=="NO"){

			$main_menu_name2 = $valuem['name'];
			$modarray = $valuem['module'];
			ksort($modarray);
			foreach ($modarray as $keyZ => $valueZ){

				if(strlen($link_main_m_multy)==0)
				 $link_main_m_multy =  $valueZ['link'];
			}

			if(strlen($page_names_arr[$main_menu_name2])>0){
					$main_menu_name2 = $page_names_arr[$main_menu_name2];
			}

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.';float: none;display: inline-block;width: -webkit-min-content;width: -moz-min-content;width: min-content;white-space: nowrap;" '.$scrpt_active_status.'>
            <a id="hot_a" style="cursor: default">
			<span style="font-size: 14px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;"><span>'.$main_menu_name2.'</span></span> ';

			if(sizeof($valuem['module'])==1){
				$style_tag1 = "min-width: 100%;width: auto";
				$style_tag2 = 'white-space: nowrap';
				$add_class = "single";
			}
			else{
				$style_tag1 = "";
				$add_class = "multi";
			}
			echo '<ul id="sami_'.$keym.'a" style="background-color: '.$camp_theme_color.';'.$style_tag1.'">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="margin-top:8px;'.$style_tag1.'">
					<a href="' . $sub_menu_link . '"  target="_blank"  class="new '.$add_class.'" style="'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="margin-top:8px;'.$style_tag1.'">
            		<a href="' . $sub_menu_link . $extension . '" class="new '.$add_class.'" style="'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}
			}

		echo '</ul> </li>';
		}
		else{
		/// Single Item
		// if(sizeof($valuem['module'])==1){
			
		// 	foreach ($valuem['module'] as $keyY => $valueY){
		// 		$link_main_m =  $valueY['link'];
		// 		$menu_item_row_id = $valueY['menu_item'];
		// 	}
		// 	$main_menu_name = $valuem['name'];
		// 	$main_menu_name = $package_functions->getPageName($link_main_m,$system_package,$main_menu_name);

		// 		if($scrpt_active_status==''){
		// 			$scrpt_active_status = ' class="no_arrow"';
		// 		}
		// 		else{
		// 			$scrpt_active_status = ' class="active no_arrow"';
		// 		}

		// 		if(strlen($page_names_arr[$main_menu_name])>0){
		// 			$main_menu_name = $page_names_arr[$main_menu_name];
		// 		}

		// 		echo '<li style="float: none;display: inline-block;width: '.$width_li.';width: -webkit-min-content;width: -moz-min-content;width: min-content;white-space: nowrap;'.$css_right.'" '.$scrpt_active_status.'>
		// 		<a id="dash_'.$keym.'" href="'.$link_main_m.$extension.'">
		// 		<span style="font-size: 14px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;"><span>'.$main_menu_name.'</span></span> </a></li>';
		// }

		// else{ 
			$main_menu_name2 = $valuem['name'];
			$modarray = $valuem['module'];
			ksort($modarray);
			foreach ($modarray as $keyZ => $valueZ){

				if(strlen($link_main_m_multy)==0)
				 $link_main_m_multy =  $valueZ['link'];
			}

			$main_menu_name2 = $package_functions->getPageName($link_main_m_multy,$system_package,$main_menu_name2);
			if(strlen($page_names_arr[$main_menu_name2])>0){
					$main_menu_name2 = $page_names_arr[$main_menu_name2];
				}

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.'; float: none;display: inline-block;width: -webkit-min-content;width: -moz-min-content;width: min-content;white-space: nowrap;" '.$scrpt_active_status.'>
            <a id="hot_a" href="'.$link_main_m_multy.$extension.'">
			<span style="font-size: 14px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;"><span>'.$main_menu_name2.'</span></span> </a>';

			echo '<ul id="sami_'.$keym.'a" style="background-color: '.$camp_theme_color.';">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="margin-top:8px">
            		<a href="' . $sub_menu_link . '"  target="_blank"  class="new" style="">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="margin-top:8px">
					<a href="' . $sub_menu_link . $extension . '" class="new" style="">' . $sub_menu_name . '</a>';
				
					if($sub_menu_link=='home'){

						  $feture_section_array= json_decode($package_functions->getOptions('DASH_SECTIONS',$system_package),true);

						$q = "SELECT ssid,wlan_name FROM exp_locations_ssid_private WHERE distributor='$user_distributor'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid WHERE distributor = '$user_distributor'
         UNION
         SELECT ssid,wlan_name FROM exp_locations_ssid_vtenant WHERE distributor = '$user_distributor'";

$network_names = $db_class1->selectDB($q);

 $graph_number = 0;

$graph_number1 = 0;

////Dash Board Sections//////////
$get_section_code_q = "SELECT u.`section_code` AS a,s.`section_name` AS b FROM `dashboard_sections` s,`dashboard_sections_user_type` u  WHERE u.`section_code`=s.`section_code`
AND `dashboard_code`='DASH01' AND u.user_type='$user_type' AND u.is_enable=1 ORDER BY order_number ASC";
$get_section_code=$db_class1->selectDB($get_section_code_q);

$section_array=array();
$a=0;


//$feture_section_guest_array= explode(",",$package_functions->getOptions('DASH_GUEST_SECTIONS',$system_package));
//print_r($feture_section_guest_array);
//$feture_section_private_array= explode(",",$package_functions->getOptions('DASH_PRIVATE_SECTIONS',$system_package));

$vernum=$db_class1->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
$nettype=$db_class1->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
//print_r($feture_section_array['guest']);
  if($nettype=='BOTH' || $nettype=='PUBLIC-PRIVATE'){

    $fesegparray=array_merge($feture_section_array['guest'],$feture_section_array['private']);

  }elseif($nettype=='GUEST' || $nettype=='PUBLIC'){

    $fesegparray=$feture_section_array['guest'];

  }elseif($nettype=='PRIVATE'){

    $fesegparray=$feture_section_array['private'];
  }elseif($nettype=='VT'){
    $fesegparray=$feture_section_array['vt'];
  }elseif($nettype=='VT-BOTH'){
    $fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['guest'],$feture_section_array['private']);
  }elseif($nettype=='VT-GUEST'){

    $fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['guest']);
  }elseif($nettype=='VT-PRIVATE'){

    $fesegparray=array_merge($feture_section_array['vt'],$feture_section_array['private']);
  }else{

    $fesegparray=array();

  }

$fesegparray = array_unique($fesegparray);
/*print_r($fesegparray);*/

$WLAN_select_graph_list = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT',$system_package),true);
$WLAN_select_graph_list_des = $package_functions->getSectionType('DSF_GRAPH_WLAN_SELECT',$system_package);
//$WLAN_select_graph_list_drop = json_decode($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT_DROP',$system_package),true);
//print_r($package_functions->getOptions('DSF_GRAPH_WLAN_SELECT',$system_package));
$advanced_features=$db_class1->getValueAsf("SELECT `advanced_features` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
$overview_disabele= false;

if(strlen($advanced_features) > 0){

  $advanced_features = json_decode($advanced_features,true);

 foreach ($fesegparray as $key => $value) {
    /*if($advanced_features[$value] == '0'){
      unset($fesegparray[$key]);
    }*/

    if($advanced_features['network_at_a_glance']=='0' && $value=='NVI_TREE_SEC_COX'){
      
      $overview_disabele= "disabele";  
      unset($fesegparray[$key]);
    }

    if($advanced_features['top_applications']=='0' && $value=='DSF_TOP_APP_COX'){
      unset($fesegparray[$key]);
    }
  }
}


    $psndg_count=count($fesegparray);
echo '<ul class="ul-down">';
foreach ($get_section_code['data'] as $rows) {//dashsections
  $section_code=$rows[a];
  $section_name=$rows[b];

  if ($section_name == 'Network') {
    $section_name = 'Summary';
  }
  $section_name = str_replace('{$wifi_txt}', '', $section_name);

  if($psndg_count==0){

  	if(in_array($section_code,$feture_section_array) || $package_features=="all")   {
        $section_array[$a]=$section_code;
  		echo '<li><a href="home?t='.$a.'">' . $section_name . '</a></li>';
        $a++;
  	}

  }else{

  	if(in_array($section_code,$fesegparray) || $package_features=="all")   {
        $section_array[$a]=$section_code;
        
  		echo '<li><a href="home?t='.$a.'">' . $section_name . '</a></li>';

        $a++;

  	}

  }



  }

  echo '</ul>';

					}
					if(!empty($tab_links[$sub_menu_link])){
						echo '<ul class="ul-down">';
						foreach ($tab_links[$sub_menu_link] as $key => $value) {

							switch ($key) {
								case 'DEFAULT':
									foreach ($value as $value1) {
										echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
									}
									break;
								case 'USERTYPE!SUPPORT':
									if($user_type!="SUPPORT"){
										foreach ($value as $value1) {
											echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
										}
									}
									break;
								case 'USERTYPESUPPORT':
									if($user_type=="SUPPORT"){
										foreach ($value as $value1) {
											echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
										}
									}
									break;
								case 'USERTYPEMNO':
									if($user_type=="MNO"){
										foreach ($value as $value1) {
											echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
										}
									}
									break;
								case 'USERTYPEMVNO_ADMIN':
									if($user_type=="MVNO_ADMIN"){
										foreach ($value as $value1) {
											echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
										}
									}
									break;
								case 'USERTYPEMNO||SUPPORT!ACCESSSUPPORT':
									if($user_type=="SUPPORT" || $user_type=="MNO"){
										if(!in_array('support', $access_modules_list)){
											foreach ($value as $value1) {
												echo '<li class=""><a href="'.$value1[0].'">'.$value1[1].'</a></li>';
											}
										}
									}
									break;
								
								default:
									if(in_array($key,$features_array) || $package_features=="all"){
										echo '<li class=""><a href="'.$value[0].'">'.$value[1].'</a></li>';
									}
									break;
							}
						}
						echo '</ul>';
					}
				}
			}

		echo '</ul> </li>';
		//}
	}
	}
}

?>
</ul>
</div>
</div>
</div>
<?php } ?>

<script type="text/javascript">

  $(document).ready(function() {

  if($(window).width()<520){
    $('.nav-tabs:not(.dropdown_tabs):not(.zg-ul-select)').addClass('show-all');

    $('.tab-content:not(.home-inner-tab):not(.home-highlight)>.tab-pane').removeClass('active');
  }

  $('.nav-tabs:not(.dropdown_tabs) li').click(function(event) {
    var tabDiv = $(this).children('a').attr('href').replace('#', '');
    if($(window).width()<520){
      if($(this).hasClass('active')){
        if($(this).parent().hasClass('show-all')){
          $(this).parent().removeClass('show-all');
          $('#'+tabDiv).addClass('active');
          $('#'+tabDiv).addClass('in');
        }
        else{
          $(this).parent().addClass('show-all');
          $('#'+tabDiv).removeClass('active');
          $('#'+tabDiv).removeClass('in');
          
        }
      }
      else{
        $(this).parent().removeClass('show-all');
        $('#'+tabDiv).addClass('active');
      $('#'+tabDiv).addClass('in');
      }
    }
  });

  $('.dropdown_tabs').click(function(event) {
    if($(this).hasClass('show-all')){
      $(this).removeClass('show-all');
    }else{
      $(this).addClass('show-all');
    }
  });

  });

</script>
<style>
.subnavbar .container>ul>li>ul:not(.dropdown-menu)>li>ul::before {
    content: "";
    position: absolute;
    width: 300px;
    height: 1px;
    background-color: #000;
    left: 0px;
    top: 24px;
}
.ul-down{
	display: block  !important;
	box-shadow: none !important;
	font-family: NHGrotesk;
}
.ul-down>li {
    list-style-type: none;
}
</style>


<script type="text/javascript">
  $(document).ready(function() {
    if($(window).width()>979){
      $('.mainnav li#sami_<?php echo $count_sami; ?> a').css('text-align','left');
      var l = $('.mainnav li#sami_<?php echo $count_sami; ?>').offset();
      var le = l.left;
      $('.subnavbar .container ul li ul:not(.dropdown-menu) li').css({left:le});
    }
  });
</script>