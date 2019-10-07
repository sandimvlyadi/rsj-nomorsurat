var selectJenisSurat = '';

$('.li-cetak-laporan').addClass('active');

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
    $.ajax({
        type: 'GET',
        url: baseurl + 'jenis-surat/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_jenis_surat"]').append('<option value="0">- Pilih Jenis Surat -</option>');
                for(var x in response.data){
                    $('select[name="id_jenis_surat"]').append('<option value="'+ response.data[x].id +'">'+ response.data[x].nama +'</option>');
                }
            } else{
                $('select[name="id_jenis_surat"]').append('<option value="0">- Pilih Jenis Surat -</option>');
            }
        }
    });
    selectJenisSurat = $('select[name="id_jenis_surat"]').select2();

    $('input[name="tanggal_dari"], input[name="tanggal_sampai"]').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
});

$('button[name="btn_print"]').on('click', function(){
    csrf();
    var id_jenis_surat = $('select[name="id_jenis_surat"]').val();
    var tanggal_dari = $('input[name="tanggal_dari"]').val();
    var tanggal_sampai = $('input[name="tanggal_sampai"]').val();

    if (id_jenis_surat == 0) {
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
        $('select[name="id_jenis_surat"]').focus();
        return;
    }

    if (tanggal_dari == '') {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan tentukan rentang tanggal terlebih dahulu.'
        }, {
            type: 'warning',
            delay: 1000,
            timer: 500,
            placement: {
              from: 'top',
              align: 'center'
            }
        });
        $('input[name="tanggal_dari"]').focus();
        return;
    }

    if (tanggal_sampai == '') {
        $.notify({
            icon: 'glyphicon glyphicon-info-sign',
            message: 'Silakan tentukan rentang tanggal terlebih dahulu.'
        }, {
            type: 'warning',
            delay: 1000,
            timer: 500,
            placement: {
              from: 'top',
              align: 'center'
            }
        });
        $('input[name="tanggal_sampai"]').focus();
        return;
    }

    $(this).attr('disabled', 'disabled');
    $.ajax({
        type: 'POST',
        url: baseurl + 'cetak-laporan/cetak/',
        data: {
            'id_jenis_surat': id_jenis_surat,
            'tanggal_dari': tanggal_dari,
            'tanggal_sampai': tanggal_sampai,
			'csrf_token': $('input[id="csrf"]').val()
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	window.open(response.target, '_blank');
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

    $(this).removeAttr('disabled');
});