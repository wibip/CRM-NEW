var canvas = new fabric.Canvas('myCanvas');
$("#canVasDiv").append('<a href="javascript:void(0)" id="reloadOverview">Refresh</a>');
var distributor;
canvas.on('mouse:over', function(e) {
    if (e.target !== null) {
        var pointer = canvas.getPointer(e);
        var posX = pointer.x;
        var posY = pointer.y;

        $('.' + e.target.cacheKey).css({
            top: posY,
            left: posX
        });
        $('.' + e.target.cacheKey).show();
    }
});

$('#reloadOverview').click(function (e) { 
    	
    $( ".append" ).remove();
    e.preventDefault();
    canvas.clear();
    overviewAjax();
});

canvas.on('mouse:out', function(e) {
    if (e.target !== null) {
        $('.' + e.target.cacheKey).hide();
    }
});

function makeCanvas(data, a, b, c, camp_layout) {
    distributor = c;
    var jsonOBJ = JSON.parse(data);
    var intrnetObj = jsonOBJ.int;
    var vEdgeObj = jsonOBJ.vEdge;
    var switchObj = jsonOBJ.switch;
    makeImage(0.65, 310, 100, intrnetObj, 'int', camp_layout, switchObj);
    line = makeRect(200, 110, 100, 0, 0, 0);
    makeImage(0.7, 310, 220, vEdgeObj, 'vEdge', camp_layout, switchObj);
    makeImage(1, 310, 300, switchObj, 'switch', camp_layout, switchObj);
    var jObj = jsonOBJ.switch;
    var z = 0,
        yy = 300;


    for (key in jObj) {


        var i = 0,
            a = 80,
            b = 100,
            c, d = 85,
            e = 95,
            f, g, h = 90,
            j = 90,
            float = 'left';

        var jObjAP = jObj[z].ap_list;

        var apCount = jObjAP.length;

        if (z > 0) {
            if (jObj[z].mac == 'noSwitch') {
                if ((apCount > 0)) {
                    line2 = makeRect(300, 311, (yy - 300), 90, 0, 0);
                    canvas.add(line2);
                }
            } else {

                line2 = makeRect(300, 311, (yy - 300), 90, 0, 0);
                canvas.add(line2);

            }
        }

        for (key1 in jObjAP) {

            if (i < 12) {

                if (float == 'left') {
                    a = a + 20;
                    c = a;
                    float = 'right';
                } else {
                    b = b - 20;
                    c = b;
                    float = 'left';
                }
                g = 120;

            } else if (12 <= i && i < 36) {

                if (float == 'left') {
                    d = d + 10;
                    c = d;
                    float = 'right';
                } else {
                    e = e - 10;
                    c = e;
                    float = 'left';
                }
                g = 180;

            } else {
                if (float == 'left') {
                    h = h + 20;
                    c = h;
                    float = 'right';
                } else {
                    j = j - 20;
                    c = j;
                    float = 'left';
                }
                g = 240;
            }

            line = makeRect(g, 311, yy, c, 0, 0);
            canvas.add(line);
            makeAp(1, line.getCoords()[1].x, line.getCoords()[1].y, i, jObjAP, camp_layout, z);

            /*for (var u = 0; u < jObjAP[i].reference.length; u++) { 
            	line = makeRect(30,line.getCoords()[1].x,line.getCoords()[1].y,c,0,0) ;
            	canvas.add(line);
            	makeAp(0.3,line.getCoords()[1].x,line.getCoords()[1].y,u,jObjAP[i].reference,camp_layout,z);
            }*/

            i++;

        }

        z++;

        if (apCount < 1) {
            yy = yy + 100;
        } else {
            yy = yy + 300;
        }
    }

    $("#canVasDiv").append('<div class="append zoom"><div onclick="zoomCanvas(\'down\')" class="up"></div><div onclick="zoomCanvas(\'up\')" class="down"></div></div>');
    $("#canVasDiv").append('<div class="append loading" style="width: 100%;top: 0px;height: 200px;position: relative;display:none"><div style="top: 50%;transform: translateY(-50%);position: relative;"><img src="img/loading_me.gif"></div></div>');
    canvas.allowTouchScrolling = true;
    canvas.hoverCursor = 'default';

    canvas.setHeight(yy);

    /*canvas.setZoom(1);*/

}


