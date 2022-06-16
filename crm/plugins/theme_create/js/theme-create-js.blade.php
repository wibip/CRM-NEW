<script>
    var imgArr = [],backgroundArr = [];
    var editableArr = [];
    var uploadEditableArr = [];
    var uploadEditableArrFull = [];
    var contenteditable_arr = {!!json_encode($_EDITABLE_["contenteditable_arr"])!!};
    var upCss = {!!json_encode($_UPCSS_,true)!!};
    var upload_arr = {!!json_encode($_EDITABLE_["upload_arr"])!!};
    var color_arr = {!!json_encode($_EDITABLE_["color_arr"])!!};
    var grad_color_arr = {!!json_encode($_EDITABLE_["grad_color_arr"])!!};
    var field_color_arr = {!!json_encode($_EDITABLE_["field_color_arr"])!!};
    appendHtml();
    editF(contenteditable_arr);
    uploadF(upload_arr);
    colorPickF(color_arr);
    gradColorPickF(grad_color_arr);
    if("{{$_FIELD_COLOR_}}"=="true"){
        fieldColorPickF(field_color_arr);
    }
    
    function appendHtml() {
        var optionalTasks = '';

        @if($_ACTION_!="view")
            optionalTasks = '<button class="optional_tasks" style="display: none"></button>';
        @endif

        $('body').prepend('<button id="trigClickPos" style="display:none" onclick="changeIconPos();"></button><span class="preview" alt="preview"></span><div class="create-panel">'+optionalTasks+'</div>');
    }

    function editF(contenteditable_arr) {

        if(contenteditable_arr!=null){
            for (let index = 0; index < contenteditable_arr.length; index++) {
                var charLimit = "";
                if(contenteditable_arr[index]['max-length'] != undefined ){
                    charLimit += "Max allowed characters including spaces are "+contenteditable_arr[index]['max-length']+".<br><br>";
                }
                if(contenteditable_arr[index]['tooltip-class'] != undefined ){
                    var tooltip_class = contenteditable_arr[index]['tooltip-class'];
                }else{
                    var tooltip_class = "";
                }
                var direction = contenteditable_arr[index]['direction'];
                if("{{$_TEMPLATE_NAME_}}"=="res_cox_modern_hori_template" && contenteditable_arr[index]['element']=='welcome_txt'){
                    direction = "right";
                }
                var contClass = "";
                if("{{$_TEMPLATE_NAME_}}"=="res_cox_modern_template" && contenteditable_arr[index]['element']=='welcome_txt'){
                    direction = "right";
                    //contClass = "right-multi";
                }
                $(contenteditable_arr[index]['element']).attr('contenteditable', 'true');
                $(contenteditable_arr[index]['element']).before('<div class="editable-icon '+contClass+'" data-ref='+contenteditable_arr[index]['element']+' data-dir='+direction+'><span class="tooltip '+tooltip_class+'">'+charLimit+'Single click the text to insert edit point.<br> Double-click the text to select a word.<br><br>For adding attributes use the following:<br><br>Italics = CTRl + i<br>Bold = CTRL +b<br>Underline = CTRL + u</span></div>');
            }
        }
    }

    function uploadF(uploadArr) {

        if(uploadArr!=null){
           
        for (let index = 0; index < uploadArr.length; index++) {
            const element = uploadArr[index];
            const elementReg = element['element'].match(/[a-zA-Z0-9-_]+/g);
            if(element['type']=='background'){
                var c = "background";
                var t = "Background";
            }else{
                var c = "";
                var t = "";
            }
            $('.create-panel').append('<div style="display: none !important" class="select-image '+c+' ' + elementReg + '_parent" data-selector=img-' + elementReg + '>Select '+c+' Image</div>');
            if(elementReg=='logo' || elementReg=='main'){
                var st = '';
            }else{
                var st = 'Select an image';
            }
            $('body').append('<div class="image-container img-' + elementReg + '"><div class="img-div"><span class="image-close" data-selector="img-' + elementReg + '"></span><div class="Imgtop">'+ st + '</div><div class="img-inner"></div></div></div>');
            
            if (element['resize']) {
                $(element['element']).resizable({
                    aspectRatio: $(this).width() / $(this).height()
                });
            }
            var uploadExClass = "";
            if(element['tooltip-class']){
                var tooltip_class = element['tooltip-class'];
            }else{
                var tooltip_class = "";
            }
            if(element['alt-txt']=='enabled'){
                var altTxtStyle = "display: none";
                uploadExClass = "up-alttxt";
                if(element['alt-txt-save']=='saved'){
                    $(element['element'] + ' img').hide();
                    altTxtStyle = "display: block";
                    $(element['element']).addClass('aTxt');
                }
                $(element['element']).append('<div style="'+altTxtStyle+'" class="alttxt"><h1 class="txt" style="margin: 0;    min-width: 100%; word-break: break-all;text-align: center;" contenteditable="true" data-max-length="20">'+element['alt-txt-value']+'</h1></div>');
                var altTxt ='<div class="alttxt-icon  '+element['direction']+'" data-ref='+element['element']+'><span class="tooltip '+tooltip_class+'">Add in your business name instead of a logo. It can have up to 20 characters with spaces.</span></div>';
                $(element['element']).append(altTxt);
            } 
            const divElement = element['element'].match(/[a-zA-Z0-9-_]+/g) + '_parent';
            editableArr.push(element['element']);

            if(elementReg=='logo' || elementReg=='main' || elementReg=='Horizontal_img' || elementReg=='verticle_img'){
                pos = false;
            }else{
                pos = true;
            }
            var maxSize = '200';
                    if(element['type']=='background'){
                        var maxSize = '1000';
                    }

            var tooltip = '<span class="tooltip '+tooltip_class+'" style="min-width:200px">Click here to change the image.Maximum size is '+maxSize+'KB and valid formats are jpeg,jpg,png,gif.</span>';
            
            element['pos'] = pos;
            element['tooltip'] = tooltip;
            element['maxSize'] = maxSize;

            if(!element['direction'] && elementReg!='logo'){
                        element['direction'] = 'left';
                    }
                   

            if (element['ref']) {
                
                if(element['alt-txt']!='enabled'){
                uploadEditableArr.push(element['ref']);
                }
                $(element['ref']).addClass('tooltipParent');
                $(element['ref']).attr('data-selector', divElement).attr('data-type', element['type']);
               
            }else{
                if(element['alt-txt']!='enabled'){
                uploadEditableArr.push(element['element']);
                }
                $(element['element']).addClass('tooltipParent');
                $(element['element']).attr('data-type', element['type']);
              
            }
            uploadEditableArrFull.push(element);
            
            $(element['element']).attr('data-selector', divElement);
            if(element['type']=='img'){
                imgArr.push(element['folder']);
            }
                    
            if(element['type']=='background'){
                backgroundArr.push(element['folder']);
            }else{
                if(pos){
                    $(element['element']).addClass('dashed-border');
                }else{
                    $(element['element']).find('img').addClass('dashed-border');
                }
            }
    }
        }
    }

    /* $(".tooltipParent").on( {
    'mousemove':function(e) { 
        if($(this).attr('data-type')=='background'){
            if( e.target === this ){
                $(this).find('span.tooltip').css({left: e.pageX + 30, top: e.pageY - 10, opacity: 1});
            }
        }else{
            $(this).find('span.tooltip').css({left: e.pageX + 30, top: e.pageY - 10, opacity: 1});
        } 
    },
    'mouseout':function(e) {  
        
                $(this).find('span.tooltip').css({left: e.pageX + 30, top: e.pageY - 10, opacity: 0});
            
        } 
    }); */
    function colorPickF(colorPickArr) {
        if(colorPickArr!=null){
        for (let index = 0; index < colorPickArr.length; index++) {

            const element = colorPickArr[index];
            var eleOutSpecial = element['element'].replace(/[^a-zA-Z0-9-_]/g, "");
            var colorElement = eleOutSpecial.match(/[a-zA-Z0-9-_]+/g) + '_colorpicker';
            var divElement = eleOutSpecial.match(/[a-zA-Z0-9-_]+/g) + '_parent';

            if ($('#' + colorElement).length > 0) {
                colorElement = colorElement + '1';
            }
            //$('.create-panel').append("<div class='colorpicker_parent " + divElement + "'>" + element['property-txt'] + " <input type='text' class='colorpicker_input' id='" + colorElement + "' /></div>");

            if (element['class']) {
                var replacerClassName = element['class'];
            } else {
                var replacerClassName = '';
            }
            if (element['tooltip-class']) {
                var tooltip_class = element['tooltip-class'];
            }else{
                var tooltip_class = "";
            }
            if (element['disabled-color-value']) {
                var dis_val = element['disabled-color-value'];
            }else{
                var dis_val = "";
            }
            editableArr.push(element['element']);
            $(element['element']).attr('data-selector', divElement);
            $(element['element']).addClass('dashed-border');
            var x = '<div class="editable-icon color colorpicker_input" id="' + colorElement + '" data-ref='+element['element']+' data-dir='+element['direction']+'><span class="tooltip '+tooltip_class+'">Click here to change the '+element['property-txt']+'.</span></div>';
            var x_disabled = '<div style="display:none;" class="editable-icon color colorpicker_input disable" id="' + colorElement + '_disabled" data-ref='+element['element']+' data-dir='+element['direction']+'><input type="hidden" id="'+element['element'].replace(/[^a-zA-Z0-9-_]/g, "").match(/[a-zA-Z0-9-_]+/g)+element['property']+'_disabled_val" value="'+dis_val+'"><span class="tooltip '+tooltip_class+'">Click here to change the '+element['property-txt']+'.</span></div>';
            if($(element['element']).attr('contenteditable')=="true"){
                $(element['element']).after(x);
                if("{{$_DISABLED_BTN_COLOR_}}"=="true"){
                    $(element['element']).after(x_disabled);
                }
            }else{
                $(element['element']).after(x);
                if("{{$_DISABLED_BTN_COLOR_}}"=="true"){
                    $(element['element']).after(x_disabled);
                }
            }

            if(element['property']=='color'){
                var pro_val = 'color';
            }else{
                var pro_val = 'background-color';
            }

            $("#" + colorElement).spectrum({
                color: $(element['element']).css(pro_val),
                showPalette: true,
                replacerClassName: replacerClassName,
                preferredFormat: "hex3",
                showInput:true,
                palette: [
                    [$(element['element']).css(pro_val)]
                ],
                showAlpha: element['showAlpha'],
                move: function(color) {
                    var a = new Array();
                    if($(element['element']).attr('style')){
                        var ex = $(element['element']).attr('style');
                        var res = ex.split(";");
                        var st = 0;
                        for(key in res){
                            var x = res[key].split(":")[0];
                            if(element['property']==x){
                                var c = x + ':'+color.toHslString()+' !important';
                                st = 1;
                            }else{
                                var c = res[key];
                            }
                            
                            a[key] = c
                        }
                        if(st==0){
                            a.push(element['property']+': '+color.toHslString()+' !important');
                        }
                        a = a.join(';');
                    }else{
                        var a = element['property']+': '+color.toHslString()+' !important ;';
                    }
                    $(element['element']).attr('style', a);
                    
                },
                change: function(color) {
                    var a = new Array();
                    if($(element['element']).attr('style')){
                        var ex = $(element['element']).attr('style');
                        var res = ex.split(";");
                        var st = 0;
                        for(key in res){
                            var x = res[key].split(":")[0];
                            if(element['property']==x){
                                var c = x + ':'+color.toHslString()+' !important';
                                st = 1;
                            }else{
                                var c = res[key];
                            }
                            
                            a[key] = c
                        }
                        if(st==0){
                            a.push(element['property']+': '+color.toHslString()+' !important');
                        }
                        a = a.join(';');
                    }else{
                        var a = element['property']+': '+color.toHslString()+' !important ;';
                    }
                    $(element['element']).attr('style', a);
                    
                }
            });

            $("#" + colorElement+'_disabled').spectrum({
                color: $(element['element']+':disabled').css(pro_val),
                showPalette: true,
                replacerClassName: replacerClassName,
                preferredFormat: "hex3",
                showInput:true,
                palette: [
                    [$(element['element']+':disabled').css(pro_val)]
                ],
                showAlpha: element['showAlpha'],
                move: function(color) {
                    var a = new Array();
                    if($(element['element']+':disabled').attr('style')){
                        var ex = $(element['element']+':disabled').attr('style');
                        var res = ex.split(";");
                        var st = 0;
                        for(key in res){
                            var x = res[key].split(":")[0];
                            if(element['property']==x){
                                var c = x + ':'+color.toHslString()+' !important';
                                st = 1;
                            }else{
                                var c = res[key];
                            }
                            
                            a[key] = c
                        }
                        if(st==0){
                            a.push(element['property']+': '+color.toHslString()+' !important');
                        }
                        a = a.join(';');
                    }else{
                        var a = element['property']+': '+color.toHslString()+' !important ;';
                    }
                    $(element['element']+':disabled').attr('style', a);
                    $("#" + element['element'].replace(/[^a-zA-Z0-9-_]/g, "").match(/[a-zA-Z0-9-_]+/g)+element['property']+'_disabled_val').val(color.toHslString()+' !important ;');
                },
                change: function(color) {
                    var a = new Array();
                    if($(element['element']+':disabled').attr('style')){
                        var ex = $(element['element']+':disabled').attr('style');
                        var res = ex.split(";");
                        var st = 0;
                        for(key in res){
                            var x = res[key].split(":")[0];
                            if(element['property']==x){
                                var c = x + ':'+color.toHslString()+' !important';
                                st = 1;
                            }else{
                                var c = res[key];
                            }
                            
                            a[key] = c
                        }
                        if(st==0){
                            a.push(element['property']+': '+color.toHslString()+' !important');
                        }
                        a = a.join(';');
                    }else{
                        var a = element['property']+': '+color.toHslString()+' !important ;';
                    }
                    $(element['element']+':disabled').attr('style', a);
                    $("#" + element['element'].replace(/[^a-zA-Z0-9-_]/g, "").match(/[a-zA-Z0-9-_]+/g)+element['property']+'_disabled_val').val(color.toHslString()+' !important ;');
                }
            });
            
        }
        }
    }

    function gradColorPickF(gradColorPick) {
        if(gradColorPick!=null){
            for (let index = 0; index < gradColorPick.length; index++) {
                const element = gradColorPick[index];
                var eleOutSpecial = element['element'].replace(/[^a-zA-Z0-9-_]/g, "");
                var colorElement = eleOutSpecial.match(/[a-zA-Z0-9-_]+/g) + '_colorpicker';
                var divElement = eleOutSpecial.match(/[a-zA-Z0-9-_]+/g) + '_parent';

                if ($('#' + colorElement).length > 0) {
                    colorElement = colorElement + '1';
                }

                var divStr = "modal_"+colorElement;
                if (element['tooltip-class']) {
                    var tooltip_class = element['tooltip-class'];
                }else{
                    var tooltip_class = "";
                }

                if (!element['pos_val']) {
                    element['pos_val'] = element['default_pos'];
                }

                if (!element['color_val']) {
                    element['color_val'] = element['default'];
                }
                
                //$(element['element']).css({ "background": "-webkit-linear-gradient(top, "+ element['color_val'] +" "+element['pos_val']+"%, "+element['2nd_color']+" "+element['2nd_pos']+"%)", "background": "-o-linear-gradient(top, "+ element['color_val'] +" "+element['pos_val']+"%, "+element['2nd_color']+" "+element['2nd_pos']+"%)", "background": "linear-gradient(to bottom, "+ element['color_val'] +" "+element['pos_val']+"%, "+element['2nd_color']+" "+element['2nd_pos']+"%"});
                var z = '<input type="hidden" id="'+colorElement+'_pos_val">';
                z = z +'<input type="hidden" id="'+colorElement+'_color_val">';
                z = z +'<input type="hidden" id="'+colorElement+'_2nd_pos">';
                z = z +'<input type="hidden" id="'+colorElement+'_2nd_color">';
                var y = '<div class="modal-grad" id="modal_'+colorElement+'"><div class="modal-content"><span class="modal-grad-close">x</span> <div style=" display: inline-block; margin-left: 5px; " class="dis_overlay"> <input type="checkbox" onclick="disableOverlay(\''+element['element']+'\',\''+element['pos_val']+'\',\''+element['color_val']+'\',\''+colorElement+'\',\''+element['2nd_pos']+'\',\''+element['2nd_color']+'\')" id="disable_overlay" style=" display: inline-block;"> <span class="tooltip '+tooltip_class+'">Disable Overlay</span></div><input type="text" id="input-'+colorElement+'" /><div style="margin-top: 15px;width: 228px;display:inline-block" class="slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 28%;"></a></div></div></div>';
                var x = '<div class="editable-icon color grad colorpicker_input" id="' + colorElement + '" onclick="openModal(\''+divStr+'\');" data-ref='+element['element']+' data-dir="left"><span class="tooltip '+tooltip_class+'">Click here to change the overlay style.</span></div>'+y+z;
                $(element['element']).prepend(x);
                setGradColor(element['element'],element['pos_val'],element['color_val'],colorElement,element['2nd_pos'],element['2nd_color']);
                $("#input-"+colorElement).spectrum({
                    color: element['color_val'],
                    showAlpha: true,
                    move: function(color) {
                        $('#disable_overlay').prop('checked', false);
                        setGradColor(element['element'],$('.slider').slider("option", "value"),color.toRgbString(),colorElement,element['2nd_pos'],element['2nd_color']);
                    },
                    change: function(color) {
                        $('#disable_overlay').prop('checked', false);
                        setGradColor(element['element'],$('.slider').slider("option", "value"),color.toRgbString(),colorElement,element['2nd_pos'],element['2nd_color']);
                    }
                });

                $( ".slider" ).slider({
						 value: parseInt(element['pos_val']),
					  change: function( event, ui ) {
                        $('#disable_overlay').prop('checked', false);
						  setGradColor(element['element'],ui.value,$("#input-"+colorElement).spectrum("get").toRgbString(),colorElement,element['2nd_pos'],element['2nd_color']);
					  }
                    });
                    
                    
                if(element['disable']){
                    if(element['disable']=='true'){
                        $('#disable_overlay').prop('checked', true);
                        disableOverlay(element['element'],element['pos_val'],element['color_val'],colorElement,element['2nd_pos'],element['2nd_color']);
                    }
                }
            }
        }
    }

    function fieldColorPickF(fieldColorPickArr){
        if(fieldColorPickArr){
            if(fieldColorPickArr['bg-color']){
                var bg_color = fieldColorPickArr['bg-color'];
            }else{
                var bg_color = 'rgba(7, 7, 7, 0.91)';
            }
            if(fieldColorPickArr['font-color']){
                var font_color = fieldColorPickArr['font-color'];
            }else{
                var font_color = 'rgb(255 255 255)';
            }
        }

        try {
            var tooltip_class = fieldColorPickArr['tooltip-class'];
        } catch (error) {
            var tooltip_class = "";
        }

        $('.survey-form').append('<div class="editable-icon color ml1" id="bg_field" data-ref=".login-form" data-dir="right"><input type="hidden" id="field_bg_val" value="'+bg_color+'"><span class="tooltip '+tooltip_class+'">Click here to change the Background Color of the fields.</span></div><div class="editable-icon color ml2" id="font_field" data-ref=".login-form" data-dir="right"><input type="hidden" id="field_font_val" value="'+font_color+'"><span class="tooltip '+tooltip_class+'">Click here to change the Font Color of the fields.</span></div>');
            
            $("#bg_field").spectrum({
                color: bg_color,
                showPalette: true,
                preferredFormat: "hex3",
                showInput:true,
                palette: [
                    [bg_color]
                ],
                showAlpha: true,
                move: function(color) {
                    $('#field_bg_val').val(color.toHslString()+' !important');
                    $('.survey-form .input').attr('style', 'background : ' + color.toHslString()+' !important');
                    $('.nice-select .list').attr('style', 'background : ' + color.toHslString()+' !important');
                    $('#field_bg_style').remove();
                    $('body').append('<style id="field_bg_style">.nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus { background : ' + color.toHslString()+' !important }</style>');
                },
                change: function(color) {
                    $('#field_bg_val').val(color.toHslString()+' !important');
                    $('.survey-form .input').attr('style', 'background : ' + color.toHslString()+' !important');
                    $('.nice-select .list').attr('style', 'background : ' + color.toHslString()+' !important');
                    $('#field_bg_style').remove();
                    $('body').append('<style id="field_bg_style">.nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus { background : ' + color.toHslString()+' !important }</style>');
                }
            });
            $("#font_field").spectrum({
                color: font_color,
                showPalette: true,
                preferredFormat: "hex3",
                showInput:true,
                palette: [
                    [font_color]
                ],
                showAlpha: true,
                move: function(color) {
                    $('#field_font_val').val(color.toHslString()+' !important');
                    $('#field_color_style').remove();
                    $('body').append('<style id="field_color_style"> .form-element .input input { color :' + color.toHslString()+' !important } ::-webkit-input-placeholder { color :' + color.toHslString()+' !important } ::-moz-placeholder { color :' + color.toHslString()+' !important } :-ms-input-placeholder { color :' + color.toHslString()+' !important } :-moz-placeholder { color :' + color.toHslString()+' !important } .nice-select.ele .current, .nice-select, .nice-select .option.disabled { color :' + color.toHslString()+' !important  } .nice-select:after { border-color :' + color.toHslString()+' !important }</style>')
                },
                change: function(color) {
                    $('#field_font_val').val(color.toHslString()+' !important');
                    $('#field_color_style').remove();
                    $('body').append('<style id="field_color_style"> .form-element .input input { color :' + color.toHslString()+' !important } ::-webkit-input-placeholder { color :' + color.toHslString()+' !important } ::-moz-placeholder { color :' + color.toHslString()+' !important } :-ms-input-placeholder { color :' + color.toHslString()+' !important } :-moz-placeholder { color :' + color.toHslString()+' !important } .nice-select.ele .current, .nice-select, .nice-select .option.disabled { color :' + color.toHslString()+' !important  } .nice-select:after { border-color :' + color.toHslString()+' !important }</style>')
               
                }
            });
    }

    function setGradColor(element,val1,color1,colorElement,pos2,colo2){
        $('#'+colorElement+'_pos_val').val(val1);
        $('#'+colorElement+'_color_val').val(color1);
        $('#'+colorElement+'_2nd_pos').val(pos2);
        $('#'+colorElement+'_2nd_color').val(colo2);
        $(element).css({ "background": "-webkit-linear-gradient(top, "+ color1 +" "+val1+"%, "+colo2+" "+pos2+"%)", "background": "-o-linear-gradient(top, "+ color1 +" "+val1+"%, "+colo2+" "+pos2+"%)", "background": "linear-gradient(to bottom, "+ color1 +" "+val1+"%, "+colo2+" "+pos2+"%"});
    }

    function openModal(x){
        $("#"+x).show();
    }
    function setUpload(cssClass, type) {
        return '<div class="upload_parent">upload image<label class="no_crop_label"><span><input data-type="' + type + '" type="file" name="' + cssClass + '" class="no_crop"></span></label></div>';
    }

    function UploadImg(that,parent,alt) {

var name = that.files[0].name;

if(name.length==0){
	return false;
}

if(alt.length>0){
	$(parent).find('img').show();
    $(parent).find('.alttxt').hide();
    $(parent).removeClass('aTxt');
    changeIconPos();
}

var form_data = new FormData();
form_data.append("file", that.files[0]);
form_data.append("type", 'theme_img_logo');
form_data.append("discode", '{{$_USER_DISTRIBUTOR_}}');

$.ajax({
	   url:"{{$_GLOBAL_URL_}}/ajax/ajaxthemeimage.php",
	   method:"POST",
	   type:"POST",
	   data: form_data,
	   contentType: false,
	   cache: false,
	   processData: false,
	   beforeSend:function(){

	   $(parent).append('<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>');
		
	   },    
	   success:function(data)
	   {
		   $(parent+' .loader.bubblingG').remove();
		   var respo = JSON.parse(data);
			if(respo.status_code=='200'){
				$(parent+' img').attr('data-name',respo.response.img_name);
				$(parent+' img').attr('src',respo.response.srcdata).load(function(){
                    changeIconPos();
                });
			}else{
				alert(respo.response);
			}
	   }
});
}
    
