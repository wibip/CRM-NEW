var edit_macs = [];

var data;
var data2;

function enableValidator(status){
    try{
        let bv = $('#location_form').data('bootstrapValidator');
        bv.enableFieldValidators('service-area-name', status);
    }catch(e){}
}
function revalidate() {
    try{
        $('#location_form').bootstrapValidator('revalidateField', 'service-area-name');
    }catch (e) {

    }
}

function businessVertChanged(show) {
    // var result = e;
    //alert(show);
    checkUncheckAll(show)
    let bv = $('#location_form').data('bootstrapValidator');

    if ($('#multi_area').is(":checked")) {

        bv.addField('service-area-name', {
            validators: {
                callback: {
                    message: 'This is a required field',
                    callback: function (value, validator, $field) {
                        // if (!$('#multi_area').is(":checked")) {
                        //     return true;
                        // }
                        var rowCount = $('#existing-area-body tr').length;
                        if(rowCount>0){
                            //console.log(rowCount);
                            return true;
                        }
                        var apCount = $('#aps_of_area option').length;
                        if(apCount==0){
                            //console.log(rowCount,apCount);
                            return true;
                        }
                        //console.log(rowCount,apCount);
                        return false;
                    }
                }
            }
        });

        let gateway = $('#gateway_type').val();
        //if (gateway != 'AC') {
            $('#service_areas').show();
            enableValidator( true);
            loadAps();
        // }else{
        //     enableValidator( false);
        // }

    } else {
        //$('#network_type option[value="GUEST"]').text('Guest');
        //$('#num-of-areas').hide();
        enableValidator( false);
        $('#service_areas').hide();
    }
    //$('#network_type').multiSelect('refresh');
}



$(function() {
    $('#zone').on('change', function() {
        loadAps();
    });
    $('#aps_of_area').multiSelect();
});

if (edit_account.toString() == '1') {
    $(window).load(function() {
        businessVertChanged();
        //loadAps();
    });
}

function changevtName(val, vt_select, no_mdu) {
    var vertical = $('#business_type').val();
    $('#network_type  option[value="VT"]').remove();
    $('#vTenant_div').hide();
    if (no_mdu == 'Yes' && vertical == 'MDU') {
        vertical = 'VTenant';
    }
    if (vertical == 'MDU') {
        $('#vt_guest_def_id  option[name="vtenant_pro_name"]').html('Select MDU Profile');
        $('.vt_name_new').html('MDU');
        $('#network_type  option[name="network_vtenant_name"]').html('MDU');
        $("#network_type").append('<option ' + vt_select + ' value="VT">MDU</option>');
        if (vt_select == 'Selected') {
            $('#vTenant_div').show();
        }
        if (val == 1) {
            $('#network_type').multiSelect('refresh');
        }
    } else {
        $('#vt_guest_def_id  option[name="vtenant_pro_name"]').html('Select vTenant Profile');
        $('.vt_name_new').html('VTenant');
        $('#network_type  option[name="network_vtenant_name"]').html('VTenant');
        if (vertical == 'VTenant') {
            if (vt_select == 'Selected') {
                $('#vTenant_div').show();
            }
            $("#network_type").append('<option ' + vt_select + ' value="VT">VTenant</option>');
        } else {
            $('#vTenant_div').hide();
        }

        if (val == 1) {
            $('#network_type').multiSelect('refresh');
        }

    }

}

function changeadminType(val, vt_select) {
    var admintype = $('#parent_package1').val();
    $('#network_type  option[value="VT"]').remove();
    $('#vt_guest_def').hide();
    $('#pg_prof').hide();
    if (admintype == 'MDU') {
        $('#network_type  option[name="network_vtenant_name"]').html('MDU');
        $("#network_type").append('<option ' + vt_select + ' value="VT">MDU</option>');
        if (vt_select == 'Selected') {
            $('#vt_guest_def').show();
            $('#pg_prof').show();
        }
        if (val == 1) {
            $('#network_type').multiSelect('refresh');
        }
    } else {
        $('#network_type  option[name="network_vtenant_name"]').html('vTenant');
        if (admintype == 'ATT_MVNO_ADMIN') {
            if (vt_select == 'Selected') {
                $('#vt_guest_def').show();
                $('#pg_prof').show();
            }
            $("#network_type").append('<option ' + vt_select + ' value="VT">vTenant</option>');
        } else {
            $('#vt_guest_def').hide();
            $('#pg_prof').hide();
        }

        if (val == 1) {
            $('#network_type').multiSelect('refresh');
        }

    }

}


