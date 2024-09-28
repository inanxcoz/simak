<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="kasbon_id" id="kasbon_id" value="<?php echo isset($val->kasbon_id) ? $val->kasbon_id : ''; ?>" />
  <div class="row">
    <div class="col-md-4">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Peminjam</div>
        <div class="col-md-8">
          <select class="validate[required] form-control select" name="kasbon_nama_id" id="kasbon_nama_id">
            <option value=""> - Pilih - </option>
            <?php
            $karyawan = get_karyawan(array());
            if (count($karyawan) > 0) {
              foreach ($karyawan as $key => $value) {
                $sc = isset($val->kasbon_nama_id) ? $val->kasbon_nama_id : '';
                $se = ($sc == $value->karyawan_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->karyawan_id . "' $se >" . strtoupper($value->karyawan_nama) . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal Pinjam</div>
        <div class="col-md-8">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="kasbon_tgl" name="kasbon_tgl" class="validate[required] form-control datepicker" value="<?php echo isset($val->kasbon_tgl) ? myDate($val->kasbon_tgl, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nominal</div>
        <div class="col-md-8">
          <input type="text" id="kasbon_nominal" name="kasbon_nominal" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->kasbon_nominal) ? $val->kasbon_nominal : 0; ?>" maxlength="8" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Keterangan</div>
        <div class="col-md-8">
          <input type="text" id="kasbon_uraian" name="kasbon_uraian" class="validate[required] form-control" value="<?php echo isset($val->kasbon_uraian) ? $val->kasbon_uraian : ''; ?>" maxlength="50" autocomplete="off" />
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-8">
          <select name="kasbon_status" id="kasbon_status" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('status') as $k1 => $v1) {
              $slc = isset($val) && trim($val->kasbon_status) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
    </div>

    <div class="col-md-12">
      <h2 class="heading-form">Detail Kasbon</h2>
      <div class="panel panel-default" style="margin-top:0px;">
        <div class="panel-heading">
          <div class="panel-title-box">
            <h3>Detail Kasbon</h3>
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
                  <th>Cicilan</th>
                  <th>Cicilan Tanggal</th>
                  <th>Cicilan Jumlah</th>
                  <th width="110">Status</th>
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
  var REF_CICIL = {};
  var REF_STAT = {};

  var VCICIL = {};
  var VSTATUS = {};

  $(document).ready(function() {
    REF_CICIL = eval('<?php echo json_encode(get_cicilan()); ?>');
    REF_STAT = eval('<?php echo json_encode(get_status()); ?>');

    <?php if (isset($cicilan)) { ?>
      VCICIL = eval('<?php echo json_encode($cicilan); ?>');
    <?php } ?>
    if (VCICIL.length > 0) {
      for (i = 0; i < VCICIL.length; i++) {
        _addItem({
          id: VCICIL[i].kd_id,
          nominal: VCICIL[i].kd_nominal,
          cicilan: VCICIL[i].kd_cicilan_id,
          tanggal: VCICIL[i].kd_tgl,
          status: VCICIL[i].kd_status
        });
      }
    }

  <?php if (isset($status)) { ?>
      VSTATUS = eval('<?php echo json_encode($status); ?>');
    <?php } ?>
    if (VSTATUS.length > 0) {
      for (i = 0; i < VSTATUS.length; i++) {
        _addItem({
          id: VCICIL[i].kd_id,
          nominal: VCICIL[i].kd_nominal,
          cicilan: VCICIL[i].kd_cicilan_id,
          tanggal: VCICIL[i].kd_tgl,
          status: VCICIL[i].kd_status,
          st: 1
        });
      }
    }
  });

  function opt_cicil(obj) {
    html = '<option value=""> - Cicilan - </option>';
    $.each(REF_CICIL, function(i) {
      slc = obj == REF_CICIL[i].cicilan_id ? 'selected="selected"' : '';
      html += '<option value="' + REF_CICIL[i].cicilan_id + '" ' + slc + '>' + REF_CICIL[i].cicilan_nama + '</option>';
    });
    return html;
  }

  function opt_status(obj) {
    html = '<option value="">- Status -</option>';
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
        nominal: 0,
        cicilan: '',
        tanggal: '',
        status: '',
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

    html += ' <td><select class="form-control validate[required]" id="cicilan_nama_' + o.id + '" name="cicilan_nama[' + o.id + ']">' + opt_cicil(o.cicilan) + '</select></td>';
    html += ' <td><div class="input-group"><span class="input-group-addon"><span class="fa fa-calendar"></span></span><input type="text" placeholder="Tanggal" class="form-control validate[required] datepicker" id="kc_tgl_' + o.id + '" name="kc_tgl[' + o.id + ']" value="' + o.tanggal + '" /></div></td>';
    html += ' <td><input type="text" placeholder="Nominal" class="form-control validate[required,custom[number]]" maxlength="9" id="kc_nominal_' + o.id + '" name="kc_nominal[' + o.id + ']" value="' + o.nominal + '" /></td>';
    html += ' <td width="98"><select class="form-control validate[required]" id="kc_status_' + o.id + '" name="kc_status[' + o.id + ']">' + opt_status(o.status) + '</select></td>';
    html += '<td><a href="#detail" style="margin-left:10px" onclick=_hapusItem("' + o.id + '") title="hapus"><span class="fa fa-trash-o" style="font-size:18px;"></span></a></td>';

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