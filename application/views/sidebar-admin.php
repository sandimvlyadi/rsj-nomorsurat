<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="li-dashboard"><a href="<?php echo base_url('dashboard/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="treeview li-nomor-surat">
        <a href="#">
          <i class="fa fa-book"></i> <span>Nomor Surat</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="li-nomor-sp"><a href="<?php echo base_url('nomor-sp/'); ?>"><i class="fa fa-circle-o"></i> Surat Perintah</a></li>
          <li class="li-nomor-sk"><a href="<?php echo base_url('nomor-sk/'); ?>"><i class="fa fa-circle-o"></i> Surat Keputusan</a></li>
          <li class="li-nomor-nota"><a href="<?php echo base_url('nomor-nota/'); ?>"><i class="fa fa-circle-o"></i> Nota Dinas</a></li>
          <li class="li-nomor-barjas"><a href="<?php echo base_url('nomor-barjas/'); ?>"><i class="fa fa-circle-o"></i> Pengadaan Barang & Jasa</a></li>
        </ul>
      </li>
      <li class="li-bagian-surat"><a href="<?php echo base_url('bagian-surat/'); ?>"><i class="fa  fa-bookmark"></i> <span>Bagian Surat</span></a></li>
      <li class="li-ujung-surat"><a href="<?php echo base_url('ujung-surat/'); ?>"><i class="fa  fa-angle-double-right"></i> <span>Ujung Surat</span></a></li>
      <li class="li-pengguna"><a href="<?php echo base_url('pengguna/'); ?>"><i class="fa fa-users"></i> <span>Pengguna</span></a></li>
      <li class="treeview li-master">
        <a href="#">
          <i class="fa fa-database"></i> <span>Master</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="li-jenis-surat"><a href="<?php echo base_url('jenis-surat/'); ?>"><i class="fa fa-circle-o"></i> <span>Jenis Surat</span></a></li>
          <li class="li-level-pengguna"><a href="<?php echo base_url('level-pengguna/'); ?>"><i class="fa fa-circle-o"></i> Level Pengguna</a></li>
          <li class="li-bagian-pengguna"><a href="<?php echo base_url('bagian-pengguna/'); ?>"><i class="fa fa-circle-o"></i> Bagian Pengguna</a></li>
          <li class="li-registrasi-pengguna"><a href="<?php echo base_url('registrasi-pengguna/'); ?>"><i class="fa fa-circle-o"></i> Registrasi Pengguna</a></li>
          <li class="li-session-log"><a href="<?php echo base_url('session-log/'); ?>"><i class="fa fa-circle-o"></i> Session Log</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>