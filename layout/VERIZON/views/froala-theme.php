<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css"> -->
 
    <!-- Include Editor style. -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_style.min.css" rel="stylesheet" type="text/css" /> -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.0.6/css/froala_editor.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.0.6/css/froala_editor.pkgd.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.0.6/css/froala_style.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.0.6/css/plugins.pkgd.min.css">
  
    <!-- CSS rules for styling the element inside the editor such as p, h1, h2, etc. 
    <link href="../css/froala_style.min.css" rel="stylesheet" type="text/css" /> -->

      <style>


      div#editor {
          height: 700px;
          margin: auto;
          text-align: left;
      }

      .ss {
        background-color: red;
      }

      .fr-toolbar{
        display: none;
      }

      .fr-wrapper:first-child:not([class]) { 
        display: none;
      }

      #imageRemove-1{
        display: none;
      }
  </style>
</head>
 
  <body>

<div id="editor">
      <div id='edit' style="margin-top: 30px;">
		
		<div style="width:100%;height:600px;">       
            <img src="layout/<?php echo $camp_layout; ?>/img/capture2.jpg" alt="background_image" style="width:100%;height:600px;object-fit: cover;">
         <!--   <div style="position: absolute; top: 0px;width:100%;height:100%;background: -webkit-linear-gradient(top , rgba(255, 255, 255, 0.45) 7% , rgba(116, 110, 179, 0.72) 86%);"> -->
                <center>
                    <div style="position: absolute; top: 50px; left:35%;width: 30%;text-align: center;color: white;height:80%;background: -webkit-gradient(linear , left top, left bottom , color-stop(7%, rgb(2, 13, 56)) , color-stop(86%, rgba(28, 0, 82, 0.47)));box-shadow: 0px 0px 20px 10px #b7b1e8;">
                        
                    
                            <div style="position: absolute; top: 20px;right: 35%;">    
                                <img src="layout/<?php echo $camp_layout; ?>/img/logo2.png" width="100px" height="100px" class="fr-fil"/> 
                            </div>

                            <div style="position: absolute; top: 180px; margin:auto;width: 100%;text-align: center; box-sizing: border-box; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; font-size: 17px; font-weight: 300;"><span style="font-size: 28px;">Register and enjoy the wifi service</span>
                                <br style="box-sizing: border-box;">
                            </div>
                           <!--  <div style="position: absolute; top: 250px;margin:auto;width: 100%;text-align: center;box-sizing: border-box; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; font-size: 17px; font-weight: 300;">Please select the type
                                <br style="box-sizing: border-box;">
                            </div> -->
                            <div style="position: absolute; top: 350px;margin:auto;width:100%;text-align: center;">
                                <span style="text-decoration:none;box-sizing: border-box; font-size: 12px; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; background-color: rgb(0, 0, 166); color: rgb(255, 255, 255); text-align: center; border-top-left-radius: 3px; border-top-right-radius: 3px; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; font-weight: 300;">Guest WIFI
                                </span>
                            </div>

                            <br><br>

                            <div style="position: absolute; top: 410px;margin:auto;width:100%;text-align: center;">
                                <span style="text-decoration:none;box-sizing: border-box; font-size: 12px; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; background-color: rgb(0, 0, 166); color: rgb(255, 255, 255); text-align: center; border-top-left-radius: 3px; border-top-right-radius: 3px; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; font-weight: 300;">Private WIFI
                                </span>
                            </div>                       
                    </div>
                </center>
                <!--</div>-->
        </div>
		
      </div>


  </div>
  <button id="saveButton">Save</button>
 
    <!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
  -->
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.pkgd.min.js"></script>
    

  <script>
    $(function(){
		
	
      $('#edit').froalaEditor({
			imageUploadParam: 'image_param',
 
            // Set the image upload URL.
            imageUploadURL: 'ajax/image_new_upload2.php',
			//imageUploadURL: 'uploads',
    
            // Additional upload params.
            imageUploadParams: {id: 'my_editor'},
    
            // Set request type.
            imageUploadMethod: 'POST',
    
            // Set max image size to 5MB.
            imageMaxSize: 5 * 1024 * 1024,
    
            // Allow to upload PNG and JPG.
            imageAllowedTypes: ['jpeg', 'jpg', 'png'],

            saveInterval: 0,
	  
			saveParam: 'content',
 
            // Set the save URL.
            saveURL: 'image_new_save.php',

            // HTTP request type.
            saveMethod: 'POST',

            // Additional save params.
            saveParams: {id: 'my_editor'},

       

	  });
	  
	  $('#saveButton').click (function () {
			$('#edit').froalaEditor('save.save')
		});
		
    });
  </script>

    <?php

    ?>
  </body>
</html>