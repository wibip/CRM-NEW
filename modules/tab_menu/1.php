<ul class="nav nav-tabs newTabs">
    <?php
    require_once __DIR__.'/../../modules/ModuleFunction.php';
    foreach ($modules[$user_type][$script] as $tab){
        if(!ModuleFunction::filter($tab['id'],$module_controls)){
            continue;
        }

        if(!isset($_GET['t'])){
            $_GET['t']=$tab['id'];
            $variable_tab='tab_'.$_GET['t'];
            $$variable_tab='set';
        }else{
            $variable_tab='tab_'.$tab['id'];
        }
        $active = isset($$variable_tab)?'class="active"':'';
        echo '<li '.$active . ' ><a href="#'.$tab['id'].'" data-toggle="tab">'.$tab['name'].'</a></li>';
    }
    ?>
</ul>

<?php
                    
                    $cancel_title = "";
                    $cancel_description = "";

                    if($script=='network'){
                        $cancel_title = "Product Update Cancel";
                        $cancel_description = "Are you sure you want to cancel this product update?";
                    }elseif ($script=='theme') {
                        $cancel_title = "Service Area Update Cancel";
                        $cancel_description = "Are you sure you want to cancel this service area update?";
                    }

                    if($script=='network' || $script=='theme'){ ?>

<div id="network-update-check" class="ui-widget-overlay ui-front" style="display: none;z-index: 100;"></div>
<div id="network-update-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="height: auto;width: auto;top: 55px;left: 50%;display: none;top: 30%;position: fixed;margin-left: -260px;z-index: 9999999999999999999999;">
<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
<span class="ui-dialog-title"><?php echo $cancel_title; ?></span>
<button type="button" id="network-update-check-close" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button></div>
	<div class="dialog confirm ui-dialog-content ui-widget-content" id="ui-id-3" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto;">
	<?php echo $cancel_description; ?>
	</div>
	<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
		<div class="ui-dialog-buttonset">
        <button type="button" id="network-update-check-closed" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false"><span class="ui-button-text">No</span></button>
		<button type="button" id="network-update-reload" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
		<span class="ui-button-text">Yes</span></button>
			
		</div>
	</div>
</div>
<script type="text/javascript">
            $(document).ready(function () {

                $('body').on('click', 'a[data-toggle="tab"]', function(event) {

                    var tabDiv = $(this).attr('href').replace('#', '');
                    $('[data-toggle="tab"]').removeClass('clicked');
                    $(this).addClass('clicked');

                    try{

                        if(!$('#' + tabDiv).hasClass('active')){
                            var check = true;
                            $(".check_update").each(function(){
                                if($(this).val()=='yes'){
                                    check = false;
                                    return false;
                                }
                            });

                            if(!check){
                                $('#network-update-check').show();
                                $('#network-update-check-div').show();
                                return false;
                            }
                        }

                        }
                        catch(err) {
                        }

                });

                $('#network-update-check-closed').click(function(event) {
                    $('#network-update-check').hide();
                    $('#network-update-check-div').hide();
                });
                $('#network-update-check-close').click(function(event) {
                    $('#network-update-check').hide();
                    $('#network-update-check-div').hide();
                });
                $('#network-update-reload').click(function(event) {
                    var url = $('[data-toggle="tab"].clicked').attr('href').replace('#', '');
                    window.location.href = "<?php echo $script; ?>?t="+url;
                });
            });
            </script>
<?php } ?>