function makeRect(width, left, top, angle, x, y, camp_layout) {
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

function makeAp(scale, x, y, i, jObj, camp_layout, z) {
    var color = "red";
    var status;

    if (jObj[i].mode == 'ROOT' && jObj[i].status == '0') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Root AP Offline.png';
        status = 'Offline';

    } else if (jObj[i].mode == 'ROOT' && jObj[i].status == '1') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Root AP.png';
        status = 'Online';

    } else if ((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '0' && jObj[i].type == 'WIRED') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Wired Mesh Offline.png';
        status = 'Offline';

    } else if ((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '1' && jObj[i].type == 'WIRED') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Wired Mesh AP.png';
        status = 'Online';

    } else if ((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '1' && jObj[i].type == 'WLESS') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Mesh Wireless AP.png';
        status = 'Online';

    } else if ((jObj[i].mode == 'AUTO' || jObj[i].mode == 'MESH') && jObj[i].status == '0' && jObj[i].type == 'WLESS') {
        pic = 'layout/' + camp_layout + '/img/COX Complex Wireless AP Offline.png';
        status = 'Offline';

    }

    fabric.Image.fromURL(pic, function(oImg) {
        oImg.scale(scale);
        oImg.set({ 'left': 5 });
        oImg.set({ 'top': 5 });
        oImg.set({ 'cacheKey': 'image' + z + i });
        oImg.selectable = false;
        oImg.hoverCursor = 'pointer';

        var pos = new fabric.Point(x, y);
        oImg.setPositionByOrigin(pos, 'center', 'center');

        oImg.on('mousedown', function(e) {
            $('.canvas-container').hide();
            $('#reloadOverview').hide();
            $('.details' + z + i).show();
            /*$("div[class^='switch']").hide();
            $('.switch'+z).show();
             $('html, body').animate({
			        scrollTop: ($(".details"+i).offset().top - 40)
			    }, 1000);*/
        });

        canvas.add(oImg);

        $("#canVasDiv").append("<div class='append tooltipGraph image" + z + i + "'><ul class='tooltiptext'><li>Type : <b>AP</b></li><li>MAC : <b>" + jObj[i].ap_code + "</b></li><li>GUEST : <b>" + jObj[i].guest + "</b></li><li>PRIVATE : <b>" + jObj[i].private + "</b></li><li>AP Name : <b>" + jObj[i].cpename + "</b></li></ul></span></div>");
        var a = '<div class="details_col' + z + i + '"> <table class="table" cellpadding="10"> <tr><th>AP Name: </th><th>' + jObj[i].cpename + ' </td></tr><tr><td>Serial Number :</td><td>' + jObj[i].serial + '</td></tr><tr><td>Firmware :</td><td>' + jObj[i].firmwareVersion + '</td></tr></table>';
        var b = "<h3>Guest SSID details</h3><h4>Name: " + jObj[i].ap_code + "</h4><h4>Total Devices: " + jObj[i].guest + "</h4>";

        var j = 0,
            ee = "";

        var total_device = '',
            guestFull = "",
            jObjAP = jObj,
            j = i,
            ss_name = "";

        for (key in jObjAP[j].clients) {

            if (key == 'guest') {
                ss_name = 'Guest';
            } else {
                ss_name = 'Private';
            }

            for (key2 in jObjAP[j].clients[key]) {

                guest = "<div class='guest'><h3>" + ss_name + " SSID details</h3> <h6>Name : " + jObjAP[j].clients[key][key2].ssid + "</h6><h6>Total Devices: " + jObjAP[j].clients[key][key2].clients.length + "</h6>";
                var ee = '';
                for (key3 in jObjAP[j].clients[key][key2].clients) {

                    var mac = jObjAP[j].clients[key][key2].clients[key3].mac;
                    ee = ee + "<table  class='hide-t table table" + mac.split(':').join("") + "'><tr><th  width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].name + "</th><th  width=\"50%\"><a href='javascript:void(0)' onclick='toggl2(\"" + mac.split(':').join("") + "\");' class='a-hide hide-details hide-details" + mac.split(':').join("") + "'></a></th></tr>";
                    ee = ee + "<tr><td width=\"50%\">MAC</td><td width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].mac + "</td></tr>";
                    ee = ee + "<tr><td width=\"50%\">IP Address</td><td width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].ipAddress + "</td></tr>";
                    ee = ee + "<tr><td width=\"50%\">Connected for</td><td width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].uptime + "</td></tr>";
                    ee = ee + "<tr><td width=\"50%\">Total Up & Download</td><td width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].uplink + " | " + jObjAP[j].clients[key][key2].clients[key3].downlink + "</td></tr>";
                    ee = ee + "<tr><td width=\"50%\">Channel</td><td width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].channel + "</td></tr>";
                    if(jObjAP[j].clients[key][key2].clients[key3].authStatus=='AUTHORIZED'){
                        color = "green";
                    }
                    ee = ee + "<tr><td width=\"50%\">Channel</td><td style=\"color: "+color+";\" width=\"50%\">" + jObjAP[j].clients[key][key2].clients[key3].authStatus + "</td></tr></table>";
                }

                guest = guest + ee + "</div>";
                guestFull = guestFull + guest;

            }

            //j++;
        }


        /*	console.log(status); 
        	console.log(jObj[i]); */

        $("#canVasDiv").append("<div class='append switch" + z + " details ap details" + z + i + "'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"details" + z + i + "\")'>Overview</a><br/><h3 class='node_txt'>AP Details</h3><h4>MAC : " + jObj[i].ap_code + "</h4><h4><h4>Status : " + status + "</h4><h4>Up Time : " + jObj[i].uptime + "</h4><h4>Model : " + jObj[i].model + "</h4><a href='javascript:void(0)' onclick='toggl(\"" + z + i + "\");' class='hide-details hide-details" + z + i + "'></a>" + a + guestFull + "</div>");
        /*<a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"details"+i+"\")'>Overview</a>*/
    });

}

