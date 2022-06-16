var distributor, switchDetailsArr = {};

function makeCanvas1(data, a, b, c, camp_layout, propName) {


    var src = '';
    var loader = 'layout/' + camp_layout + '/img/loading-whitebg.gif';

    var jsonOBJ = JSON.parse(data),
        intrnetObj = jsonOBJ.int,
        vEdgeObj = jsonOBJ.vEdge,
        serverObj = jsonOBJ.server,
        /****/
        switchObj = jsonOBJ.switch,
        x = 0,
        ul = '',
        details = '',
        onSw = 0,
        allSw = 0,
        onved = 0,
        onserver = 0,
        allved = 0,
        allserver = 0,
        onAp = 0,
        allAp = 0,
        SwitchStr = '<li><h3 style="text-align: left;">Switches</h3><input type="checkbox" checked="checked" id="switchImg" /><label for="switchImg" class="switch"></label><ul>',
        ApStr = '<li><h3 style="text-align: left;">Access Points</h3><input type="checkbox" checked="checked" id="apImg" /><label for="apImg" class="ap"></label><ul><li class="ap-loader" style="display:none"><img src='+loader+'></li>',
        vEdgeStr = '<li><h3 style="text-align: left;">Router VMs</h3><input type="checkbox" checked="checked" id="vedgeImg" /><label for="vedgeImg" class="vedge"></label><ul>';
        serverStr = '<li><h3 style="text-align: left;">Servers</h3><input type="checkbox" checked="checked" id="serverImg" /><label for="serverImg" class="vedge"></label><ul>';

    /****/
    /*var switchObj = [{"mac":"CC:5A:53:3D:87:8A","status":0,"Up_Time":"54 days, 11:01:50","AP_Description":"SUWANE25A2W-45300000-010101ARR","Serial_Number":"FOC2124Z1RB","Firmware":"15.2(4)E3","ipAddress":"10.254.254.253","vedge":"1","upstatus":"3 of 3 Ports Up","ap_list":[{"ap_code":"34:8F:27:29:D9:10","apName":"SUWANE25PWA-45300000-010101ARR","serial":"321739000827","firmwareVersion":"3.6.2.0.254","type":"WIRED","uptime":"54 days, 10:59:54","model":"R510","cpename":"SUWANE25PWA-45300000-010101ARR","clients":{"guest":[{"ssid":"vEDGE-PP-GDB2","clients":[{"mac":"AA:CB:AC:AA:AA:AA","name":"P30","ipAddress":"192.168.1.1","uptime":"1","uplink":"aa","channel":"sdsd","downlink":"sds"},{"mac":"AA:CB:AC:AA:AA:AA","name":"P30 Lite","ipAddress":"192.168.1.1","uptime":"1","uplink":"aa","channel":"sdsd","downlink":"sds"},{"mac":"AA:CB:AC:AA:AA:AA","name":"P20","ipAddress":"192.168.1.1","uptime":"1","uplink":"aa","channel":"sdsd","downlink":"sds"}]},{"ssid":"vEDGE-PP-GDB3","clients":[]},{"ssid":"vEDGE-PP-GDB4","clients":[]},{"ssid":"vEDGE-PP-GDB","clients":[]}],"private":[{"ssid":"vEDGE-PP-PDB","clients":[]},{"ssid":"vEDGE-PP-PDB2","clients":[]},{"ssid":"vEDGE-PP-PDB3","clients":[]},{"ssid":"vEDGE-PP-PDB4","clients":[]}]},"guest":0,"private":0,"mode":"AUTO","status":"1","reference":""},{"ap_code":"58:B6:33:24:36:E0","apName":"SUWANE25PWA-45300000-010102ARR","serial":"321504410362","firmwareVersion":"3.6.2.0.254","type":"WIRED","uptime":"51 days, 10:29:48","model":"R500","cpename":"SUWANE25PWA-45300000-010102ARR","clients":{"guest":[{"ssid":"vEDGE-PP-GDB2","clients":[]},{"ssid":"vEDGE-PP-GDB3","clients":[]},{"ssid":"vEDGE-PP-GDB4","clients":[]},{"ssid":"vEDGE-PP-GDB","clients":[]}],"private":[{"ssid":"vEDGE-PP-PDB","clients":[]},{"ssid":"vEDGE-PP-PDB2","clients":[]},{"ssid":"vEDGE-PP-PDB3","clients":[]},{"ssid":"vEDGE-PP-PDB4","clients":[]}]},"guest":0,"private":0,"mode":"AUTO","status":"1","reference":""}],"detail_arr":{"GigabitEthernet0\/1 description":"Uplink to Internet","GigabitEthernet0\/1 operational state":"Up","GigabitEthernet0\/10 description":"Downlink to Customer Untrusted Port","GigabitEthernet0\/10 operational state":"Up","GigabitEthernet0\/2 description":"Downlink to AC","GigabitEthernet0\/2 operational state":"Up"}},{"mac":"noSwitch","ap_list":[]}];
     */
    distributor = c;

    for (key12 in vEdgeObj) {

        var vdUniq = (vEdgeObj[allved].mac.replace(/:/g, "") + vEdgeObj[allved].AP_Description.split(' ').join("").split('.').join(""));

        if (vEdgeObj[allved].status == '1') {
            var vdstatus = 'Online';
            onved++;
        } else {
            var vdstatus = 'Offline';
        }

        vEdgeStr = vEdgeStr + '<li><label data-ref="' + allved + '" data-type="vEdge" data-desc="' + vEdgeObj[allved].AP_Description + '" data-uniq="' + vdUniq + '"  class="tree_label ellipsis vedgeChild ' + vdstatus + '">' + vEdgeObj[allved].AP_Description + '</label></li>';
        details = details + '<div class="treeDesc details_vd' + allved + '" style="display: none;"><a href="javascript:void(0);" class="overview a">Overview</a><h2><b>ASSET DETAILS</b></h2><label class="node_txt">MAC: <b>' + vEdgeObj[allved].mac + '</b></label><label>STATUS : <b>' + vdstatus + '</b></label><label>UP TIME : <b>' + vEdgeObj[allved].Up_Time + '</b></label><div class="' + vdUniq + 'Loader Treeloader" style="display: none"><img src="' + loader + '"></div><div class="' + vdUniq + 'Table" style="display: none;padding-top: 30px"><table class="table" cellpadding="10"><tbody><tr><td>vEdge Name:</td><td>' + vEdgeObj[allved].AP_Description + '</td></tr><tr><td>Serial Number:</td><td>' + vEdgeObj[allved].Serial_Number + '</td></tr><tr><td>Firmware:</td><td>' + vEdgeObj[allved].Firmware + '</td></tr></tbody></table></div></div>';

        allved++;
    }

    for (key12 in serverObj) {

        var serverUniq = (serverObj[allserver].mac.replace(/:/g, "") + serverObj[allserver].AP_Description.split(' ').join("").split('.').join(""));

        if (serverObj[allserver].status == '1') {
            var serverstatus = 'Online';
            onserver++;
        } else {
            var serverstatus = 'Offline';
        }

        serverStr = serverStr + '<li><label data-ref="' + allserver + '" data-type="server" data-desc="' + serverObj[allserver].AP_Description + '" data-uniq="' + serverUniq + '"  class="tree_label vedgeChild ' + serverstatus + '">' + serverObj[allserver].mac + '</label></li>';
        details = details + '<div class="treeDesc details_server' + allserver + '" style="display: none;"><a href="javascript:void(0);" class="overview a">Overview</a><h2><b>ASSET DETAILS</b></h2><label class="node_txt">MAC: <b>' + serverObj[allserver].mac + '</b></label><label>STATUS : <b>' + serverstatus + '</b></label><label>UP TIME : <b>' + serverObj[allserver].Up_Time + '</b></label><div class="' + serverUniq + 'Loader Treeloader" style="display: none"><img src="' + loader + '"></div><div class="' + serverUniq + 'Table" style="display: none;padding-top: 30px"><table class="table" cellpadding="10"><tbody><tr><td>Server Name:</td><td>' + serverObj[allserver].AP_Description + '</td></tr><tr><td>Serial Number:</td><td>' + serverObj[allserver].Serial_Number + '</td></tr><tr><td>Firmware:</td><td>' + serverObj[allserver].Firmware + '</td></tr></tbody></table></div></div>';

        allserver++;
    }
    var switchGr = [];
    var switchSingle = [];
    var y=0;
    for (key in switchObj) {
        if(switchObj[y].AP_Description){
            var swStr = switchObj[y].AP_Description;
            var gr = swStr.split("-");
            var thisGr = gr[gr.length - 1].substring(0, 4);
            if(!switchGr.includes(thisGr)){
                if(switchSingle.includes(thisGr)){
                    switchGr.push(thisGr);
                    var index = switchSingle.indexOf(thisGr);
                    if (index > -1) {
                        switchSingle.splice(index, 1);
                    }
                }else{
                    switchSingle.push(thisGr);
                }
            }
        }

        y++;
    }

  
    var switchGrOb = {};
    var switchSingleOb = {};
    var switchGCheck = {};
    for (key in switchObj) {
        if (switchObj[x].mac != 'noSwitch') {
            allSw++;

            if (switchObj[x].status == '1') {
                var swStatus = 'Online';
                onSw++;
            } else {
                var swStatus = 'Offline';
            }

            var jObjAP = switchObj[x].ap_list,
                y = 0,
                swUniq = (switchObj[x].mac.replace(/:/g, "") + switchObj[x].AP_Description.split(' ').join("").split('.').join(""));

            switchDetailsArr[swUniq] = switchObj[x].detail_arr;

            var swStr = switchObj[x].AP_Description;
            var gr = swStr.split("-");
            var thisGr = gr[gr.length - 1].substring(0, 4);
            if(switchGr.includes(thisGr)){
                if(!Array.isArray(switchGrOb[thisGr])){
                    switchGrOb[thisGr] = [];
                }
                switchGCheck[thisGr] = switchObj[x].AP_Description;
                switchGrOb[thisGr].push('<li><label data-ref="' + x + '" data-type="switch" data-desc="' + switchObj[x].AP_Description + '" data-uniq="' + swUniq + '"  class="tree_label switchChild groupSwitch ' + swStatus + '">' + switchObj[x].AP_Description + '</label></li>');
            }else{
                if(!Array.isArray(switchSingleOb[thisGr])){
                    switchSingleOb[thisGr] = [];
                }
                switchSingleOb[thisGr].push('<li><label data-ref="' + x + '" data-type="switch" data-desc="' + switchObj[x].AP_Description + '" data-uniq="' + swUniq + '"  class="tree_label switchChild ' + swStatus + '">' + switchObj[x].AP_Description + '</label></li>');

            }

            //SwitchStr = SwitchStr + '<li><label data-ref="' + x + '" data-type="switch" data-desc="' + switchObj[x].AP_Description + '" data-uniq="' + swUniq + '"  class="tree_label switchChild ' + swStatus + '">' + switchObj[x].AP_Description + '</label></li>';

            details = details + '<div class="treeDesc details_sw' + x + '" style="display: none;"><a href="javascript:void(0);" class="overview a">Overview</a><h2><b>ASSET DETAILS</b></h2><label class="node_txt">MAC: <b>' + switchObj[x].mac + '</b></label><label>STATUS: <b>' + swStatus + '</b></label><label>UP TIME : <b>' + switchObj[x].Up_Time + '</b></label><div class="' + swUniq + 'Loader Treeloader" style="display: none"><img src="' + loader + '"></div><div class="' + swUniq + 'Table" style="display: none;padding-top: 30px"><table class="table" cellpadding="10"><tbody><tr><td>Switch Name:</td><td>' + switchObj[x].AP_Description + '</td></tr><tr><td>Serial Number:</td><td>' + switchObj[x].Serial_Number + '</td></tr><tr><td>Firmware:</td><td>' + switchObj[x].Firmware + '</td></tr><tr><td>IP Address:</td><td>' + switchObj[x].ipAddress + '</td></tr></tbody></table></div></div>';

            for (key1 in jObjAP) {

                if (jObjAP[y].status == '1') {
                    var apstatus = 'Online';
                    onAp++;
                } else {
                    var apstatus = 'Offline';
                }

                var apUniq = (jObjAP[y].ap_code.replace(/:/g, "") + jObjAP[y].apName.split(' ').join(""));

                var ssidStr = '<h2><b>WLAN DETAIL</b></h2><div class="wlanDetails' + x + y + '" ></div></div>';
                var a = '<div class="treeDesc details_col' + x + y + '" style="display: none;"> <a href="javascript:void(0);" class="overview a">Overview</a><h2><b>ASSET DETAILS</b></h2><label class="node_txt">MAC: <b>' + jObjAP[y].ap_code + '</b></label><label>STATUS : <b>' + apstatus + '</b></label><label>UP TIME : <b>' + jObjAP[y].uptime + '</b></label><label>MODEL : <b>' + jObjAP[y].model + '</b></label><div class="' + apUniq + 'Loader Treeloader" style="display: none"><img src="' + loader + '"></div><div class="' + apUniq + 'Table" style="display: none;"><a href="javascript:void(0)" style="text-align: left;padding-right: 20px;" onclick=\'toggl("' + apUniq + '");\' class="hide-details hide-details a-hide"></a><table style="display: none" class="table aptable" cellpadding="10"> <tr><td>AP Name: </td><td>' + jObjAP[y].cpename + ' </td></tr></table>'+ssidStr+'</div>';

                var apUniq = (jObjAP[y].ap_code.replace(/:/g, "") + jObjAP[y].apName.split(' ').join(""));
                var apNameStr = jObjAP[y].apName.split("-");
                var apNameStr = apNameStr[apNameStr.length-1];
                ApStr = ApStr + '<li><label data-ref="' + x + y + '" data-toggle="tooltip" title="' + jObjAP[y].apName + '" data-type="AP" data-mac="' + jObjAP[y].ap_code + '" data-uniq="' + apUniq + '"  class="tree_label apChild ' + apstatus + '">' + apNameStr + '</label></li>';
                y++;
                allAp++;
                details = details + a;
            }
        } else {

            var jObjAP = switchObj[x].ap_list,
                y = 0;

            for (key1 in jObjAP) {

                if (jObjAP[y].status == '1') {
                    var apstatus = 'Online';
                    onAp++;
                } else {
                    var apstatus = 'Offline';
                }

                var apUniq = (jObjAP[y].ap_code.replace(/:/g, "") + jObjAP[y].apName.split(' ').join(""));

                var ssidStr = '<h2><b>WLAN DETAIL</b></h2><div class="wlanDetails' + x + y + '"></div></div>';
                var a = '<div class="treeDesc details_col' + x + y + '" style="display: none;"><a href="javascript:void(0);" class="overview a">Overview</a> <h2><b>ASSET DETAILS</b></h2><label class="node_txt">MAC: <b>' + jObjAP[y].ap_code + '</b></label><label>STATUS : <b>' + apstatus + '</b></label><label>UP TIME : <b>' + jObjAP[y].uptime + '</b></label><label>MODEL : <b>' + jObjAP[y].model + '</b></label><div class="' + apUniq + 'Loader Treeloader" style="display: none"><img src="' + loader + '"></div><div class="' + apUniq + 'Table" style="display: none;"><a href="javascript:void(0)" style="text-align: left;padding-right: 20px;" onclick=\'toggl("' + apUniq + '");\' class="hide-details hide-details a-hide"></a><table style="display: none" class="table aptable" cellpadding="10"> <tr><td>AP Name: </td><td>' + jObjAP[y].cpename + ' </td></tr></table>'+ssidStr+'</div>';

                var apNameStr = jObjAP[y].apName.split("-");
                var apNameStr = apNameStr[apNameStr.length-1];

                var apUniq = (jObjAP[y].ap_code.replace(/:/g, "") + jObjAP[y].apName.split(' ').join(""));
                ApStr = ApStr + '<li class="aplist '+jObjAP[y].apName+'"><label data-ref="' + x + y + '"  data-toggle="tooltip" title="' + jObjAP[y].apName + '"  data-type="AP" data-mac="' + jObjAP[y].ap_code + '" data-uniq="' + apUniq + '"  class="tree_label apChild ' + apstatus + '">' + apNameStr + '</label></li>';
                y++;
                allAp++;
                details = details + a;
            }

        }

        x++;
    }

    var switchGrStr = '<li><h4 style="text-align: left;">Switch Groups</h4>';
    var z = 0;
    for (keyOb3 in switchGrOb) {
        var building1 = Number (keyOb3.substring(0, 2)); 
        var floor1 = Number (keyOb3.substring(2, 4));
        if(Number.isInteger(building1) && Number.isInteger(floor1)){
            var str1 = "Building "+building1+" Floor "+floor1;
        }else{
            var str1 = "";
        }
        switchGrStr = switchGrStr + '<input type="checkbox" id="switchGroup'+keyOb3+'Img"  class="switchGroupInput" data-val="'+switchGCheck[keyOb3]+'" /><label for="switchGroup'+keyOb3+'Img" class="switchGroup">'+str1+'</label><ul>';
        var z2 = 0;
        for (keyOb4 in switchGrOb[keyOb3]) {
            switchGrStr = switchGrStr + switchGrOb[keyOb3][z2];
            z2++;
        }
        switchGrStr = switchGrStr + '</ul>';
        z++;
    }

    switchGrStr = switchGrStr + '</li>';

    if(z==0){
        switchGrStr = "";
    }

    var switchSingleStr = '<li><h4 style="text-align: left;">Single Switch</h4>';
    var z1 = 0;
    for (keyOb in switchSingleOb) {  
        var building = Number (keyOb.substring(0, 2)); 
        var floor = Number (keyOb.substring(2, 4));
        if(Number.isInteger(building) && Number.isInteger(floor)){
            var str = "Building "+building+" Floor "+floor;
        }else{
            var str = "";
        }
        switchSingleStr = switchSingleStr + '<input type="checkbox" checked="checked" id="switchSingle'+keyOb+'Img" /><label for="switchSingle'+keyOb+'Img" class="switchSingle">'+str+'</label><ul>';
        var z3 = 0;
        for (keyOb2 in switchSingleOb[keyOb]) {
            switchSingleStr = switchSingleStr + switchSingleOb[keyOb][z3];
            z3++;
        }
        switchSingleStr = switchSingleStr + '</ul>';
        z1++;
    }

    switchSingleStr = switchSingleStr + '</li>';

    if(z1==0){
        switchSingleStr = "";
    }

    SwitchStr = SwitchStr + switchGrStr + switchSingleStr;

    ul = vEdgeStr + '</ul></li>' + SwitchStr + '</ul></li>' + ApStr + '</ul></li>';

    $('#innerCanvasContainer1').html('<div class="overviewDiv1"><div class="treeDiv"><div class="treeDivInner"><label class="internet"><img src="layout/' + camp_layout + '/img/internet.png"><span>' + propName + '</span></label><ul class="tree treeUl">' + ul + '</ul></div></div><div class="detailsTree"><span class="arrow left"> BACK</span><div class="treeDivDetails"><h2><b>ASSET INVENTORY</b></h2><table><tbody><tr><th style="text-align: left">TYPE</th><th style="text-align: left">QTY</th><th style="text-align: left">STATUS</th></tr><tr><td>Router VMs</td><td>' + allved + '</td><td>' + onved + ' of ' + allved + ' UP</td></tr><tr><td>Switches</td><td>' + allSw + '</td><td>' + onSw + ' of ' + allSw + ' UP</td></tr><tr><td>Access Points</td><td>' + allAp + '</td><td>' + onAp + ' of ' + allAp + ' UP</td></tr></tbody></table></div>' + details + '</div></div>');
    $('[data-toggle="tooltip"]').tooltip();
}


