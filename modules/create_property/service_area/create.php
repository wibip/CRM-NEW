<div id="service_areas" style="display: none;">
    <div class="hideMe" id="apg_msg" style="display: none;"><div class="alert-manual alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong id="ap_id_2"></strong></div></div>
    <div class="hideMe" id="apg_msg_2" style="display: none;"><div class="alert-manual alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong id="ap_id_3"></strong></div></div>
    <div id="service-x">
        <div class="control-group">
            <label class="control-label new_service" for="service-area-x" id="label">Create Service Area</label>
            <div class="controls col-lg-5 form-group">
                <input type="text" class="span4 form-control" id="service-area-name" name="service-area-name">
                <button style="display: none;" class="btn btn-danger" data-uuid="" id="cancel-apg-update" type="button" onclick="cancel_edit(this);">⤫</button>
            </div>
            <!-- /controls -->
        </div>
        <!-- /control-group -->
        <div class="control-group">
            <div class="controls col-lg-5 form-group">
                <select class="form-control span4 select" id="aps_of_area" multiple="multiple" >

                </select>
            </div>
            <!-- /controls -->
        </div>
        <!-- /control-group --><!-- /control-group -->
        <div class="control-group">
            <div class="controls col-lg-5 form-group">
                <button type="button" id="submit-apg" class="btn btn-primary" onclick="clickSaveArea();">Save</button>
            </div>
            <!-- /controls -->
        </div>
        <!-- /control-group -->
    </div>
    <div class="widget widget-table action-table" style="display: inline-block;width: 68%;">
        <button type="button" id="refresh-apg" class="btn btn-primary" onclick="loadAps();" style="margin-bottom: 2px;">Refresh</button>
        <div class="widget-content ">
            
            <div style="overflow-x:auto;">
                <table class="table table-striped table-bordered " id="existing-area-tbl">
                    <thead>
                    <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Service Area</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">APs</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="existing-area-body">
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>