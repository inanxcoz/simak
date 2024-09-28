<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="payment_id" id="payment_id" value="<?php echo isset($val->payment_id) ? $val->payment_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-3 control-label">Doc No</div>
        <!-- <div class="col-md-9">
          <?php
            $ci = get_instance();
            $query = "SELECT max(payment_kode) as maxKode FROM app_payment";
            $data = $ci->db->query($query)->row_array();
            $kode = $data['maxKode'];
            $noUrut = (int) substr($kode, 7, 3);
            $noUrut++;
            $char = "PRAMN24";
            $kodeBaru = $char.sprintf("%03s", $noUrut);
          ?>
          <input type="text" id="payment_kode" name="payment_kode" class="validate[required] form-control" value="<?php echo $kodeBaru;?>" maxlength="10" autocomplete="off" readonly/>
        </div> -->
        <div class="col-md-9">
          <input type="text" id="payment_kode" name="payment_kode" class="validate[required] form-control" value="<?php echo isset($val->payment_kode) ? $val->payment_kode : 'PRAMN240'; ?>" maxlength="10" autocomplete="off"/>
        </div>
      </div>      
      <div class="row form-group">
        <div class="col-md-3 control-label">Fiscal Year</div>
        <div class="col-md-9">
          <select class="validate[required] form-control select" name="payment_tahun" id="payment_tahun">
            <option value=""> - Pilih - </option>
            <?php
            $tahun = get_tahun_pajak(array());
            if (count($tahun) > 0) {
              foreach ($tahun as $key => $value) {
                $sc = isset($val->payment_tahun) ? $val->payment_tahun : '';
                $se = ($sc == $value->tahun_angka) ? 'selected="selected"' : '';
                echo "<option value='" . $value->tahun_angka . "' $se >" . $value->tahun_angka . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Vendor Name</div>
        <div class="col-md-9">
          <select class="validate[required] form-control select" name="payment_vendor_id" id="payment_vendor_id">
            <option value=""> - Pilih - </option>
            <?php
            $vendor = get_vendor(array());
            if (count($vendor) > 0) {
              foreach ($vendor as $key => $value) {
                $sc = isset($val->payment_vendor_id) ? $val->payment_vendor_id : '';
                $se = ($sc == $value->vendor_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->vendor_id . "' $se >" . strtoupper($value->vendor_nama) . " | " . $value->vendor_norek . " | " . $value->bank_nama . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>    
      <div class="row form-group">
        <div class="col-md-3 control-label">Entered By</div>
        <div class="col-md-9">
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
      <div class="row form-group">
        <div class="col-md-3 control-label">Start Date</div>
        <div class="col-md-9">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="payment_dateentry" name="payment_dateentry" class="validate[required] form-control datepicker" value="<?php echo isset($val->payment_dateentry) ? myDate($val->payment_dateentry, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">End Date</div>
        <div class="col-md-9">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="payment_datepayment" name="payment_datepayment" class="validate[required] form-control datepicker" value="<?php echo isset($val->payment_datepayment) ? myDate($val->payment_datepayment, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Reference</div>
        <div class="col-md-9">
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
        <div class="col-md-3 control-label">Status</div>
        <div class="col-md-9">
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
      <br>
    </div>

    <div class="col-md-6">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td style="color: red;"><b><i>Summary Payment Request</i></b></td>
          </tr>
          <tr>
            <td id="summary">
              <b><?php echo $val->payment_kode; ?></b><br>
              <b><?php echo isset($val) ? strtoupper(get_vendor_name($val->payment_vendor_id)) : ''; ?> | <?php echo myDate($val->payment_dateentry, "d M Y", false); ?> - <?php echo myDate($val->payment_datepayment, "d M Y", false); ?></b><br><br>
              <?php
              if (isset($detail_photo)) {
                $grandTotal = 0;
                foreach ((array)$detail_photo as $k => $v) {
                  $subAmount = $v->pb_qty * $v->pb_amount;
                  $Tax = $subAmount * $v->pb_tax;
                  $Total = $subAmount - $Tax;
                  $grandTotal = $Total + $grandTotal;
              ?>
                  <b><?php echo $v->pb_norek; ?> - <?php echo isset($val) ? get_bank_name($v->pb_bank_id) : ''; ?></b><br>
                  <?php echo $v->pb_text; ?> - <?php echo myNum($Total); ?><br>
              <?php }
              } ?>
              <br>
              <b>Total : <?php echo myNum($grandTotal); ?></b>
            </td>
          </tr>
          <tr>
            <td><button id="copyButton">Copy Summary</button>
            <p id="statusSum" style="color: green; font-weight: bold;"></p></td>
          </tr>
          <tr>
            <td id="kalimat">irwan1010@gmail.com,ak.inank@gmail.com,hhumaedi@gmail.com</td>
          </tr>
          <tr>
            <td><button id="copyBtn">Copy Email</button>
            <p id="status" style="color: green; font-weight: bold;"></p></td>
          </tr>
        </table>
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
                  <th>Tahun</th>
                  <th>Date</th>
                  <th>Rekening</th>
                  <th>Account</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Amount</th>
                  <th>Tax</th>
                  <th>Status</th>
                  <th>Upload</th>
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
  var REF_THN = {};
  var REF_STAT = {};

  var VBANK = {};
  var VTAX = {};
  var VTHN = {};
  var VSTATUS = {};

  var PHOTO_ITEM = {};

  document.getElementById("copyButton").addEventListener("click", function() {
    // Mendapatkan kalimat yang ingin disalin
    var kalimat = document.getElementById("summary").innerText;

    // Membuat elemen temporary untuk menampung kalimat
    var tempInput = document.createElement("textarea");
    tempInput.value = kalimat;
    document.body.appendChild(tempInput);

    // Menyalin teks dari elemen temporary
    tempInput.select();
    document.execCommand("copy");

    // Menghapus elemen temporary
    document.body.removeChild(tempInput);

    // Menampilkan pesan sukses tanpa reload halaman
    document.getElementById("statusSum").innerText = "Summary berhasil disalin!";
  });

  document.getElementById("copyBtn").addEventListener("click", function() {
    // Mendapatkan kalimat yang ingin disalin
    var kalimat = document.getElementById("kalimat").innerText;

    // Membuat elemen temporary untuk menampung kalimat
    var tempInput = document.createElement("textarea");
    tempInput.value = kalimat;
    document.body.appendChild(tempInput);

    // Menyalin teks dari elemen temporary
    tempInput.select();
    document.execCommand("copy");

    // Menghapus elemen temporary
    document.body.removeChild(tempInput);

    // Menampilkan pesan sukses tanpa reload halaman
    document.getElementById("status").innerText = "Email berhasil disalin!";
  });

  $(document).ready(function() {

    REF_BANK = eval('<?php echo json_encode(get_bank()); ?>');
    REF_TAX = eval('<?php echo json_encode(get_tax()); ?>');
    REF_THN = eval('<?php echo json_encode(get_tahun_pajak()); ?>');
    REF_STAT = eval('<?php echo json_encode(get_status()); ?>');

    <?php if (isset($detail_photo)) {
      $mx = array();
      foreach ((array)$detail_photo as $p => $q) {
       $image_big = get_new_image(array(
          "url"     => cfg('upload_path_payment') . "/" . $q->pb_file,
          "folder"  => "payment"
        ), true);
        $q->pb_file = $image_big;
        $mx[] = $q;
      }
    ?>
      PHOTO_ITEM = eval('<?php echo json_encode($mx); ?>');
    <?php } ?>
    if (PHOTO_ITEM.length > 0) {
      for (i = 0; i < PHOTO_ITEM.length; i++) {
        _addItem({
          id: PHOTO_ITEM[i].pb_id,
          norek: PHOTO_ITEM[i].pb_norek,
          bank: PHOTO_ITEM[i].pb_bank_id,
          longtext: PHOTO_ITEM[i].pb_text,
          qty: PHOTO_ITEM[i].pb_qty,
          amount: PHOTO_ITEM[i].pb_amount,
          tax: PHOTO_ITEM[i].pb_tax,
          thn: PHOTO_ITEM[i].pb_thn,
          tanggal: PHOTO_ITEM[i].pb_tgl,
          status: PHOTO_ITEM[i].pb_status,
          url: PHOTO_ITEM[i].pb_file,
          st: 1
        });
      }
    }

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
          tax: VBANK[i].pb_tax,
          thn: VBANK[i].pb_thn,
          tanggal: VBANK[i].pb_tgl,
          status: VBANK[i].pb_status,
          url: VBANK[i].pb_file,
          st: 1
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
          tax: VTAX[i].pb_tax,
          thn: VTAX[i].pb_thn,
          tanggal: VTAX[i].pb_tgl,
          status: VTAX[i].pb_status,
          url: VTAX[i].pb_file,
          st: 1
        });
      }
    }

    <?php if (isset($thn)) { ?>
      VTHN = eval('<?php echo json_encode($thn); ?>');
    <?php } ?>
    if (VTHN.length > 0) {
      for (i = 0; i < VTHN.length; i++) {
        _addItem({
          id: VTHN[i].pb_id,
          norek: VTHN[i].pb_norek,
          bank: VTHN[i].pb_bank_id,
          longtext: VTHN[i].pb_text,
          qty: VTHN[i].pb_qty,
          amount: VTHN[i].pb_amount,
          tax: VTHN[i].pb_tax,
          thn: VTHN[i].pb_thn,
          tanggal: VTHN[i].pb_tgl,
          status: VTHN[i].pb_status,
          url: VTHN[i].pb_file,
          st: 1
        });
      }
    }

    <?php if (isset($status)) { ?>
      VSTATUS = eval('<?php echo json_encode($status); ?>');
    <?php } ?>
    if (VSTATUS.length > 0) {
      for (i = 0; i < VSTATUS.length; i++) {
        _addItem({
          id: VSTATUS[i].pb_id,
          norek: VSTATUS[i].pb_norek,
          bank: VSTATUS[i].pb_bank_id,
          longtext: VSTATUS[i].pb_text,
          qty: VSTATUS[i].pb_qty,
          amount: VSTATUS[i].pb_amount,
          tax: VSTATUS[i].pb_tax,
          thn: VSTATUS[i].pb_thn,
          tanggal: VSTATUS[i].pb_tgl,
          status: VSTATUS[i].pb_status,
          url: VSTATUS[i].pb_file,
          st: 1
        });
      }
    }
  });

  function opt_bank(obj) {
    html = '<option value="">Bank</option>';
    $.each(REF_BANK, function(i) {
      slc = obj == REF_BANK[i].bank_id ? 'selected="selected"' : '';
      html += '<option value="' + REF_BANK[i].bank_id + '" ' + slc + '>' + REF_BANK[i].bank_nama + '</option>';
    });
    return html;
  }

  function opt_tax(obj) {
    html = '<option value="">Pajak</option>';
    $.each(REF_TAX, function(i) {
      slc = obj == REF_TAX[i].tax_nilai ? 'selected="selected"' : '';
      html += '<option value="' + REF_TAX[i].tax_nilai + '" ' + slc + '>' + REF_TAX[i].tax_nama + '</option>';
    });
    return html;
  }

  function opt_thn(obj) {
    html = '<option value="">Tahun</option>';
    $.each(REF_THN, function(i) {
      slc = obj == REF_THN[i].tahun_angka ? 'selected="selected"' : '';
      html += '<option value="' + REF_THN[i].tahun_angka + '" ' + slc + '>' + REF_THN[i].tahun_angka + '</option>';
    });
    return html;
  }

  function opt_status(obj) {
    html = '<option value="">Status</option>';
    $.each(REF_STAT, function(i) {
      slc = obj == REF_STAT[i].status_id ? 'selected="selected"' : '';
      html += '<option value="' + REF_STAT[i].status_id + '" ' + slc + '>' + REF_STAT[i].status_nama + '</option>';
    });
    return html;
  }

  function _addItem(val) {
    idx = Math.round(Math.random() * 10000000000000000000);
    if (typeof val == 'undefined') {
      val = {
        id: idx,
        norek: 0,
        bank: '',
        longtext: '-',
        qty: 1,
        amount: 0,
        tax: '',
        thn: '',
        tanggal: '',
        status: '',
        url: '',
        st: ''
      };
    }
    html = _createHtml(val);
    $('#items').append(html);
    $("#form-validated").validationEngine();
    _init_picker();
  }

  function _createHtml(o) {
    html = '<tr id="item_' + o.id + '">';

    html += ' <td width="75"><select class="form-control validate[required]" id="pc_thn_' + o.id + '" name="pc_thn[' + o.id + ']">' + opt_thn(o.thn) + '</select></td>';
    html += ' <td width="150"><div class="input-group"><span class="input-group-addon"><span class="fa fa-calendar"></span></span><input type="text" placeholder="Tanggal" class="form-control validate[required] datepicker" id="pc_tgl_' + o.id + '" name="pc_tgl[' + o.id + ']" value="' + o.tanggal + '" /></div></td>';
    html += ' <td width="160"><input type="text" placeholder="No.Rekening" class="form-control validate[required,custom[number]]" maxlength="15" id="pc_norek_' + o.id + '" name="pc_norek[' + o.id + ']" value="' + o.norek + '" /></td>';
    html += ' <td width="150"><select class="form-control validate[required]" id="bank_nama_' + o.id + '" name="bank_nama[' + o.id + ']">' + opt_bank(o.bank) + '</select></td>';
    html += ' <td><input type="text" placeholder="Description" class="form-control validate[required]" id="pc_text_' + o.id + '" name="pc_text[' + o.id + ']" value="' + o.longtext + '" /></td>';
    html += ' <td width="70"><input type="text" placeholder="Qty" class="form-control validate[required,custom[number]]" maxlength="2" id="pc_qty_' + o.id + '" name="pc_qty[' + o.id + ']" value="' + o.qty + '" /></td>';
    html += ' <td width="115"><input type="text" placeholder="Nominal" class="form-control validate[required,custom[number]]" maxlength="9" id="pc_amount_' + o.id + '" name="pc_amount[' + o.id + ']" value="' + o.amount + '" /></td>';
    html += ' <td width="90"><select class="form-control validate[required]" id="pc_tax_' + o.id + '" name="pc_tax[' + o.id + ']">' + opt_tax(o.tax) + '</select></td>';
    html += ' <td width="98"><select class="form-control validate[required]" id="pc_status_' + o.id + '" name="pc_status[' + o.id + ']">' + opt_status(o.status) + '</select></td>';

    html += '<td width="75">';
    if ($.trim(o.st) != '') {
      html += '<input type="file" class="btn fileinput btn-primary"  name="file_' + o.id + '">';
    } else {
      html += '<a class="file-input-wrapper btn btn-default  btn fileinput btn-primary"><span>Browse</span><input type="file" class="btn fileinput btn-primary"  name="file_' + o.id + '"></a>';
    }
    if ($.trim(o.url) != '') {
      html += '<a href="' + o.url + '" title="Image Photo" class="act_modal" rel="700|400">';
      html += '<img alt="" src="' + o.url + '" style="height:25px;width:25px;margin-top:0px;margin-left:10px;" class="img-polaroid"></a> ';
    }
    html += '</td>';

    html += '<td><a href="#detail" style="margin-left:5px" onclick=_hapusItem("' + o.id + '") title="hapus"><span class="fa fa-trash-o" style="font-size:18px;"></span></a></td>';

    html += '</tr>';
    return html;
    $("#form-validated").validationEngine();
  }

  function _hapusItem(id) {
    $('#item_' + id).fadeOut("medium", function() {
      $(this).remove();
    });
  }
</script>