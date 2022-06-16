/**
 * 
 */


function imgload_one(image1, bttom_text, header1,ad_id,hits,total,color){
	//jquery_ajax(1, ad_id);

	var v = ((parseInt(hits)+ +1)/(parseInt(total)+ +1))*100;
	console.log(v+'%');
	$('input[name=survey_radiog_lite]').attr('disabled', true);
	window.setTimeout(function(){
		
	//	$('#survey_top').html('<div class="progress" role="progressbar" data-goal="-50" aria-valuemin="-100" aria-valuemax="0"><div class="progress__bar" style="display: block; height: 100%; background: '+color+';"><span class="progress__label" style="float: right; padding: 0 1px; color: #ffffff; font-size: 12px;"></span></div></div>');
	    $('#survey_content').html('<a href="#"> GO ONLINE</a><br><br><img src='+image1+' width="100%" >');
	    $('#bottom').html('<div style="background:#222; color:#fafafa; padding:10px;" ><h4 align="center" style="margin:0; margin-top:10px; padding:0; padding-bottom:10px; font-family:sans-serif;">'+bttom_text+'<a href="#"> GO </a></h4> </div>');

	    //document.getElementById("radio2").disabled = true;
	    //document.getElementById("radio3").disabled = true;
	    
	  $('.progress').asProgress({
            'namespace': 'progress'
        });
        
	    $('.progress').asProgress('go',v+'%');
	         
	},1000);
}

function imgload_two(image2, bttom_text,header1,ad_id,hits,total,color){
	//jquery_ajax(2, ad_id);
	var v = ((parseInt(hits)+ +1)/(parseInt(total)+ +1))*100;
	console.log(v+'%');
	$('input[name=survey_radiog_lite]').attr('disabled', true);	
	window.setTimeout(function(){

		//$('#survey_top').html('<div class="progress2" role="progressbar" data-goal="-50" aria-valuemin="-100" aria-valuemax="0"><div class="progress__bar" style="display: block; height: 100%; background: '+color+';"><span class="progress__label" style="float: right; padding: 0 1px; color: #ffffff; font-size: 12px;"></span></div></div>');
	    $('#survey_content').html('<a href="#"> GO ONLINE</a><br><br><img src='+image2+' width="100%" >');
	    $('#bottom').html('<div style="background:#222; color:#fafafa; padding:10px;" ><h4 align="center" style="margin:0; margin-top:10px; padding:0; padding-bottom:10px; font-family:sans-serif;">'+bttom_text+'<a href="#"> GO </a></h4> </div>');
	    
		  $('.progress2').asProgress({
	            'namespace': 'progress'
	        });
	        
		    $('.progress2').asProgress('go',v+'%');

	},1000);   
}

function imgload_three(image3, bttom_text,header1,ad_id,hits,total,color){
	
	//jquery_ajax(3, ad_id);
	var v = ((parseInt(hits)+ +1)/(parseInt(total)+ +1))*100;
	console.log(v+'%');
	$('input[name=survey_radiog_lite]').attr('disabled', true);
	window.setTimeout(function(){
			
		//$('#survey_top').html('<div class="progress3" role="progressbar" data-goal="-50" aria-valuemin="-100" aria-valuemax="0"><div class="progress__bar" style="display: block; height: 100%; background: '+color+';"><span class="progress__label" style="float: right; padding: 0 1px; color: #ffffff; font-size: 12px;"></span></div></div>');
	    $('#survey_content').html('<a href="#"> GO ONLINE</a><br><br><img src='+image3+' width="100%" >');
	    $('#bottom').html('<div style="background:#222; color:#fafafa; padding:10px;" ><h4 align="center" style="margin:0; margin-top:0px; padding:0; padding-bottom:0px; font-family:sans-serif;">'+bttom_text+'<a href="#"> GO </a></h4> </div>');
	    
		  $('.progress3').asProgress({
	            'namespace': 'progress'
	        });
	        
		    $('.progress3').asProgress('go',v+'%');
		    
	},1000);
}












function jquery_ajax(survay_results, ad_id){
	console.log('jquery ajax function');
	
	var token = getURLParameter('auth_token');

	var data = {action:"survey", token:token, survay_results:survay_results, advert_id:ad_id};

	/*var token = getURLParameter('auth_token');
   	var survay_results = getURLParameter('survay_results');
   	var advert_id = getURLParameter('ad_id');*/

   	$.ajax({
    	type: 'POST',
    	dataType : 'json',
    	url: "API/ajaxResult.php",
    	//data : {action:'survey', token : token, survay_results:survay_results, advert_id:advert_id},
    	data : data,
    	success: function (response) {
	     	console.log(response);
	     	switch(response.status)
	     	{
		       	case "ERROR":  // social login failure
			        console.log('error');
			       
			        break;
		       	case "SUCCESS": 
			        console.log('success');
			        console.log('success ads');		            
            }
            
        }
    });
}
		

		