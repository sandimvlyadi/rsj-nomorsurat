<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Penomoran Surat | Cetak Laporan</title>
  <?php $this->load->view('script-head'); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <?php $this->load->view('header'); ?>

  <!-- =============================================== -->

  <?php $this->load->view('sidebar'); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Cetak Laporan</h1>
    </section>

    <!-- Main content -->
    <section class="content">

    <div id="form" class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <form id="formData">
                <input id="csrf" type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="" />
                <div class="form-group">
                  <label>Jenis Surat</label>
                  <select name="id_jenis_surat" class="form-control" style="width: 100%;"></select>
                </div>
                <div class="form-group">
                  <label>Tanggal</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="tanggal_dari" type="text" class="form-control" placeholder="Dari" readonly style="background-color: #fff;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="tanggal_sampai" type="text" class="form-control" placeholder="Sampai" readonly style="background-color: #fff;">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="box-footer">
              <div class="row pull-right">
                <div class="col-xs-12">
                  <button id="0" name="btn_print" class="btn btn-xs btn-success btn-flat"><i class="fa fa-print"></i> Cetak</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('footer'); ?>

</div>
<!-- ./wrapper -->

<?php $this->load->view('script-foot'); ?>
<script src="<?php echo base_url('assets/admina/js/admina.cetak.laporan.js'); ?>"></script>
</body>
</html>