function toggl(ele) {

    if ($(".details_col" + ele).is(':visible')) {
        $(".details_col" + ele).hide();
        $(".hide-details" + ele).addClass('a-hide');
    } else {
        $(".details_col" + ele).show();
        $(".hide-details" + ele).removeClass('a-hide');
    }

}

function toggl2(ele) {

    if (!$(".table" + ele).hasClass('hide-t')) {
        $(".hide-details" + ele).addClass('a-hide');
        $(".table" + ele).addClass('hide-t');
    } else {
        $(".hide-details" + ele).removeClass('a-hide');
        $(".table" + ele).removeClass('hide-t');
    }

}

function zoomCanvas(meth) {
    var zoom = canvas.getZoom();

    if (meth == 'up') {
        newZoom = (zoom + 0.2);

    } else {
        newZoom = (zoom - 0.2);
    }

    canvas.setZoom(newZoom);
    var zoom = canvas.getZoom();

}

function resize() {

    var canvasSizer = document.getElementById("canVasDiv");
    var canvasScaleFactor = canvasSizer.offsetWidth / 525;
    var width = canvasSizer.offsetWidth;
    var height = canvasSizer.offsetHeight;
    var ratio = canvas.getWidth() / canvas.getHeight();

    if ((width / height) > ratio) {
        width = height * ratio;
    } else {
        height = width / ratio;
    }
    var scale = width / canvas.getWidth();
    var zoom = canvas.getZoom();
    zoom *= scale;

    canvasSizer.style.width = width + "px";
    /*
       canvasSizer.style.height = height+"px"; */

    canvas.setDimensions({ width: width, height: height });
    canvas.setViewportTransform([zoom, 0, 0, zoom, 0, 0]);
    canvas.renderAll();

}

window.addEventListener('load', resize, false);

function backToCanvas(hideEle) {
    /*$('html, body').animate({
    			        scrollTop: $('#canVasDiv').offset().top
    			    }, 5);*/
    $('.canvas-container').show();
    $('#reloadOverview').show();
    $('.' + hideEle).hide();
    /*$("[class^='switch']").hide();*/
}

function makeImage(scale, x, y, jObj, method, camp_layout, switchObj) {

    var j = 0,
        k = 0,
        l = 0,
        float = 'left',
        x1 = x,
        methodV;

    if (jObj !== null) {

        for (key in jObj) {

            methodV = 0;

            if (method == 'switch') {

                if (jObj[j].mac != 'noSwitch') {

                    if (jObj[j].status == '1') {
                        pic = 'layout/' + camp_layout + '/img/Switch.png';
                    } else {
                        pic = 'layout/' + camp_layout + '/img/COX Complex Switch Offline.png';
                    }

                    methodV = 'switch';
                    image(pic, scale, x, y, methodV, jObj[j], j);

                    var ApCount = jObj[j].ap_list.length;


                    if (ApCount < 1) {
                        y = y + 100;
                    } else {
                        y = y + 300;
                    }

                }

            } else if (method == 'vEdge') {

                var w = 0,
                    vEgTO = y,
                    y1 = y;

                if (switchObj !== null) {

                    for (keysw in switchObj) {
                        var vedgeConnt = switchObj[w].vedge;
                        if (vedgeConnt == '1') {
                            vEgTO = y1;
                        }

                        var ApCount = switchObj[w].ap_list.length;

                        if (ApCount < 1) {
                            y1 = y1 + 100;
                        } else {
                            y1 = y1 + 300;
                        }

                        w++;
                    }
                }

                if (float == 'left') {
                    k++;
                    x = x1;
                    x = (x - (55 * k));
                    float = 'right';

                    if (k > 1) {
                        vEgTO = (vEgTO - 35);
                    }

                } else {
                    l++;
                    x = x1;
                    x = (x + (55 * l));
                    float = 'left';
                }


                if (jObj[j].status == '1') {
                    pic = 'layout/' + camp_layout + '/img/COX Complex vEdge.png?v=1';
                } else {
                    pic = 'layout/' + camp_layout + '/img/COX Complex vEdge Offline.png?v=1';
                }

                methodV = 'vEdge';
                image(pic, scale, x, vEgTO, methodV, jObj[j], j);

            } else if (method == 'int') {

                methodV = 'int';

                if (jObj[j].status == '1') {
                    pic = 'layout/' + camp_layout + '/img/COX Complex Internet.png';
                } else {
                    pic = 'layout/' + camp_layout + '/img/COX Complex Internet Offline.png';
                }

                image(pic, scale, x, y, methodV, jObj[j], j);
            }

            j++;

        }
    }

}

