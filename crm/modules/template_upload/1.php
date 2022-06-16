<link href="css/formValidation.css" rel="stylesheet">
<script type="text/javascript" src="js/formValidation.js"></script>
<script type="text/javascript" src="js/bootstrap_form.js"></script>
<div class="tab-pane <?php if (isset($tab_template_upload)) {
                            echo 'active';
                        } ?>" id="template_upload">

    <?php

    if (isset($_SESSION['template_upload'])) {
        echo $_SESSION['template_upload'];
        unset($_SESSION['template_upload']);
    }
    ?>
    <h3>Upload Template</h3>

<p></p>

<br>
<script>
    $(document).ready(function () {

        $('#image_themp_form').formValidation({
        	framework: 'bootstrap',
        	fields: {

        		temp_name: {
        			validators: {
        				<?php echo $db->validateField('notEmpty'); ?>
        			}
        		}

        	}
        });

        $('#upload-template-form').change(function (e) { 
        e.preventDefault();
        $('#image_themp_form').formValidation().formValidation('validate');
        var isValidForm = $('#image_themp_form').data('formValidation').isValid();
        
        var formData = new FormData(this);
        formData.append('temp_name', $('#temp_name').val());
        if(!isValidForm){
            $("#theme_temp_file").replaceWith($("#theme_temp_file").val('').clone(true));
        }else{

            $('.templateUploadLabel').addClass('upload');
            $('#templateUplaodLoader').css('display', 'block');
            $.ajax({
                type: "POST",
                url: "ajax/templateUpload.php",
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status=='success'){
                        //var a = '<a class="templatePreview" target="_blank" href="ajax/template_view.php?live_preview=set&template_name='+data.data.updatedfilename+'">Preview</a>';
                        $('#uploaded_temp_folder').val(data.data.updatedfilename);
                        $('#old_zip_name').val(data.data.oldfilename);
                        var a = '<span><img src="layout/<?php echo $camp_layout;?>/img/success.png"></span>';
                        $('#uploadRes').html(a);
                    }else{
                        var a = '<span>'+data.data+'</span>';
                        $('#uploadRes').html(a);
                    }
                    $('#content').val(JSON.stringify(data.data.content));
                    $('#img_content').val(JSON.stringify(data.data.img_content));
                    $('#templateUplaodLoader').css('display', 'none');
                    $('.templateUploadLabel').removeClass('upload');
                    $('#image_themp_form').formValidation('revalidateField', 'temp_name');
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#templateUplaodLoader').css('display', 'none');
                    $('.templateUploadLabel').removeClass('upload');
                    var a = 'Upload failed.'
                    $('#uploadRes').html(a);
                    $("#theme_temp_file").replaceWith($("#theme_temp_file").val('').clone(true));
                }
            });
        }
    });
    });
    
</script>
<style>
    .templateUploadLabel::after{
        content:"Browse Template";
    }
    .templateUploadLabel.upload::after{
        content:"Uploading..";
    }
    .fancybox-close {
        display: block !important;
    }
</style>
<div class="upload-form-div" style="
margin-top: -50px;
">
    <form class="form-horizontal upload-form" id="upload-template-form" method="post" enctype="multipart/form-data" style="position: relative; top: 128px;">
        <div class="control-group">
            <label class="control-label" for="radiobtns">Upload Template</label>
            <div class="controls form-group">

                <label class="btn btn-primary templateUploadLabel">

                                            <span><input type="file" name="theme_temp_file" class="span4" id="theme_temp_file" onclick="this.value=null;"/>
                                            </span></label> <div id="uploadRes" style="display:inline-block"></div>
                    <input type="hidden" name="base_portal_folder" value="<?php echo $base_portal_folder; ?>">
                    <input type="hidden" name="img_name" value="<?php echo $img_name; ?>">
                    <input type="hidden" name="img_folder" value="<?php echo $img_folder; ?>">
                    <img id="templateUplaodLoader" style="display:none;margin-top:5px" src="img/loader.gif" alt="Uploading">
                                            </div>
        </div>

    </form>
<form id="image_themp_form" class="form-horizontal" method="post" enctype="multipart/form-data" action="?t=template_upload" >

