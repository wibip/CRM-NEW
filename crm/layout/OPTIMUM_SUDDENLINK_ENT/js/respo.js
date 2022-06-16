$(window).on("load resize",function(){

	var width_2 = $(window).width();
	
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

$(document).ready(function() {
    $("div:not(.adapt_skip)").removeClass("input-prepend");
    $("div:not(.adapt_skip)").removeClass("input-append");
    $("input:radio:not(.hide_rad):not(.fixfreequency)").after("<label style='display: inline-block;'></label>");
    $("input:radio.fixfreequency").after("<label style='display: inline-block;width: 31px;'></label>");
    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,#list4,[data-toggle^=toggle])").after('<label style="display: inline-block; margin-top: 10px;"></label>');
});

 $(document).ready(function () {
     try {

         $("#theme_type option[value='return']").remove();
     }
     catch (err) {

     }
 });