function loadAps() {
    cancel_edit();
    if (!$('#multi_area').is(":checked"))
        return true;


    $('#loading_div').addClass('loading2');
    //clear existing data
    $('#service-area-name').val('');
    $('#aps_of_area').find('option').remove();
    refreshAPsAreaMultiSelect();
    $('#submit-apg').html('Save');
    $('#submit-apg').removeData('edit');
    $('#existing-area-body').find('tr').remove();


    data = $("#zone").val();
    data2 = $("#conroller").val();

    if (data.length == 0 || data2.length == 0) {
        $('#loading_div').removeClass('loading2');
        return;
    }
    $('#existing-area-body').html('<img src="img/loading_ajax.gif">');
    var formData = { action: 'get', zone_id: data, controller: data2 };
    //console.log(formData);
    $.ajax({
        url: "ajax/getZoneAPs.php",
        type: "POST",
        data: formData,
        success: function(data) {
            var json = JSON.parse(data);
            macs = json['data'];
            exist_count = json['count'];
            mac_names = json['mac_names'];

            //$('#service-i .select').empty();
            //console.log(macs);
            $('#existing-area-body').html('');
            showExistingGroups(macs);
            $('#loading_div').removeClass('loading2');
            revalidate();
            //$("#number_of_area").prop("disabled",false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#existing-area-body').html('');
            $('#ap_id').empty();
            $('#ap_id').append('error');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            $('#loading_div').removeClass('loading2');
        }
    });

}

function aClick(id) {

    var id_srt = id + "";

    if ($('#' + id_srt).hasClass("disabled")) {
        //alert('twice');
        return false;
    }
    $('#' + id_srt).html('<img src="img/loading_ajax.gif">');
    $('#' + id_srt).addClass('disabled');

    //$( "#mydiv" ).hasClass( "quux" )
    var id_data = id_srt.split('-');
    $('#ap_assignment_warn').removeClass('save' + id_data[1]);
    if ($('#' + id_srt).data('edit')) {
        updateAPGroup(id_data[1]);
    } else {
        submitAPGroup(id_data[1]);
    }
}

function clickSaveArea() {
    if ($('#submit-apg').hasClass("disabled")) {
        //alert('twice');
        return false;
    }
    $('#submit-apg').html('<img src="img/loading_ajax.gif">');
    $('#submit-apg').addClass('disabled');

    //$( "#mydiv" ).hasClass( "quux" )
    //var id_data = id_srt.split('-');
    $('#ap_assignment_warn').removeClass('save');
    if ($('#submit-apg').data('edit')) {
        updateAPGroup();
    } else {
        submitAPGroup();
    }
}