<?php echo '<input type="hidden" name="theme_temp_secret" id="theme_temp_secret" value="'.$_SESSION['FORM_SECRET'].'" />';?>
                
<div class="control-group" style="
margin-bottom: 98px;
">
            <label class="control-label" for="radiobtns">Template Name</label>
            <div class="controls form-group">

                <input class="span4 form-control" id="temp_name" name="temp_name" type="text"  >

            </div>
        </div>
        
        <input type="hidden" name="uploaded_temp_folder" id="uploaded_temp_folder">
        <input type="hidden" name="content" id="content">
        <input type="hidden" name="img_content" id="img_content">
        <input type="hidden" name="old_zip_name" id="old_zip_name">

<div class="form-actions">
                                    <input type="submit"  name="submit_theme_temp" id="submit_theme_temp" class="btn btn-primary" value="Save" >

                                </div>

</form>
</div>

<div class="widget widget-table action-table">
                <div class="widget-header">
                </div>
                <!-- /widget-header -->
                <div class="widget-content table_response">
                     <div style="overflow-x:auto">
                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>



                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Template Name</th>
                                
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Download</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $gt_template_optioncode = $package_functions->getOptions('TEMPLATE_ACTIVE', $system_package);
                                $pieces1 = explode(",", $gt_template_optioncode);
                                $len1 = count($pieces1);
                                $outstr1 = "";
    
                                for ($i = 0; $i < $len1; $i++) {
                                    if ($i == ($len1 - 1)) {
                                        $outstr1 = $outstr1 . "'" . $pieces1[$i] . "'";
                                    } else {
                                        $outstr1 = $outstr1 . "'" . $pieces1[$i] . "',";
                                    }
                                }

                                $key_q1 = "SELECT DISTINCT t.template_id AS template_id,t.name,t.id,u.`template_id` AS upload_template_id FROM `exp_template` t LEFT JOIN `exp_template_upload` u 
                                ON t.template_id=u.`template_id` 
                                WHERE t.template_id IN ($outstr1) AND t.is_enable=1";

                                $query_results1=$db->selectDB($key_q1);

                               
                                foreach ($query_results1['data'] AS $row) {
                                    $template_id =  $row[template_id];
                                    $upload_template_id =  $row[upload_template_id];
                                    $temp_name = $row[name];
                                    $id = $row[id];
                                    

                                    echo '<tr>
                                        <td> '.$temp_name.' </td>';


                        

                                ///////////////////////////////////////////																	
                                    
                                    echo '<td>';
                                    if($upload_template_id!=NULL){
                                    echo'<a href="javascript:void();" id="DEL_TEMP_' . $id . '"  class="btn btn-small btn-primary">
                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Delete</a><img id="ap_loader_' . $id . '" src="img/loading_ajax.gif" style="display:none">
                                        <script type="text/javascript">
                                        $(document).ready(function() {
                                            $(\'#DEL_TEMP_' . $id . '\').easyconfirm({locale: {
                                                title: \'Delete Template\',
                                                text: \'Are you sure you want to delete this template?\',
                                                button: [\'Cancel\',\' Confirm\'],
                                                closeText: \'close\'
                                                 }
                                            });
                                            $(\'#DEL_TEMP_' . $id . '\').click(function() {
                                                window.location = "?token2=' . $secret . '&t=template_upload&delete_template_id=' . $template_id . '"
                                            });
                                            });
                                        </script></td>';
                                    }else{
                                        echo '-';
                                    }
                                    // echo'<td>';
                                    // if($upload_template_id!=NULL){
                                    // echo '<a class="templatePreview" data-fancybox-type="iframe"  href="ajax/template_view.php?template_name='.$template_id.'">Preview</a>';
                                    // }
                                    // echo'</td>';
                                    echo'<td>';
                                    echo'<a href="ajax/template_download.php?file='.$template_id.'.zip" >Download </a></td>';
                                    echo'</tr>';

                                }
                                ?>


                        </tbody>
                        </table>
                </div>
                </div>
                <!-- /widget-content -->
            </div>
            <!-- /widget -->
</div>