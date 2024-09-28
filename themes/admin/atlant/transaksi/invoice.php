<?php getFormSearch(array(
  "add_years" => true
)); ?>
<div class="panel panel-default" style="margin-top:-10px;">
  <div class="panel-heading">
    <div class="panel-title-box">
      <h3>Tabel <?php echo isset($title) ? $title : ''; ?></h3>
      <span>Data <?php echo isset($title) ? $title : ''; ?> dari <?php echo cfg('app_name'); ?> (<?php echo $cRec; ?>) </span>
      <p style="color: red;"><b><i>Berdasarkan Undang-Undang No.7 Tahun 2021 tentang Harmonisasi Peraturan Perpajakan (HPP). Mulai Tanggal 01 April 2022 Tarif PPN Sebesar 11%</i></b></p>
    </div>
    <ul class="panel-controls" style="margin-top: 2px;">
      <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
      <li><a href="<?php echo current_url(); ?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
    </ul>
  </div>
  <div class="panel-body panel-body-table">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>NSFP / Kontrak</th>
            <th>Tanggal / Invoice</th>
            <th>Tertagih / Perihal</th>
            <th>Nominal</th>
            <th>PPN / Payment</th>
            <th>Tgl. Kirim / Bayar</th>
            <th>Dokumen / Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php
          if (count($data) > 0) {
            $invoice = "";
            $ppn = 0.11;
            $pph = 0.02;
            foreach ($data as $r) {
              $byr_ppn = $r->inv_nominal * $ppn;
              $byr_pph = $r->inv_nominal * $pph;
              $byr_pph_final = $r->inv_nominal * $r->inv_pph;
              $payment = $r->inv_nominal + $byr_ppn - $byr_pph;
          ?>
              <?php if ($invoice != $r->inv_tahun) { ?>
                <tr>
                  <td colspan="20" style="text-align: left;"><b>Tahun Invoice : <?php echo $r->tahun_angka; ?></b></td>
                </tr>
              <?php }
              $invoice = $r->inv_tahun; ?>
              <tr valign="top">
                <td><?php echo ++$no; ?></td>
                <td><?php echo $r->nsfp_nomor; ?><br><br><?php echo $r->inv_spk; ?></td>
                <td><?php echo myDate($r->inv_tgl, "d M Y", false); ?><br><br><?php echo $r->inv_nomor; ?></td>
                <td><?php echo $r->client_nama; ?><br><br><?php echo $r->inv_perihal; ?></td>
                <?php
                if ($r->inv_status == 0) {
                  $color = "style='text-align: right;background-color: #FEA223'";
                } else if ($r->inv_status == 1) {
                  $color = "style='text-align: right;background-color: #95B75D'";
                } else if ($r->inv_status == 2) {
                  $color = "style='text-align: right;background-color: #B64645'";
                } else if ($r->inv_status == 3) {
                  $color = "style='text-align: right;background-color: #3FBAE4'";
                }
                ?>
                <td <?= $color ?>><?php echo myNum($r->inv_nominal); ?></td>
                <td style="text-align: right;"><?php echo myNum($byr_ppn); ?> <br><br> <?php echo myNum($payment); ?></td>
                <!-- <td style="text-align: right;"><?php echo myNum($byr_pph); ?></td> 
                <td style="text-align: right;"><?php echo myNum($byr_pph_final); ?></td> 
                <td style="text-align: right;"><?php echo myNum($payment); ?></td> -->
                <td><?php echo myDate($r->inv_tgl_kirim, "d M Y", false); ?> <br><br> <?php echo myDate($r->inv_tgl_byr, "d M Y", false); ?></td>
                <td><?php if (isset($r->inv_file) && trim($r->inv_file) != "") { ?>
                    <a href="<?php echo get_image(base_url() . 'assets/collections/invoice/' . $r->inv_file); ?>" title="<?php echo $r->inv_file; ?>" target="_blank" class="label label-default">
                      File
                    </a>
                  <?php } ?> <br><br>
                  <?php echo get_status_data_html($r->inv_status); ?>
                </td>
                <td><?php link_action($links_table_item, "?_id=" . _encrypt($r->inv_id)); ?></td>
              </tr>
          <?php }
          } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="pull-right">
  <?php echo isset($paging) ? $paging : ''; ?>
</div>