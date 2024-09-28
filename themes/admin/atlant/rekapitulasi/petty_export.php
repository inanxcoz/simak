<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=Laporan_Data_Rekap_Petty_Cash.xls");  //File name extension was wrong
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
}
$judul = "LAPORAN DATA REKAPITULASI PETTY CASH";
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $judul; ?></title>
  <style type="text/css">
    html {
      font-family: Calibri; /*Montserrat;*/
      font-size: 13px;
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
      <?php echo $judul; ?><br>
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
        <th>Perihal</th>
        <th>Nota</th>
        <th width="80">Tanggal</th>
        <th>Jumlah</th>
        <th>Nominal</th>
        <th>Debet</th>
        <th>Kredit</th>
        <th>Saldo</th>
        <th>Status</th>
        <th>Dokumen</th>
      </tr>
    </thead>
    <tbody style="text-align: center;">
      <?php
      if (count($data) > 0) {
        $no          = 0;
        $petty       = "";
        $Debet       = 0;
        $Saldo       = 0;
        $TotalDebet  = 0;
        $TotalKredit = 0;
        $TotalSaldo  = 0;
        foreach ($data as $r) {
          $Debet       = $r->petty_qty * $r->petty_debet;
          $Kredit      = $r->petty_kredit;
          $Saldo       += -$Debet + $Kredit;
          $TotalDebet  += $Debet;
          $TotalKredit += $Kredit;
          $TotalSaldo  = $TotalKredit - $TotalDebet;
      ?>
          <?php if ($petty != myDate($r->petty_tgl, "F", false)) { ?>
            <tr>
              <td colspan="11" style="text-align: left;"><b>Tahun : <?php echo $r->petty_tahun; ?> | Bulan : <?php echo myDate($r->petty_tgl, "F", false); ?></b></td>
            </tr>
          <?php }
          $petty = myDate($r->petty_tgl, "F", false); ?>
          <tr valign="top">
            <td><?php echo ++$no; ?></td>
            <td style="text-align: left;"><?php echo $r->petty_perihal; ?></td>
            <td><?php echo $r->petty_nota; ?></td>
            <td><?php echo myDate($r->petty_tgl, "d M Y", false); ?></td>
            <td><?php echo myNum($r->petty_qty); ?></td>
            <td style="text-align: right;"><?php echo myNum($r->petty_debet); ?></td>
            <td style="text-align: right;background-color: #FEA223;"><?php echo myNum($Debet); ?></td>
            <td style="text-align: right;background-color: #B64645;"><?php echo myNum($r->petty_kredit); ?></td>
            <td style="text-align: right;background-color: #36B7E3;"><?php echo myNum($Saldo); ?></td>
            <td><?php echo ($r->petty_status == 1) ? '<span class="label label-info">Done</span>' : '<span class="label label-warning">Progress</span>'; ?></td>
            <td><?php if (isset($r->petty_file) && trim($r->petty_file) != "") { ?>
                    <a href="<?php echo get_image(base_url() . 'assets/collections/petty/' . $r->petty_file); ?>" title="<?php echo $r->petty_file; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank">
                        File
                    </a>
                <?php } ?>
            </td>
          </tr>
      <?php }
      } ?>
      <tr style="background-color: #33414E;text-align: center;color:#fff;">
        <td colspan="6"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo myNum($TotalDebet); ?></b></td>
        <td style="text-align: right;"><b><?php echo myNum($TotalKredit); ?></b></td>
        <td style="text-align: right;"><b><?php echo myNum($TotalSaldo); ?></b></td>
        <td colspan="2"></td>
      </tr>
    </tbody>
  </table>
  <!-- <script>
    window.print();
</script> -->
</body>

</html>