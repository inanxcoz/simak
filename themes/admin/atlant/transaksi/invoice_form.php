<?php js_validate(); ?>
<style>
  .readonly {
    background-color: #F9F9F9 !important;
    color: #000 !important;
    border: 1px solid #D5D5D5;
    font-weight: bold;
    border-bottom: 1px solid #D5D5D5;
    border-style: solid;
  }
</style>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="inv_id" id="inv_id" value="<?php echo isset($val->inv_id) ? $val->inv_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Tahun</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="inv_tahun" id="inv_tahun">
            <option value="">- Pilih -</option>
            <?php foreach ((array)get_tahun_pajak() as $m) {
              $s = isset($val) && $val->inv_tahun == $m->tahun_angka ? 'selected="selected"' : '';
              echo "<option value='" . $m->tahun_angka . "' $s >" . $m->tahun_angka . "</option>";
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nomor Seri Faktur Pajak</div>
        <div class="col-md-7" style="margin-left:0px;">
          <select name="inv_nsfp" class="validate[required] form-control" id="inv_nsfp">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">No. Kontrak</div>
        <div class="col-md-7">
          <input type="text" id="inv_spk" name="inv_spk" class="validate[required] form-control" value="<?php echo isset($val->inv_spk) ? $val->inv_spk : ''; ?>" maxlength="100" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="inv_tgl" name="inv_tgl" class="validate[required] form-control datepicker" value="<?php echo isset($val->inv_tgl) ? myDate($val->inv_tgl, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">No. Invoice</div>
        <div class="col-md-7">
          <input type="text" id="inv_nomor" name="inv_nomor" class="validate[required] form-control" value="<?php echo isset($val->inv_nomor) ? $val->inv_nomor : ''; ?>" maxlength="21" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Client</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="inv_client_id" id="inv_client_id">
            <option value=""> - Pilih - </option>
            <?php
            $client = get_client(array());
            if (count($client) > 0) {
              foreach ($client as $key => $value) {
                $sc = isset($val->inv_client_id) ? $val->inv_client_id : '';
                $se = ($sc == $value->client_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->client_id . "' $se >" . strtoupper($value->client_nama) . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Perihal</div>
        <div class="col-md-7">
          <textarea id="inv_perihal" rows="5" name="inv_perihal" class="validate[required] form-control"><?php echo isset($val->inv_perihal) ? $val->inv_perihal : ''; ?></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nominal</div>
        <div class="col-md-7">
          <input type="text" id="inv_nominal" name="inv_nominal" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->inv_nominal) ? $val->inv_nominal : 0; ?>" maxlength="9" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal Kirim</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="inv_tgl_kirim" name="inv_tgl_kirim" class="validate[required] form-control datepicker" value="<?php echo isset($val->inv_tgl_kirim) ? myDate($val->inv_tgl_kirim, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal Bayar</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="inv_tgl_byr" name="inv_tgl_byr" class="validate[required] form-control datepicker" value="<?php echo isset($val->inv_tgl_byr) ? myDate($val->inv_tgl_byr, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tax</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="inv_pph" id="inv_pph">
            <option value=""> - Pilih - </option>
            <?php
            $pajak = get_tax(array());
            if (count($pajak) > 0) {
              foreach ($pajak as $key => $value) {
                $sc = isset($val->inv_pph) ? $val->inv_pph : '';
                $se = ($sc == $value->tax_nilai) ? 'selected="selected"' : '';
                echo "<option value='" . $value->tax_nilai . "' $se >" . $value->tax_nama . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <?php
      $ppn = 0.11;
      $byr_ppn = $val->inv_nominal * $ppn;
      ?>
      <div class="row form-group">
        <div class="col-md-4 control-label">Bayar PPN</div>
        <div class="col-md-7">
          <input type="text" class="form-control readonly" readonly value="<?php echo myNum($byr_ppn); ?>" maxlength="11" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">NTPN PPN</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="inv_ntpn" id="inv_ntpn">
            <option value=""> - Pilih - </option>
            <?php
            $ntpn = get_ntpn(array());
            if (count($ntpn) > 0) {
              foreach ($ntpn as $key => $value) {
                $sc = isset($val->inv_ntpn) ? $val->inv_ntpn : '';
                $se = ($sc == $value->pajak_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->pajak_id . "' $se >" . strtoupper($value->pajak_perihal) . "</option>";
              }
            } ?>
          </select>
          <!-- <input type="text" id="inv_ntpn" name="inv_ntpn" class="validate[required] form-control" value="<?php //echo isset($val->inv_ntpn)?$val->inv_ntpn:'';?>" maxlength="16" autocomplete="off"/> -->
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File Dokumen</div>
        <div class="col-md-7">
          <input type="file" id="inv_file" class="fileinput btn-primary" name="inv_file" />
          <?php if (isset($val->inv_file) && trim($val->inv_file) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/invoice/' . $val->inv_file); ?>" title="<?php echo $val->inv_file; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <select name="inv_status" id="inv_status" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('status') as $k1 => $v1) {
              $slc = isset($val) && trim($val->inv_status) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
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
  $(document).ready(function() {
    <?php if (isset($val)) { ?>
      get_nsfp(<?php echo $val->inv_tahun; ?>, <?php echo $val->inv_nsfp; ?>);
    <?php } ?>

    $('#inv_tahun').change(function() {
      get_nsfp($(this).val(), "")
    });
  });

  function get_nsfp(thn, fkr) {
    fkr = (typeof fkr == "undefined") ? "" : fkr;
    $.post("<?php echo site_url('ajax/data/faktur_pajak'); ?>", {
      thn: thn,
      fkr: fkr
    }, function(o) {
      $('#inv_nsfp').html(o);
    });
  }
</script>