
var canvas = new fabric.Canvas('myCanvas');

canvas.on('mouse:over', function(e) {
	if(e.target !== null){
		var pointer = canvas.getPointer(e);
		  var posX = pointer.x;
		  var posY = pointer.y;

		  $('.'+e.target.cacheKey).css({
		  	top: posY,
		  	left: posX
		  });
		$('.'+e.target.cacheKey).show();
	}
  });

canvas.on('mouse:out', function(e) {
    if(e.target !== null){
		$('.'+e.target.cacheKey).hide();
	}
});


/*
var panning = false;
canvas.on('mouse:up', function (e) {
    panning = false;
});

canvas.on('mouse:down', function (e) {
    panning = true;
});
canvas.on('mouse:move', function (e) {
    if (panning && e && e.e) {
       debugger;
        var units = 10;
        var delta = new fabric.Point(e.e.movementX, e.e.movementY);
        canvas.relativePan(delta);
    }
});*/



function makeCanvas(data,a,b,c,camp_layout){

	var jsonOBJ = JSON.parse(data);
	var intrnetObj = jsonOBJ.int;
	makeImage(0.65,270,100,intrnetObj,'int',camp_layout);
	line = makeRect(200,70,100,0,0,0);
	var vEdgeObj = jsonOBJ.vEdge;
	makeImage(0.8,270,220,vEdgeObj,'vEdge',camp_layout);
	var switchObj = jsonOBJ.switch;
	makeImage(1,270,300,switchObj,'switch',camp_layout);
    var jObj = jsonOBJ.switch;
	var z=0,yy=300;

	for (key in jObj) {

		if(z > 0){
			line2 = makeRect(300,271,300,90,0,0);
			canvas.add(line2);
		}

	var i=0,a=80,b=100,c,d=85,e=95,f,g,h=90,j=90,float='left';

	var jObjAP = jObj[z].ap_list;

	for (key1 in jObjAP) {
		
		if(i < 12){

			if(float=='left'){
				a = a + 20;
				c = a;
				float = 'right';
			}else{
				b = b - 20;
				c = b;
				float='left';
			}
		    g = 120;

		}else if(12 <= i && i < 36){

			if(float=='left'){
				d = d + 10;
				c = d;
				float = 'right';
			}else{
				e = e - 10;
				c = e;
				float='left';
			}
		    g = 180;

		}else{
			if(float=='left'){
				h = h + 20;
				c = h;
				float = 'right';
			}else{
				j = j - 20;
				c = j;
				float='left';
			}
		    g = 240;
		}
	
		line = makeRect(g,271,yy,c,0,0);
		canvas.add(line);
		makeAp(1,line.getCoords()[1].x,line.getCoords()[1].y,i,jObjAP,camp_layout);

		for (var u = 0; u < jObjAP[i].reference.length; u++) { 
			line = makeRect(30,line.getCoords()[1].x,line.getCoords()[1].y,c,0,0) ;
			canvas.add(line);
			makeAp(0.3,line.getCoords()[1].x,line.getCoords()[1].y,u,jObjAP[i].reference,camp_layout);
		}

		i++;

	}

	z++;
	yy = yy + 300;
}

	$("#canVasDiv").append('<div class="zoom"><div onclick="zoomCanvas(\'down\')" class="up"></div><div onclick="zoomCanvas(\'up\')" class="down"></div></div>');
        
	canvas.allowTouchScrolling = true;
	canvas.hoverCursor = 'default';

	canvas.setHeight(yy);

	/*canvas.setZoom(1);*/

}



function makeRect(width,left,top,angle,x,y,camp_layout){
	return new fabric.Rect({
		fill: '#fff',
		  width: width,
		  left: left,
		  top: top,
		  angle: angle,
	      selectable: false,
	      strokeWidth: 1,
	      stroke: '#000000',
	      strokeDashArray: [x, y]
    });
}

