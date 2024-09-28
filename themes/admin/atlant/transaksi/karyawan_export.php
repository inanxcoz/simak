<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=Laporan_Data_Karyawan.xls");  //File name extension was wrong
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Laporan Data Karyawan</title>
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
      LAPORAN DATA KARYAWAN<br>
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
        <th>NIP</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Tempat/Tgl. Lahir</th>
        <th>Gender</th>
        <th>Alamat KTP</th>
        <th>Alamat Domisili</th>
        <th>Agama</th>
        <th>Perkawinan</th>
        <th>Nama Ibu Kandung</th>
        <th>No. NPWP</th>
        <th>No. BPJS-TK</th>
        <th>No. BPJS-JKN</th>
        <th>No. Handphone</th>
        <th>Email</th>
        <th>File KTP</th>
        <th>File NPWP</th>
        <th>File BPJS-TK</th>
        <th>File BPJS-JKN</th>
        <th>File Photo</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody style="text-align: center;">
      <?php
      if (count($data) > 0) {
        $no = 0;
        foreach ($data as $r) { ?>
          <tr valign="top">
            <td><?php echo ++$no; ?></td>
            <td><?php echo strtoupper($r->karyawan_nip); ?></td>
            <td><?php echo strtoupper($r->karyawan_nik); ?></td>
            <td><?php echo strtoupper($r->karyawan_nama); ?></td>
            <td><?php echo strtoupper($r->karyawan_tempat_lahir); ?>, <?php echo myDate($r->karyawan_tgl_lahir, "d F Y", false); ?></td>
            <td><?php echo get_jenis_kelamin($r->karyawan_gender); ?></td>
            <td><?php echo strtoupper($r->karyawan_alamat); ?>
                RT. <?php echo strtoupper($r->karyawan_rt); ?>/RW. <?php echo strtoupper($r->karyawan_rw); ?>
                KEL. <?php echo strtoupper($r->kel_nama); ?>,
                KEC. <?php echo strtoupper($r->kec_nama); ?>,
                KAB. <?php echo strtoupper($r->kab_nama); ?>,
                PROV. <?php echo strtoupper($r->propinsi_nama); ?>
                KODE POS <?php echo strtoupper($r->kel_kode_pos); ?>
            </td>
            <td><?php echo strtoupper($r->karyawan_domisili); ?></td>
            <td><?php echo get_agama($r->karyawan_agama); ?></td>
            <td><?php echo get_kawin($r->karyawan_kawin); ?></td>
            <td><?php echo strtoupper($r->karyawan_ibu_kandung); ?></td>
            <td><?php echo strtoupper($r->karyawan_npwp); ?></td>
            <td><?php echo strtoupper($r->karyawan_bpjstk); ?></td>
            <td><?php echo strtoupper($r->karyawan_bpjs); ?></td>
            <td><?php echo strtoupper($r->karyawan_telp); ?></td>
            <td><?php echo $r->karyawan_email; ?><br><?php echo $r->karyawan_email2; ?></td>
            <td><?php if (isset($r->karyawan_file_ktp) && trim($r->karyawan_file_ktp) != "") { ?>
                  <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $r->karyawan_file_ktp); ?>" title="<?php echo $r->karyawan_file_ktp; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank"><b>File</b>
                    <!-- <img alt="" src="<?php echo get_image(base_url()."assets/collections/karyawan/".$r->karyawan_file_ktp);?>" class="img-polaroid" style="height:50px;width:80px"> -->
                  </a>
                <?php } ?>
            </td>
            <td><?php if (isset($r->karyawan_file_npwp) && trim($r->karyawan_file_npwp) != "") { ?>
                  <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $r->karyawan_file_npwp); ?>" title="<?php echo $r->karyawan_file_npwp; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank"><b>File</b>
                    <!-- <img alt="" src="<?php echo get_image(base_url()."assets/collections/karyawan/".$r->karyawan_file_npwp);?>" class="img-polaroid" style="height:50px;width:80px"> -->
                  </a>
                <?php } ?>
            </td>
            <td><?php if (isset($r->karyawan_file_bjpstk) && trim($r->karyawan_file_bjpstk) != "") { ?>
                  <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $r->karyawan_file_bjpstk); ?>" title="<?php echo $r->karyawan_file_bjpstk; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank"><b>File</b>
                    <!-- <img alt="" src="<?php echo get_image(base_url()."assets/collections/karyawan/".$r->karyawan_file_bjpstk);?>" class="img-polaroid" style="height:30px;width:30px"> -->
                  </a>
                <?php } ?>
            </td>
            <td><?php if (isset($r->karyawan_file_bjps) && trim($r->karyawan_file_bjps) != "") { ?>
                  <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $r->karyawan_file_bjps); ?>" title="<?php echo $r->karyawan_file_bjps; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank"><b>File</b>
                    <!-- <img alt="" src="<?php echo get_image(base_url()."assets/collections/karyawan/".$r->karyawan_file_bjps);?>" class="img-polaroid" style="height:30px;width:30px"> -->
                  </a>
                <?php } ?>
            </td>
            <td><?php if (isset($r->karyawan_file_photo) && trim($r->karyawan_file_photo) != "") { ?>
                  <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $r->karyawan_file_photo); ?>" title="<?php echo $r->karyawan_file_photo; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank"><b>File</b>
                    <!-- <img alt="" src="<?php echo get_image(base_url()."assets/collections/karyawan/".$r->karyawan_file_photo);?>" class="img-polaroid" style="height:80px;width:50px"> -->
                  </a>
                <?php } ?>
            </td>
            <td><?php echo ($r->karyawan_status == 1) ? '<span class="label label-info">Pegawai</span>' : '<span class="label label-warning">Bukan Pegawai</span>'; ?></td>
          </tr>
      <?php }
      } ?>
    </tbody>
  </table>
<!--   <script>
    window.print();
  </script> -->
</body>

</html>