function image(pic, scale, x, y, method, jObj, j) {
    fabric.Image.fromURL(pic, function(oImg) {
        oImg.scale(scale);
        oImg.set({ 'left': 5 });
        oImg.set({ 'top': 5 });

        oImg.selectable = false;

        if (method == 'int') {
            var pos = new fabric.Point((x + 9), y);
        } else {
            var mac = jObj.mac.split(':').join("");
            var pos = new fabric.Point(x, y);
            oImg.hoverCursor = 'pointer';
            if (jObj.status == "0") {
                jObj.status = 'Offline';
            } else {
                jObj.status = 'Online';
            }



            if (method == 'vEdge') {

                oImg.set({ 'cacheKey': 'vEdge' + mac });

                var vlan = '';

                for (key in jObj.vlanArr) {

                    for (key1 in jObj.vlanArr[key]) {
                        vlan = vlan + '<tr><td>' + key1 + ' :  | Speed Snapshot </td><td>' + jObj.vlanArr[key][key1] + '</td></tr>';
                    }
                }

                var a = '<div class="details_col' + mac + jObj.AP_Description.split(' ').join("") + '"> <table class="table" cellpadding="10"> <tr><th>vEdge Name: </th><th>' + jObj.AP_Description + ' </th></tr><tr><td>Serial Number :</td><td>' + jObj.Serial_Number + '</td></tr><tr><td>Firmware :</td><td>' + jObj.Firmware + '</td></tr>' + vlan + '</table>';
                $("#canVasDiv").append("<div class='append details vEdge Exdetails" + mac + jObj.AP_Description.split(' ').join("") + "'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"Exdetails" + mac + jObj.AP_Description.split(' ').join("") + "\")'>Overview</a><br/><h3>vEdge Node Details</h3><h4>Status : " + jObj.status + "</h4><h4>Up Time : " + jObj.Up_Time + "</h4><a href='javascript:void(0)' onclick='toggl(\"" + mac + jObj.AP_Description.split(' ').join("") + "\");' class='hide-details hide-details" + mac + jObj.AP_Description.split(' ').join("") + "'></a>" + a + "</div>");
                $("#canVasDiv").append("<div class='append tooltipGraph vEdge" + mac + "'><ul class='tooltiptext'><li>Type : <b>vEdge</b></li><li>vEdge Name : <b>" + jObj.AP_Description + "</b></li><li>Status : <b>" + jObj.status + "</b></li><li>Up Time : <b>" + jObj.Up_Time + "</b></li></ul></span></div>");
                oImg.on('mousedown', function(e) {

                    $('.canvas-container').hide();
                    $('.loading').show();

                    $.post('ajax/arris_graphs.php', { type: 'overview', name: jObj.AP_Description, method: 'vEdge', distributor: distributor }, function(data, textStatus, xhr) {
                        ethernet1 = '';

                        var jsonOBJ = JSON.parse(data);
                        $('.ethernet').remove();
                        for (keye in jsonOBJ.ethernet) {
                            /*
                            for (keyee in jsonOBJ.ethernet[keye]) {*/
                            ethernet1 = ethernet1 + '<tr class="ethernet"><td>' + keye + ' :</td><td>' + jsonOBJ.ethernet[keye] + '</td></tr>';
                            /*}*/
                        }

                        $('.Exdetails' + mac + jObj.AP_Description.split(' ').join("") + ' table tr:last').after(ethernet1);

                        $('.loading').hide();
                        $('#reloadOverview').hide();
                        $('.Exdetails' + mac + jObj.AP_Description.split(' ').join("")).show();
                    });
                });
            }

            if (method == 'switch') {


                var ethernet1 = '';
                oImg.set({ 'cacheKey': 'switch' + jObj.AP_Description });
                var ApCount = jObj.ap_list.length;
                var a = '<div class="switch' + j + ' details_col' + mac + jObj.AP_Description.split(' ').join("") + '"> <table class="table" cellpadding="10"> <tr><th>Switch Name: </th><th>' + jObj.AP_Description + ' </th></tr><tr><td>Serial Number :</td><td>' + jObj.Serial_Number + '</td></tr><tr><td>Firmware :</td><td>' + jObj.Firmware + '</td></tr><tr><td>IP Address :</td><td>' + jObj.ipAddress + '</td></tr>' + ethernet1 + '</table>';
                $("#canVasDiv").prepend("<div class='append switch" + j + " details Exdetails" + mac + jObj.AP_Description.split(' ').join("") + "'><a href='javascript:void(0);' class='overview' onclick='backToCanvas(\"Exdetails" + mac + jObj.AP_Description.split(' ').join("") + "\")'>Overview</a><br/><h3>Switch Node Details</h3><h4>Model : " + jObj.model + "</h4><h4>Serial Number : " + jObj.Serial_Number + "</h4><h4>Status : " + jObj.status + "</h4><h4>Port : " + jObj.upstatus + "</h4><h4>Up Time : " + jObj.Up_Time + "</h4><a href='javascript:void(0)' onclick='toggl(\"" + mac + jObj.AP_Description.split(' ').join("") + "\");' class='hide-details hide-details" + mac + jObj.AP_Description.split(' ').join("") + "'></a>" + a + "</div>");
                var upstatus = jObj.upstatus;
                var upstatus = upstatus.split("of");
                var downcount_arr = upstatus[1].split(" ");
                var downcount = parseInt(downcount_arr[1])-parseInt(upstatus[0]);
                var aasd = jObj.AP_Description


                //alert(jObj.AP_Description);
                $("#canVasDiv").append("<div class='append tooltipGraph switch" + jObj.AP_Description + "'><ul class='tooltiptext'><li>Type : <b>Switch</b></li><li>Switch Name <b>" + jObj.AP_Description + "</b></li><li>Status : <b>" + jObj.status + "</b></li><li>Model : <b>" + jObj.model + "</b></li><li>Serial Number : <b>" + jObj.Serial_Number + "</b></li><li>Up Time : <b>" + jObj.Up_Time + "</b></li><li>Total APs : <b>" + ApCount + "</b></li></ul></span></div>");
                oImg.on('mousedown', function(e) {

                    $('.canvas-container').hide();
                    $('.loading').show();

                    $.post('ajax/arris_graphs.php', { type: 'overview', name: jObj.AP_Description, method: 'switch', distributor: distributor, req_arr: JSON.stringify(jObj.detail_arr) }, function(data, textStatus, xhr) {
                        ethernet1 = '';

                        var jsonOBJ = JSON.parse(data);
                        $('.ethernet').remove();
                        for (keye in jsonOBJ.ethernet) {
                            /*
                            for (keyee in jsonOBJ.ethernet[keye]) {*/
                            ethernet1 = ethernet1 + '<tr class="ethernet"><td>' + keye + ' :</td><td>' + jsonOBJ.ethernet[keye] + '</td></tr>';
                            /*}*/
                        }

                        $('.Exdetails' + mac + jObj.AP_Description.split(' ').join("") + ' table tr:last').after(ethernet1);
                        $('.loading').hide();
                        $('#reloadOverview').hide();
                        $('.Exdetails' + mac + jObj.AP_Description.split(' ').join("")).show();
                    });

                    /*$('.switch'+j).show();

				            $('html, body').animate({
						        scrollTop: ($('.Exdetails'+mac+jObj.AP_Description.split(' ').join("")).offset().top - 40)
						    }, 1000);*/
                });
            }




        }

        oImg.setPositionByOrigin(pos, 'center', 'center');
        canvas.add(oImg);

        if (method == 'vEdge') {
            line = new fabric.Line([x, y, 310, (y +80 )], {
                stroke: '#000000',
                strokeWidth: 1,
                selectable: false
            });

            canvas.add(line);

            line.sendToBack();
        }else if(method == 'int'){
            line = new fabric.Line([x, y, 310, 300], {
                stroke: '#000000',
                strokeWidth: 1,
                selectable: false
            });

            canvas.add(line);

            line.sendToBack();
        }

    });
}