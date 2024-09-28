<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=Laporan_Data_Rekap_Pajak.xls");  //File name extension was wrong
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
}
$judul = "LAPORAN DATA REKAPITULASI PAJAK BADAN";
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $judul; ?></title>
  <style type="text/css">
    html {
      font-family: Lexend; /*Montserrat;*/
      font-size: 12px;
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
        <th>Masa Pajak</th>
        <th>Jenis Pajak dan Setoran</th>
        <th>Nomor Ketetapan</th>
        <th>Perihal</th>
        <th>Nominal</th>
        <th>Kode Billing</th>
        <th>Tanggal Bayar</th>
        <th>Kode NTPN</th><!-- 
        <th>Nominal EBUPOT</th> -->
        <th>Nomor EBUPOT</th>
        <th>Tanggal EBUPOT</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody style="text-align: center;">
      <?php
      if (count($data) > 0) {
        $no = 0;
        $pajak = "";
        $pph = 0.3;
        $totalPajak = 0;
        $sub_pph = 0;
        foreach ($data as $r) {
          $byr_pph = $r->pajak_bayar * $pph;
          $totalPajak += $r->pajak_bayar;
          $sub_pph += $byr_pph;
      ?>
          <?php if ($pajak != $r->pajak_tahun) { ?>
            <tr>
              <td colspan="13" style="text-align: left;"><b>Tahun Pajak : <?php echo $r->pajak_tahun; ?></b></td>
            </tr>
          <?php }
          $pajak = $r->pajak_tahun; ?>
          <tr valign="top">
            <td><?php echo ++$no; ?></td>
            <td><?php echo get_bulan_data_html($r->pajak_masa); ?></td>
            <td><?php echo get_pajak_data_html($r->pajak_jenis); ?></td>
            <td><?php echo $r->pajak_ketetapan; ?></td>
            <td><?php echo $r->pajak_perihal; ?></td>
            <?php
            if ($r->pajak_status == 0) {
              $color = "style='text-align: right;background-color: #FEA223'";
            } else if ($r->pajak_status == 1) {
              $color = "style='text-align: right;background-color: #3FBAE4'";
            }
            ?>
            <td <?= $color ?>><?php echo myNum($r->pajak_bayar); ?></td>
            <td class="str"><?php echo $r->pajak_billing; ?></td>
            <td><?php echo myDate($r->pajak_tgl, "d M Y", false); ?></td>
            <td class="str"><?php echo $r->pajak_ntpn; ?></td>
            <!-- <td style="text-align: right;background-color: yellow;"><?php echo myNum($byr_pph); ?></td> -->
            <td class="str"><?php echo $r->pajak_bupot; ?></td>
            <td><?php echo myDate($r->pajak_tgl_bupot, "d M Y", false); ?></td>
            <td><?php echo ($r->pajak_status == 1) ? '<span class="label label-info">Done</span>' : '<span class="label label-warning">Progress</span>'; ?></td>
          </tr>
      <?php }
      } ?>
      <tr style="background-color: #33414E;text-align: center;color:#fff;">
        <td colspan="5"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo myNum($totalPajak); ?></b></td>
        <td colspan="6"></td>
      </tr>
    </tbody>
  </table>
  <!-- <script>
    window.print();
</script> -->
</body>

</html>