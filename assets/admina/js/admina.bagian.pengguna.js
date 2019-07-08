var table = '';
var selectLevelPengguna = '';

$('.li-bagian-pengguna').addClass('active');

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
        	'url'	: baseurl + 'bagian-pengguna/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
                        var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-xs btn-flat" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-xs btn-flat" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                    : i,
                            'nama_level_pengguna'   : response.data[x].nama_level_pengguna,
                            'nama'                  : response.data[x].nama,
                            'keterangan'            : response.data[x].keterangan,
	            			'aksi'                  : button
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
            { 'data' : 'nama_level_pengguna' },
            { 'data' : 'nama' },
            { 'data' : 'keterangan' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 4 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'level-pengguna/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_level_pengguna"]').append('<option value="0">- Pilih Level Pengguna -</option>');
                for(var x in response.data){
                    $('select[name="id_level_pengguna"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama+'</option>');
                }
            } else{
                $('select[name="id_level_pengguna"]').append('<option value="0">- Pilih Level Pengguna -</option>');
            }
        }
    });
    selectLevelPengguna = $('select[name="id_level_pengguna"]').select2();
});

$('button[name="btn_add"]').click(function(){
	csrf();
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="nama"]').val('');
    $('textarea[name="keterangan"]').val('');
    $(selectLevelPengguna).val('0').trigger('change');

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#dataTable').on('click', 'button[name="btn_edit"]', function(){
	csrf();
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'bagian-pengguna/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectLevelPengguna).find('option').each(function(){
                    if ($(this).val() == d.id_level_pengguna) {
                        $(selectLevelPengguna).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="nama"]').val(d.nama);
                $('textarea[name="keterangan"]').val(d.keterangan);

                $('button[name="btn_save"]').attr('id', id);
                $('#formTitle').text('Edit Data');

                csrf();
                $('#table').hide();
                setTimeout(function(){
                    $('#form').fadeIn()
                }, 100);
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

$('#dataTable').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'bagian-pengguna/delete/',
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

$('button[name="btn_cancel"]').click(function(){
	$('#form').hide();
	setTimeout(function(){
		$('#table').fadeIn();
	}, 100);
});

$('button[name="btn_save"]').click(function(){
    var id = $(this).attr('id');
	$(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formData').find('input, textarea').each(function(){
        if($(this).prop('required')){
            if($(this).val() == ''){
                var placeholder = $(this).attr('placeholder');
                $.notify({
                    icon: 'glyphicon glyphicon-info-sign',
                    message: 'Kolom ' + placeholder +' tidak boleh kosong.'
                }, {
                    type: 'warning',
                    delay: 1000,
                    timer: 500,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
                $(this).focus();
                missing = true;
                return false;
            }
        }
    });

    $(this).removeAttr('disabled');
    if(missing){
        return;
    }

    if ($('select[name="id_level_pengguna"]').val() == 0) {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan pilih level pengguna terlebih dahulu.'
        }, {
            type: 'warning',
            delay: 1000,
            timer: 500,
            placement: {
              from: 'top',
              align: 'center'
            }
        });
        $(this).focus();
        return;
    }

    $.ajax({
        type: 'POST',
        url: baseurl + 'bagian-pengguna/save/',
        data: {
        	'id': $(this).attr('id'),
        	'form': $('#formData').serialize(),
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
				csrf();
                table.ajax.reload(null, false);
                $('#form').hide();
				setTimeout(function(){
					$('#table').fadeIn();
				}, 100);
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