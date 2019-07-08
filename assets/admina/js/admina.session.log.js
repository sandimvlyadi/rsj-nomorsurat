var table = '';

$('.li-master').addClass('menu-open');
$('.li-master .treeview-menu').css('display', 'block');
$('.li-session-log').addClass('active');

function csrf()
{
	$.ajax({
        type: 'GET',
        url: baseurl + 'csrf/get/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var csrf = response.csrf;
				$('input[name="'+ csrf.name +'"]').val(csrf.hash);
            }
        }
    });
}

$(document).ready(function(){
	csrf();
	table = $('#dataTable').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'session-log/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
                        var button = '<button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-xs btn-flat" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'            : i,
                            'display_name'  : response.data[x].display_name,
                            'token'         : response.data[x].token,
	            			'aksi'	        : button
	            		});
	            		i = i + 1;
	            	}

	            	response.data = row;
            		return row;
            	} else{
            		response.draw = 0;
            		return [];
            	}
            }
        },

        'columns' : [
        	{ 'data' : 'no' },
            { 'data' : 'display_name' },
            { 'data' : 'token' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 3 ]
    		}
  		]
	});
});

$('#dataTable').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'session-log/delete/',
        data: {
        	'id': id,
			'csrf_token': $('input[id="csrf"]').val()
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	$.notify({
                    icon: "glyphicon glyphicon-ok",
                    message: response.msg
                }, {
                    type: 'success',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
                table.ajax.reload(null, false);
				csrf();
            } else{
                $.notify({
                    icon: "glyphicon glyphicon-info-sign",
                    message: response.msg
                }, {
                    type: 'danger',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
            }
        }
    });
});