$(document).ready(function() {

    $(document.body).on('click', '.switchGroupInput' ,function(event){
          
        $('.switchGroupInput').removeClass('selected');
        if($(this).prop('checked')){
            $(".switchGroupInput").not(this).prop("checked",false);
            setInt();
            $('li.aplist').hide();
            $('.ap-loader').show();
            $('.treeDivInner').addClass('treeLoad');
            $('label.tree_label.selected').each( function () { 
                if($(this).data("type") == 'switch'){
                    $(this).removeClass('selected');
                }
            });
            $(this).addClass('selected');

            $.post('ajax/arris_graphs.php', { type: 'overview', name: $(this).data("val"), method: 'switch', distributor: distributor, req_arr: JSON.stringify(switchDetailsArr[$(this).data("uniq")]) }, function(data, textStatus, xhr) {
                $('.ap-loader').hide();
                $('.treeDivInner').removeClass('treeLoad');
                var jsonOBJ = JSON.parse(data);
                for (key in jsonOBJ.ap_list) {
                    $('.aplist.'+key).show();
                }  
            });  
            
        }else{
            $('li.aplist').show();
        }
    });

    $(document.body).on('click', 'label.tree_label' ,function(event){
        $('#reloadOverview1').hide();
        $('.ap-loader').hide();
        if ($(this).data("type") == 'AP') {
            $('label.tree_label.selected').each( function () { 
                 if($(this).data("type") != 'switch'){
                     $(this).removeClass('selected');
                 }
            });
            $(this).addClass('selected');

        }else{
            $('label.tree_label').removeClass('selected');
            $(this).addClass('selected');
        }
        var color = "red";
        if ($('.detailsTree').is(":hidden")) {
            $('.treeDiv').css('width', '0%').addClass('close');
            $('.detailsTree').css('width', '100%').removeClass('close');
            setTimeout(function() { $('.detailsTree').show(); }, 200);
        }

        $('.treeDesc').hide();
        $('.treeDivDetails').hide();

        if ($(this).data("type") == 'AP') {
            var ref = $(this).data("ref");
            var uniq = $(this).data("uniq");
            $('.details_col' + ref).show();
            var cl = '.' + $(this).data("uniq") + 'Loader';
            $('.apd').remove();
            var cl2 = '.' + $(this).data("uniq") + 'Table table.aptable tr:last';
            var cl3 = '.' + $(this).data("uniq") + 'Table';
            $(cl).show();
            $('.treeDivInner').addClass('treeLoad');
            $(cl3).hide();
            $.post('ajax/arris_graphs.php', { type: 'overview', mac: $(this).data("mac"), method: 'AP', distributor: distributor }, function(data, textStatus, xhr) {
                apd = '';
                var jsonOBJ = JSON.parse(data);
                for (keye in jsonOBJ.AP) {
                    apd = apd + '<tr class="apd"><td>' + keye + ' :</td><td>' + jsonOBJ.AP[keye] + '</td></tr>';
                }
                var ssidStr = '';
                for (key2 in jsonOBJ.clients) {
                    if (key2 == 'guest') {
                        ssidType = 'GUEST';
                    } else if(key2 == 'private') {
                        ssidType = 'PRIVATE';
                    } else if(key2 == 'vtenant') {
                        ssidType = 'RESIDENT';
                    }
                    
                    for (key3 in jsonOBJ.clients[key2]) {
                        ssidStr = ssidStr + '<label class="node_txt">TYPE: <b>' + ssidType + '</b></label><label>SSID: <b>' + key3+ '</b></label><label>TOTAL DEVICES: <b>' + jsonOBJ.clients[key2][key3].length + '</b></label>';

                        var ee = '';
                        for (key4 in jsonOBJ.clients[key2][key3]) {
                            var mac = jsonOBJ.clients[key2][key3][key4].mac;
                            ee = ee + "<table  class='hide-t table table" + mac.split(':').join("") + "'><tr><th  width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].name + "</th><th  width=\"50%\"><a href='javascript:void(0)' onclick='toggl2(\"" + mac.split(':').join("") + "\");' class='a-hide hide-details hide-details" + mac.split(':').join("") + "'></a></th></tr>";
                            ee = ee + "<tr><td width=\"50%\">MAC</td><td width=\"50%\">" + mac + "</td></tr>";
                            ee = ee + "<tr><td width=\"50%\">IP Address</td><td width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].ipAddress + "</td></tr>";
                            ee = ee + "<tr><td width=\"50%\">Connected for</td><td width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].uptime + "</td></tr>";
                            ee = ee + "<tr><td width=\"50%\">Total Up & Download</td><td width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].uplink + " | " + jsonOBJ.clients[key2][key3][key4].downlink + "</td></tr>";
                            ee = ee + "<tr><td width=\"50%\">Channel</td><td width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].channel + "</td></tr>";
                            
                            if(jsonOBJ.clients[key2][key3][key4].authStatus=='AUTHORIZED'){
                                color = "green";
                            }
                            ee = ee + "<tr><td width=\"50%\">Status</td><td style=\"color: "+color+";\" width=\"50%\">" + jsonOBJ.clients[key2][key3][key4].authStatus + "</td></tr></table>";

                        }
                        ssidStr = ssidStr + ee;
                    }
                }
                $(cl).hide();
                $('.treeDivInner').removeClass('treeLoad');
                $(cl2).after(apd);
                $(cl3).show();
                $('.wlanDetails' + ref).html(ssidStr);
            });

        } else if ($(this).data("type") == 'switch') {

           
            $('.details_sw' + $(this).data("ref")).show();
            var cl = '.' + $(this).data("uniq") + 'Loader';
            var cl2 = '.' + $(this).data("uniq") + 'Table table tr:last';
            var cl3 = '.' + $(this).data("uniq") + 'Table';
            $('.ethernet').remove();
            $(cl).show();
            $('.treeDivInner').addClass('treeLoad');
            $(cl3).hide();
            if(!$(this).hasClass('groupSwitch')){
                $('.switchGroupInput').prop('checked',false);
                $('.switchGroupInput').removeClass('selected');
                $('li.aplist').hide();
                $('.ap-loader').show();
            }
            $.post('ajax/arris_graphs.php', { type: 'overview', name: $(this).data("desc"), method: 'switch', distributor: distributor, req_arr: JSON.stringify(switchDetailsArr[$(this).data("uniq")]) }, function(data, textStatus, xhr) {
                ethernet1 = '';
                var jsonOBJ = JSON.parse(data);
                for (keye in jsonOBJ.ethernet) {

                    ethernet1 = ethernet1 + '<tr class="ethernet"><td>' + keye + ' :</td><td>' + jsonOBJ.ethernet[keye] + '</td></tr>';

                }

                if(!$(this).hasClass('groupSwitch')){
                    $('.ap-loader').hide();
                    for (key in jsonOBJ.ap_list) {
                        $('.aplist.'+key).show();
                    }
                }
                $(cl).hide();
                $('.treeDivInner').removeClass('treeLoad');
                $(cl2).after(ethernet1);
                $(cl3).show();
            });

        } else if ($(this).data("type") == 'vEdge') {

            $('.details_vd' + $(this).data("ref")).show();
            var cl = '.' + $(this).data("uniq") + 'Loader';
            var cl2 = '.' + $(this).data("uniq") + 'Table table tr:last';
            var cl3 = '.' + $(this).data("uniq") + 'Table';
            $('.ethernet').remove();
            $(cl).show();
            $('.treeDivInner').addClass('treeLoad');
            $(cl3).hide();
            $('li.aplist').show();
            $.post('ajax/arris_graphs.php', { type: 'overview', name: $(this).data("desc"), method: 'vEdge', distributor: distributor }, function(data, textStatus, xhr) {
                ethernet1 = '';
                var jsonOBJ = JSON.parse(data);
                for (keye in jsonOBJ.ethernet) {

                    ethernet1 = ethernet1 + '<tr class="ethernet"><td>' + keye + ' :</td><td>' + jsonOBJ.ethernet[keye] + '</td></tr>';

                }
                $(cl).hide();
                $('.treeDivInner').removeClass('treeLoad');
                $(cl2).after(ethernet1);
                $(cl3).show();
            });
        } else if ($(this).data("type") == 'server') {

            $('.details_server' + $(this).data("ref")).show();
            var cl = '.' + $(this).data("uniq") + 'Loader';
            var cl2 = '.' + $(this).data("uniq") + 'Table table tr:last';
            var cl3 = '.' + $(this).data("uniq") + 'Table';
            $('.ethernet').remove();
            $(cl3).show();
            //$('.treeDivInner').addClass('treeLoad');
            /*$(cl).show();*/
            /*$(cl3).hide();*/

            /*$.post('ajax/arris_graphs.php', { type: 'overview', name: $(this).data("desc"), method: 'vEdge', distributor: distributor }, function(data, textStatus, xhr) {
                ethernet1 = '';
                var jsonOBJ = JSON.parse(data);
                for (keye in jsonOBJ.ethernet) {

                    ethernet1 = ethernet1 + '<tr class="ethernet"><td>' + keye + ' :</td><td>' + jsonOBJ.ethernet[keye] + '</td></tr>';

                }
                $(cl).hide();
                $(cl2).after(ethernet1);
                $(cl3).show();
            });*/
        }
    });

    $(document.body).on('click', 'span.arrow' ,function(event){

        $('.treeDiv').css('width', '100%').removeClass('close');
        $('.detailsTree').css('width', '60%').addClass('close');
        $('.detailsTree').hide();

    });

    $(document.body).on('click', '.internet img' ,function(event){
        setInt();
    });

    $(document.body).on('click', '.a.overview' ,function(event){
        setInt();
    });
});

function setInt(){
    $('.ap-loader').hide();
    $('#reloadOverview1').show();
    $('label.tree_label').removeClass('selected');
    $('.treeDesc').hide();
        $('.treeDivDetails').show();
        $('.aplist').show();
        if ($('.detailsTree').is(":hidden")) {
            $('.treeDiv').css('width', '0%').addClass('close');
            $('.detailsTree').css('width', '100%').removeClass('close');
            setTimeout(function() { $('.detailsTree').show(); }, 200);
        }
    
}
function toggl(ele) {

    var cl = "." + ele + "Table table.aptable";
    var cl2 = "." + ele + "Table .hide-details";

    if ($(cl).is(':visible')) {
        $(cl).hide();
        $(cl2).addClass('a-hide');
    } else {
        $(cl).show();
        $(cl2).removeClass('a-hide');
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