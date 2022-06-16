<!--       <h1 class="head">
    First impressions last,
make yours a splash page. <img data-toggle="tooltip" title='Guests will automatically be redirected to your customizable webpage upon connection to your Guest Wi-Fi network. Create multiple themes for your location and easily enable/disable stored themes from the “Manage” tab.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
</h1> -->

<style type="text/css">

#yourId5{
	width: 200px !important;
    height: 114px !important;
}

#yourId5 .croppedImg{
	width: 200px !important;
    height: 114px !important;
    max-height: 114px !important;
    
}



 .intro_page{
        
    <?php 

    if (file_exists($page_img_url)) {

        echo 'background: url('.$page_img_url.');';
        echo 'height: 337px;margin-top: -35px;background-size: 100%;';
    } 

     ?>

     height: 300px !important;
    margin-top: -35px !important; 
    background-repeat: no-repeat;
    background-size: cover !important;
    background-position: center !important;
        
        
    }

    .intro_page_txt{
           /* width: 960px;*/
            margin: auto;
            text-align: center;
            /* left: 20%; */
            padding-top: 70px;
    }

    .intro_page_txt h1{
        font-size: 47px;
        color: #fff;
        line-height: 50px;
    }

    .intro_page_txt h2{
        font-size: 36px;
        color: #fff;
         line-height: 45px;
    }

    .navbar-fixed-top .navbar-inner{
        padding: 8px;
    }

</style>
