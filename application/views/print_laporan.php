<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Laporan</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
    <style>
      table > thead > tr > th, table > tbody > tr > td {
        text-align: center;
      }
    </style>
</head>
<body onload="print()">
    <table width="100%" class="table table-bordered table-large">
      <thead>
        <tr>
          <th rowspan="2" style="vertical-align:middle;">NO URUT</th>
          <th rowspan="2" style="vertical-align:middle;">NAMA PETUGAS YANG BERTUGAS</th>
          <th colspan="2">SURAT PERINTAH</th>
          <th colspan="2">SPPD</th>
          <th rowspan="2" style="vertical-align:middle;">TEMPAT TUJUAN</th>
        </tr>
        <tr>
          <th>TANGGAL</th>
          <th>NOMOR</th>
          <th>TANGGAL</th>
          <th>NOMOR</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; ?>
        <?php
          foreach ($data as $key => $value) { ?>
            <?php $i=0; ?>
            <?php $nDetail = count($value->detail); ?>
            <?php foreach ($value->detail as $keyDetail => $detail) { ?>
              <tr>
                <?php
                  if ($i == 0) { ?>
                    <td style="vertical-align:middle;" rowspan="<?php echo $nDetail; ?>"><?php echo $no; ?></td>
                  <?php }
                ?>
                <td style="text-align:left;vertical-align:middle;"><?php echo $detail->nama_petugas; ?></td>
                <?php
                  if ($i == 0) { ?>
                    <td style="vertical-align:middle;" rowspan="<?php echo $nDetail; ?>"><?php echo tgl_indo($value->tanggal); ?></td>
                  <?php }
                ?>
                <?php
                  if ($i == 0) { ?>
                    <td style="vertical-align:middle;" rowspan="<?php echo $nDetail; ?>"><?php echo $value->nomor; ?></td>
                  <?php }
                ?>
                <?php
                  if ($i == 0) { ?>
                    <td style="vertical-align:middle;" rowspan="<?php echo $nDetail; ?>"><?php echo tgl_indo($detail->tanggal_sppd); ?></td>
                  <?php }
                ?>
                <td style="text-align:left;vertical-align:middle;"><?php echo $detail->id; ?></td>
                <?php
                  if ($i == 0) { ?>
                    <td style="vertical-align:middle;" rowspan="<?php echo $nDetail; ?>"><?php echo $detail->tempat . '<br>' . $value->tujuan; ?></td>
                  <?php }
                ?>
              </tr>
              <?php $i=$i+1; ?>
            <?php }
            $no = $no + 1;
          }
        ?>
      </tbody>
    </table>
</body>
</html>