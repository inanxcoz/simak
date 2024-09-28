<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="kel_id" id="kel_id" value="<?php echo isset($val->kel_id) ? $val->kel_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Provinsi</div>
        <div class="col-md-8">
          <select class="validate[required] form-control select" name="kel_prov_id" id="kel_prov_id">
            <option value="">- Pilih -</option>
            <?php foreach ((array)get_provinsi() as $m) {
              $s = isset($val) && $val->kel_prov_id == $m->propinsi_id ? 'selected="selected"' : '';
              echo "<option value='" . $m->propinsi_id . "' $s >" . $m->propinsi_nama . "</option>";
            } ?>
          </select>
        </div>
      </div>
     <div class="row form-group">
        <div class="col-md-4 control-label">Nama Kabupaten/Kota</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="kel_kab_id" class="validate[required] form-control" id="kel_kab_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Kecamatan</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="kel_kec_id" class="validate[required] form-control" id="kel_kec_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Kelurahan</div>
        <div class="col-md-8">
          <input type="text" id="kel_nama" name="kel_nama" class="validate[required] form-control" value="<?php echo isset($val->kel_nama) ? $val->kel_nama : ''; ?>" maxlength="100" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kode Kelurahan</div>
        <div class="col-md-8">
          <input type="text" id="kel_kode" name="kel_kode" class="validate[required] form-control" value="<?php echo isset($val->kel_kode) ? $val->kel_kode : ''; ?>" maxlength="15" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kode Pos</div>
        <div class="col-md-8">
          <input type="number" id="kel_kode_pos" name="kel_kode_pos" class="validate[required] form-control" value="<?php echo isset($val->kel_kode_pos) ? $val->kel_kode_pos : ''; ?>" maxlength="5" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-8">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->kel_status == 1 ? 'checked="checked"' : ''; ?> name="kel_status" class="icheckbox validate[required]" value="1" /> Aktif</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->kel_status == 0 ? 'checked="checked"' : ''; ?> name="kel_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
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
      get_kab_city(<?php echo $val->kel_prov_id; ?>, <?php echo $val->kel_kab_id; ?>);
      get_kec_city(<?php echo $val->kel_prov_id; ?>, <?php echo $val->kel_kab_id; ?>, <?php echo $val->kel_kec_id; ?>);
    <?php } ?>

    $('#kel_prov_id').change(function() {
      get_kab_city($(this).val(), "")
      get_kec_city($(this).val(), "")
    });

    $('#kel_kab_id').change(function() {
      get_kec_city($('#kel_prov_id').val(), $(this).val(), "", "")
    });
  });

  function get_kab_city(prov, kab) {
    kab = (typeof kab == "undefined") ? "" : kab;
    $.post("<?php echo site_url('ajax/data/kabupaten'); ?>", {
      prov: prov,
      kab: kab
    }, function(o) {
      $('#kel_kab_id').html(o);
    });
  }

  function get_kec_city(prov, kab, kec) {
    kec = (typeof kec == "undefined") ? "" : kec;
    $.post("<?php echo site_url('ajax/data/kecamatan'); ?>", {
      prov: prov,
      kab: kab,
      kec: kec
    }, function(o) {
      $('#kel_kec_id').html(o);
    });
  }
</script>