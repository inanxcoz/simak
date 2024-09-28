  <div class="row">
    <h2 class="heading-form" style="text-align: center;"><b>PAYMENT REQUEST</b></h2>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Doc No</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo $val->payment_kode; ?></b></td>
          </tr>
          <tr>
            <td>Fiscal Year</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo $val->payment_tahun; ?></b></td>
          </tr>
          <tr>
            <td>Vendor Number</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo isset($val) ? get_vendor_kode($val->payment_vendor_id) : ''; ?></b></td>
          </tr>
          <tr>
            <td>Vendor Name</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo strtoupper(isset($val) ? get_vendor_name($val->payment_vendor_id) : ''); ?></b></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Entered By</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_nama_data_html($val->payment_nama); ?></td>
          </tr>
          <tr>
            <td>Start Date</td>
            <td style="text-align: center;">:</td>
            <td><?php echo myDate($val->payment_dateentry, "d F Y", false); ?></td>
          </tr>
          <tr>
            <td>End Date</td>
            <td style="text-align: center;">:</td>
            <td><?php echo myDate($val->payment_datepayment, "d F Y", false); ?></td>
          </tr>
          <tr>
            <td>Reference</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_reference_data_html($val->payment_reference); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Doc Currency</td>
            <td style="text-align: center;">:</td>
            <td>IDR</td>
          </tr>
          <tr>
            <td>Payment Method</td>
            <td style="text-align: center;">:</td>
            <td>Transfer</td>
          </tr>
          <tr>
            <td>Status</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_status_data_html($val->payment_status);
                ?></td>
          </tr>
          <tr>
            <td>Action</td>
            <td style="text-align: center;">:</td>
            <td><span class="label label-danger"><a onclick="print()" style="color:white;"> Print</a></span></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <h2 class="heading-form">Listing and Detail Payment Request</h2>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th width="100">Date</th>
            <th>Rekening</th>
            <th width="150">Account</th>
            <th>Description</th>
            <!--<th>Qty</th>
            <th>File</th>-->
            <th>Status</th>
            <th>Amount</th>
            <th>Tax</th>
            <th>Payment</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php
          if (isset($bank)) {
            $subTotal = 0;
            $no = 1;
            foreach ((array)$bank as $k => $v) {
              $subAmount = $v->pb_qty * $v->pb_amount;
              $Tax = $subAmount * $v->pb_tax;
              $Total = $subAmount - $Tax;
              $subTotal += $Total;
          ?>
              <tr>
                <td><?php echo $no++; ?>.</td>
                <td><?php echo myDate($v->pb_tgl, "d M Y", false); ?></td>
                <td><?php echo $v->pb_norek; ?></td>
                <td><?php echo isset($val) ? get_bank_name($v->pb_bank_id) : ''; ?></td>
                <td style="text-align: left;"><?php echo $v->pb_text; ?></td>
                <!-- <td><?php // echo $v->pb_qty; 
                          ?></td>
                <td><?php // if (isset($v->pb_file) && trim($v->pb_file) != "") { 
                    ?>
                    <a href="<?php // echo get_image(base_url() . 'assets/collections/payment/' . $v->pb_file); 
                              ?>" title="<?php // echo $v->pb_file; 
                                          ?>" class="act_modal btn btn-primary" rel="700|400">
                      File
                    </a>
                  <?php // } 
                  ?>
                </td> -->
                <?php
                if ($v->pb_status == 1) {
                  $color = "style='text-align: right;background-color: #FEA223'";
                } else if ($v->pb_status == 2) {
                  $color = "style='text-align: right;background-color: #95B75D'";
                } else if ($v->pb_status == 3) {
                  $color = "style='text-align: right;background-color: #B64645'";
                } else if ($v->pb_status == 4) {
                  $color = "style='text-align: right;background-color: #3FBAE4'";
                }
                ?>
                <td><?php echo isset($val) ? get_status_name($v->pb_status) : ''; ?></td>
                <td style="text-align: right;"><?php echo myNum($v->pb_amount); ?></td>
                <td style="text-align: right;"><?php echo myNum($Tax); ?></td>
                <td style="text-align: right;"><?php echo myNum($Total); ?></td>
                </td>
              </tr>
          <?php }
          } ?>
          <?php
          $pph23 = $subTotal * 0.02;
          $ppn10 = $subTotal * 0.1;
          $grandTotal = $subTotal - $pph23 + $ppn10
          ?>
          <tr>
            <td style="text-align: justify;" colspan="2" rowspan="2"><br><i>Amount in word</i></b></td>
            <td style="text-align: justify;" colspan="4" rowspan="2"><br><i><?php echo ucwords(terbilang($subTotal)); ?> Rupiah</i></td>
            <td style="text-align: right;" colspan="2"><b>SubTotal</b></td>
            <td style="text-align: right;"><b><?php echo myNum($subTotal); ?></b></td>
          </tr>
          <!--<tr style="text-align: right;">
            <td colspan="2"><b>PPN 10%</b></td>
            <td><b>0</b></td>
            <td><b><?php //echo myNum($ppn10); 
                    ?></b></td>
          </tr>
          <tr style="text-align: right;">
            <td colspan="2"><b>PPH 2%</b></td>
            <td><b>0</td>
            <td><b><?php //echo myNum($pph23);
                    ?></b></td>
          </tr>-->
          <tr>
            <td style="text-align: right; " colspan="2"><b>GrandTotal</b></td>
            <td style="text-align: right;"><b><?php echo myNum($subTotal); ?></b></td>
            <!--<td style="text-align: right;"><b><?php //echo myNum($grandTotal); 
                                                  ?></b></td>-->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-4">
    <div class="table-responsive">
      <table>
        <tbody>
          <tr>
            <td><?php echo cfg('app_name'); ?></td>
          </tr>
          <tr>
            <td><?php echo cfg('app_alamat'); ?></td>
          </tr>
          <tr>
            <td><?php echo cfg('app_kota'); ?></td>
          </tr>
          <tr>
            <td><?php echo cfg('app_prov'); ?></td>
          </tr>
          <tr>
            <td><?php echo cfg('app_telp'); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-8">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <tr>
            <th>Created By</th>
            <th>Approved By</th>
            <th>Authorized By</th>
            <th>Received By</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <tr>
            <td><img src="<?php echo themeUrl();?>img/tanda-tangan-asep.png" height="95"><br><b><?php echo get_nama_data_html($val->payment_nama); ?></b></td>
            <td><img src="<?php echo themeUrl();?>img/tanda-tangan-irwan.png" height="95"><br><b><?php echo cfg('app_chief'); ?></b></td>
            <td><img src="<?php echo themeUrl();?>img/tanda-tangan-hume.png" height="95"><br><b><?php echo cfg('app_dirut'); ?></b></td>
            <td><br><br><b><?php echo get_status_data_html($val->payment_status); ?></b><br><br><br><b><?php echo isset($val) ? get_vendor_name($val->payment_vendor_id) : ''; ?></b></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  </div>
  <!-- <script>
    window.print();
</script>