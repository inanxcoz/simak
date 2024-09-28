<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="tahun_id" id="tahun_id" value="<?php echo isset($val->tahun_id) ? $val->tahun_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Tahun</div>
        <div class="col-md-7">
          <input type="text" id="tahun_angka" name="tahun_angka" class="validate[required] form-control" value="<?php echo isset($val->tahun_angka) ? $val->tahun_angka : ''; ?>" maxlength="19" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->tahun_status == 1 ? 'checked="checked"' : ''; ?> name="tahun_status" class="icheckbox validate[required]" value="1" /> Digunakan</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->tahun_status == 0 ? 'checked="checked"' : ''; ?> name="tahun_status" class="icheckbox validate[required]" value="0" /> Tidak Digunakan</label>
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