function makeAp(scale,x,y,i,jObj,camp_layout){

	var status;

	if(jObj[i].mode == 'ROOT' && jObj[i].status == '0'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Root AP Offline.png';
		status = 'Offline';

	}else if(jObj[i].mode == 'ROOT' && jObj[i].status == '1'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Root AP.png';
		status = 'Online';
		
	}else if((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '0' && jObj[i].type == 'WIRED'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Wired Mesh Offline.png';
		status = 'Offline';
		
	}else if((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '1' && jObj[i].type == 'WIRED'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Wired Mesh AP.png';
		status = 'Online';

	}else if((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '1' && jObj[i].type == 'WLESS'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Mesh Wireless AP.png';
		status = 'Online';

	}else if((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '0' && jObj[i].type == 'WLESS'){
		pic = 'layout/'+camp_layout+'/img/COX Complex Wireless AP Offline.png';
		status = 'Offline';

	}

	fabric.Image.fromURL(pic, function(oImg) {
		oImg.scale(scale);
        oImg.set({ 'left': 5 });
        oImg.set({ 'top': 5 });
        oImg.set({ 'cacheKey': 'image'+i });
        oImg.selectable = false;
        oImg.hoverCursor = 'pointer';
        
        var pos = new fabric.Point(x,y);
        oImg.setPositionByOrigin(pos, 'center', 'center');

        oImg.on('mousedown', function(e) {
            $('.canvas-container').hide();
            $('.details'+i).show();
        });

        canvas.add(oImg);

        $("#canVasDiv").append("<div class='tooltipGraph image"+i+"'><ul class='tooltiptext'><li>MAC : "+jObj[i].ap_code+"</li><li>MODE : "+jObj[i].mode+"</li><li>GUEST : "+jObj[i].guest+"</li><li>PRIVATE : "+jObj[i].private+"</li></ul></span></div>");
        var a = '<div class="details_col'+i+'"> <table class="table" cellpadding="10"> <tr><th>AP Description: </th><th>'+jObj[i].apName+' </td></tr><tr><td>Serial Number :</td><td>'+jObj[i].serial+'</td></tr><tr><td>Firmware :</td><td>'+jObj[i].firmwareVersion+'</td></tr></table>';
        var b = "<h5>Guest SSID details</h5><h4>Name: "+jObj[i].ap_code+"</h4><h4>Total Devices: "+jObj[i].guest+"</h4>";
       	
       	var j = 0,ee="";

       	var total_device='',guestFull="",jObjAP=jObj,j=i,ss_name="";

       	 for (key in jObjAP[j].clients) {
     
	    	if(key=='guest'){
	    		ss_name = 'Guest';
	    	}else{
	    		ss_name = 'Private';
	    	}
	        
	        for (key2 in jObjAP[j].clients[key]) {

	        	console.log(jObjAP[j].clients[key]); 
	           
	        	guest = "<div class='guest'><h5>"+ss_name+" SSID details</h5> <h6>Name : "+jObjAP[j].clients[key][key2].ssid+"</h6><h6>Total Devices: "+jObjAP[j].clients[key][key2].clients.length+"</h6>"; 
	            var ee = '';
	            for (key3 in jObjAP[j].clients[key][key2].clients) {
	            

	            	var mac = jObjAP[j].clients[key][key2].clients[key3].mac;
	       		ee =  ee+"<table  class='table table"+mac.split(':').join("")+"'><tr><th  width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].name+"</th><th  width=\"50%\"><a href='javascript:void(0)' onclick='toggl2(\""+mac.split(':').join("")+"\");' class='hide-details hide-details"+mac.split(':').join("")+"'></a></th></tr>";
	       		ee =  ee+"<tr><td width=\"50%\">MAC</td><td width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].mac+"</td></tr>";
	       		ee =  ee+"<tr><td width=\"50%\">IP Address</td><td width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].ipAddress+"</td></tr>";
	       		ee =  ee+"<tr><td width=\"50%\">Connected for</td><td width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].uptime+"</td></tr>";
	       		ee =  ee+"<tr><td width=\"50%\">Total Up & Download</td><td width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].uplink+" | "+jObjAP[j].clients[key][key2].clients[key3].downlink+"</td></tr>";
	       		ee =  ee+"<tr><td width=\"50%\">Channel</td><td width=\"50%\">"+jObjAP[j].clients[key][key2].clients[key3].channel+"</td></tr></table>";
	       		
	            }

	            guest = guest + ee + "</div>";
	            
	            guestFull = guestFull+guest;
	            
	        }
	       		
	           //j++;
	    }
    

       /*	console.log(status); 
       	console.log(jObj[i]); */

        $("#canVasDiv").append("<div class='details details"+i+"'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"details"+i+"\")'>Overview</a><br/><h5>AP Node Details</h5><h4>MAC : "+jObj[i].ap_code+"</h4><h4>STATUS : "+status+"</h4><h4>Mesh Mode : "+jObj[i].mode+"</h4><h4>Up Time : "+jObj[i].uptime+"</h4><a href='javascript:void(0)' onclick='toggl(\""+i+"\");' class='hide-details hide-details"+i+"'></a>"+a+guestFull+"</div>");

	});

} 

function toggl(ele){

	if($(".details_col"+ele).is(':visible')){
		$(".details_col"+ele).hide();
		$(".hide-details"+ele).addClass('a-hide');
	}else{
		$(".details_col"+ele).show();
		$(".hide-details"+ele).removeClass('a-hide');
	}

}

function toggl2(ele){

	if(!$(".table"+ele).hasClass('hide-t')){
		$(".hide-details"+ele).addClass('a-hide');
		$(".table"+ele).addClass('hide-t');
	}else{
		$(".hide-details"+ele).removeClass('a-hide');
		$(".table"+ele).removeClass('hide-t');
	}
	
}

function zoomCanvas(meth){
	var zoom = canvas.getZoom();

	if(meth=='up'){
		newZoom = (zoom+0.2);
		
	}else{
		newZoom = (zoom-0.2);
	}

	canvas.setZoom(newZoom);

	var zoom = canvas.getZoom();

	alert(zoom);
}

function resize() {

    var canvasSizer = document.getElementById("canVasDiv");
    var canvasScaleFactor = canvasSizer.offsetWidth/525;
    var width = canvasSizer.offsetWidth;
    var height = canvasSizer.offsetHeight;
    var ratio = canvas.getWidth() /canvas.getHeight();

         if((width/height)>ratio){
             width = height*ratio;
         } else {
             height = width / ratio;
         }
    var scale = width / canvas.getWidth();
    var zoom = canvas.getZoom();
    zoom *= scale;

    canvasSizer.style.width = width+"px"; /*
    canvasSizer.style.height = height+"px"; */

    canvas.setDimensions({ width: width, height: height });
    canvas.setViewportTransform([zoom , 0, 0, zoom , 0, 0]);
    canvas.renderAll();

}

window.addEventListener('load', resize, false);

function backToCanvas(hideEle){
			$('.canvas-container').show();
            $('.'+hideEle).hide();
}

function makeImage(scale,x,y,jObj,method,camp_layout) {

	var j=0,k=0,l=0,float='left',x1=x,methodV;

	if(jObj !== null){

		for (key in jObj) {

			methodV=0;

			if(jObj[j].status == '0' && method == 'switch'){
				pic = 'layout/'+camp_layout+'/img/COX Complex Switch Offline.png';
				methodV = 'switch';
				image(pic,scale,x,y,methodV,jObj[j]);
				y = y + 300 ;
			}else if(jObj[j].status == '1' && method == 'switch'){
				pic = 'layout/'+camp_layout+'/img/Switch.png';
				methodV = 'switch';
				image(pic,scale,x,y,methodV,jObj[j]);
				y = y + 300 ;
			}else if(method == 'vEdge'){

				if(float=='left'){
					k++;
					x = x1;
					x = (x - (40*k));
					float = 'right';

					if(k > 1){
						y = (y - 20);
					}

				}else{
					l++;
					x = x1;
					x = (x + (40*l));
					float = 'left';
				}


				if(jObj[j].status == '1'){
					pic = 'layout/'+camp_layout+'/img/COX Complex vEdge.png';
				}else{
				    pic = 'layout/'+camp_layout+'/img/COX Complex vEdge Offline.png';
				}

				methodV = 'vEdge';
				image(pic,scale,x,y,methodV,jObj[j]);

			}else if(jObj[j].status == '0' && method == 'int'){
				methodV = 'int';
				pic = 'layout/'+camp_layout+'/img/COX Complex Internet Offline.png';
				image(pic,scale,x,y,methodV,jObj[j]);
			}else if(jObj[j].status == '1' && method == 'int'){
				methodV = 'int';
				pic = 'layout/'+camp_layout+'/img/COX Complex Internet.png';
				image(pic,scale,x,y,methodV,jObj[j]);
			}
	

			j++;

		}
	}

}

function image(pic,scale,x,y,method,jObj) {
	fabric.Image.fromURL(pic, function(oImg) {
				oImg.scale(scale);
		        oImg.set({ 'left': 5 });
		        oImg.set({ 'top': 5 });
		        oImg.selectable = false;
		        
		        if(method=='int'){
		        	var pos = new fabric.Point((x+9),y);
		        }else{
		        	var mac = jObj.mac.split(':').join("");
		        	var pos = new fabric.Point(x,y);
		        	oImg.hoverCursor = 'pointer';
		        	if(jObj.status=="0"){
		        		jObj.status = 'Offline';
		        	}else{
		        		jObj.status = 'Online';
		        	}

		        	if(method=='vEdge'){

		        		var a = '<div class="details_col'+mac+jObj.AP_Description.split(' ').join("")+'"> <table class="table" cellpadding="10"> <tr><th>vEdge Description: </th><th>'+jObj.AP_Description+' </th></tr><tr><td>Serial Number :</td><td>'+jObj.Serial_Number+'</td></tr><tr><td>Firmware :</td><td>'+jObj.Firmware+'</td></tr><tr><td>VLAN 99 | Speed Snapshot :</td><td>'+jObj.v99+'</td></tr><tr><td>VLAN 101 | Speed Snapshot :</td><td>'+jObj.v101+'</td></tr><tr><td>VLAN 102 | Speed Snapshot :</td><td>'+jObj.v102+'</td></tr></table>';
		        		$("#canVasDiv").append("<div class='details Exdetails"+mac+jObj.AP_Description.split(' ').join("")+"'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"Exdetails"+mac+jObj.AP_Description.split(' ').join("")+"\")'>Overview</a><br/><h5>vEdge Node Details</h5><h4>Status : "+jObj.status+"</h4><h4>Up Time : "+jObj.Up_Time+"</h4><a href='javascript:void(0)' onclick='toggl(\""+mac+jObj.AP_Description.split(' ').join("")+"\");' class='hide-details hide-details"+mac+jObj.AP_Description.split(' ').join("")+"'></a>"+a+"</div>");
		        		
		        	}

		        	if(method=='switch'){

		        		var a = '<div class="details_col'+mac+jObj.AP_Description.split(' ').join("")+'"> <table class="table" cellpadding="10"> <tr><th>Switch Name: </th><th>'+jObj.AP_Description+' </th></tr><tr><td>Serial Number :</td><td>'+jObj.Serial_Number+'</td></tr><tr><td>Firmware :</td><td>'+jObj.Firmware+'</td></tr><tr><td>IP Address :</td><td>'+jObj.ipAddress+'</td></tr><tr><td>GigabitEthernet1/1/1 :</td><td>'+jObj.GigabitEthernet1+'</td></tr><tr><td>GigabitEthernet1/1/2 :</td><td>'+jObj.GigabitEthernet2+'</td></tr><tr><td>GigabitEthernet1/1/3 :</td><td>'+jObj.GigabitEthernet3+'</td></tr><tr><td>GigabitEthernet1/1/4 :</td><td>'+jObj.GigabitEthernet4+'</td></tr></table>';
		        		$("#canVasDiv").append("<div class='details Exdetails"+mac+jObj.AP_Description.split(' ').join("")+"'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"Exdetails"+mac+jObj.AP_Description.split(' ').join("")+"\")'>Overview</a><br/><h5>Switch Node Details</h5><h4>MAC : "+jObj.mac+"</h4><h4>Status : "+jObj.status+"</h4><h4>Port : "+jObj.upstatus+"</h4><h4>Up Time : "+jObj.Up_Time+"</h4><a href='javascript:void(0)' onclick='toggl(\""+mac+jObj.AP_Description.split(' ').join("")+"\");' class='hide-details hide-details"+mac+jObj.AP_Description.split(' ').join("")+"'></a>"+a+"</div>");
		        		
		        	}

		        	oImg.on('mousedown', function(e) {
			            $('.canvas-container').hide();
			            $('.Exdetails'+mac+jObj.AP_Description.split(' ').join("")).show();
			        });

		        	
		        }

		        oImg.setPositionByOrigin(pos, 'center', 'center');
		        canvas.add(oImg);

		        if(method=='vEdge' || method=='int'){
		        	line = new fabric.Line([x, y, 270, 300], {
				        stroke: '#000000',
					    strokeWidth: 1,
					    selectable: false
				    });

				    canvas.add(line);

				    line.sendToBack();
		        }

			});
}

