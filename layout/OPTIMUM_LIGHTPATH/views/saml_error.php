
	<link href="../layout/OPTIMUM_LIGHTPATH/css/respo.css" rel="stylesheet">
	<style type="text/css">
		html body{
			background:  #000 !important;
		}
		.logo{
			width: 250px;
			padding-top: 40px;
			padding-bottom: 30px;
		}
		h1{
			font-size: 47px;
			font-family: Montserrat-SemiBold;
			color: #fff;
		}
		.middle{
			background-image: url('../layout/OPTIMUM_LIGHTPATH/img/SAML_Error_Image.jpg');
			width: 100%;
			height: 535px;
			background-size: 100%;
			display: table-cell;
			vertical-align: middle;
			background-repeat:  no-repeat;
		}
		.error-msg{
			color:  #fff;
			text-align:  center;
		}
		.con-dis{

		}
		h2{
			font-size: 35px;
			font-family: Montserrat-Regular;
			text-align:  center;
			color: #fff;
			padding: 50px;
		}
		.btn-div{
			text-align:  center;
    		padding: 20px;
		}
		.btn-div .btn{
			 	font-size: 20px !important;
			    height: 30px;
			    padding-left: 20px;
			    line-height: 30px;
			    color: #fff !important;
			    padding-right: 20px;
		}
		.logo img{
				width: 100%
		}

		@media (max-width: 979px) and (min-width: 768px){
			.middle{
				height: 435px;
			}
		}
		@media (max-width: 767px){
			.logo{
				width: 100%;
				text-align: center;
			}
			.logo img{
				width: 60%
			}
			h1{
				font-size: 37px;
				text-align: center;
			}
			.middle{
				height: auto;
			}
		}
	</style>
<div class="main">
	<div class="container">
    	<div class="logo" style="">
        	<img src="../layout/OPTIMUM_LIGHTPATH/img/logo.png">
    	</div>
		<h1 style="padding-bottom: 30px">It is not your fault!</h1>

		<div class="middle">
				<div class="error-msg">[<?php echo $oops_error_message; ?>]</div>
    			<div class="con-dis"><h2>Contact your Altice Business support and let them know your login failed</h2>
    			<h1 style="text-align:  center;"><?php echo $oops_error_contact; ?></h1></div>
		</div>

		<div class="btn-div"><a href="<?php echo $oops_error_goback; ?>" class="btn btn-primary">Go Back</a></div>
	</div>
</div>
