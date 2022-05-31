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



