<h1 class="head"><span>
    Customer </span> <span>Details <img data-toggle="tooltip" title="Based on the type of splash page theme you have active, data is collected about your visitors. If the splash page theme is using Facebook and Manual or Manual Only template demographic data such as name, email, mobile phone, gender and age group are collected. In case you using a Click & Connect or Passcode Authentication template no data is collected outside of the MAC Address of the device used" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>

<style type="text/css">
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

    h1.head {
    padding: 27px;
    width: 960px !important;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    box-sizing: border-box;}

    @media (max-width: 393px){
    h1.head {
        font-size: 28px;
        text-align: left !important;
    }
    #search_customer_input{
        margin-bottom: 15px;
    }
}

</style>