
<style type="text/css">

	.navbar .navbar-inner{
		border-top: none !important;
		padding: 17px 0;
	}

	.no_arrow .glyph-angle-down{
		display: none !important;
	}
	@media (max-width: 979px){
		.navbar-fixed-top {
			display: block !important;
		}
	}
	.subnavbar .dropdown-menu::before, .subnavbar .dropdown-menu::after{
		content: none !important;
	}
	.dropdown{
		display: table;
	}

	.subnavbar .dropdown .dropdown-toggle{
		    vertical-align: middle;
    padding-left: 30px !important;
    display: table-cell !important;
    background : url('layout/<?php echo $camp_layout ?>/img/user.png') !important;
    background-size: 22px !important;
    background-repeat: no-repeat !important;
    background-position: 0px 16px !important;
    margin-top: 0px !important;
    position: relative;
    padding-right: 20px !important;
	}

	body .subnavbar-inner.black-background{
		    background: black !important;
	}

	body .subnavbar-inner{
		    background: transparent !important;
	}



	.glyph-angle-down:before {
    content: "\eA12";
}

/*body .subnavbar .container>ul>li{
	height: 30px;
}*/

/*body .subnavbar .container > ul{
	margin-top: 20px;
}*/

body .subnavbar .container>ul>li.active>a{
	border-bottom: none ;
}

body .subnavbar .container>ul>li>a>span:not(.glyph), body .subnavbar .container>ul>li>a{
	font-size: 12px !important;
    font-family: Montserrat,Arial,Helvetica Neue,Helvetica,sans-serif !important;
    line-height: 20px  !important;
}

	.dropdown .glyph{
        position: absolute !important;
    top: 0 !important;
    right: 0;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 60px;
    -webkit-font-smoothing: antialiased;
}

