var table = '';
var selectBagianSurat = '';
var selectUjungSurat = '';
var varIdBagianSurat = 0;
var userSession = [];

$('.li-nomor-surat').addClass('menu-open');
$('.li-nomor-surat .treeview-menu').css('display', 'block');
$('.li-nomor-sp').addClass('active');

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
                userSession = session;
                $('input[name="display_name"]').val(session.displayName);
                $('input[name="id_pengguna"]').val(session.id);
            }
        }
    });
}

function initComponent()
{
    $('button[name="btn_save"]').attr('id', '0');
    $('input[name="nomor"]').val('-');
    $('input[name="tujuan"]').val('');
    $('input[name="tempat"]').val('');
    $('input[name="tanggal_sppd"]').val('');
    $('input[name="nomor_sppd"]').val('');
    $('input[name="tanggal"]').val('');
    $('textarea[name="keterangan"]').val('');
    $(selectBagianSurat).val('0').trigger('change');
    $(selectUjungSurat).val('0').trigger('change');
    $('button[name="btn_delete_petugas"]').trigger('click');
    $('input[name="nama_petugas[]"]').val('');
    userdata();
}

$(document).ready(function(){
    userdata();
	csrf();
	table = $('#dataTable').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'nomor-sp/datatable/',
            'type'	: 'GET',
            'data'  : function(d){
                d.filter_dari = $('input[name="filter_dari"]').val(),
                d.filter_sampai = $('input[name="filter_sampai"]').val()
            },
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
                        var button = '';
                        if (userSession.id == response.data[x].id_pengguna) {
                            button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-xs btn-flat" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-xs btn-flat" title="Hapus Data"><i class="fa fa-trash"></i></button>';
                        }
                        var file = '';
                        if (response.data[x].file_upload == '' || response.data[x].file_upload == null) {
                            file = '<button id="'+ response.data[x].id +'" name="btn_upload" class="btn btn-primary btn-xs btn-flat" title="Upload File">Upload <i class="fa fa-cloud-upload"></i></button>';
                        } else {
                            file = '<a href="'+ baseurl +'uploads/files/'+ response.data[x].file_upload +'" target="_blank"><i class="fa fa-cloud-download"></i> Download</a> <button id="'+ response.data[x].id +'" name="btn_upload" class="btn btn-primary btn-xs btn-flat" title="Upload Ulang"><i class="fa fa-cloud-upload"></i></button>';
                        }

	            		row.push({
	            			'no'                : i,
                            'tanggal'           : response.data[x].tanggal,
                            'nomor'             : response.data[x].nomor,
                            'tujuan'            : response.data[x].tujuan,
                            'nama_bagian_surat' : response.data[x].nama_bagian_surat,
                            'display_name'      : response.data[x].display_name,
                            'file_upload'       : file,
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
            { 'data' : 'tanggal' },
            { 'data' : 'nomor' },
            { 'data' : 'tujuan' },
            { 'data' : 'nama_bagian_surat' },
            { 'data' : 'display_name' },
            { 'data' : 'file_upload' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 6, 7 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'nomor-sp/select-bagian/',
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

    $('input[name="tanggal"], input[name="tanggal_sppd"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      endDate: new Date()
    });

    $('input[name="filter_dari"], input[name="filter_sampai"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
});

$('button[name="btn_add"]').click(function(){
    varIdBagianSurat = 0;
	csrf();
	initComponent();

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#dataTable').on('click', 'button[name="btn_edit"]', function(){
    csrf();
    initComponent();
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'nomor-sp/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data[0];
                var petugas = [];
                for (let i = 0; i < response.data.length; i++) {
                    petugas.push(response.data[i].nama_petugas);
                }
                console.log(petugas);

                $('button[name="btn_save"]').attr('id', id);
                $('#formTitle').text('Edit Data');

                $('input[name="nomor"]').val(d.nomor);
                $('input[name="tujuan"]').val(d.tujuan);
                $('input[name="tanggal"]').val(d.tanggal);
                $('input[name="tempat"]').val(d.tempat);
                $('input[name="tanggal_sppd"]').val(d.tanggal_sppd);
                $('input[name="nomor_sppd"]').val(d.nomor_sppd);
                $('textarea[name="keterangan"]').val(d.keterangan);
                userdata();

                $(selectUjungSurat).find('option').each(function(){
                    if ($(this).val() == d.id_ujung_surat) {
                        $(selectUjungSurat).val($(this).val()).trigger('change');
                    }
                });

                $(selectBagianSurat).find('option').each(function(){
                    if ($(this).val() == d.id_bagian_surat) {
                        $(selectBagianSurat).val($(this).val()).trigger('change');
                    }
                });

                for (let index = 0; index < petugas.length; index++) {
                    if (index == 0) {
                        $('input[name="nama_petugas[]"]:eq(0)').val(petugas[index]);
                    } else{
                        $('button[name="btn_add_petugas"]').trigger('click');
                        $('input[name="nama_petugas[]"]:eq('+index+')').val(petugas[index]);
                    }
                    
                }

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
        url: baseurl + 'nomor-sp/delete/',
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
    initComponent();
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
        url: baseurl + 'nomor-sp/save/',
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

$('#dataTable').on('click', 'button[name="btn_upload"]', function(){
    var id = $(this).attr('id');
    $('input[name="upload_file"]').attr('id', id);
    $('input[name="upload_file"]').trigger('click');
});

$('input[name="upload_file"]').on('change', function(){
    if ($(this).val() != '') {
        var fd = $(this).prop('files')[0];
        var fu = new FormData();
        fu.append('file', fd);
        fu.append('csrf_token', $('input[id="csrf"]').val());
        fu.append('id', $(this).attr('id'));

        $.ajax({
            type: 'POST',
            url: baseurl + 'nomor-sp/upload/',
            data: fu,
            dataType: 'json',
            contentType: false,
            processData: false,
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

                csrf();
            }
        });
    }
});

$('input[name="filter_dari"], input[name="filter_sampai"]').on('change', function(){
    table.ajax.reload(null, false);
});

$('button[name="btn_reset"]').on('click', function(){
    $('input[name="filter_dari"], input[name="filter_sampai"]').val('');
    table.ajax.reload(null, false);
});

$('select[name="id_bagian_surat"], select[name="id_ujung_surat"], input[name="tanggal"]').on('change', function(){
    var id_bagian_surat = $('select[name="id_bagian_surat"]').val();
    var id_ujung_surat = $('select[name="id_ujung_surat"]').val();
    var tanggal = $('input[name="tanggal"]').val();
    var button_id = $('button[name="btn_save"]').attr('id');
    if (id_bagian_surat != 0 && id_ujung_surat != 0 && tanggal != '') {
        $.ajax({
            type: 'POST',
            url: baseurl + 'nomor-sp/get-nomor/',
            data: {
                'id_bagian_surat': id_bagian_surat,
                'id_ujung_surat': id_ujung_surat,
                'tanggal': tanggal,
                'button_id': button_id,
                'csrf_token': $('input[id="csrf"]').val()
            },
            dataType: 'json',
            success: function(response){
                if(response.result){
                    $('input[name="nomor"]').val(response.nomor);
                }

                csrf();
            }
        });
    }
});

$(document).on('click', 'button[name="btn_add_petugas"]', function(){
    var template = $('template[name="petugas"]').html();
    $('.list-petugas').append(template);
});

$(document).on('click', 'button[name="btn_delete_petugas"]',  function(){
    $(this).closest('.row').remove();
});