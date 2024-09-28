<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="petty_id" id="petty_id" value="<?php echo isset($val->petty_id) ? $val->petty_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Tahun</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="petty_tahun" id="petty_tahun">
            <option value=""> - Pilih - </option>
            <?php
            $tahun = get_tahun_pajak(array());
            if (count($tahun) > 0) {
              foreach ($tahun as $key => $value) {
                $sc = isset($val->petty_tahun) ? $val->petty_tahun : '';
                $se = ($sc == $value->tahun_angka) ? 'selected="selected"' : '';
                echo "<option value='" . $value->tahun_angka . "' $se >" . $value->tahun_angka . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Perihal</div>
        <div class="col-md-7">
          <textarea id="petty_perihal" rows="3" name="petty_perihal" class="validate[required] form-control"><?php echo isset($val->petty_perihal) ? $val->petty_perihal : ''; ?></textarea>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Type</div>
        <div class="col-md-7">
          <select name="petty_nota" id="petty_nota" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('nota') as $k1 => $v1) {
              $slc = isset($val) && trim($val->petty_nota) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="petty_tgl" name="petty_tgl" class="validate[required] form-control datepicker" value="<?php echo isset($val->petty_tgl) ? myDate($val->petty_tgl, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Qty</div>
        <div class="col-md-7">
          <input type="text" id="petty_qty" name="petty_qty" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->petty_qty) ? $val->petty_qty : 0; ?>" maxlength="3" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Debet</div>
        <div class="col-md-7">
          <input type="text" id="petty_debet" name="petty_debet" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->petty_debet) ? $val->petty_debet : 0; ?>" maxlength="8" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kredit</div>
        <div class="col-md-7">
          <input type="text" id="petty_kredit" name="petty_kredit" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->petty_kredit) ? $val->petty_kredit : 0; ?>" maxlength="8" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File Dokumen</div>
        <div class="col-md-7">
          <input type="file" id="petty_file" class="fileinput btn-primary" name="petty_file" />
          <?php if (isset($val->petty_file) && trim($val->petty_file) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/petty/' . $val->petty_file); ?>" title="File <?php echo $val->petty_file; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->petty_status == 1 ? 'checked="checked"' : ''; ?> name="petty_status" class="icheckbox validate[required]" value="1" /> Done</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->petty_status == 0 ? 'checked="checked"' : ''; ?> name="petty_status" class="icheckbox validate[required]" value="0" /> Progress</label>
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