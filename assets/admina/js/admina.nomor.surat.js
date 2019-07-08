var table = '';
var selectJenisSurat = '';
var selectBagianSurat = '';
var selectUjungSurat = '';
var varIdBagianSurat = 0;

$('.li-nomor-surat').addClass('active');

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

function userdata()
{
    $.ajax({
        type: 'GET',
        url: baseurl + 'csrf/userdata/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var session = response.userdata.session;
                $('input[name="display_name"]').val(session.displayName);
                $('input[name="id_pengguna"]').val(session.id);
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
        	'url'	: baseurl + 'nomor-surat/datatable/',
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
                            'nama_bagian_surat' : response.data[x].nama_bagian_surat,
                            'nomor'             : response.data[x].nomor,
                            'tujuan'            : response.data[x].tujuan,
                            'perihal'           : response.data[x].perihal,
                            'tanggal'           : response.data[x].tanggal,
                            'display_name'      : response.data[x].display_name,
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
            { 'data' : 'nama_bagian_surat' },
            { 'data' : 'nomor' },
            { 'data' : 'tujuan' },
            { 'data' : 'perihal' },
            { 'data' : 'tanggal' },
            { 'data' : 'display_name' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 6, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 8 ]
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

    $.ajax({
        type: 'GET',
        url: baseurl + 'bagian-surat/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_bagian_surat"]').append('<option value="0">- Pilih Bagian Surat -</option>');
                for(var x in response.data){
                    $('select[name="id_bagian_surat"]').append('<option value="'+ response.data[x].id +'">'+ response.data[x].kode + ' - ' + response.data[x].nama +'</option>');
                }
            } else{
                $('select[name="id_bagian_surat"]').append('<option value="0">- Pilih Bagian Surat -</option>');
            }
        }
    });
    selectBagianSurat = $('select[name="id_bagian_surat"]').select2();

    $.ajax({
        type: 'GET',
        url: baseurl + 'ujung-surat/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_ujung_surat"]').append('<option value="0">- Pilih Ujung Surat -</option>');
                for(var x in response.data){
                    $('select[name="id_ujung_surat"]').append('<option value="'+ response.data[x].id +'">'+ response.data[x].nama +'</option>');
                }
            } else{
                $('select[name="id_ujung_surat"]').append('<option value="0">- Pilih Ujung Surat -</option>');
            }
        }
    });
    selectUjungSurat = $('select[name="id_ujung_surat"]').select2();

    $('input[name="tanggal"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });

    userdata();
});

$('button[name="btn_add"]').click(function(){
    varIdBagianSurat = 0;
	csrf();
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="nomor"]').val('');
    $('input[name="tujuan"]').val('');
    $('input[name="perihal"]').val('');
    $('input[name="tanggal"]').val('');
    $(selectJenisSurat).val('0').trigger('change');
    $(selectBagianSurat).val('0').trigger('change');
    $(selectUjungSurat).val('0').trigger('change');
    userdata();

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
        url: baseurl + 'nomor-surat/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                varIdBagianSurat = d.id_bagian_surat;
                $('input[name="nomor"]').val(d.nomor);
                $('input[name="tujuan"]').val(d.tujuan);
                $('input[name="perihal"]').val(d.perihal);
                $('input[name="tanggal"]').val(d.tanggal);
                userdata();

                $(selectUjungSurat).find('option').each(function(){
                    if ($(this).val() == d.id_ujung_surat) {
                        $(selectUjungSurat).val($(this).val()).trigger('change');
                    }
                });

                $(selectJenisSurat).find('option').each(function(){
                    if ($(this).val() == d.id_jenis_surat) {
                        $(selectJenisSurat).val($(this).val()).trigger('change');
                    }
                });

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
        url: baseurl + 'nomor-surat/delete/',
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

    if ($('select[name="id_bagian_surat"]').val() == 0) {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan pilih bagian surat terlebih dahulu.'
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

    if ($('select[name="id_ujung_surat"]').val() == 0) {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan pilih ujung surat terlebih dahulu.'
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
        url: baseurl + 'nomor-surat/save/',
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

function selectBagianSuratByIdJenisSurat(id)
{
    $('select[name="id_bagian_surat"] option').remove();
    $.ajax({
        type: 'GET',
        url: baseurl + 'bagian-surat/select-by-id-jenis-surat/'+id+'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_bagian_surat"]').append('<option value="0">- Pilih Bagian Surat -</option>');
                for(var x in response.data){
                    $('select[name="id_bagian_surat"]').append('<option value="'+ response.data[x].id +'">'+ response.data[x].kode + ' - ' + response.data[x].nama +'</option>');
                }

                $(selectBagianSurat).find('option').each(function(){
                    if ($(this).val() == varIdBagianSurat) {
                        $(selectBagianSurat).val($(this).val()).trigger('change');
                    }
                });
            } else{
                $('select[name="id_bagian_surat"]').append('<option value="0">- Pilih Bagian Surat -</option>');
            }
        }
    });
}

$('#formData').on('change', 'select[name="id_jenis_surat"], select[name="id_bagian_surat"], input[name="tanggal"], select[name="id_ujung_surat"]', function(){
    var name = $(this).attr('name');
    if (name == 'id_jenis_surat') {
        var id = $(this).val();
        selectBagianSuratByIdJenisSurat(id);
    }

    var idJenisSurat = $('select[name="id_jenis_surat"]').val();
    var idBagianSurat = $('select[name="id_bagian_surat"]').val();
    var tanggal = $('input[name="tanggal"]').val();
    var ujung = $('select[name="id_ujung_surat"] option:selected').text();
    var idUjung = $('select[name="id_ujung_surat"] option:selected').val();
    if (idJenisSurat != 0 && idBagianSurat != 0 && tanggal != '') {
        $.ajax({
            type: 'POST',
            url: baseurl + 'nomor-surat/generate/',
            data: {
                'id': $(this).attr('id'),
                'id_jenis_surat': idJenisSurat,
                'id_bagian_surat': idBagianSurat,
                'tanggal': tanggal,
                'csrf_token': $('input[id="csrf"]').val()
            },
            dataType: 'json',
            success: function(response){
                if(response.result){
                    var nomor = response.nomor;
                    if (idUjung != 0) {
                        nomor += ujung;
                    }
                    $('input[name="nomor"]').val(nomor);
                    csrf();
                }
            }
        });
    }
});