.glyph{
        position: relative !important;
    top: 5px;
    display: inline-block !important;
    font-family: 'glyphs' !important;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

<?php 

if(sizeof($main_mod_array) >= 5){
 ?>

 .subnavbar .container>ul>li>a{
 	padding: 0px !important;
 }

  .subnavbar .container>ul>li{
 	max-width: 150px;
 }

<?php } ?>
</style>

<div class="navbar navbar-fixed-top"  <?php if($top_menu=='bottom'){ ?> style="display: none;" <?php } ?>>
  <div class="navbar-inner">


    <div id="container_id" class="container">

    <?php 
/*
    $log_img = '<img class="logo_img" style="max-height: 36px;float: left;" src="layout/'.$camp_layout.'/img/top_logo.png" border="0">';*/
     $log_img = '<img class="logo_img" style="max-height: 36px;float: left;" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMjcuNTg1IDc4Ljg4OCI+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTUxLjI5MyAwLjAwMWMtOS4yNzMgMC0xNi44MTYgNy41NDMtMTYuODE2IDE2LjgxN2MwIDkuMyA3LjUgMTYuOCAxNi44IDE2LjggczE2LjgxNS03LjU0OSAxNi44MTUtMTYuODIxQzY4LjEwOCA3LjUgNjAuNiAwIDUxLjMgMCBNNTEuMjkzIDMwLjMyNmMtNy40NDkgMC0xMy41MS02LjA2Mi0xMy41MS0xMy41MDggYzAtNy40NDMgNi4wNjEtMTMuNTA0IDEzLjUxLTEzLjUwNGM3LjQ0OSAwIDEzLjUgNi4xIDEzLjUgMTMuNTA0QzY0LjgwMiAyNC4zIDU4LjcgMzAuMyA1MS4zIDMwLjMiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMTk2LjI5NCAxNy4wMzJjLTAuOTA0LTAuNDczLTYuMzg5LTMuMzAxLTcuMTgtMy43MWMtMi44NzktMS40NjgtMy44OTgtMi43NzEtMy44OTgtNC45NzYgYzAtMy4wNTkgMi41MTItNS4wMzYgNi40MDgtNS4wMzZjMi4yODggMCA0LjUgMSA1LjggMS43MzZjMC4yMzYgMC4xIDAuNSAwLjIgMC44IDAuMiBjMC45MTIgMCAxLjY1NC0wLjc0IDEuNjU0LTEuNjUyYzAtMC42MTItMC4zMzQtMS4xNDYtMC44MjgtMS40MzJjLTEuNjM1LTAuOTEtNC40MjItMi4xNjItNy40MjYtMi4xNjIgYy01LjcyMyAwLTkuNzIxIDMuNDMzLTkuNzIxIDguMzQ1YzAgNC40IDIuOSA2LjUgNS43IDcuOTQ2YzAuNzkzIDAuNCA2LjMgMy4zIDcuMiAzLjcgYzIuMTkyIDEuMSAzLjQgMi45IDMuNCA0Ljg1MWMwIDIuNjU2LTIuMjQ4IDUuNDgtNi40MTMgNS40OGMtNC4wNSAwLTcuMTk1LTIuNzE4LTguMDY1LTMuNTUzbC0wLjI1Ni0wLjI0OGwtMi40NSAyLjIgbDAuMjg5IDAuMjg1YzEuMDg2IDEuMSA1LjEgNC42IDEwLjUgNC41OTdjNi4wODQgMCA5LjcyLTQuNDcxIDkuNzItOC43OTFDMjAxLjUzIDIxLjYgMTk5LjYgMTguOCAxOTYuMyAxNyIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xNi44MTQgMy4zMTRjMy42MTEgMCA3IDEuNCA5LjYgMy45NTJjMC42MDYgMC42IDEuNyAwLjYgMi4zIDAgYzAuMzE2LTAuMzA5IDAuNDg2LTAuNzI0IDAuNDg2LTEuMTY5YzAtMC40MzktMC4xNy0wLjg1OC0wLjQ4Ni0xLjE2N2wtMC4yLTAuMjA5Yy0zLjE1MS0zLjA0My03LjMwNS00LjcyLTExLjY5MS00LjcyIEM3LjU0MiAwIDAgNy41IDAgMTYuODE3YzAgOS4zIDcuNSAxNi44IDE2LjggMTYuODIyYzQuODk0IDAgOS4zMDMtMi4xMDEgMTIuMzc2LTUuNDQ5bC0yLjM0LTIuMzQ0IGMtMi40NzQgMi43NS02LjA1NiA0LjQ4LTEwLjAzNiA0LjQ4Yy03LjQ0OCAwLTEzLjUwOC02LjA2Mi0xMy41MDgtMTMuNTA5QzMuMzA3IDkuNCA5LjQgMy4zIDE2LjggMy4zIi8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTEzMC44MTUgMy4zMTRjMy42MDcgMCA3IDEuNCA5LjYgMy45NTJjMC42MDQgMC42IDEuNyAwLjYgMi4zIDAgYzAuMzE1LTAuMzA5IDAuNDg3LTAuNzI0IDAuNDg3LTEuMTY5YzAtMC40MzktMC4xNzItMC44NTgtMC40ODctMS4xNjdsLTAuMjAyLTAuMjA5Yy0zLjE1My0zLjA0My03LjMwNS00LjcyLTExLjY4OS00LjcyIGMtOS4yNzIgMC0xNi44MTcgNy41NDMtMTYuODE3IDE2LjgxNmMwIDkuMyA3LjUgMTYuOCAxNi44IDE2LjgyMmM0Ljg5MiAwIDkuMzAxLTIuMTAxIDEyLjM3Ny01LjQ0OWwtMi4zNDMtMi4zNDQgYy0yLjQ3MyAyLjc1LTYuMDU2IDQuNDgtMTAuMDM0IDQuNDhjLTcuNDQ5IDAtMTMuNTExLTYuMDYyLTEzLjUxMS0xMy41MDlDMTE3LjMwNSA5LjQgMTIzLjQgMy4zIDEzMC44IDMuMyIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xMDIuMzI5IDBjLTAuNjIxIDAtMS4xMSAwLjQtMS4zNzkgMC45MTljLTAuMjcxIDAuNTE2LTkuODk1IDI0LjMyMS05Ljg5NSAyNC4zIFM4MS40MyAxLjQgODEuMiAwLjkyQzgwLjg4OSAwLjQgODAuNCAwIDc5LjggMGMtMC43MjUgMC0xLjI3MSAwLjUzMi0xLjQ2MyAxLjIwNmMtMC4xOTIgMC42NzYtNS42MjIgMzAuNjM5LTUuNjIyIDMwLjYgYy0wLjAxOCAwLjA5Ny0wLjAyOSAwLjE5Ny0wLjAyOSAwLjMwMWMwIDAuOCAwLjcgMS41IDEuNSAxLjQ5MmMwLjcyNiAwIDEuMzMzLTAuNTIgMS40NjUtMS4yMDdsNC43MDEtMjUuNjMzIGMwIDAgOS4xIDIyLjQgOS4zIDIyLjk0OWMwLjI2NiAwLjUgMC44IDAuOSAxLjQgMC45NDVjMC42MyAwIDEuMTIzLTAuNDEyIDEuMzg5LTAuOTQ1IGMwLjI2Ni0wLjUzMyA5LjMzOS0yMi45NDkgOS4zMzktMjIuOTQ5bDQuODg5IDI2LjY1NGgzLjAzMmMwIDAtNS43Mi0zMS41Ny01LjkxMS0zMi4yNDZDMTAzLjYgMC41IDEwMy4xIDAgMTAyLjMgMCIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xNjIuMTE5IDAuMDAxYy0wLjYzLTAuMDAxLTEuMTE1IDAuNDA4LTEuMzg4IDAuOTQzYy0wLjI3MiAwLjUzMy0xMi40NTUgMzAuNjIxLTEyLjQ1NSAzMC42IGMtMC4wNzQgMC4xNzktMC4xMTUgMC4zNzYtMC4xMTUgMC41ODFjMCAwLjggMC43IDEuNSAxLjUgMS40OTNjMC42MjkgMCAxLjE2OC0wLjM5MiAxLjM4Ny0wLjk0N2w0LjczLTExLjYzNGgxMi43MDEgbDUuMDQ1IDEyLjM5NGgzLjIyMWMwIDAtMTIuOTYzLTMxLjk3NS0xMy4yMy0zMi41MDhDMTYzLjIzOSAwLjQgMTYyLjggMCAxNjIuMSAwIE0xNTcuMTIgMTcuNzQ3bDQuOTk5LTEyLjI5NyBsNS4wMDUgMTIuMjk3SDE1Ny4xMnoiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMjI3LjU4NSAxLjgzNGMwLTAuOTE1LTAuNzQ1LTEuNjU1LTEuNjU4LTEuNjU1aC0xOC43MjVjLTAuOTExIDAtMS42NTEgMC43NC0xLjY1MSAxLjcgYzAgMC45IDAuNyAxLjcgMS43IDEuNjUyaDcuODUxdjI5Ljk2NmgzLjAzVjMuNDg3aDcuODQ0QzIyNi44NCAzLjUgMjI3LjYgMi43IDIyNy42IDEuOCIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik05OS41IDQ1LjI0Yy0xLjY1NyAwLTIuNjgyIDEuMTY2LTIuNjgyIDIuNTk5djMwLjg0OWg1LjM2MlY0Ny44MzggQzEwMi4xODEgNDYuNCAxMDEuMiA0NS4yIDk5LjUgNDUuMiIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0zOC42NzYgNjUuNDdsMC4wMDMtMTcuNjIzYzAtMS40MzMtMS4wNTMtMi41OTgtMi42ODEtMi41OTggYy0xLjY1IDAtMi42ODUgMS4xNjUtMi42ODUgMi41OTh2MTcuNDY0YzAgNy41IDUuMyAxMy42IDEzLjcgMTMuNTU0YzguMzcxIDAgMTMuNjUyLTYuMDc3IDEzLjY1Mi0xMy41NTRsMC4wMDUtMTkuODkyIGgtNS4zNzNWNjUuNDdjMCA0LjQxMi0yLjkzNCA4LjM1Ny04LjI4NCA4LjM1N0M0MS42MTIgNzMuOCAzOC43IDY5LjkgMzguNyA2NS41Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTE2OC41NDYgNTAuNjY0YzEuNzU2IDAgMi44MzYtMS4xMjkgMi44MzYtMi42MjIgYzAtMS40OTYtMS4wNzYtMi42MjUtMi44MzYtMi42MjVoLTE2LjQxN2MtMS41MjggMC0yLjYwMSAxLjA4Mi0yLjYwMSAyLjU5NnYyOC4wOTNjMCAxLjUgMS4xIDIuNiAyLjYgMi41ODRoMTkuMDc3di01LjIzIGgtMTYuMzI0VjYzLjhoMTIuMzExYzEuODY2IDAgMi44OTctMS4xMDkgMi44OTctMi42MTVjMC0xLjUwNS0xLjAyMi0yLjYxNS0yLjg5Ny0yLjYxNWgtMTIuMzExdi03LjkwNkgxNjguNTQ2eiIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0yMS42MDYgNjAuNjc3YzAuODg5LTAuNTY3IDMuMzU3LTIuNTA4IDMuMzU3LTYuODIgYzAtNS4xMDItMy42NS04LjQzOS05LjI0MS04LjQzOUg0LjIyOWMtMS41NTEgMC0yLjU5MSAxLjA2LTIuNTkxIDIuNTkydjMwLjY3OGgxNC43NThjNS45NzkgMCAxMC4xMTItNC4zNTQgMTAuMTEyLTkuOTIxIEMyNi41MDcgNjIuOCAyMi42IDYxLjEgMjEuNiA2MC43IE03IDUwLjYxOGg4LjA0NGMzLjAyMyAwIDQuNSAxLjggNC41IDQuMDQ2YzAgMi4yMjUtMS42MTIgNC4wNDctNC40OTEgNC4wNDdINyBWNTAuNjE4eiBNMTUuMzg3IDczLjU1NEg3di05Ljk0OGw4LjM4OCAwLjAwMmMzLjg1NSAwIDUuNyAyLjIgNS43IDQuOTcyQzIxLjA4MSA3MS4zIDE5LjEgNzMuNiAxNS40IDczLjYiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMTE1LjQ1MSA0NS4yNGMtMS42MjIgMC0yLjY3IDEuMTUzLTIuNjcgMi41NzJ2MjguNDYzIGMwIDEuNCAxLjMgMi42IDIuNyAyLjU4NGMxLjQgMCAyLjY2LTEuMTQ5IDIuNjYtMi41ODRWNTUuNzM4YzAgMCAxMyAxNi43IDE2LjUgMjEuMSBjMC44NjQgMS4xIDEuNSAyIDMgMi4wMjZjMS41NTYgMCAyLjU5OS0xLjEyNyAyLjU5OS0yLjU4NlY0NS40MTRoLTUuMzUzdjIzLjAzM2MwIDAtMTQuNTQ5LTE4LjY2Mi0xNi41NzgtMjEuMjQ4IEMxMTcuNDE5IDQ2IDExNi43IDQ1LjIgMTE1LjUgNDUuMiIvPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik02Ni44NiA3My45MjljMC42ODIgMC45IDMuOCA1IDEwLjcgNSBjNi43NzcgMCAxMS4zOTktMy45MDYgMTEuMzk5LTkuMzVjMC0zLjU3Ni0xLjQxLTYuNDYzLTYuNzA2LTkuMDEyYy0xLjQxNi0wLjY4OC01LjQwNi0yLjYtNS40MDYtMi42IGMtMi4xMjUtMS4wMjctMy4wNTctMi4yNDgtMy4wNTctMy44OTJjMC0xLjc1MSAxLjQ0MS0zLjYzIDQuOTM5LTMuNjNjMS45OTIgMCAzLjUgMC42IDQuNCAxIGMwLjQwNCAwLjIgMS40IDAuNiAyLjMgMC42NDRjMS4xNzcgMCAyLjQ1NC0wLjgzNiAyLjQ1NC0yLjUzN2MwLTEuNDIyLTEuMDItMi4xOTUtMS45MS0yLjYxNiBjLTEuNDM0LTAuNjc3LTMuNjY2LTEuNjU0LTcuNDE0LTEuNjU0Yy01LjkyNCAwLTEwLjMxNyAzLjc1NS0xMC4zMTcgOC45NDFjMCA0LjggMy4yIDcuMSA3LjEgOSBjMC43MzUgMC40IDMuNiAxLjcgNC40IDIuMTE5YzIuNDQgMS4yIDMuNyAyLjMgMy43IDQuMzZjMCAyLjIyNi0yLjA2NiA0LjA3NS01LjIwOSA0LjEgYy00LjUgMC02Ljg5Ni0yLjk1Mi03LjMzNi0zLjQ1TDY2Ljg2IDczLjkyOXoiLz48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMTc2LjY3MSA3My45MjljMC42ODQgMC45IDMuOCA1IDEwLjggNSBjNi43NjkgMCAxMS4zODMtMy45MDYgMTEuMzgzLTkuMzVjMC0zLjU3Ni0xLjM4NS02LjQ2My02LjcwOC05LjAxMmMtMS40MDgtMC42ODgtNS4zOTgtMi42LTUuMzk4LTIuNiBjLTIuMTMxLTEuMDI3LTMuMDYyLTIuMjQ4LTMuMDYyLTMuODkyYzAtMS43NTEgMS40MzgtMy42MyA0Ljk1NS0zLjYzYzEuOTg1IDAgMy41IDAuNiA0LjMgMSBjMC40MDggMC4yIDEuNCAwLjYgMi4zIDAuNjQ0YzEuMTc1IDAgMi40NTktMC44MzYgMi40NTktMi41MzdjMC0xLjQyMi0xLjAyMS0yLjE5NS0xLjkxNy0yLjYxNiBjLTEuNDQzLTAuNjc3LTMuNjg0LTEuNjU0LTcuNDEyLTEuNjU0Yy01LjkxNiAwLTEwLjMyNiAzLjc1NS0xMC4zMjYgOC45NDFjMCA0LjggMy4yIDcuMSA3LjEgOSBjMC43NDQgMC40IDMuNiAxLjcgNC40IDIuMTE5YzIuNDE0IDEuMiAzLjcgMi4zIDMuNyA0LjM2YzAgMi4yMjYtMi4wNzYgNC4wNzUtNS4xOTkgNC4xIGMtNC41MiAwLTYuODk3LTIuOTUyLTcuMzM0LTMuNDVMMTc2LjY3MSA3My45Mjl6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTIwMy44OTYgNzMuOTI5YzAuNjg0IDAuOSAzLjggNSAxMC43IDUgYzYuNzcxIDAgMTEuNDItMy45MDYgMTEuNDItOS4zNWMwLTMuNTc2LTEuNDItNi40NjMtNi43MDUtOS4wMTJjLTEuNDI2LTAuNjg4LTUuNDM1LTIuNi01LjQzNS0yLjYgYy0yLjA5Ni0xLjAyNy0zLjAyOC0yLjI0OC0zLjAyOC0zLjg5MmMwLTEuNzUxIDEuNDM5LTMuNjMgNC45Mi0zLjYzYzIgMCAzLjYgMC42IDQuNCAxIGMwLjM5NCAwLjIgMS4zIDAuNiAyLjIgMC42NDRjMS4xNzYgMCAyLjQ2My0wLjgzNiAyLjQ2My0yLjUzN2MwLTEuNDIyLTEuMDIzLTIuMTk1LTEuOTItMi42MTYgYy0xLjQ0My0wLjY3Ny0zLjY0Ni0xLjY1NC03LjQxNC0xLjY1NGMtNS45MTIgMC0xMC4yOTMgMy43NTUtMTAuMjkzIDguOTQxYzAgNC44IDMuMiA3LjEgNy4xIDkgYzAuNzI5IDAuNCAzLjYgMS43IDQuNCAyLjExOWMyLjQ1MSAxLjIgMy43IDIuMyAzLjcgNC4zNmMwIDIuMjI2LTIuMDYxIDQuMDc1LTUuMjIxIDQuMSBjLTQuNDg2IDAtNi44OTgtMi45NTItNy4zMzUtMy40NUwyMDMuODk2IDczLjkyOXoiLz48L3N2Zz4=" border="0">';
    
    if($top_menu=='bottom'){ 
		echo '<a href="intro">'.$log_img.'</a>';
	}
		?>
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </a>

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

       
          if($menutype=="SUB_MENU"){

          	

          	foreach ($main_mod_array as $keym => $valuem){

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

           			echo '<ul class="dropdown-menu">';

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
          			echo '</ul>';

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
					}


          			echo '<li id="sysmenu'.$keym.'" class="dropdown sysmenu1" style="display: none;">
            		<a href="'.$link_main_m_multy.$extension.'" class="dropdown-toggle" data-toggle="dropdown"> '.$main_menu_name2.'<b class="caret"></b></a>';


           			echo '<ul class="dropdown-menu">';

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
          			echo '</ul>';

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
					if(!(isset($_SESSION['p_token']))){
						if($no_profile != '1'){
					?>
              <li><a href="profile<?php echo $extension; ?>">Profile</a></li>
				<?php } 
					}
				}?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li><a href="#" id="logout_1">Logout</a></li>

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

              <li>
				  <a href="support<?php echo $extension; ?>?back_sup=true">Back to Support</a></li>

              <?php } ?>
			  
			  <?php 
			  
			  if(isset($_SESSION['p_token'])){ ?>

              <li>
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
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">

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

			

			

          	$li_style = " ";
          	$a_style = "text-align: left;padding-right: 0px;margin-top: 10px";
          	$b_style = "margin-top: -2px;margin-left: 8px;";
    }
    else{
          	$full_name1 = $full_name;
          	$li_style = " line-height: 60px;";
          	$a_style = "text-align: left;padding-right: 0px";
          	$b_style = "margin-top: 28px;margin-left: 8px;";
    }

    $full_name = 'Profile';

    $full_name1 = 'Profile';
