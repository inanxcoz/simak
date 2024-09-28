<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=Laporan_Data_Faktur_Pajak.xls");  //File name extension was wrong
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Laporan Data Nomor Seri Faktur Pajak</title>
  <style type="text/css">
    html {
      font-family: Calibri; /*Montserrat;*/
      font-size: 14px;
    }

    .table {
      border-collapse: collapse;
    }

    .table thead tr th {
      padding: 5px;
    }

    .table tbody tr td {
      padding: 5px;
    }

    .str {
      mso-number-format: \@;
    }
  </style>
</head>

<body>
  <center>
    <h3>
      LAPORAN DATA NOMOR SERI FAKTUR PAJAK<br>
      <?php echo cfg('app_name'); ?>
    </h3>
    <h4>
      <?php echo cfg('app_alamat'); ?>, <?php echo cfg('app_kota'); ?><br>
      <?php echo cfg('app_prov'); ?>, <?php echo cfg('app_telp'); ?>
    </h4>
  </center>
  <table class="table" border="1">
    <thead style="background-color: #33414E;text-align: center;color:#fff;">
      <tr>
        <th>No</th>
        <th>Tahun</th>
        <th>Nomor Seri Faktur Pajak</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody style="text-align: center;">
      <?php
      $no = 0;
      if (count($data) > 0) {
        foreach ($data as $r) { ?>
          <tr valign="top">
            <td><?php echo ++$no; ?></td>
            <td><?php echo $r->nsfp_tahun_id; ?></td>
            <td><?php echo $r->nsfp_nomor; ?></td>
            <td><?php echo ($r->nsfp_status == 1) ? '<span class="label label-info">Digunakan</span>' : '<span class="label label-warning">Tidak Digunakan</span>'; ?></td>
          </tr>
      <?php }
      } ?>
    </tbody>
  </table>
  <script>
    window.print();
  </script>
</body>

</html>