<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script>
    	$(document).ready(function() {
			$.extend( $.fn.dataTable.defaults, {
          "ordering":true,
		  "dom": '<"wrapper"flt<"data-table-bottom"<"data-table-controls"><"data-table-bottom-right"ip>>>',
           columnDefs: [{
            orderable: false,
			searchable: false,
            targets: "no-sort"
          }],
		  order: [[1, 'asc']],
		  language: {
				search: "_INPUT_",
				searchPlaceholder: "Search",
				lengthMenu: "Per Page _MENU_ "
		 },
          "drawCallback": function() {
			var tb_id = this.attr('id');
			var wrapper = $('#'+tb_id+'_wrapper');
			var delete_a = $('#'+tb_id).data('delete');
			var create_a = $('#'+tb_id).data('create');
			txt = '';
			if(delete_a == true){
				txt += '<form method="post" name="'+tb_id+'_delete_selected_form" ><input class="dl-val" type="hidden" name="'+tb_id+'_delete_raws"><button id="'+tb_id+'_delete_btn" type="submit" title="Delete Selected Raws" class="delete" disabled><i class="icon-trash show"></i></button></form>';
			}
			if(create_a != undefined){
				txt += '<a href="'+create_a+'" class="btn btn-primary"><i class="icon-pencil show"></i> Create New</a>';
			}
			wrapper.find('.data-table-controls').html(txt);
            if(delete_a == true){
            $('button.delete').tooltip();
            $('#'+tb_id+'_wrapper').on('click', 'input.delete-all',function(){
                wrapper.find('input.delete').prop('checked', this.checked);
                if ($(this).prop("checked") == true) {
                $("#"+tb_id+"_delete_btn").attr("disabled", false);
                } else {
                $("#"+tb_id+"_delete_btn").attr("disabled", true);
                }
            });

            $('#'+tb_id+'_wrapper').on('click', 'input.delete',function(){
                var all_checked = true;
                var a_check = false;
                wrapper.find('input.delete').each(function (index, element) {
                    if ($(this).prop("checked") != true) {
                        all_checked = false;
                    }else{
                        a_check = true;
                    }
                });

                if(all_checked){
                    wrapper.find('input.delete-all').prop('checked', true);
                }else{
                    wrapper.find('input.delete-all').prop('checked', false);
                }

                if(a_check){
                    $("#"+tb_id+"_delete_btn").attr("disabled", false);
                }else{
                    $("#"+tb_id+"_delete_btn").attr("disabled", true);
                }
              });

              $("#"+tb_id+"_delete_btn").easyconfirm({
                locale: {
                  title: 'Delete Raws',
                  text: 'Are you sure you want to delete these selected raws?  ',
                  button: ['Cancel', ' Confirm'],
                  closeText: 'close'
                }
              });
              $("#"+tb_id+"_delete_btn").click(function(e) {
                var arr = [];
                wrapper.find('input.delete:checked').each(function (index, element) {
                    arr.push($(this).val());
                });
                
                $('input[name="'+tb_id+'_delete_raws"]').val(arr);
              });
            }
            try {
	            $("#"+tb_id+" th").each(function(){
	                if ($(this).hasClass('sorting') || $(this).hasClass('sorting_desc') || $(this).hasClass('sorting_asc')) {
	                    $(this).attr('title','Click to sort');
	                    $(this).tooltip();
	                }
	            });
            } catch (error) {
	
            }

          }
        });

		
        $('.data-table').DataTable();
      });
  </script>