function updateAPGroup() {
    var name = $('#service-area-name').val();
    var macs = $('#aps_of_area').val() || [];


    var uuid = $('#service-area-name').data('uuid');
    if (!name || macs.length === 0) {
        //alert("Name or APs are empty");
        $('#ap_id').empty();
        $('#ap_id').append('Name or APs are empty');
        $('#servicearr-check-div').show();
        $('#sess-front-div').show();
        $('#submit-apg').removeClass('disabled');
        $('#submit-apg').html('Update');
        return false;
    }
    //console.log(uuid);
    $('#ap_id').empty();
    var formData = {
        action: 'update',
        UUID: uuid,
        zone_id: data,
        //dis:"<?php echo $user_distributor; ?>",
        controller: data2,
        name: name,
        macs: macs
    };
    $.ajax({
        url: "ajax/createAPGroup.php",
        type: "POST",
        data: formData,
        success: function(data) {
            var res = JSON.parse(data);

            if (res.status == 'false') {
                //alert("Ap Group Update is failed ");
                /*$('#ap_id_3').html("Ap Group Update is failed");
                $('#apg_msg_2').show();*/
                showErrorAlert("Service Area Update is failed");
                $('#submit-apg').removeClass('disabled');
                $('#submit-apg').html('Update');
                $('#ap_assignment_warn').removeClass('save');
                return false;
            } else {
                //alert("Ap Group Update is successful");
                /*$('#ap_id_2').html("Ap Group Update is successful");
                $('#apg_msg').show();*/
                showSuccessAlert("Service Area Update is successful");

                /*macs.forEach(myFunction);
                function myFunction(item) {
                    $("#aps_of_area option[value='"+item+"']").remove();
                }*/
                $('#ap_assignment_warn').removeClass('save');

                var rt = $("#existing-area-body td[data-uuid='" + uuid + "']").closest("tr");
                //rt.find("td:eq(1)").text(macs.join("<br>"));
                rt.find("td:eq(1)").replaceWith(macListTd(macs));
                edit_macs = [];
                cancel_edit();

            }
            makeTooltip();
            revalidate();
            return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#ap_id').empty();
            //alert("Network Error");
            $('#ap_id').append('Network Error');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            $('#submit-apg').removeClass('disabled');
            $('#submit-apg').html('Update Assignment');
            return false;
        }
    });


}

function submitAPGroup() {
    var name = $('#service-area-name').val();
    var macs = $('#aps_of_area').val() || [];
    //var macs_clear = [];

    if (!name || macs.length === 0) {
        //alert("Name or APs are empty");
        $('#ap_id').empty();
        $('#ap_id').append('Name or APs are empty');
        $('#servicearr-check-div').show();
        $('#sess-front-div').show();
        $('#submit-apg').removeClass('disabled');
        $('#submit-apg').html('Save');
        return false;
    }

    // macs.forEach(myFunction);
    // function myFunction(item, index) {
    //     macs_clear.push(item.split('-')[0]);
    // }

    var formData = {
        zone_id: data,
        //dis:"<?php echo $user_distributor; ?>",
        controller: data2,
        name: name,
        macs: macs
    };
    $.ajax({
        url: "ajax/createAPGroup.php",
        type: "POST",
        data: formData,
        success: function(data) {
            var res = JSON.parse(data);
            if (res.status == 'false') {
                //alert("Ap Group Creation failed ");
                /*$('#ap_id_3').html("Ap Group Creation is failed");
                $('#apg_msg_2').show();*/
                showErrorAlert("Service Area Creation is failed");
                $('#submit-apg').removeClass('disabled');
                $('#submit-apg').html('Save');
                $('#ap_assignment_warn').removeClass('save');
                return false;
            }
            if (res.status == 'duplicate') {
                //alert("Ap Group Creation failed ");
                $('#ap_id').empty();
                $('#ap_id').append("<div>Service Area Already Exists</div>");
                $('#servicearr-check-div').show();
                $('#sess-front-div').show();
                $('#submit-apg').removeClass('disabled');
                $('#submit-apg').html('Save');
                $('#ap_assignment_warn').removeClass('save');
                return false;
            }

            macs.forEach(myFunction);

            function myFunction(item, index) {
                //macs_selected.push(item.split('-')[0]);
                $("#aps_of_area option[value='" + item + "']").remove();

            }

            //console.log(macs);
            $("#aps_of_area").multiSelect('refresh');
            $('#existing-area-tbl > tbody:last-child').append(apgTblRow(res.uuid, name, macs)); //('<tr><td data-uuid="'+res.uuid+'">'+name+'</td>'+macListTd(macs)+'<td><a href="#existing_service_area" class="btn btn-default" onclick="editAPGroup(this);">Edit</a><a class="btn btn-default" onclick="area_remove(this);">Delete</a></td></tr></tr>');
            //$('#ap_id_2').html("Ap Group Creation is successful");
            //$('#apg_msg').show();
            //$('#sess-front-div').show();
            showSuccessAlert("Service Area Creation is successful");

            $('#submit-apg').html('Save');
            $('#submit-apg').removeClass('disabled');
            $('#service-area-name').val("");
            makeTooltip();
            revalidate();
            return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //alert("Network Error");
            $('#ap_id').empty();
            $('#ap_id').append('Network Error');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            $('#submit-apg').removeClass('disabled');
            $('#submit-apg').html('Assign APs');
            return false;
        }
    });

}

