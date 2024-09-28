<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="nsfp_id" id="nsfp_id" value="<?php echo isset($val->nsfp_id) ? $val->nsfp_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Tahun</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="nsfp_tahun_id" id="nsfp_tahun_id">
            <option value="">- Pilih -</option>
            <?php foreach ((array)get_tahun_pajak() as $m) {
              $s = isset($val) && $val->nsfp_tahun_id == $m->tahun_angka ? 'selected="selected"' : '';
              echo "<option value='" . $m->tahun_angka . "' $s >" . $m->tahun_angka . "</option>";
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nomor Seri Faktur Pajak</div>
        <div class="col-md-7">
          <input type="text" id="nsfp_nomor" name="nsfp_nomor" class="validate[required] form-control" value="<?php echo isset($val->nsfp_nomor) ? $val->nsfp_nomor : ''; ?>" maxlength="19" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->nsfp_status == 1 ? 'checked="checked"' : ''; ?> name="nsfp_status" class="icheckbox validate[required]" value="1" /> Digunakan</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->nsfp_status == 0 ? 'checked="checked"' : ''; ?> name="nsfp_status" class="icheckbox validate[required]" value="0" /> Tidak Digunakan</label>
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