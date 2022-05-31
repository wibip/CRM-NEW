$(document).ready(function() {

    try{

    $("#theme_type option[value='return']").remove();
    }
    catch (err){

    }

    $("input:radio:not(.hide_rad)").after("<label style='display: inline-block;''></label>");
    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
    $("div:not(.adapt_skip)").removeClass("input-prepend");
    $("div:not(.adapt_skip)").removeClass("input-append");/*
    $("#tab5_form1 select").addClass("mini_select");*/
    $("meter").addClass("span4");

    $('button[type=submit]').click(function( event ) {
        $('div.error-wrapper').remove();
        $('input,select').removeClass("error");
    });

    $("*:not(.inline_error)").on("invalid", function(event) {
            event.preventDefault();
            $(this).nextAll('div.error-wrapper').remove();
            $( this ).after( "<div style='display: inline-block;' class='error-wrapper bubble-pointer mbubble-pointer'><p>This field is required.</p></div>" );
            $(this).addClass("error");
        });

    $("input.inline_error_1").on("invalid", function(event) {
        event.preventDefault();
        $(this).addClass("error");
       
    });

    $("input.inline_error_2").on("invalid", function(event) {
        event.preventDefault();
        $(this).addClass("error");
        $(this).after( "<div style='display: inline-block;' class='error-wrapper bubble-pointer mbubble-pointer'><p>This field is required.</p></div>");
    });

        

setTimeout(function(){ 

 $("small").each(function( index ) {
            var attr = $(this).attr('data-bv-validator');
            
            if (typeof attr !== typeof undefined && attr !== false) {
                    $(this).addClass("error-wrapper bubble-pointer mbubble-pointer");
            }
        });

}, 30);

$('a[data-toggle="tab"]').on('click', function (e) {

   
    try{
        $('.alert').hide();
    }
    catch (err){

    }
    
});
   
});







function validate_func(this_is){
    
	
}

 $(window).on("load resize",function(){


 	var width_2 = $(window).width();

 	if(width_2<600){
 		$( "#active_theme_table td:last" ).css("width","100px");
 	}
 	else{
 		$( "#active_theme_table td:last" ).css("width","");
 	}

    var width_table_res = $(".main-inner").children().first().width();
    
    var width_table_res1 = width_table_res - 30;
    $(".table_response").css("width", width_table_res1);

    if(width_2<463){
        var width_table_res2 = width_table_res - 30;
    }
    else{
        var width_table_res2 = width_table_res - 220;
    }
    
    $(".theme_response").css("width", width_table_res2);
 });



