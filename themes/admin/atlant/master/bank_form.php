<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="bank_id" id="bank_id" value="<?php echo isset($val->bank_id) ? $val->bank_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Peserta</div>
        <div class="col-md-8">
          <input type="text" id="bank_peserta" name="bank_peserta" class="validate[required] form-control" value="<?php echo isset($val->bank_peserta) ? $val->bank_peserta : ''; ?>" maxlength="60" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Bank</div>
        <div class="col-md-8">
          <input type="text" id="bank_nama" name="bank_nama" class="validate[required] form-control" value="<?php echo isset($val->bank_nama) ? $val->bank_nama : ''; ?>" maxlength="60" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">BIC Peserta</div>
        <div class="col-md-8">
          <input type="text" id="bank_bic" name="bank_bic" class="validate[required] form-control" value="<?php echo isset($val->bank_bic) ? $val->bank_bic : ''; ?>" maxlength="8" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Sandri Kliring</div>
        <div class="col-md-8">
          <input type="text" id="bank_kliring" name="bank_kliring" class="validate[required] form-control" value="<?php echo isset($val->bank_kliring) ? $val->bank_kliring : ''; ?>" maxlength="7" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->bank_status == 1 ? 'checked="checked"' : ''; ?> name="bank_status" class="icheckbox validate[required]" value="1" /> Aktif</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->bank_status == 0 ? 'checked="checked"' : ''; ?> name="bank_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
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