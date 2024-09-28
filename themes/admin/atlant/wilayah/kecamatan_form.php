<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="kec_id" id="kec_id" value="<?php echo isset($val->kec_id) ? $val->kec_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Provinsi</div>
        <div class="col-md-8">
          <select class="validate[required] form-control select" name="kec_prov_id" id="kec_prov_id">
            <option value="">- Pilih -</option>
            <?php foreach ((array)get_provinsi() as $m) {
              $s = isset($val) && $val->kec_prov_id == $m->propinsi_id ? 'selected="selected"' : '';
              echo "<option value='" . $m->propinsi_id . "' $s >" . $m->propinsi_nama . "</option>";
            } ?>
          </select>
        </div>
      </div>
     <div class="row form-group">
        <div class="col-md-4 control-label">Nama Kabupaten/Kota</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="kec_kab_id" class="validate[required] form-control" id="kec_kab_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Kecamatan</div>
        <div class="col-md-8">
          <input type="text" id="kec_nama" name="kec_nama" class="validate[required] form-control" value="<?php echo isset($val->kec_nama) ? $val->kec_nama : ''; ?>" maxlength="100" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kode Kecamatan</div>
        <div class="col-md-8">
          <input type="text" id="kec_kode" name="kec_kode" class="validate[required] form-control" value="<?php echo isset($val->kec_kode) ? $val->kec_kode : ''; ?>" maxlength="60" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-8">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->kec_status == 1 ? 'checked="checked"' : ''; ?> name="kec_status" class="icheckbox validate[required]" value="1" /> Aktif</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->kec_status == 0 ? 'checked="checked"' : ''; ?> name="kec_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
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
      get_kab_city(<?php echo $val->kec_prov_id; ?>, <?php echo $val->kec_kab_id; ?>);
    <?php } ?>

    $('#kec_prov_id').change(function() {
      get_kab_city($(this).val(), "")
    });
  });

  function get_kab_city(prov, kab) {
    kab = (typeof kab == "undefined") ? "" : kab;
    $.post("<?php echo site_url('ajax/data/kabupaten'); ?>", {
      prov: prov,
      kab: kab
    }, function(o) {
      $('#kec_kab_id').html(o);
    });
  }
</script>