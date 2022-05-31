$(function () {
    $('.device').click(function (e) { 
        e.preventDefault();
        var cssClass = $(this).attr('data-dev');
        if($('.iframe-parent').hasClass(cssClass)){
            cssClass = '';
        }else{
        }
        $('.preview').click();
        $('.iframe-parent').attr("class", "iframe-parent "+cssClass);
        
    });

    $('.preview').click(function (e) { 
        $('body').addClass('white');
        if($(this).hasClass('open')){
            $(this).removeClass('open');
            $('.create-panel').removeClass('open');
            $('.iframe-parent').attr("class", "iframe-parent");
        }else{
            $(this).addClass('open');
            $('.create-panel').addClass('open');
        }
        $('.preview', $('iframe').contents()).click();
    });
});

function fancyClose(enc){
    if(enc!='default'){
        //parent.document.getElementById('enc').value = enc; fancybox method
        document.cookie = "enc="+enc;
    }
    //parent.jQuery.fancybox.close(); fancybox method
    window.close();
}