function copyToClipboard(txt) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(txt).select();
    document.execCommand("copy");
    $temp.remove();
}

function macListTd(list) {
    var copy = "<i class=\"icon-copy show red-url highlight\" onclick=\"copyToClipboard('" + list.join(',') + "')\" ></i>";
    return '<td data-mac-list="' + list.join(",") + '"><a class="btn btn-default apg-tooltip" title="' + list.join("<br>") + '">View</a>' + copy + '</td>';
}

function apgTblRow(uuid, name, macs) {
    return '<tr>' +
        '<td data-uuid="' + uuid + '">' + name + '</td>' +
        macListTd(macs) +
        '<td><a href="#existing_service_area" class="btn btn-default" onclick="editAPGroup(this);">Edit</a></td><td><a class="btn btn-default" onclick="area_remove(this);">Delete</a></td></tr>'
}

function showExistingGroups(macs) { //existing

    var rowCount = 0;
    jQuery.each(macs, function(i, val) {

        if (i != 'default' && i != 'all') {
            rowCount++;
            $('#existing-area-tbl > tbody:last-child').append(apgTblRow(val['id'], i, val['macs']));
            /*('<tr>' +
                '<td data-uuid="'+val['id']+'">'+i+'</td>' +
                macListTd(val['macs']) +
                '<td><a href="#existing_service_area" class="btn btn-default" onclick="editAPGroup(this);">Edit</a><a class="btn btn-default" onclick="area_remove(this);">Delete</a></td></tr>');*/

        } else if (i == 'default') {
            val['macs'].forEach(function(item, index) {
                $("#aps_of_area").append(newAPMAC(item, item, null, null)); //('<option value="'+item+'">'+item+'</option>');
                //macs_selected.push(item);
            });
            refreshAPsAreaMultiSelect();
        }
    });
    $('#number_of_area option:eq(' + exist_count + ')').prop('selected', true);
    makeTooltip();
    //areaCountSelector();
}

function refreshAPsAreaMultiSelect() {
    $('#aps_of_area').multiSelect('refresh');
    $('[data-toggle="tooltip"]').tooltip();
}

function makeTooltip() {
    $('.apg-tooltip').tooltipster({
        theme: 'tooltipster-shadow',
        animation: 'grow',
        onlyOne: true,
        trigger: 'click',
        contentAsHTML: true
    });
}