$( window ).scroll(function() {
            changeIconPos();
        });

        $("[contenteditable='true']").on("change paste keyup", function() {
            changeIconPos();
        });
        $(window).load(function() {

            for (let index = 0; index < uploadEditableArrFull.length; index++) {
            const element = uploadEditableArrFull[index];
            var crop = true;
            if(element['crop']=="false"){
                crop = false;
            }
            if(element['tooltip-class']){
                var tooltip_class = element['tooltip-class'];
            }else{
                var tooltip_class = "";
            }
            if(element['element']=='.logo'){
                var uploadExClass = "";
                if(element['alt-txt']=='enabled'){
                    uploadExClass = "up-alttxt";
                }
                var tooltip = '<span class="tooltip" style="min-width:400px">The maximum space the logo can occupy is 180px (width) by 100px (height). Any shape or size logo is allowed, but the system will scale the logo, keeping its original aspect ratio to fit within the above space. Maximum size is 200KB. This restriction is set to avoid the captive portal to load slow due to a large logo. Valid formats are jpeg,jpg,png,gif. <br><br> Ex. If the width is more than 180px, the system will scale it into 180px and the height will be auto adjusted. If width is less than 180px and height is more than 100px, the height will be adjusted to 100px and the width will be auto adjusted.</span>';
                if(element['tooltip-txt']){
                     tooltip = '<span class="tooltip '+tooltip_class+'">'+element['tooltip-txt']+'</span>';
                }
                $(element['element']).append('<div class="cropControls cropControlsUpload editable-icon-upload '+uploadExClass+'" data-ref="'+element['element']+'"> <label><i class="cropControlUpload"><input type="file" name="img" class="no_crop" onchange="UploadImg(this,\''+element['element']+'\',\''+uploadExClass+'\');"></i></label>'+tooltip+' </div>');
            }else if(crop==false){
                $(element['element']).after('<div class="cropControls cropControlsUpload editable-icon-upload '+uploadExClass+'" data-ref="'+element['element']+'"> <label><i class="cropControlUpload"><input type="file" name="img" class="no_crop" onchange="UploadImg(this,\''+element['parent']+'\',\''+uploadExClass+'\');"></i></label><span class="tooltip '+tooltip_class+'">Click here to change the image.Maximum size is 200KB and valid formats are jpeg,jpg,png,gif.</span> </div>');
            } else{

            new Croppic(element['element'], {
                uploadUrl:'{{$_GLOBAL_URL_}}/plugins/img_upload/img_save_to_file_template_upload.php',
                uploadData:{
				"maxSize":element['maxSize']
			    },
                cropUrl:'{{$_GLOBAL_URL_}}/plugins/img_upload/img_crop_to_file_template_upload.php?discode={{$_USER_DISTRIBUTOR_}}',
                modal:true,
                doubleZoomControls:false,
                rotateControls: false,
                loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                onBeforeImgUpload: function(){  },
                onAfterImgUpload: function(){ $('.cropControlUpload').hide();  },
                onImgDrag: function(){  },
                onImgZoom: function(){  },
                onBeforeImgCrop: function(){  },
                onAfterImgCrop:function(){ $('.cropControlUpload').show(); changeIconPos(); },
                onReset:function(){ $('.cropControlUpload').show(); changeIconPos(); },
                onError:function(errormessage){ $('.cropControlUpload').show(); changeIconPos(); }
            },element);
        }

        }

        

            $('.editable-icon-upload').each(function (index, element) {
                if(($(window).width()-$(this).offset().left) < 510){
                    $(this).addClass('left');
                }
                
            });
            
        $('.editable-icon').each(function (index, element) {
            if((($(window).width()-$(this).offset().left) < 200) || $(this).offset().left < 0){
                $(this).find('span.tooltip').addClass('tooltip-left');
            }
            
        });


        changeIconPos();
});

        $(window).on('resize', function(){
            changeIconPos();
        });
        $("#help_click1").on("click", function() {
            changeIconPos();
        });
        $('#wrap1').on('resize', function(){
            changeIconPos();
        });

        if (!String.prototype.startsWith) {
  String.prototype.startsWith = function(searchString, position) {
    position = position || 0;
    return this.indexOf(searchString, position) === position;
  };
}
    function changeIconPos(scrollPosition){

        scrollPosition = $(window).scrollTop();

        $('.editable-icon-upload').each(function (index, element) {
            
            if($(this).attr('data-ref')=='.logo'){
                if($($(this).attr('data-ref')+" img").css('display') == 'none'){
                    $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top - scrollPosition)+'px',
                        left: (($($(this).attr('data-ref')+" h1").offset().left + $($(this).attr('data-ref')+" h1").outerWidth()) + 34)+'px'
                    });
                }else{
                $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top - scrollPosition)+'px',
                        left: (($($(this).attr('data-ref')+" img").offset().left + $($(this).attr('data-ref')+" img").outerWidth()) + 34)+'px'
                    });
                }

                $('.alttxt-icon').css({
                        top: ($("[data-ref='.logo'].cropControlsUpload").offset().top-scrollPosition)+'px',
                        left: (($("[data-ref='.logo'].cropControlsUpload").offset().left + $("[data-ref='.logo'].cropControlsUpload").outerWidth()) + 30)+'px'
                    });

            }
            else{
                if($(this).attr('data-direction')=='left'){
                    $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                        left: ($($(this).attr('data-ref')).offset().left)+'px'
                    });
                }else{
                    $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                        left: (($($(this).attr('data-ref')).offset().left + $($(this).attr('data-ref')).outerWidth()) + 5)+'px'
                    });
                }
            }
        });

        $('.gallery-icon').each(function (index, element) {
            $(this).css({
                    top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                    left: (($($(this).attr('data-ref')).offset().left + $($(this).attr('data-ref')).outerWidth()) + 5)+'px'
                });
        });
        $('.editable-icon:not(#hr_colorpicker):not(.grad)').each(function (index, element) {
            var x = $(this).attr('data-selector');
            var b=false;
            if(x != undefined){
                b = x.startsWith('upload_img_');
            }
            if($(this).attr('data-ref')=='#accept_txt'){
                $(this).css({
                    top: ($($(this).attr('data-ref')).parent().offset().top-scrollPosition)+'px',
                    left: ($($(this).attr('data-ref')).parent().offset().left + $($(this).attr('data-ref')).parent().outerWidth() + 35)+'px'
                });
                if("{{$_DISABLED_BTN_COLOR_}}"!="true"){
                    $(this).addClass('dup');
                }
            }
            else if($(this).attr('data-dir')=='left-in'){
                $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                        left: ($($(this).attr('data-ref')).offset().left)+'px'
                    });
            }
            else if($(this).hasClass('color') || $(this).attr('data-dir')=='right'){
                $(this).css({
                    top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                    left: (($($(this).attr('data-ref')).offset().left + $($(this).attr('data-ref')).outerWidth()) + 5)+'px'
                });
                if("{{$_DISABLED_BTN_COLOR_}}"!="true"){
                    $(this).addClass('dup');
                }
                //$(this).addClass('dup');
            }else if(b){
                $(this).css({
                    top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                    left: ($($(this).attr('data-ref')).offset().left)+'px'
                });        
            }else{
                if($(this).attr('data-ref')=='registration_btn'){
                    $(this).css({
                        top: ($($(this).attr('data-ref')).parent().offset().top-scrollPosition)+'px',
                        left: ($($(this).attr('data-ref')).parent().offset().left - 30)+'px'
                    });
                }else{
                    $(this).css({
                        top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                        left: ($($(this).attr('data-ref')).offset().left - 30)+'px'
                    });
                }
            }         
        });
        $('.editable-icon.grad').each(function (index, element) {
            $(this).css({
                top: ($($(this).attr('data-ref')).offset().top-scrollPosition)+'px',
                left: ($($(this).attr('data-ref')).offset().left + 28)+'px'
            });        
        });
    }

    function disableOverlay(element,pos_val,color_val,colorElement,pos2,colo2){
        if ($('#disable_overlay').is(':checked')) {
            $(element).css({ "background":"none"});
            
        }else{
            try {
                var pos_val_new = $('.slider').slider("option", "value");
                var color_val_new = $("#input-"+colorElement).spectrum("get").toRgbString();
            } catch (error) {
                var pos_val_new = pos_val;
                var color_val_new = color_val;
            }
            setGradColor(element,pos_val_new,color_val_new,colorElement,pos2,colo2);
        }
    }
    $(document).ready(function() {

        $('span.upload, .alttxt-icon, .editable-icon-upload').each(function (index, element) {
            if(($(window).width()-$(this).offset().left) < 200){
                $(this).addClass('left');
            }
            
        });

        
        $(".fancybox").fancybox();
        @if($_ACTION_!="view")
        $('.survey-form').append('<div class="editable-icon survey" data-ref=".survey-form" data-dir="right"><span class="tooltip">Click here to select which fields to show</span></div>');

        $('.survey-form').click(function(e) {
            $('.modal-m').show();
        });

        $('.modal-close').click(function(e) {
            e.stopPropagation();
            $('.modal-m').hide();
        });

        $('.modal-grad-close').click(function(e) {
            e.stopPropagation();
            $('.modal-grad').hide();
        });

        @endif

        $('.ref-input').click(function(e) {
            if($(this).prop( "checked")){
                $('#'+$(this).data('ref')).show();
            }else{
                
                if($('.ref-input:checkbox:checked').length < 1){
                    $('#ap_id').empty();
                    $('#ap_id').append('At least one option should be enabled.');
                    $('#servicear-check-div').show();
                    $('#sess-front-div').show();
                    //alert('At least one option should be enabled.');
                    return false;
                }
                $('#'+$(this).data('ref')).hide();
            }
            try {
                $('#right-top').trigger('resizediv');
            } catch (error) {
                
            }
            changeIconPos();
        });

        $('.ref-input-man').click(function(e) {
            if($(this).prop( "checked")){
                $('#'+$(this).data('ref')).parent().show();
            }else{
                
                if($('.ref-input-man:checkbox:checked').length < 1){
                    $('#ap_id').empty();
                    $('#ap_id').append('At least one option should be enabled.');
                    $('#servicear-check-div').show();
                    $('#sess-front-div').show();
                    //alert('At least one option should be enabled.');
                    return false;
                }
                $('#'+$(this).data('ref')).parent().hide();
            }
            try {
                $('#right-top').trigger('resizediv');
            } catch (error) {
                
            }
            changeIconPos();
        });
        
        $('body').on('click', '#save_changes', function(e) {
            e.preventDefault();
            $(this).html('saving..');
            
            for (let index = 0; index < contenteditable_arr.length; index++) {
                contenteditable_arr[index]['value']=$(contenteditable_arr[index]['element']).html();
            }

            for (let index = 0; index < upload_arr.length; index++) {

                if(upload_arr[index]['alt-txt']=='enabled'){
                    if($(upload_arr[index]['element']+' .alttxt').is(":visible")){
                        upload_arr[index]['alt-txt-value'] = $(upload_arr[index]['element']+' .alttxt h1').text();
                        upload_arr[index]['alt-txt-save'] = "saved";
                    }else{
                        upload_arr[index]['value']=$(upload_arr[index]['element'] + ' img').attr('data-name');
                        upload_arr[index]['alt-txt-save'] = "notsaved";
                        upload_arr[index]['css']="width:"+$(upload_arr[index]['element'] + ' img').css('width')+"; height:"+$(upload_arr[index]['element'] + ' img').css('height')+";";
                    }
                }else{
                    if (upload_arr[index]['type'] == 'background') {
                        upload_arr[index]['value']=$(upload_arr[index]['element']).attr('data-name');
                        upload_arr[index]['css']="width:"+$(upload_arr[index]['element']).css('width')+"; height:"+$(upload_arr[index]['element']).css('height')+";";
                    }else if(upload_arr[index]['type'] == 'img_upload' || upload_arr[index]['type'] == 'template_upload'){
                        upload_arr[index]['value']=$(upload_arr[index]['element']).attr('data-name');
                        upload_arr[index]['css']="width:"+$(upload_arr[index]['element']).css('width')+"; height:"+$(upload_arr[index]['element']).css('height')+";";
                    }else{
                        upload_arr[index]['value']=$(upload_arr[index]['element'] + ' img').attr('data-name');
                        upload_arr[index]['css']="width:"+$(upload_arr[index]['element']).css('width')+"; height:"+$(upload_arr[index]['element']).css('height')+";";
                    }
                }
            }
            for (let index = 0; index < color_arr.length; index++) {

                if("{{$_DISABLED_BTN_COLOR_}}"=="true" && (color_arr[index]['element']=='#click_reg_submit_unique_button' || color_arr[index]['element']=='#pass_reg_submit_unique_button')){
                    var css="";
                    var st = 0;
                    var eleOutSpecial = color_arr[index]['element'].replace(/[^a-zA-Z0-9-_]/g, "").match(/[a-zA-Z0-9-_]+/g)+color_arr[index]['property']+'_disabled_val';
                    
                    if($("#" + eleOutSpecial).val()){
                        css = $("#" + eleOutSpecial).val();
                    }
                    color_arr[index]['disabled-color-value']=css;

                }
                try{
                    saveChangesTOC();
                }catch(err) {}
                var css;
                var st = 0;
                if($(color_arr[index]['element']).attr('style')){
                    var ex = $(color_arr[index]['element']).attr('style');
                        var res = ex.split(";");
                        for(key in res){
                            var x = res[key].split(":")[0];
                            if(color_arr[index]['property']==x){
                                css = res[key].split(":")[1];
                                var st = 1;
                                break;
                            }
                        }
                }
                if(st == 0){
                    css = $(color_arr[index]['element']).css(color_arr[index]['property']);
                }
                css = String(css).replace(/"/g, "'");
                color_arr[index]['value']=css;
            }

        if(grad_color_arr!=null){
            for (let index = 0; index < grad_color_arr.length; index++) {
                const element = grad_color_arr[index];
                var eleOutSpecial = element['element'].replace(/[^a-zA-Z0-9-_]/g, "");
                var colorElement = eleOutSpecial.match(/[a-zA-Z0-9-_]+/g) + '_colorpicker';

                grad_color_arr[index]['pos_val'] = $('#'+colorElement+'_pos_val').val();
                grad_color_arr[index]['color_val'] = $('#'+colorElement+'_color_val').val();
                grad_color_arr[index]['2nd_pos'] = $('#'+colorElement+'_2nd_pos').val();
                grad_color_arr[index]['2nd_color'] = $('#'+colorElement+'_2nd_color').val();

                if ($('#disable_overlay').is(':checked')) {
                    grad_color_arr[index]['disable'] = 'true';
                }else{
                    grad_color_arr[index]['disable'] = 'false';
                }
            }
        }

        if("{{$_FIELD_COLOR_}}"=="true"){
            var field_bg_val = $('#field_bg_val').val();
            var field_font_val = $('#field_font_val').val();
            field_color_arr = {
                "bg-color":field_bg_val,
                "font-color":field_font_val
            };
        }else{
            field_color_arr = [
                
                ];
        }


            var elementData;

            try {
                
                $.loadScript("{{$_BASE_URL_}}/src/registration/{{$_REG_TYPE_}}/js/reg.js", function(){
                   elementData = regInit();

                   var json = { "contenteditable_arr":contenteditable_arr,"upload_arr":upload_arr,"color_arr":color_arr,"grad_color_arr":grad_color_arr,"elementData":elementData,"field_color_arr":field_color_arr }

            var data = {
                "template_name": "{{$_TEMPLATE_NAME_}}",
                "enc": "{{$_ENC_}}",
                "data": JSON.stringify(json)
            };
            $.ajax({
            type: "POST",
            url: "{{$_GLOBAL_URL_}}/ajax/theme_create_save.php",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                
                if(obj.status=='success'){
                    $('#theme_create_form_submit').click();
                }else{
                    swal({ button: {
                        text: "OK",
                        // className: "btn-primary"
                    },dangerMode: true,text:"Failed. Please try again!"}).then(function(value) {
                    });
                }
                $(this).html('save');
                
            }
        });
                }, function(){
                    elementData = null;

var json = { "contenteditable_arr":contenteditable_arr,"upload_arr":upload_arr,"color_arr":color_arr,"grad_color_arr":grad_color_arr,"elementData":elementData }

var data = {
"template_name": "{{$_TEMPLATE_NAME_}}",
"enc": "{{$_ENC_}}",
"data": JSON.stringify(json)
};
$.ajax({
type: "POST",
url: "{{$_GLOBAL_URL_}}/ajax/theme_create_save.php",
data: data,
success: function(response) {
var obj = JSON.parse(response);

if(obj.status=='success'){
    $('#theme_create_form_submit').click();
}else{
    swal({ button: {
        text: "OK",
        // className: "btn-primary"
    },dangerMode: true,text:"Failed. Please try again!"}).then(function(value) {
    });
}
$(this).html('save');

}
});
                });
                
            } catch (error) {
                elementData = null;

                var json = { "contenteditable_arr":contenteditable_arr,"upload_arr":upload_arr,"color_arr":color_arr,"grad_color_arr":grad_color_arr,"elementData":elementData }

            var data = {
                "template_name": "{{$_TEMPLATE_NAME_}}",
                "enc": "{{$_ENC_}}",
                "data": JSON.stringify(json)
            };
            $.ajax({
            type: "POST",
            url: "{{$_GLOBAL_URL_}}/ajax/theme_create_save.php",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                
                if(obj.status=='success'){
                    $('#theme_create_form_submit').click();
                }else{
                    swal({ button: {
                        text: "OK",
                        // className: "btn-primary"
                    },dangerMode: true,text:"Failed. Please try again!"}).then(function(value) {
                    });
                }
                $(this).html('save');
                
            }
        });
            }
        
        });

        $('.preview').click(function(e) {
            e.preventDefault();
            if ($(this).hasClass('open')) {
                $('.create-panel').show();
                $('[data-contenteditable="true"]').attr("contenteditable", "true");
                $(this).removeClass('open');
                $('html').removeClass('open');
            } else {
                $('.create-panel').hide();
                $('[contenteditable="true"]').attr("data-contenteditable", "true").attr("contenteditable", "false");
                $(this).addClass('open');
                $('html').addClass('open');
            }
        });
        $(editableArr.join(", ")).bind('click', function(e) {
            e.stopPropagation();
            $('.colorpicker_parent, .select-image:not(.background)').css("display", "none");
            $('.' + $(this).attr("data-selector")).css("display", "inline-block");
        });

        $(uploadEditableArr.join(", ")).bind('click', function(e) {

            if($(this).attr('data-type')=='background'){
                if ($(e.target).hasClass('upload') ) {
                    $('.' + $(this).attr("data-selector")+'.select-image').click();
                }
            }else{
                if ($(e.target).hasClass('gallery-icon') ) {
                    $('.img-' + $(e.target).attr("data-ref").match(/[a-zA-Z0-9-_]+/g)).addClass('open');
                }
            }

        });

        $('.upload:not(.up-alttxt)').bind('click', function(e) {
            $(this).parent().click();
        });

        $('.alttxt-icon').bind('click', function(e) {
            $(this).parent().find('img').hide();
            $(this).parent().find('.alttxt').show();
            $(this).parent().addClass('aTxt');
            changeIconPos();
        });

        $('.up-alttxt').bind('click', function(e) {
            e.stopPropagation();
            $(this).parent().find('img').show();
            $(this).parent().find('.alttxt').hide();
                    $('.' + $(this).parent().attr("data-selector")+'.select-image').click();
                    $(this).parent().removeClass('aTxt');
            changeIconPos();
        });

        // $('.select-image').bind('click', function(e) {
        //     e.stopPropagation();
        //     $('.' + $(this).attr("data-selector")).addClass('open');
        // });

        $('span.upload').bind('click', function(e) {
            e.stopPropagation();
            $('[' + $(this).attr("data-selector")+']').click();
        });
        $('[data-type="template_upload"]').bind('click', function(e) {
            e.stopPropagation();
            $('.' + $(this).attr("data-selector")).click();
        });
        $('.template_up_img').bind('click', function(e) {
            e.stopPropagation();
            $('[' + $(this).attr("data-selector")+']').click();
        });
        $('.image-close').bind('click', function(e) {
            $('.' + $(this).attr("data-selector")).removeClass('open');
        });


        $('[type="file"].no_crop').change(function(e) {
            e.preventDefault();
            $('.image-close').click();
            var name = this.files[0].name;
            var type = $(this).attr('data-type');
            var cssClass = $(this).attr('name');
            var mainSelector,opSelector,loader;
            if(type=='img_upload'){
                mainSelector = '['+cssClass+']';
                loader = $('['+cssClass+']').next('.upload');
                opSelector = '['+cssClass+']';
            }else if(type=='template_upload'){
                mainSelector = '['+cssClass+']';
                loader = $('['+cssClass+']').next('.upload');
                opSelector = '['+cssClass+']';
            }else{
                mainSelector = '.'+cssClass;
                loader = $('.'+cssClass+' .upload');
                opSelector = '.'+cssClass+' img';
            }
            if (name.length == 0) {
                return false;
            }
            var form_data = new FormData();
            form_data.append("file", this.files[0]);
            form_data.append("type", type);
            form_data.append("discode", '{{$_USER_DISTRIBUTOR_}}');

            $.ajax({
                url: "{{$_GLOBAL_URL_}}/ajax/ajaxthemeimage.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    loader.addClass('loading');
                   /*  $('.' + cssClass).append('<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>');
 */
                },
                success: function(data) {
                    
                    var respo = JSON.parse(data);
                    if (respo.status_code == '200') {
                        $(opSelector + '.croppedImg').remove();

                        if (type == 'background') {
                            $('#background_img_check').val('1');
                            $(mainSelector).attr('data-name', respo.response.img_name);
                            $(mainSelector).css('background', 'url(' + respo.response.srcdata + ')');
                        } else {
                            $(opSelector).load(function() { changeIconPos(); }).attr('src', respo.response.srcdata).attr('data-name', respo.response.img_name);

                        }
                        /* $(mainSelector + ' .loader.bubblingG').remove(); */
                        loader.removeClass('loading');
                        
                    } else {
                        loader.removeClass('loading');
                        $('#ap_id').empty();
                        $('#ap_id').append(respo.response);
                        $('#servicear-check-div').show();
                        $('#sess-front-div').show();
                        //alert(respo.response);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    loader.removeClass('loading');
                    //alert(thrownError);
                    $('#ap_id').empty();
                    $('#ap_id').append(thrownError);
                    $('#servicear-check-div').show();
                    $('#sess-front-div').show();
                }
            });

        });

        var data = {
            "template_name": "{{$_TEMPLATE_NAME_}}",
            "img": imgArr.toString(),
            "background": backgroundArr.toString()
        };

        $('.upload_img').each(function(i, obj) {
            
            $(this).position({
                        my: "right bottom",
                        at: "right bottom",
                        of: '['+$(this).attr("data-selector")+']'
                    });
        });
        $.ajax({
            type: "POST",
            url: "{{$_GLOBAL_URL_}}/ajax/image_load.php",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                var logo = obj.img;
                for(var key in logo) {
                    var element = logo[key];
                    for (let index = 0; index < element.length; index++) {
                        var element1 = element[index];
                        var element_name = element1.split("/");
                        element_name = element_name[element_name.length-1];
                        $('.img-'+key+' > .img-div > .img-inner').append('<img class="ext-img" data-pr="'+key+'" src="' + element1 + '" data-src="' + element1 + '" data-name="' + element_name + '">');
                    }
                }
                var bg = obj.background;
                for(var key in bg) {
                    var element = bg[key];
                    for (let index = 0; index < element.length; index++) {
                        var element1 = element[index];
                        var element_name = element1.split("/");
                        element_name = element_name[element_name.length-1];
                        $('.'+key+' > .img-div > .img-inner').append('<img class="ext-img" data-pr="'+key+'" src="' + element1 + '" data-src="' + element1 + '"  data-name="' + element_name + '">');
                    }
                }

            }
        });


        $('body').on('click','.ext-img', function(e) {
            e.preventDefault();
            var src = $(this).attr('data-src');
            var pr = $(this).attr('data-pr');
            $('.'+pr+' img').attr('src', src);
            $('.'+pr+' img').attr('data-name', $(this).attr('data-name'));
            $('.img-'+pr+' .image-close').click();
        });

        $('body').on('click', '.img-main > .img-div > .img-inner img', function(e) {
            e.preventDefault();
            var src = $(this).attr('data-src');
            $('.main').css("background", 'url(' + src + ')');
            $('.main').attr('data-name', $(this).attr('data-name'));
            $('.img-main .image-close').click();
        });

        $.loadScript = function (url, callback,errorCallback) {
            $.ajax({
                url: url+'?v={{$_BI_V_}}',
                dataType: 'script',
                success: callback,
                error: errorCallback,
                async: false,
                cache: true
            });
        }

        $('body').on('click', '#cancel_changes', function(e) {
            //parent.fancyClose("default"); fancybox method
            window.top.location.replace("{{$_GLOBAL_URL_}}/{{$_PAGE_}}?t=createTheme&data=set&enc={{$_ENC_}}&modify_st={{$_MODIFY_ST_}}");
        });

        $('body').on('click', '#cancel_changes1', function(e) {
            //parent.fancyClose("default"); fancybox method
            window.top.close();
        });
        
        @if($_ACTION_!="view")
            $('body').append('<div class="fin-btn-div"><button id="save_changes" class="btn btn-primary">Save</button><button id="cancel_changes" class="btn btn-secondary">Cancel</button></div>');
        @endif 
         @if($_FROM_THEME_UPLOAD_=="true")
            $('body').append('<div class="fin-btn-div"><button id="cancel_changes1" class="btn btn-primary">Cancel</button></div>');
        @endif

        try {
            $('body').addClass('wysiwyg');
        } catch (error) {
            
        }
        if("{{$_TEMPLATE_NAME_}}"=="res_photoonly_template"){
            $('.fin-btn-div').css("right","160px");
        }
    });
function hidediv() {
            $('#servicear-check-div').hide();
            $('#sess-front-div').hide();
        }
</script>