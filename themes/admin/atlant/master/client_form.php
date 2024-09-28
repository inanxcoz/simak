<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="client_id" id="client_id" value="<?php echo isset($val->client_id) ? $val->client_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Client</div>
        <div class="col-md-8">
          <input type="text" id="client_nama" name="client_nama" class="validate[required] form-control" value="<?php echo isset($val->client_nama) ? $val->client_nama : ''; ?>" maxlength="50" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">NPWP</div>
        <div class="col-md-8">
          <input type="text" id="client_npwp" name="client_npwp" class="validate[required] form-control" value="<?php echo isset($val->client_npwp) ? $val->client_npwp : ''; ?>" maxlength="20" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Alamat NPWP</div>
        <div class="col-md-8">
          <textarea id="client_alamat" rows="5" name="client_alamat" class="validate[required] form-control"><?php echo isset($val->client_alamat) ? $val->client_alamat : ''; ?></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Alamat Kantor</div>
        <div class="col-md-8">
          <textarea id="client_kantor" rows="5" name="client_kantor" class="validate[required] form-control"><?php echo isset($val->client_kantor) ? $val->client_kantor : ''; ?></textarea>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">PIC</div>
        <div class="col-md-8">
          <input type="text" id="client_pic" name="client_pic" class="validate[required] form-control" value="<?php echo isset($val->client_pic) ? $val->client_pic : ''; ?>" maxlength="25" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Handphone</div>
        <div class="col-md-8">
          <input type="text" id="client_hp" name="client_hp" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->client_hp) ? $val->client_hp : ''; ?>" maxlength="12" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->client_status == 1 ? 'checked="checked"' : ''; ?> name="client_status" class="icheckbox validate[required]" value="1" /> Aktif</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->client_status == 0 ? 'checked="checked"' : ''; ?> name="client_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
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