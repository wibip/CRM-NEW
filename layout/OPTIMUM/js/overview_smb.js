

var uniqueId = 'id-' + Math.random().toString(36).substr(2, 16);
var backBtn,canvas = new fabric.Canvas('myCanvas');
var Last1 = 'notCreated',
    First1 = 'notdone',
    status_txt, status_clz;
var Direction = 'none';

function Construct(jsonData, createId, graph_code, location_id) {

   /* Last1 = 'notCreated', First1 = 'notdone';
    Direction = 'none';
     var jObj = JSON.parse(jsonData);*/

    var size = 0, key ;
    backBtn = '<a href="javascript:void(0)" onclick="backDiv();" style="font-size: 16px; font-weight: 600;float:left; margin-top: 8px; position: relative;">< Back</a><br><br>';

  /*  $("#" + createId).addClass('tree_graph');

    for (key in jObj) {

        if (jObj.hasOwnProperty(key)) {

            if (jObj[size].reference == '0' || Object.keys(jObj[size].reference).length === 0 || jObj[size].reference == null){
            
                if (First1 == 'done' && Direction == 'right') {
                    Left(jObj[size].speed, jObj[size].guest, jObj[size].private, jObj[size].name, jObj[size].status, jObj[size].ap_code.toString(), createId, graph_code, location_id);
                }
                else if (Direction == 'left') {
                    Right(jObj[size].speed, jObj[size].guest, jObj[size].private, jObj[size].name, jObj[size].status, jObj[size].ap_code, createId, graph_code, location_id);
                }
                else if (First1 == 'notdone') {
                    init(jObj[size].speed, jObj[size].guest, jObj[size].private, jObj[size].name, jObj[size].status, jObj[size].ap_code, createId, graph_code, location_id);
                }
            }
            else{
                Bottom(jObj[size].guest, jObj[size].private, jObj[size].name, jObj[size].ap_code, jObj[size].status, jObj[size].reference, createId, graph_code, location_id);
            }
        }
        size++;
    }
 */

    var ap_root = 0; 
    var mesh_wired = 0;
    var mesh_wless = 0;
    var ap_root_arr = new Array();
    var mesh_wired_arr = new Array();
    var mesh_wless_arr = new Array();

    var jObj_arr = JSON.parse(jsonData);
    var jObj = jObj_arr.aps;
    var size = 0, key, has_root = false ;

    for (key in jObj) {

        if(jObj[size].mode == 'ROOT'){
            ap_root = ap_root + 1;
            ap_root_arr.push(size);
            has_root = true;
        }
        if(jObj[size].mode != 'ROOT' && jObj[size].type == 'WIRED'){
            mesh_wired = mesh_wired + 1;
            mesh_wired_arr.push(size);
        }
        if(jObj[size].mode != 'ROOT' && jObj[size].type == 'WLESS'){
            mesh_wless = mesh_wless + 1;
            mesh_wless_arr.push(size);
        }
            
            size++;
            
    }

    var method = String(ap_root) + String(mesh_wired) + String(mesh_wless);

    if(!has_root){
        ap_root_arr = [];
        method = '';

        if(mesh_wired==4){
            ap_root_arr.push(3);
            method = '130';
        }else if(mesh_wired==3 && mesh_wless==0){
            ap_root_arr.push(2);
            method = '120';
        }else if(mesh_wired==2 && mesh_wless==0){
            ap_root_arr.push(1);
            method = '110';
        }else if(mesh_wired==3 && mesh_wless==1){
            ap_root_arr.push(2);
            method = '121';
        }else if(mesh_wired==2 && mesh_wless==1){
            ap_root_arr.push(1);
            method = '111';
        }else if(mesh_wired==2 && mesh_wless==2){
            ap_root_arr.push(1);
            method = '112';
        }else if(mesh_wired==1 && mesh_wless==0){
            ap_root_arr.push(0);
            method = '100';
        }else if(mesh_wired==1 && mesh_wless==3){
            ap_root_arr.push(0);
            method = '103';
        }else if(mesh_wired==1 && mesh_wless==2){
            ap_root_arr.push(0);
            method = '102';
        }else if(mesh_wired==1 && mesh_wless==1){
            ap_root_arr.push(0);
            method = '101';
        }else if(mesh_wired==0 && mesh_wless==0){
            ap_root_arr.push(0);
            method = '000';
        }else{

        }

    }

    canvas.hoverCursor = 'default';


    fabric.Image.fromURL('img/overview/Picture2.png', function(oImg) {

        oImg.scale(0.2);

        oImg.set({ 'left': 200 });
        oImg.set({ 'top': 60 });

        canvas.add(oImg);
        oImg.hoverCursor = 'default';
        oImg.selectable = false;

        var rect = new fabric.Rect({ width: 5, height: 55, fill: '#000' });

        rect.set({ 'left': 241 });
        rect.set({ 'top': 145 });

        canvas.add(rect);

        rect.selectable = false;

        var path = new fabric.Path('M 0 0 L 15 20 L -15 20 z');
        path.set({ left: 208, top: 146 });
        canvas.add(path);

        path.selectable = false;

        var path = new fabric.Path('M 0 0 L 30 0 L 15 20 z');
        path.set({ left: 248, top: 166 });
        canvas.add(path);

        path.selectable = false;



        doEx(method, canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,jObj_arr.switch_mac);

      

    });



}

