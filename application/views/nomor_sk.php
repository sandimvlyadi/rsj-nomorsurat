<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Penomoran Surat | Nomor Surat Keputusan</title>
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
      <h1>Nomor Surat Keputusan</h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div id="table" class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-3">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="filter_dari" type="text" class="form-control pull-right" placeholder="Dari" readonly style="background-color: #fff;">
                    </div>
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="filter_sampai" type="text" class="form-control pull-right" placeholder="Sampai" readonly style="background-color: #fff;">
                    </div>
                  </div>
                </div>
                <div class="col-xs-1">
                  <button name="btn_reset" class="btn btn-default btn-flat" title="Reset Filter"><i class="fa fa-refresh"></i></button>
                </div>
                <div class="col-xs-5">
                  <button name="btn_add" class="btn btn-xs btn-primary btn-flat pull-right"><i class="fa fa-plus"></i> Tambah Data</button>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Tanggal</th>
                      <th>Nomor Surat</th>
                      <th>Tujuan</th>
                      <th>Perihal</th>
                      <th>Bagian</th>
                      <th>Pengguna</th>
                      <th>File</th>
                      <th style="min-width: 75px;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="form" class="row" style="display: none;">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 id="formTitle">Tambah Data</h3>
            </div>
            <div class="box-body">
              <form id="formData">
                <input id="csrf" type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="" />
                <input id="0" type="file" name="upload_file" style="display: none;">
                <div class="form-group">
                  <label>Bagian Surat</label>
                  <select name="id_bagian_surat" class="form-control" style="width: 100%;"></select>
                </div>
                <div class="form-group">
                  <label>Tanggal Surat</label>
                  <input type="text" name="tanggal" class="form-control" placeholder="Tanggal Surat" value="<?php echo date('Y-m-d'); ?>" required readonly style="background-color: #fff;"></input>
                </div>
                <div class="form-group">
                  <label>Ujung Surat</label>
                  <select name="id_ujung_surat" class="form-control" style="width: 100%;"></select>
                </div>
                <div class="form-group">
                  <label>Nomor Surat</label>
                  <input type="text" name="nomor" class="form-control" placeholder="Nomor Surat" readonly></input>
                </div>
                <div class="form-group">
                  <label>Tujuan</label>
                  <input type="text" name="tujuan" class="form-control" placeholder="Tujuan Surat" required></input>
                </div>
                <div class="form-group">
                  <label>Perihal</label>
                  <input type="text" name="perihal" class="form-control" placeholder="Perihal Surat"></input>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Dibuat Oleh</label>
                  <input type="text" name="display_name" class="form-control" placeholder="Dibuat Oleh" readonly required></input>
                  <input type="hidden" name="id_pengguna" class="form-control" placeholder="Dibuat Oleh" required></input>
                </div>
              </form>
            </div>
            <div class="box-footer">
              <div class="row pull-right">
                <div class="col-xs-12">
                  <button id="0" name="btn_save" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i> Simpan</button>
                  <button name="btn_cancel" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i> Batal</button>
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
<script src="<?php echo base_url('assets/admina/js/admina.nomor.sk.js'); ?>"></script>
</body>
</html>