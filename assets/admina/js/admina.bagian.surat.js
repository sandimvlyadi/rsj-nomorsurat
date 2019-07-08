var table = '';
var selectJenisSurat = '';

$('.li-bagian-surat').addClass('active');

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
        	'url'	: baseurl + 'bagian-surat/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
                        var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-xs btn-flat" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-xs btn-flat" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_jenis_surat'  : response.data[x].nama_jenis_surat,
                            'kode'              : response.data[x].kode,
                            'nama'              : response.data[x].nama,
                            'keterangan'        : response.data[x].keterangan,
	            			'aksi'              : button
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
            { 'data' : 'nama_jenis_surat' },
            { 'data' : 'kode' },
            { 'data' : 'nama' },
            { 'data' : 'keterangan' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 5 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'jenis-surat/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_jenis_surat"]').append('<option value="0">- Pilih Jenis Surat -</option>');
                for(var x in response.data){
                    $('select[name="id_jenis_surat"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama+'</option>');
                }
            } else{
                $('select[name="id_jenis_surat"]').append('<option value="0">- Pilih Jenis Surat -</option>');
            }
        }
    });
    selectJenisSurat = $('select[name="id_jenis_surat"]').select2();
});

$('button[name="btn_add"]').click(function(){
	csrf();
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="kode"]').val('');
    $('input[name="nama"]').val('');
    $('textarea[name="keterangan"]').val('');
    $(selectJenisSurat).val('0').trigger('change');

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
        url: baseurl + 'bagian-surat/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectJenisSurat).find('option').each(function(){
                    if ($(this).val() == d.id_jenis_surat) {
                        $(selectJenisSurat).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="kode"]').val(d.kode);
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
        url: baseurl + 'bagian-surat/delete/',
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

    if ($('select[name="id_jenis_surat"]').val() == 0) {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan pilih jenis surat terlebih dahulu.'
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
        url: baseurl + 'bagian-surat/save/',
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