function overview_refresh(createId,graph_code,user_distributor){
    canvas.clear();
    $('#home_over_load').show();
    $.post("ajax/treeViewRefresh.php", { user_distributor: user_distributor },
        function(data, textStatus, jqXHR) {
            $('#home_over_load').hide();
            Construct(data, createId, graph_code, user_distributor) ;
        });
}


function setbring(canvas,switch_mac,c){

     if (switch_mac) {

            fabric.Image.fromURL('img/overview/Picture1.png', function(oImg1x) {

            oImg1x.scale(0.2);

            oImg1x.set({ 'left': 200 });
            oImg1x.set({ 'top': 190 });

            canvas.add(oImg1x);   
            canvas.bringToFront(oImg1x);
            oImg1x.selectable = false;

           

      var rectx = new fabric.Rect({ width: 100, height: 12, fill: '#fff' });
            
      
            
      rectx.set({ 'left': 197 });
      rectx.set({ 'top': 218 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
            
            if(c=='only_switch'){
                var textx = new fabric.Text(switch_mac.toUpperCase(), { left: 202, top: 222,fontSize: 10 });
              }else{
                  var textx = new fabric.Text(switch_mac.toUpperCase(), { left: 195, top: 219,fontSize: 10 });
              }

            canvas.add(textx);
            textx.selectable = false;
           
            canvas.bringToFront(textx);


              });


        }


}


//ovrview new//

function doEx(method, canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,switch_mac) {

    //hubEdge(canvas);
        switch (method) {
        case '130':
            hubEdge(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,2,createId,graph_code,location_id,switch_mac);
            hubAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,switch_mac);
            setbring(canvas,switch_mac,'');
            break;
        case '121':
            hubAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,switch_mac);
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            WlessDirect(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,0);
            setbring(canvas,switch_mac,'');
            break;
        case '112':
            hubEdge(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,0,createId,graph_code,location_id,switch_mac);
            wlessAngleLeft(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            setbring(canvas,switch_mac,'');
            break;
        case '103':
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            WlessDirect(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,2);
            wlessAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            setbring(canvas,switch_mac,'');
            break;
        case '120':
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            hubAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,switch_mac);
            setbring(canvas,switch_mac,'');
            break;
        case '111':
            hubEdge(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,0,createId,graph_code,location_id,switch_mac);
            WlessDirectLeft(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            setbring(canvas,switch_mac,'');
            break;
        case '102':
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            wlessAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            setbring(canvas,switch_mac,'');
            break;
        case '110':
            hubEdge(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,0,createId,graph_code,location_id,switch_mac);
            setbring(canvas,switch_mac,'');
            break;
        case '101':
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            WlessDirect(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,0);
            setbring(canvas,switch_mac,'');
            break;
        case '100':
            hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id);
            setbring(canvas,switch_mac,'');
            break;
        case '000':
            setbring(canvas,switch_mac,'only_switch');
            break;
        default:

    }


}


