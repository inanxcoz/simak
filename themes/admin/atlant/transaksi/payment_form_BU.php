<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="payment_id" id="payment_id" value="<?php echo isset($val->payment_id) ? $val->payment_id : ''; ?>" />
  <div class="row">
    <div class="col-md-8">
      <div class="row form-group">
        <div class="col-md-3 control-label">Doc No</div>
        <div class="col-md-4">
          <input type="text" id="payment_kode" name="payment_kode" class="validate[required] form-control" value="<?php echo isset($val->payment_kode) ? $val->payment_kode : ''; ?>" maxlength="50" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Fiscal Year</div>
        <div class="col-md-4">
          <select name="payment_tahun" id="payment_tahun" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('tahun') as $k1 => $v1) {
              $slc = isset($val) && trim($val->payment_tahun) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Vendor Name</div>
        <div class="col-md-8">
          <select class="validate[required] form-control select" name="payment_vendor_id" id="payment_vendor_id">
            <option value=""> - Pilih - </option>
            <?php
            $vendor = get_vendor(array());
            if (count($vendor) > 0) {
              foreach ($vendor as $key => $value) {
                $sc = isset($val->payment_vendor_id) ? $val->payment_vendor_id : '';
                $se = ($sc == $value->vendor_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->vendor_id . "' $se >" . $value->vendor_kode . " | " . strtoupper($value->vendor_nama) . " | " . $value->vendor_norek . " | " . $value->bank_nama . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Entered By</div>
        <div class="col-md-4">
          <select name="payment_nama" id="payment_nama" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('nama') as $k1 => $v1) {
              $slc = isset($val) && trim($val->payment_nama) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <br>
    </div>
    <div class="col-md-4">
      <div class="row form-group">
        <div class="col-md-4 control-label">Entry Date</div>
        <div class="col-md-8">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="payment_dateentry" name="payment_dateentry" class="validate[required] form-control datepicker" value="<?php echo isset($val->payment_dateentry) ? myDate($val->payment_dateentry, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Payment Date</div>
        <div class="col-md-8">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="payment_datepayment" name="payment_datepayment" class="validate[required] form-control datepicker" value="<?php echo isset($val->payment_datepayment) ? myDate($val->payment_datepayment, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Reference</div>
        <div class="col-md-8">
          <select name="payment_reference" id="payment_reference" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('reference') as $k1 => $v1) {
              $slc = isset($val) && trim($val->payment_reference) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-8">
          <select name="payment_status" id="payment_status" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('status') as $k1 => $v1) {
              $slc = isset($val) && trim($val->payment_status) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <h2 class="heading-form">Detail Payment Request</h2>
      <div class="panel panel-default" style="margin-top:0px;">
        <div class="panel-heading">
          <div class="panel-title-box">
            <h3>Detail Payment Request</h3>
            <span>Klik (+) button to add item</span>
          </div>
          <ul class="panel-controls" style="margin-top: 2px;">
            <li><a href="javascript:void(true);" onclick="_addItem();"><span class="fa fa-plus"></span></a></li>
          </ul>
        </div>
        <div class="panel-body panel-body-table">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>GL Account</th>
                  <th>GL Descritption</th>
                  <th>Long Text</th>
                  <th>Qty</th>
                  <th>Amount</th>
                  <th>Tax</th>
                  <th width="10">#</th>
                </tr>
              </thead>
              <tbody id="items" class="answers">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br />
  <div class="panel-footer">
    <div class="pull-left">
      <button type="button" onclick="document.location='<?php echo $own_links; ?>'" class="btn btn-warning btn-cons">Cancel</button>
    </div>
    <div class="pull-right">
      <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
    </div>
  </div>
</form>


<script type="text/javascript">
  var REF_BANK = {};
  var REF_TAX = {};
  var VBANK = {};
  var VTAX = {};
  $(document).ready(function() {
    REF_BANK = eval('<?php echo json_encode(get_bank()); ?>');
    REF_TAX = eval('<?php echo json_encode(get_tax()); ?>');

    <?php if (isset($bank)) { ?>
      VBANK = eval('<?php echo json_encode($bank); ?>');
    <?php } ?>
    if (VBANK.length > 0) {
      for (i = 0; i < VBANK.length; i++) {
        _addItem({
          id: VBANK[i].pb_id,
          norek: VBANK[i].pb_norek,
          bank: VBANK[i].pb_bank_id,
          longtext: VBANK[i].pb_text,
          qty: VBANK[i].pb_qty,
          amount: VBANK[i].pb_amount,
          tax: VBANK[i].pb_tax
        });
      }
    }

    <?php if (isset($tax)) { ?>
      VTAX = eval('<?php echo json_encode($tax); ?>');
    <?php } ?>
    if (VTAX.length > 0) {
      for (i = 0; i < VTAX.length; i++) {
        _addItem({
          id: VTAX[i].pb_id,
          norek: VTAX[i].pb_norek,
          bank: VTAX[i].pb_bank_id,
          longtext: VTAX[i].pb_text,
          qty: VTAX[i].pb_qty,
          amount: VTAX[i].pb_amount,
          tax: VTAX[i].pb_tax
        });
      }
    }
  });

  function opt_bank(obj) {
    html = '<option value=""> - Bank - </option>';
    $.each(REF_BANK, function(i) {
      slc = obj == REF_BANK[i].bank_id ? 'selected="selected"' : '';
      html += '<option value="' + REF_BANK[i].bank_id + '" ' + slc + '>' + REF_BANK[i].bank_nama + '</option>';
    });
    return html;
  }

  function opt_tax(obj) {
    html = '<option value=""> - Pajak - </option>';
    $.each(REF_TAX, function(i) {
      slc = obj == REF_TAX[i].tax_nilai ? 'selected="selected"' : '';
      html += '<option value="' + REF_TAX[i].tax_nilai + '" ' + slc + '>' + REF_TAX[i].tax_nama + '</option>';
    });
    return html;
  }

  function _addItem(val) {
    idx = Math.round(Math.random() * 10000000000000000000);
    if (typeof val == 'undefined') {
      val = {
        id: idx,
        norek: '',
        bank: '',
        longtext: '',
        qty: '',
        amount: '',
        tax: ''
      };
    }
    html = _createHtml(val);
    $('#items').append(html);
  }

  function _createHtml(o) {
    html = '<tr id="item_' + o.id + '">';
    html += ' <td width="150"><input type="text" placeholder="No.Rek" class="form-control validate[required,custom[number]]" maxlength="15" id="pc_norek_' + o.id + '" name="pc_norek[' + o.id + ']" value="' + o.norek + '" /></td>';
    html += ' <td width="150"><select class="form-control validate[required]" id="bank_nama_' + o.id + '" name="bank_nama[' + o.id + ']">' + opt_bank(o.bank) + '</select></td>';
    html += ' <td><input type="text" placeholder="Description" class="form-control validate[required]" id="pc_text_' + o.id + '" name="pc_text[' + o.id + ']" value="' + o.longtext + '" /></td>';
    html += ' <td width="60"><input type="text" placeholder="Qty" class="form-control validate[required,custom[number]]" maxlength="2" id="pc_qty_' + o.id + '" name="pc_qty[' + o.id + ']" value="' + o.qty + '" /></td>';
    html += ' <td width="105"><input type="text" placeholder="Nominal" class="form-control validate[required,custom[number]]" maxlength="8" id="pc_amount_' + o.id + '" name="pc_amount[' + o.id + ']" value="' + o.amount + '" /></td>';
    html += ' <td width="90"><select class="form-control" id="pc_tax_' + o.id + '" name="pc_tax[' + o.id + ']">' + opt_tax(o.tax) + '</select></td>';
    html += '<td><a href="#detail" style="margin-left:10px" onclick=_hapusItem("' + o.id + '") title="hapus"><span class="fa fa-trash-o" style="font-size:18px;"></span></a></td>';
    html += '</tr>';
    return html;
  }

  function _hapusItem(id) {
    $('#item_' + id).fadeOut("medium", function() {
      $(this).remove();
    });
  }
</script>