?>

	

<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">
           <?php echo $full_name1; ?> <span class="glyph glyph-angle-down"></span></a>

            <ul class="dropdown-menu" style="left: -30px">
				<?php

				if($script!='verification'){

				if(!(isset($_SESSION['p_token']))){
					if($no_profile != '1'){
				?>
              		<li><a href="profile<?php echo $extension; ?>">Profile</a></li>
				<?php }
					}
				}
				?>

				<?php  if($session_logout_btn_display != 'none'){ ?>

              <li><a href="#" id="logout_2">Logout</a></li>

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

              <li>
				  <a href="support<?php echo $extension; ?>?back_sup=true">Back to Support</a></li>

              <?php } ?>
              
              <?php if($_SESSION['p_token']){ ?>

              <li>
				  <a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a></li>
              
              <?php } ?>
            </ul>


          </li>

          <?php } 

$menutype = $db_class1->setVal('menu_type','ADMIN');
if($menutype=="SUB_MENU"){

	if($top_menu=="bottom"){
				echo '<li class="no_arrow" style="line-height:60px; margin-right: 10px"><a href="intro" style="line-height: 60px !important;">'.$log_img.'</a></li>';
				echo '<style> .logo_img{ max-height: 40px !important; float: none !important; } </style>';
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

	//$main_mod_array = array_reverse($main_mod_array);

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

			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.';" '.$scrpt_active_status.'>
            <a id="hot_a" style="cursor: default">
			<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name2.'</span> <span class="glyph glyph-angle-down"></span></a>';

			if(sizeof($valuem['module'])==1){
				$style_tag1 = "min-width: 100%;width: auto";
				$style_tag2 = 'white-space: nowrap';
				$add_class = "single";
			}
			else{
				$style_tag1 = "";
				$add_class = "multi";
			}
			echo '<ul id="sami_'.$keym.'a" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);'.$style_tag1.'">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;'.$style_tag1.'">
            		<a href="' . $sub_menu_link . '"  target="_blank"  class="new '.$add_class.'" style="padding:5px;'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;'.$style_tag1.'">
            		<a href="' . $sub_menu_link . $extension . '" class="new '.$add_class.'" style="padding:5px;'.$style_tag2.'">' . $sub_menu_name . '</a></li>';
				}
			}

		echo '</ul> </li>';

		}
		else{
		/// Single Item

		if(sizeof($valuem['module'])==1){
			//print_r($valuem['module']);
			foreach ($valuem['module'] as $keyY => $valueY){
				$link_main_m =  $valueY['link'];
				$menu_item_row_id = $valueY['menu_item'];
			}
			$main_menu_name = $valuem['name'];

			$main_menu_name = $package_functions->getPageName($link_main_m,$system_package,$main_menu_name);

				if($scrpt_active_status==''){
					$scrpt_active_status = ' class="no_arrow"';
				}
				else{
					$scrpt_active_status = ' class="active no_arrow"';
				}

				if(strlen($page_names_arr[$main_menu_name])>0){
					$main_menu_name = $page_names_arr[$main_menu_name];
				}

				echo '<li style="width: '.$width_li.';'.$css_right.'" '.$scrpt_active_status.'>
				<a id="dash_'.$keym.'" href="'.$link_main_m.$extension.'">
				<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name.'</span><span class="glyph glyph-angle-down"></span> </a></li>';

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

			$main_menu_name2 = $package_functions->getPageName($link_main_m_multy,$system_package,$main_menu_name2);

			if(strlen($page_names_arr[$main_menu_name2])>0){
					$main_menu_name2 = $page_names_arr[$main_menu_name2];
				}


			echo '<li id="sami_'.$keym.'" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: '.$width_li.';'.$css_right.';" '.$scrpt_active_status.'>
            <a id="hot_a" href="'.$link_main_m_multy.$extension.'">
			<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">'.$main_menu_name2.'</span> <span class="glyph glyph-angle-down"></span></a>';


			echo '<ul id="sami_'.$keym.'a" style="display: none;list-style-type: none;position: absolute; background-color: '.$camp_theme_color.';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);">';
			$link_main_m_multy = '';

			foreach ($modarray as $keyY => $valueY){
				$sub_menu_link = $valueY['link'];
				$sub_menu_new_link = $valueY['nw_link'];
				$sub_menu_name = $valueY['name'];

				if(strlen($page_names_arr[$sub_menu_name])>0){
					$sub_menu_name = $page_names_arr[$sub_menu_name];
				}

				if($sub_menu_new_link==1){
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            		<a href="' . $sub_menu_link . '"  target="_blank"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
				}else {
					echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            		<a href="' . $sub_menu_link . $extension . '" class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
				}
			}

		echo '</ul> </li>';
		}
	}
	}
}

?>

</ul>

</div>
</div>

</div>

<?php } ?>