function hubEdge(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,xx,createId,graph_code,location_id,switch_mac) {

     var line = new fabric.Line([242, 193, 200, 244], {
        stroke: 'black',
        strokeWidth: 5,
    });

    canvas.add(line);

    var pic1 =  'img/overview/Picture11.png';

    if(jObj[ap_root_arr[0]].mode == 'DISABLE'){
        pic1 =  'img/overview/Picture11r.png';
    }else if(jObj[ap_root_arr[0]].mode == 'AUTO'){
        pic1 =  'img/overview/Picture11b.png';
    }else{

    }

    line.selectable = false; 

    fabric.Image.fromURL(pic1, function(oImg1) {

        var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 147 });
            rectx.set({ 'top': 342 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;


    var text = new fabric.Text(jObj[ap_root_arr[0]].name, { left: 149, top: 344 ,fontSize: 10});
    canvas.add(text);

    canvas.bringToFront(text);

    var text2 = new fabric.Text(jObj[ap_root_arr[0]].guest.toString(), { left: 170, top: 235 ,fontSize: 12});
    canvas.add(text2);

    var text3 = new fabric.Text(jObj[ap_root_arr[0]].private.toString(), { left: 230, top: 235 ,fontSize: 12});
    canvas.add(text3);

    if (jObj[ap_root_arr[0]].status == 1) {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

        oImg1.scale(0.2);

        oImg1.set({ 'left': 162 });
        oImg1.set({ 'top': 244 });

        canvas.add(oImg1);
        
                    
        var circle = new fabric.Circle({
          radius: 6, fill: status_clr, left: 167, top: 300
        });
        canvas.add(circle);


/*    var text2 = new fabric.Text(status_txt, { left: 130, top: 305 ,fontSize: 12});
  
  canvas.add(text2);*/

        canvas.item(4).selectable = false;
        oImg1.hoverCursor = 'pointer';
        oImg1.on('mousedown', function(e) {
            viewDetails(jObj[ap_root_arr[0]].ap_code,jObj[ap_root_arr[0]].name,createId,graph_code,location_id);
          
        });

        if (switch_mac) {

           var line1 = new fabric.Line([270, 228, 283, 244], {
                stroke: 'black',
                strokeWidth: 5,
            });

       }else{

        var line1 = new fabric.Line([242, 193, 283, 244], {
                stroke: 'black',
                strokeWidth: 5,
            });
       }

        canvas.add(line1);

        line1.selectable = false;

        var pic2 =  'img/overview/Picture133.png';

        if(jObj[mesh_wired_arr[xx]].mode == 'DISABLE'){
            pic2 =  'img/overview/Picture133r.png';
        }else if(jObj[mesh_wired_arr[xx]].mode == 'AUTO'){
            pic2 =  'img/overview/Picture133b.png';
        }else{

        }

        fabric.Image.fromURL(pic2, function(oImg2) {
        
            if (jObj[mesh_wired_arr[xx]].status == 1) {
            status_txt = 'Online';
            status_clr = 'green';
        }
        else {
            status_txt = 'Offline';
            status_clr = 'red';
        }

        var rectx2 = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx2.set({ 'left': 246 });
            rectx2.set({ 'top': 342 });
            canvas.add(rectx2);
            canvas.bringToFront(rectx2);
            rectx2.selectable = false;
    
            var text4 = new fabric.Text(jObj[mesh_wired_arr[xx]].name, { left: 248, top: 344 ,fontSize: 10});
            canvas.add(text4);

            canvas.bringToFront(text4);

            var text5 = new fabric.Text(jObj[mesh_wired_arr[xx]].guest.toString(), { left: 250, top: 235 ,fontSize: 12});
            canvas.add(text5);

            var text6 = new fabric.Text(jObj[mesh_wired_arr[xx]].private.toString(), { left: 310, top: 235 ,fontSize: 12});
            canvas.add(text6);

            oImg2.scale(0.2);

            oImg2.set({ 'left': 243 });
            oImg2.set({ 'top': 244 });

            canvas.add(oImg2);
            
            
            var circle1 = new fabric.Circle({
              radius: 6, fill: status_clr, left: 308, top: 300
            });
            canvas.add(circle1);

            canvas.selectable = false;

            /*var text2 = new fabric.Text(status_txt, { left: 327, top: 305 ,fontSize: 12});   
              canvas.add(text2);*/

            oImg2.hoverCursor = 'pointer';

            oImg2.on('mousedown', function(e) {
                viewDetails(jObj[mesh_wired_arr[xx]].ap_code,jObj[mesh_wired_arr[xx]].name,createId,graph_code, location_id);
            });

            oImg1.selectable = false;
            oImg2.selectable = false;
            text.selectable = false;
            text2.selectable = false;
            text3.selectable = false;
            text4.selectable = false;
            text5.selectable = false;
            text6.selectable = false;
            circle.selectable = false;
            circle1.selectable = false;

        });

    });
}


function hubDirectRoot(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id) {

    var rect = new fabric.Rect({ width: 5, height: 62, fill: '#000' });

    rect.set({ 'left': 241 });
    rect.set({ 'top': 183 });

    canvas.add(rect);

    var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 198 });
            rectx.set({ 'top': 342 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
    
      var text = new fabric.Text(jObj[ap_root_arr[0]].name, { left: 200, top: 344 ,fontSize: 10});
canvas.add(text);

canvas.bringToFront(text);
    var text2 = new fabric.Text(jObj[ap_root_arr[0]].guest.toString(), { left: 210, top: 235 ,fontSize: 12});
canvas.add(text2);

    var text3 = new fabric.Text(jObj[ap_root_arr[0]].private.toString(), { left: 270, top: 235 ,fontSize: 12});
canvas.add(text3);

var status_clr,status_txt;
if (jObj[ap_root_arr[0]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

    var pic1 =  'img/overview/Picture11.png';

    if(jObj[ap_root_arr[0]].mode == 'DISABLE'){
        pic1 =  'img/overview/Picture11r.png';
    }else if(jObj[ap_root_arr[0]].mode == 'AUTO'){
        pic1 =  'img/overview/Picture11b.png';
    }else{

    }

    fabric.Image.fromURL(pic1, function(oImg1) {

        oImg1.scale(0.2);

        oImg1.set({ 'left': 202 });
        oImg1.set({ 'top': 244 });

        canvas.add(oImg1);
        
         var circle = new fabric.Circle({
  radius: 6, fill: status_clr, left: 270, top: 295
});
canvas.add(circle);

circle.selectable = false;

        canvas.item(4).selectable = false;
        oImg1.hoverCursor = 'pointer';
        oImg1.on('mousedown', function(e) {
             viewDetails(jObj[ap_root_arr[0]].ap_code,jObj[ap_root_arr[0]].name,createId,graph_code,location_id);
        });

        oImg1.selectable = false;
        rect.selectable = false;
        text.selectable = false;
        text2.selectable = false;
        text3.selectable = false;
        circle.selectable = false;    
    });
}

function WlessDirect(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,xx) {
    var line = new fabric.Line([241, 315, 241, 384], {
        strokeDashArray: [5, 5],
        stroke: 'black',
        strokeWidth: 5,
    });

    canvas.add(line);

    var pic2 =  'img/overview/Picture133.png';

    if(jObj[mesh_wless_arr[xx]].mode == 'DISABLE'){
        pic2 =  'img/overview/Picture133r.png';
    }else if(jObj[mesh_wless_arr[xx]].mode == 'AUTO'){
        pic2 =  'img/overview/Picture133b.png';
    }else{

    }

    fabric.Image.fromURL(pic2, function(oImg1) {

        var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 198 });
            rectx.set({ 'top': 482 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
    
        
      var text = new fabric.Text(jObj[mesh_wless_arr[xx]].name, { left: 200, top: 484 ,fontSize: 10});
canvas.add(text);

canvas.bringToFront(text);

    var text2 = new fabric.Text(jObj[mesh_wless_arr[xx]].guest.toString(), { left: 210, top: 375 ,fontSize: 12});
canvas.add(text2);

    var text3 = new fabric.Text(jObj[mesh_wless_arr[xx]].private.toString(), { left: 270, top: 375 ,fontSize: 12});
canvas.add(text3);
var status_clr,status_txt;
if (jObj[mesh_wless_arr[xx]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }


        oImg1.scale(0.2);

        oImg1.set({ 'left': 202 });
        oImg1.set({ 'top': 384 });

        canvas.add(oImg1);
        
           var circle = new fabric.Circle({
  radius: 6, fill: status_clr, left: 270, top: 435
});
canvas.add(circle);

        canvas.item(4).selectable = false;
        oImg1.hoverCursor = 'pointer';
        oImg1.on('mousedown', function(e) {
             viewDetails(jObj[mesh_wless_arr[xx]].ap_code,jObj[mesh_wless_arr[xx]].name,createId,graph_code,location_id);
        });

        oImg1.selectable = false;
        line.selectable = false;
        text.selectable = false;
        text2.selectable = false;
        text3.selectable = false;
        circle.selectable = false; 

    });
}


function WlessDirectLeft(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id) {
    var line = new fabric.Line([200, 315, 200, 384], {
        strokeDashArray: [5, 5],
        stroke: 'black',
        strokeWidth: 5,
    });

    canvas.add(line);

    var pic2 =  'img/overview/Picture133.png';

    if(jObj[mesh_wless_arr[0]].mode == 'DISABLE'){
        pic2 =  'img/overview/Picture133r.png';
    }else if(jObj[mesh_wless_arr[0]].mode == 'AUTO'){
        pic2 =  'img/overview/Picture133b.png';
    }else{

    }

    fabric.Image.fromURL(pic2, function(oImg1) {

        var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 153 });
            rectx.set({ 'top': 482 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;

                 var text = new fabric.Text(jObj[mesh_wless_arr[0]].name, { left: 155, top: 484 ,fontSize: 10});
canvas.add(text);
canvas.bringToFront(text);

    var text2 = new fabric.Text(jObj[mesh_wless_arr[0]].guest.toString(), { left: 170, top: 375 ,fontSize: 12});
canvas.add(text2);

    var text3 = new fabric.Text(jObj[mesh_wless_arr[0]].private.toString(), { left: 230, top: 375 ,fontSize: 12});
canvas.add(text3);

var status_clr,status_txt;

if (jObj[mesh_wless_arr[0]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

        oImg1.scale(0.2);

        oImg1.set({ 'left': 162 });
        oImg1.set({ 'top': 384 });

        canvas.add(oImg1);
          var circle = new fabric.Circle({
  radius: 6, fill: status_clr, left: 167, top: 440
});
canvas.add(circle);

        canvas.item(4).selectable = false;
        oImg1.hoverCursor = 'pointer';
        oImg1.on('mousedown', function(e) {
             viewDetails(jObj[mesh_wless_arr[0]].ap_code,jObj[mesh_wless_arr[0]].name,createId,graph_code,location_id);
        });

        oImg1.selectable = false;
        line.selectable = false;
        text.selectable = false;
        text2.selectable = false;
        text3.selectable = false;
        circle.selectable = false; 
    });
}



function wlessAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id) {


    var line = new fabric.Line([241, 315, 160, 384], {
        strokeDashArray: [5, 5],
        stroke: 'black',
        strokeWidth: 5,
    });

    canvas.add(line);
    line.selectable = false;

    var pic2 =  'img/overview/Picture122.png';

    if(jObj[mesh_wless_arr[0]].mode == 'DISABLE'){
        pic2 =  'img/overview/Picture122r.png';
    }else if(jObj[mesh_wless_arr[0]].mode == 'AUTO'){
        pic2 =  'img/overview/Picture122b.png';
    }else{

    }

    fabric.Image.fromURL(pic2, function(oImg3) {

        var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 101 });
            rectx.set({ 'top': 482 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
    
         var text = new fabric.Text(jObj[mesh_wless_arr[0]].name, { left: 103, top: 484 ,fontSize: 10});
canvas.add(text);

canvas.bringToFront(text);

    var text2 = new fabric.Text(jObj[mesh_wless_arr[0]].guest.toString(), { left: 120, top: 375 ,fontSize: 12});
canvas.add(text2);

    var text3 = new fabric.Text(jObj[mesh_wless_arr[0]].private.toString(), { left: 120, top: 460 ,fontSize: 12});
canvas.add(text3);
var status_clr,status_txt;
if (jObj[mesh_wless_arr[0]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

        oImg3.scale(0.2);

        oImg3.set({ 'left': 120 });
        oImg3.set({ 'top': 384 });

        canvas.add(oImg3);
        
             var circle = new fabric.Circle({
  radius: 6, fill: status_clr, left: 118, top: 420
});
canvas.add(circle);

        oImg3.hoverCursor = 'pointer';

        oImg3.on('mousedown', function(e) {
             viewDetails(jObj[mesh_wless_arr[0]].ap_code,jObj[mesh_wless_arr[0]].name,createId,graph_code,location_id);
        });

        oImg3.selectable = false;


        var line = new fabric.Line([241, 315, 321, 384], {
            strokeDashArray: [5, 5],
            stroke: 'black',
            strokeWidth: 5,
        });

        canvas.add(line);
        line.selectable = false;

        var pic1 =  'img/overview/Picture6.png';

    if(jObj[mesh_wless_arr[1]].mode == 'DISABLE'){
        pic1 =  'img/overview/Picture6r.png';
    }else if(jObj[mesh_wless_arr[1]].mode == 'AUTO'){
        pic1 =  'img/overview/Picture6b.png';
    }else{

    }

        fabric.Image.fromURL(pic1, function(oImg3) {

            var rectx1 = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx1.set({ 'left': 295 });
            rectx1.set({ 'top': 482 });
            canvas.add(rectx1);
            canvas.bringToFront(rectx1);
            rectx1.selectable = false;
        
              var text4 = new fabric.Text(jObj[mesh_wless_arr[1]].name, { left: 297, top: 484 ,fontSize: 10});
canvas.add(text4);

canvas.bringToFront(text4);

    var text5 = new fabric.Text(jObj[mesh_wless_arr[1]].guest.toString(), { left: 360, top: 375 ,fontSize: 12});
canvas.add(text5);

    var text6 = new fabric.Text(jObj[mesh_wless_arr[1]].private.toString(), { left: 360, top: 460 ,fontSize: 12});
canvas.add(text6);
var status_clr,status_txt;
if (jObj[mesh_wless_arr[1]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

            oImg3.scale(0.2);

            oImg3.set({ 'left': 288 });
            oImg3.set({ 'top': 384 });
            oImg3.hoverCursor = 'pointer';
            canvas.add(oImg3);
            
            var circle1 = new fabric.Circle({
              radius: 6, fill: status_clr, left: 358, top: 420
            });
            canvas.add(circle1);

            oImg3.on('mousedown', function(e) {
                 viewDetails(jObj[mesh_wless_arr[1]].ap_code,jObj[mesh_wless_arr[1]].name,createId,graph_code,location_id);
            });

            oImg3.selectable = false;
            text.selectable = false;
            text2.selectable = false;
            text3.selectable = false;
            text4.selectable = false;
            text5.selectable = false;
            text6.selectable = false;
            circle.selectable = false; 
            circle1.selectable = false; 

        });

    });
}

function wlessAngleLeft(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id) {


    var line = new fabric.Line([200, 315, 120, 384], {
        strokeDashArray: [5, 5],
        stroke: 'black',
        strokeWidth: 5,
    });

    canvas.add(line);

    line.selectable = false;

     var pic2 =  'img/overview/Picture122.png';

    if(jObj[mesh_wless_arr[0]].mode == 'DISABLE'){
        pic2 =  'img/overview/Picture122r.png';
    }else if(jObj[mesh_wless_arr[0]].mode == 'AUTO'){
        pic2 =  'img/overview/Picture122b.png';
    }else{

    }

    fabric.Image.fromURL(pic2, function(oImg3) {

        var rectx1 = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx1.set({ 'left': 71 });
            rectx1.set({ 'top': 482 });
            canvas.add(rectx1);
            canvas.bringToFront(rectx1);
            rectx1.selectable = false;
    
          var text = new fabric.Text(jObj[mesh_wless_arr[0]].name, { left: 73, top: 484 ,fontSize: 10});
          canvas.add(text);

          canvas.bringToFront(text);

          var text2 = new fabric.Text(jObj[mesh_wless_arr[0]].guest.toString(), { left: 80, top: 375 ,fontSize: 12});
          canvas.add(text2);

          var text3 = new fabric.Text(jObj[mesh_wless_arr[0]].private.toString(), { left: 80, top: 460 ,fontSize: 12});
          canvas.add(text3);
          var status_clr,status_txt;
    if (jObj[mesh_wless_arr[0]].status == '1') {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

        oImg3.scale(0.2);

        oImg3.set({ 'left': 80 });
        oImg3.set({ 'top': 384 });

        canvas.add(oImg3);
        
        var circle = new fabric.Circle({
          radius: 6, fill: status_clr, left: 143, top: 440
        });
        canvas.add(circle);

        oImg3.hoverCursor = 'pointer';

        oImg3.on('mousedown', function(e) {
             viewDetails(jObj[mesh_wless_arr[0]].ap_code,jObj[mesh_wless_arr[0]].name,createId,graph_code,location_id);
        });

        oImg3.selectable = false;

        var line = new fabric.Line([200, 315, 281, 384], {
            strokeDashArray: [5, 5],
            stroke: 'black',
            strokeWidth: 5,
        });

        canvas.add(line);

        line.selectable = false;

          var pic1 =  'img/overview/Picture6.png';

            if(jObj[mesh_wless_arr[1]].mode == 'DISABLE'){
                pic1 =  'img/overview/Picture6r.png';
            }else if(jObj[mesh_wless_arr[1]].mode == 'AUTO'){
                pic1 =  'img/overview/Picture6b.png';
            }else{

            }

        fabric.Image.fromURL(pic1, function(oImg3) {

            var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 250 });
            rectx.set({ 'top': 482 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
        
        var text4 = new fabric.Text(jObj[mesh_wless_arr[1]].name, { left: 252, top: 484 ,fontSize: 10});
        canvas.add(text4);

        canvas.bringToFront(text4);

        var text5 = new fabric.Text(jObj[mesh_wless_arr[1]].guest.toString(), { left: 320, top: 375 ,fontSize: 12});
        canvas.add(text5);

        var text6 = new fabric.Text(jObj[mesh_wless_arr[1]].private.toString(), { left: 320, top: 460 ,fontSize: 12});
        canvas.add(text6);

        var status_clr,status_txt;

        if (jObj[mesh_wless_arr[1]].status == '1') {
            status_txt = 'Online';
            status_clr = 'green';
        }
        else {
            status_txt = 'Offline';
            status_clr = 'red';
        }

            oImg3.scale(0.2);

            oImg3.set({ 'left': 248 });
            oImg3.set({ 'top': 384 });
            oImg3.hoverCursor = 'pointer';
            canvas.add(oImg3);

          
          var circle1 = new fabric.Circle({
  radius: 6, fill: status_clr, left: 251, top: 440
});
canvas.add(circle1);

            oImg3.selectable = false;
            text.selectable = false;
            text2.selectable = false;
            text3.selectable = false;
            text4.selectable = false;
            text5.selectable = false;
            text6.selectable = false;
            circle.selectable = false; 
            circle1.selectable = false; 

            oImg3.on('mousedown', function(e) {
                 viewDetails(jObj[mesh_wless_arr[1]].ap_code,jObj[mesh_wless_arr[1]].name,createId,graph_code,location_id);
            });

        });

    });
}

/*function hubAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj) {

    var rect1 = new fabric.Rect({ width: 5, height: 100, fill: '#000' });

    rect1.set({ 'left': 200 });
    rect1.set({ 'top': 180 });
    rect1.set({ 'angle': 50 });

    canvas.add(rect1);

    rect1.selectable = false;

    fabric.Image.fromURL('img/overview/Picture122.png', function(oImg3) {

        oImg3.scale(0.2);

        oImg3.set({ 'left': 82 });
        oImg3.set({ 'top': 246 });

        canvas.add(oImg3);
        oImg3.hoverCursor = 'pointer';

        oImg3.on('mousedown', function(e) {
            console.log('img4');
        });

        oImg3.selectable = false;



        var rect1 = new fabric.Rect({ width: 5, height: 100, fill: '#000' });

        rect1.set({ 'left': 281 });
        rect1.set({ 'top': 185 });
        rect1.set({ 'angle': 310 });

        canvas.add(rect1);

        fabric.Image.fromURL('img/overview/Picture6.png', function(oImg3) {

            oImg3.scale(0.2);

            oImg3.set({ 'left': 326 });
            oImg3.set({ 'top': 246 });
            oImg3.hoverCursor = 'pointer';
            canvas.add(oImg3);

            oImg3.selectable = false;
            rect1.selectable = false;

            oImg3.on('mousedown', function(e) {
                console.log('img4');
            });

        });

    });


}*/


function hubAngle(canvas,ap_root_arr,mesh_wired_arr,mesh_wless_arr,jObj,createId,graph_code,location_id,switch_mac) {

    var rect1 = new fabric.Rect({ width: 5, height: 132, fill: '#000' });

    rect1.set({ 'left': 245 });
    rect1.set({ 'top': 190 });
    rect1.set({ 'angle': 65 });

    canvas.add(rect1);

    rect1.selectable = false;

        var pic2 =  'img/overview/Picture122.png';

    if(jObj[mesh_wired_arr[0]].mode == 'DISABLE'){
        pic2 =  'img/overview/Picture122r.png';
    }else if(jObj[mesh_wired_arr[0]].mode == 'AUTO'){
        pic2 =  'img/overview/Picture122b.png';
    }else{

    }

    fabric.Image.fromURL(pic2, function(oImg3) {

         var rectx = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx.set({ 'left': 51 });
            rectx.set({ 'top': 342 });
            canvas.add(rectx);
            canvas.bringToFront(rectx);
            rectx.selectable = false;
    
     var text = new fabric.Text(jObj[mesh_wired_arr[0]].name, { left: 53, top: 344 ,fontSize: 10});
canvas.add(text);

canvas.bringToFront(text);

    var text2 = new fabric.Text(jObj[mesh_wired_arr[0]].guest.toString(), { left: 80, top: 240 ,fontSize: 12});
canvas.add(text2);

    var text3 = new fabric.Text(jObj[mesh_wired_arr[0]].private.toString(), { left: 80, top: 320 ,fontSize: 12});
canvas.add(text3);


    if (jObj[mesh_wired_arr[0]].status == 1) {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

        oImg3.scale(0.2);

        oImg3.set({ 'left': 82 });
        oImg3.set({ 'top': 246 });

        canvas.add(oImg3);
        
        var circle = new fabric.Circle({
  radius: 6, fill: status_clr, left: 79, top: 280
});
canvas.add(circle);

        oImg3.hoverCursor = 'pointer';

        oImg3.on('mousedown', function(e) {
             viewDetails(jObj[mesh_wired_arr[0]].ap_code,jObj[mesh_wired_arr[0]].name,createId, graph_code,location_id);
        });

        oImg3.selectable = false;



        

        if (switch_mac) {

            var rect1 = new fabric.Rect({ width: 5, height: 88, fill: '#000' });

            rect1.set({ 'left': 284 });
            rect1.set({ 'top': 214 });
            rect1.set({ 'angle': 295 });
        }else{

            var rect1 = new fabric.Rect({ width: 5, height: 128, fill: '#000' });

             rect1.set({ 'left': 244 });
             rect1.set({ 'top': 197 });
             rect1.set({ 'angle': 295 });

        }

       

        canvas.add(rect1);

             var pic1 =  'img/overview/Picture6.png';

    if(jObj[mesh_wired_arr[1]].mode == 'DISABLE'){
        pic1 =  'img/overview/Picture6r.png';
    }else if(jObj[mesh_wired_arr[1]].mode == 'AUTO'){
        pic1 =  'img/overview/Picture6b.png';
    }else{

    }


        fabric.Image.fromURL(pic1, function(oImg3) {

            var rectx1 = new fabric.Rect({ width: 100, height: 16, fill: '#fff' });

            rectx1.set({ 'left': 345 });
            rectx1.set({ 'top': 342 });
            canvas.add(rectx1);
            canvas.bringToFront(rectx1);
            rectx1.selectable = false;
        
            
     var text4 = new fabric.Text(jObj[mesh_wired_arr[1]].name, { left: 347, top: 344 ,fontSize: 10});
canvas.add(text4);

canvas.bringToFront(text4);

    var text5 = new fabric.Text(jObj[mesh_wired_arr[1]].private.toString(), { left: 403, top: 320 ,fontSize: 12});
canvas.add(text5);

    var text6 = new fabric.Text(jObj[mesh_wired_arr[1]].guest.toString(), { left: 403, top: 240 ,fontSize: 12});
canvas.add(text6);


    if (jObj[mesh_wired_arr[1]].status == 1) {
        status_txt = 'Online';
        status_clr = 'green';
    }
    else {
        status_txt = 'Offline';
        status_clr = 'red';
    }

            oImg3.scale(0.2);

            oImg3.set({ 'left': 326 });
            oImg3.set({ 'top': 246 });
            oImg3.hoverCursor = 'pointer';
            canvas.add(oImg3);
            
             var circle1 = new fabric.Circle({
  radius: 6, fill: status_clr, left: 397, top: 280
});
canvas.add(circle1);

            oImg3.selectable = false;
            rect1.selectable = false;
            text.selectable = false;
            text2.selectable = false;
            text3.selectable = false;
            text4.selectable = false;
            text5.selectable = false;
            text6.selectable = false;
            circle.selectable = false; 
            circle1.selectable = false; 

            oImg3.on('mousedown', function(e) {
                viewDetails(jObj[mesh_wired_arr[1]].ap_code,jObj[mesh_wired_arr[1]].name,createId,graph_code,location_id);
            });

        });

    });


}

 


function viewDetails(ap_code, name, createId, graph_code, location_id) {

    $.post("ajax/treeView.php", { ap_code: ap_code, location_id: location_id, graph_code: graph_code },
        function(data, textStatus, jqXHR) {
            //var data = '{ "status": "Online", "upTime": "19 Hours", "apDetails": [{ "type": "5 Ghz - Guest", "Total Devices": "2", "SSID": "freeWIFI", "extraDetails": { "Serial Number": "342342334", "name": "Iphone", "Total f": "f", "SSffgID": "freefgfWIFI" } }, { "type": "2.4 Ghz - Guest", "Total Devices": "5", "SSID": "free", "extraDetails": { "Serial Number": "yy", "name": "Iphone", "Total f": "fy", "SSffgID": "ty" } }, { "type": "2.4 Ghz - Private", "Total Devices": "8", "SSID": "PrivWIFI", "extraDetails": { "Serial Number": "342342334", "name": "Iphone", "Total f": "f", "SSffgID": "freefgfWIFI" } }], "extraDetails": { "Serial Number": "342342334", "Total f": "f", "SSffgID": "freefgfWIFI" } }';
            /*  set(JSON.parse(data)); */
            set(data, name, createId);

            $( "div[id^='NVI_TREE_NODES']" ).show();
            $( "div[id^='NVI_TREE_NODES']" ).css({
                'padding-bottom': '20px',
                'width': '600px',
                'max-width': '100%',
                'margin': 'auto'
            });
            $('#canvasSizer').hide();

        },
        "json"
    );
}

function set(data, name, createId) {

    var nodeDetails = '<h2>' + name + '</h2>';

    var key00, detailsEle00;

    for (key00 in data['nodeDetails']) {

        if (data['nodeDetails'].hasOwnProperty(key00)) {
            nodeDetails = nodeDetails + '<h3>' + data['nodeDetails'][key00] + '</h3>';
        }
    }

    var key0, detailsEle0, tableEle0 = '';

    for (key0 in data['extraDetails']) {

        if (data['extraDetails'].hasOwnProperty(key0)) {
            tableEle0 = tableEle0 + '<tr><td>' + key0 + '</td><td>' + data['extraDetails'][key0] + '</td></tr>';
        }
    }

    detailsEle0 = '<a href="javascript:void(0)" onclick="hide_this(\'nodedetails\',this)" class="collapsed" aria-expanded="false" aria-controls="collapseExample"><i class="icon-plus-sign show" style="font-size: 15px"></i></a><div class="" id="nodedetails" style="margin-top: 10px;display:none;max-width: 500px;margin: auto;"><div class=""><div class="">Node Details</div><div class=""><table class="table table-striped table-bordered">';

    nodeDetails = nodeDetails + detailsEle0 + tableEle0 + '</table></div></div></div>';

    var size = 0,
        key, apDetails = "",
        detailsEle;

    for (key in data['apDetails']) {

        if (data['apDetails'].hasOwnProperty(key)) {

            var size1 = 0,
                key1, pre_text, apDetails1 = "";
            for (key1 in data['apDetails'][key]) {
                if (data['apDetails'][key].hasOwnProperty(key1)) {

                    pre_text = '';

                    if (key1 == 'type') {
                        pre_text = '<h2>' + data['apDetails'][key][key1] + '</h2>';
                    } else if (key1 == 'extraDetails') {

                        var size3 = 0,
                            key3, tab = '';
                        for (key3 in data['apDetails'][key][key1]) {
                            var size2 = 0,
                                key2, tableEle = '';
                            for (key2 in data['apDetails'][key][key1][key3]) {
                                if (data['apDetails'][key][key1][key3].hasOwnProperty(key2)) {

                                    if (key2 != 'name') {
                                        tableEle = tableEle + '<tr><td>' + key2 + '</td><td>' + data['apDetails'][key][key1][key3][key2] + '</td></tr>';
                                    }
                                }
                            }
                            size3++;
                            tab = tab + '<a class="btn btn-default show-btn collapsed" href="javascript:void(0)" onclick="hide_this(\'details00' + size + size3 + '\',this)" aria-expanded="false" aria-controls="collapseExample" > ' + data['apDetails'][key][key1][key3]['name'] + '<i class="icon-angle-right show"><div></div></i></a><div class="tree_div" id="details00' + size + size3 + '" style="display: none;"><div class=""><div class=""><table class="table table-striped table-bordered">' + tableEle + '</table></div></div></div>';

                        }

                    } else {
                        pre_text = '<h3>' + key1 + ': ' + data['apDetails'][key][key1] + '</h3>';

                    }

                    if (data['apDetails'][key]['Total Devices'] == 0) {
                        pre_text = pre_text + '<div style="position: absolute;height: 30px;max-width: 400px;width: 100%"></div>';
                    }

                    apDetails1 = apDetails1 + pre_text;

                }
                size1++;
            }
            detailsEle = '<a class="collapsed" id="dddd' + size + '" href="javascript:void(0)" onclick="hide_this(\'details' + size + '\',this)" aria-expanded="false" aria-controls="collapseExample" ><i class="icon-plus-sign show" style="font-size: 15px"></i></a><div  id="details' + size + '" style="margin-top: 10px;display: none"><div>';
            size++;
            apDetails = apDetails + apDetails1 + detailsEle + tab + '</div></div>';
        }
    }


    $("#" + createId).html(backBtn + nodeDetails + apDetails);

}


function emptyChart(createId, div_cont) {

    $("#" + createId).addClass('tree_graph');
    $("#" + createId).html('<div style="position: static !important; top: 60px;" class="alert alert-danger all_na"><strong>' + div_cont + '</strong></div>');
}

function hide_this(val,this_val) {

    if($(this_val).hasClass( "collapsed" )){
        $(this_val).removeClass('collapsed');
    }
    else{
        $(this_val).addClass('collapsed');
    }

    if ($("#" + val).css('display') == 'none') {
        $("#" + val).show();
    }else{
        $("#" + val).hide();
    }
}

function backDiv() {
    $( "div[id^='NVI_TREE_NODES']" ).hide();
    $('#canvasSizer').show();
}

function resize() {

    var canvasSizer = document.getElementById("canvasSizer");
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
    canvas.setDimensions({ width: width, height: height });
    canvas.setViewportTransform([zoom , 0, 0, zoom , 0, 0]);
    canvas.renderAll();

}

//window.addEventListener('load', resize, false);
/*window.addEventListener('resize', resize, false);*/