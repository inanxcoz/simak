<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="payment_id" id="payment_id" value="<?php echo isset($val->payment_id) ? $val->payment_id : ''; ?>" />
  <div class="row">
    <h2 class="heading-form" style="text-align: center;"><b>PAYMENT REQUEST</b></h2>
    <div class="col-md-7">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Doc No</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo $val->payment_kode; ?></b></td>
          </tr>
          <tr>
            <td>Vendor Name</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo isset($val) ? get_vendor_name($val->payment_vendor_id) : ''; ?></b></td>
          </tr>
          <tr>
            <td>Date</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo myDate($val->payment_dateentry, "d M Y", false); ?> - <?php echo myDate($val->payment_datepayment, "d M Y", false); ?></b></td>
          </tr>
          <?php
          if (isset($bank)) {
            $grandTotal = 0;
            foreach ((array)$bank as $k => $v) {
              $subAmount = $v->pb_qty * $v->pb_amount;
              $Tax = $subAmount * $v->pb_tax;
              $Total = $subAmount - $Tax;
              $grandTotal = $Total + $grandTotal;
          ?>
              <tr>
                <td>No. Rekening</td>
                <td style="text-align: center;">:</td>
                <td><b><?php echo $v->pb_norek; ?></b></td>
              </tr>
              <tr>
                <td>Bank</td>
                <td style="text-align: center;">:</td>
                <td><?php echo isset($val) ? get_bank_name($v->pb_bank_id) : ''; ?></td>
              </tr>
              <tr>
                <td>Description</td>
                <td style="text-align: center;">:</td>
                <td><?php echo $v->pb_text; ?></td>
              </tr>
              <tr>
                <td>Amount</td>
                <td style="text-align: center;">:</td>
                <td><?php echo myNum($Total); ?></td>
              </tr>
          <?php }
          } ?>
          <tr>
            <td>Total</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo myNum($grandTotal); ?></b></td>
          </tr>
          <tr>
            <td>Terbilang</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo ucwords(terbilang($grandTotal)); ?></b></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-5">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Fiscal Year</td>
            <td style="text-align: center;">:</td>
            <td><?php echo $val->payment_tahun; ?></td>
          </tr>
          <tr>
            <td>Doc Currency</td>
            <td style="text-align: center;">:</td>
            <td>IDR</td>
          </tr>
          <tr>
            <td>Entry Date</td>
            <td style="text-align: center;">:</td>
            <td><?php echo myDate($val->payment_dateentry, "d F Y", false); ?></td>
          </tr>
          <tr>
            <td>Payment Date</td>
            <td style="text-align: center;">:</td>
            <td><?php echo myDate($val->payment_datepayment, "d F Y", false); ?></td>
          </tr>
          <tr>
            <td>Entered By</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_nama_data_html($val->payment_nama); ?></td>
          </tr>
          <tr>
            <td>Reference</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_reference_data_html($val->payment_reference); ?></td>
          </tr>
          <tr>
            <td>Payment Method</td>
            <td style="text-align: center;">:</td>
            <td>Transfer</td>
          </tr>
          <tr>
            <td>Status</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_status_data_html($val->payment_status); ?></td>
          </tr>
        </table>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped">
            <tr>
              <td><i>Summary Payment Request</i></td>
            </tr>
            <tr>
              <td><b><?php echo $val->payment_kode; ?></b></td>
            </tr>
            <tr>
              <td><b><?php echo isset($val) ? get_vendor_name($val->payment_vendor_id) : ''; ?></b></td>
            </tr>
            <tr>
              <td><b><?php echo myDate($val->payment_dateentry, "d M Y", false); ?> - <?php echo myDate($val->payment_datepayment, "d M Y", false); ?></b></td>
            </tr>
            <?php
            if (isset($bank)) {
              $grandTotal = 0;
              foreach ((array)$bank as $k => $v) {
                $subAmount = $v->pb_qty * $v->pb_amount;
                $Tax = $subAmount * $v->pb_tax;
                $Total = $subAmount - $Tax;
                $grandTotal = $Total + $grandTotal;
            ?>
                <tr>
                  <td><b><?php echo $v->pb_norek; ?> - <?php echo isset($val) ? get_bank_name($v->pb_bank_id) : ''; ?></b></td>
                </tr>
                <tr>
                  <td><?php echo $v->pb_text; ?></td>
                </tr>
                <tr>
                  <td><?php echo myNum($Total); ?></td>
                </tr>
            <?php }
            } ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <h2 class="heading-form">Listing and Detail Payment Request</h2>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <tr>
            <th>No. Rekening</th>
            <th>Bank</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Tax</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php
          if (isset($bank)) {
            $subTotal = 0;
            foreach ((array)$bank as $k => $v) {
              $subAmount = $v->pb_qty * $v->pb_amount;
              $Tax = $subAmount * $v->pb_tax;
              $Total = $subAmount - $Tax;
              $subTotal += $Total;
          ?>
              <tr>
                <td><?php echo $v->pb_norek; ?></td>
                <td><?php echo isset($val) ? get_bank_name($v->pb_bank_id) : ''; ?></td>
                <td style="text-align: left;"><?php echo $v->pb_text; ?></td>
                <td><?php echo $v->pb_qty; ?></td>
                <td style="text-align: right;"><?php echo myNum($v->pb_amount); ?></td>
                <td style="text-align: right;"><?php echo myNum($Tax); ?></td>
                <td style="text-align: right;"><?php echo myNum($Total); ?></td>
              </tr>
          <?php }
          } ?>
          <?php
          $pph23 = $subTotal * 0.02;
          $ppn10 = $subTotal * 0.1;
          ?>
          <tr style="text-align: right;">
            <td colspan="6"><b>SubTotal</b></td>
            <td><b><?php echo myNum($subTotal); ?></b></td>
          </tr>
          <!-- <tr style="text-align: right;">
              <td colspan="6"><b>PPH 23</b></td>
              <td><b><?php // echo myNum($pph23);
                      ?></b></td>
            </tr>
            <tr style="text-align: right;">
              <td colspan="6"><b>PPN 10</b></td>
              <td><b><?php // echo myNum($ppn10);
                      ?></b></td>
            </tr>
            <tr style="text-align: right;">
              <td colspan="6"><b>GrandTotal</b></td>
              <td><b><?php // echo myNum($subTotal-$pph23+$ppn10);
                      ?></b></td>
            </tr> -->
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-4">

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
            <td><br><br><br><br><br><?php echo get_nama_data_html($val->payment_nama); ?></td>
            <td><br><br><br><br><br><?php echo cfg('app_chief'); ?></td>
            <td><br><br><br><br><br><?php echo cfg('app_dirut'); ?></td>
            <td><br><br><?php echo get_status_data_html($val->payment_status); ?><br><br><br><?php echo isset($val) ? get_vendor_name($val->payment_vendor_id) : ''; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  </div>
</form>
<!-- <script>
    window.print();
</script> -->