function area_remove(el) {

    if ($(el).hasClass("disabled")) {
        //alert('twice');
        return false;
    }
    $(el).html('<img src="img/loading_ajax.gif">');
    $(el).addClass('disabled');

    var currentRow = $(el).closest("tr");

    //var name=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    var uuid = currentRow.find("td:eq(0)").data('uuid'); // get current row 1st TD value
    var macs = currentRow.find("td:eq(1)").data('mac-list').split(','); // get current row 2nd TD

    //var uuid = $(el).data('uuid');
    //alert(uuid);
    //var area_number = $(el).attr('id').split('-')[2];

    // var aps = [];
    // $('#aps_of_area-' + area_number +' option:selected').each(function () {
    //     aps.push(this.value);
    // });

    var formData = {
        action: 'remove',
        group_uuid: uuid,
        //dis: "<?php echo $user_distributor; ?>",
        macs: macs,
        zone_id: data,
        controller: data2
    };
    //console.log(formData);
    $.ajax({
        url: "ajax/getZoneAPs.php",
        type: "POST",
        data: formData,
        success: function(data) {
            var res = JSON.parse(data);
            if (res.status == 'success') {
                //exist_count--;
                macs.forEach(function(value, index) {
                    //console.log($(select_elm).attr('id'));

                    $('#aps_of_area').append(newAPMAC(value, value, null, null));

                });

                refreshAPsAreaMultiSelect();
                $(currentRow).fadeOut(1000, function() {
                    currentRow.remove();
                    revalidate();
                });

            } else {
                /*$('#ap_id').empty();
                $('#ap_id').append('Service Area removing failed');
                $('#servicearr-check-div').show();
                $('#sess-front-div').show();*/
                showErrorAlert('Service Area removing failed');
                //alert('AP Group removing failed');
                $(el).removeClass('disabled');
                $(el).html('Delete');
            }
            revalidate();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //alert("Network Error");
            $('#ap_id').empty();
            $('#ap_id').append('Network Error');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            $(el).removeClass('disabled');
            return false;
        }
    });
}

function editAPGroup(element) {
    //cancel_edit();

    if ($('#submit-apg').data('edit')) {
        $('#ap_id').empty();
        $('#ap_id').append('<div>Please Save the changes or cancel</div>');
        $('#servicearr-check-div').show();
        $('#sess-front-div').show();
        return;
    }

    var currentRow = $(element).closest("tr");

    var name = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    var uuid = currentRow.find("td:eq(0)").data('uuid'); // get current row 1st TD value
    var macs = currentRow.find("td:eq(1)").data('mac-list').split(','); // get current row 2nd TD

    //var col3=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
    //var data=col1+"\n"+col2+"\n"+col3;
    $('#service-area-name').val(name);
    $('#service-area-name').prop("disabled", true);
    macs.forEach(myFunction);

    function myFunction(item) {
        if (item.length < 1) { return; }
        $("#aps_of_area").append(newAPMAC(item, item, false, true))
    }

    refreshAPsAreaMultiSelect();
    $('#service-area-name').data('uuid', uuid);
    $('#submit-apg').data('edit', 'edit');
    $('#submit-apg').html('Update');
    $('#cancel-apg-update').show();
    edit_macs = macs;
}

function newAPMAC(arg1,arg2,arg3,arg4) {
    //console.log('newAPMAC');
    let opt =  new Option(arg1, arg2, arg3, arg4);
    opt.setAttribute("data-toggle", "tooltip");
    opt.setAttribute("title", mac_names[arg1]);
    return opt;
}

function cancel_edit() {
    //alert(edit_macs);
    edit_macs.forEach(myFunction2);

    function myFunction2(item) {
        //if(item.length<1){return;}
        //alert(item);
        //$("#aps_of_area").append(new Option(item, item,false,true))
        $("#aps_of_area option[value='" + item + "']").remove();
    }

    $('#service-area-name').val('');
    $('#service-area-name').prop("disabled", false);
    $('#service-area-name').removeData('uuid');
    $('#submit-apg').removeData('edit');
    $('#submit-apg').html('Save');
    $('#cancel-apg-update').hide();
    $('#aps_of_area').children("option:selected").remove();
    $('#submit-apg').removeClass('disabled');
    refreshAPsAreaMultiSelect();

}

function showSuccessAlert(msg) {
    $('#ap_id_2').html(msg);
    $("#apg_msg").fadeTo(2000, 500).slideUp(500, function() {
        $("#apg_msg").slideUp(500);
    });
}

function showErrorAlert(msg) {
    $('#ap_id_3').html(msg);
    $("#apg_msg_2").fadeTo(2000, 500).slideUp(500, function() {
        $("#apg_msg_2").slideUp(500);
    });
}

function checkUncheckAll(status) {
    $(".multi_area_option").map(function() {
        //this.prop;
        $(this).prop("checked", status);
    })
}