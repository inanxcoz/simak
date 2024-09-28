<?php getFormSearch(); ?>
<div class="panel panel-default" style="margin-top:-10px;">
  <div class="panel-heading">
    <div class="panel-title-box">
      <h3>Tabel <?php echo isset($title) ? $title : ''; ?></h3>
      <span>Data <?php echo isset($title) ? $title : ''; ?> dari <?php echo cfg('app_name'); ?> (<?php echo $cRec; ?>) </span>
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
            <th width="105">Date</th>
            <th>Rekening</th>
            <th width="150">Account</th>
            <th>Description</th>
            <th>Amount</th>
            <!-- <th>Tax</th> -->
            <th>Payment</th>
            <th>Dokumen</th>
            <th>Status</th>
            <th width="90">Action</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php
          if (count($data) > 0) {
            $payment = "";
            $subTotal = 0;
            foreach ($data as $r) {
              $subAmount = $r->pb_qty * $r->pb_amount;
              $Tax = $subAmount * $r->pb_tax;
              $Total = $subAmount - $Tax;
              $subTotal += $Total;
          ?>
              <?php if ($payment != $r->payment_id) { ?>
                <tr>
                  <td colspan="11" style="text-align: left;"><b>Tahun : <?php echo $r->tahun_angka; ?> | <?php echo $r->payment_kode; ?> | <?php echo get_reference_data_html($r->payment_reference); ?> | <?php echo strtoupper($r->vendor_nama); ?> | <?php echo myDate($r->payment_dateentry, "d M", false); ?> - <?php echo myDate($r->payment_datepayment, "d M Y", false); ?> | Status : &nbsp;<?php echo get_status_data_html($r->payment_status); ?></b></td>
                </tr>
              <?php }
              $payment = $r->payment_id; ?>
              <tr valign="top">
                <td><?php echo ++$no; ?></td>
                <td><?php echo myDate($r->pb_tgl, "d M Y", false); ?></td>
                <td><?php echo $r->pb_norek; ?></td>
                <td><?php echo $r->bank_nama; ?></td>
                <td style="text-align: left;"><?php echo $r->pb_text; ?></td>
                <!-- <?php
                if ($r->pb_status == 1) {
                  $color = "style='text-align: right;background-color: #FEA223'";
                } else if ($r->pb_status == 2) {
                  $color = "style='text-align: right;background-color: #95B75D'";
                } else if ($r->pb_status == 3) {
                  $color = "style='text-align: right;background-color: #B64645'";
                } else if ($r->pb_status == 4) {
                  $color = "style='text-align: right;background-color: #3FBAE4'";
                }
                ?> -->
                <td style="text-align: right;"><?php echo myNum($r->pb_amount); ?></td>
                <!-- <td style="text-align: right;"><?php echo myNum($Tax); ?></td> -->
                <td style="text-align: right;"><?php echo myNum($Total); ?></td>
                <td><?php if (isset($r->pb_file) && trim($r->pb_file) != "") { ?>
                    <a href="<?php echo get_image(base_url() . 'assets/collections/payment/' . $r->pb_file); ?>" target="_blank" title="<?php echo $r->pb_file; ?>" class="label label-default">
                      File
                    </a>
                  <?php } ?>
                </td>
                <td><?php
                    if ($r->pb_status == 1) {
                      echo "<span class='label label-warning'>" . $r->status_nama . "</span>";
                    } else if ($r->pb_status == 2) {
                      echo "<span class='label label-success'>" . $r->status_nama . "</span>";
                    } else if ($r->pb_status == 3) {
                      echo "<span class='label label-danger'>" . $r->status_nama . "</span>";
                    } else if ($r->pb_status == 4) {
                      echo "<span class='label label-info'>" . $r->status_nama . "</span>";
                    }
                    ?>
                </td>
                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->payment_id)); ?></td>
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