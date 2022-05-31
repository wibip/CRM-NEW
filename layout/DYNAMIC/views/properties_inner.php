

<style type="text/css">
    /*home styles*/



  .widget-header{
        display: none;
  }
  .widget-content{
    padding: 0px !important;
    border: 1px solid #ffffff !important;
  }
  .intro_page{
    z-index: -4;
  }
  /*.nav-tabs{
    padding-left: 42% !important;
  }
  body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{
        background-color: #000000;
    border: none;
  }*/


  .nav-tabs>li>a{
    border-radius: 0px 0px 0 0 !important;
  }

  .nav-tabs>li:nth-child(1)>a{
    border-right: none !important;
  }

  body {
    background: #ffffff !important;
}


/*footer styles*/

.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}

.main-inner{
  position: relative;
}

.main {
    padding-bottom: 0 !important;
}

  /*network styles
*/

.tab-pane{
  padding-bottom: 50px;
}

.tab-pane:nth-child(1){
  padding-top: 0px;
}

.tab-pane:last-child{
  border-bottom: none;
}

.alert {
    /*position: absolute;*/
    position: unset;
    top: 60px;
    width: 100%;
} 


/* .header2_part1 h2 {
    padding: 50px;
    width: 960px !important;
    margin: auto;
    font-size: 34px;
    margin-top: 80px;
    margin-bottom: 70px;
    text-align: center;
    color: #000;
    font-family: Regular !important;
    box-sizing: border-box;
} */

 h1.head, .header2_part1 h2{
    margin-bottom: 5px !important;
  }

.header2_part1 h2:empty
{
    display:none;
}

#create_users table thead th{
  white-space: pre-line;
  vertical-align: top;
}
#create_users table thead th:nth-child(4) {
    word-spacing: 0px;
    min-width: 125px;
}
#create_users table thead th:nth-child(5) {
  max-width: 50px;
}

#create_users table tbody tr td:nth-child(1),#create_users table tbody tr td:nth-child(2),#create_users table tbody tr td:nth-child(3),#create_users table tbody tr td:nth-child(4){
    max-width: 120px;
    word-break: break-all;
}

.header2_part1 + p + br{
  display: none;
}

@media (max-width: 480px){
   .header2_part1 h2{
          padding-right: 25px !important;
          padding-left: 25px !important;
    }
}

@media (max-width: 979px){
  .header2_part1 h2{
    padding-bottom: 20px !important;
      width: auto !important;
          font-size: 28px !important;
  }
  body a.inline-btn{
    display: inline-block !important;
    margin-top: 0px !important; 
  }
}


</style>
