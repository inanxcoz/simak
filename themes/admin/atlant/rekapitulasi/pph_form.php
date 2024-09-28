<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="pajak_id" id="pajak_id" value="<?php echo isset($val->pajak_id) ? $val->pajak_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Tahun</div>
        <div class="col-md-7">
          <select class="validate[required] form-control select" name="pajak_tahun" id="pajak_tahun">
            <option value=""> - Pilih - </option>
            <?php
            $tahun = get_tahun_pajak(array());
            if (count($tahun) > 0) {
              foreach ($tahun as $key => $value) {
                $sc = isset($val->pajak_tahun) ? $val->pajak_tahun : '';
                $se = ($sc == $value->tahun_angka) ? 'selected="selected"' : '';
                echo "<option value='" . $value->tahun_angka . "' $se >" . $value->tahun_angka . "</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Masa Pajak</div>
        <div class="col-md-7">
          <select name="pajak_masa" id="pajak_masa" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('bulan') as $k1 => $v1) {
              $slc = isset($val) && trim($val->pajak_masa) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Jenis Pajak dan Setoran</div>
        <div class="col-md-7">
          <select name="pajak_jenis" id="pajak_jenis" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('jenis_pajak') as $k1 => $v1) {
              $slc = isset($val) && trim($val->pajak_jenis) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nomor Ketetapan</div>
        <div class="col-md-7">
          <input type="text" id="pajak_ketetapan" name="pajak_ketetapan" class="validate[required] form-control" value="<?php echo isset($val->pajak_ketetapan) ? $val->pajak_ketetapan : '-'; ?>" maxlength="50" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Perihal</div>
        <div class="col-md-7">
          <textarea id="pajak_perihal" rows="3" name="pajak_perihal" class="validate[required] form-control"><?php echo isset($val->pajak_perihal) ? $val->pajak_perihal : ''; ?></textarea>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File Dokumen</div>
        <div class="col-md-7">
          <input type="file" id="pajak_file" class="fileinput btn-primary" name="pajak_file" />
          <?php if (isset($val->pajak_file) && trim($val->pajak_file) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/pph/' . $val->pajak_file); ?>" title="File <?php echo $val->pajak_file; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Jumlah Bayar</div>
        <div class="col-md-7">
          <input type="text" id="pajak_bayar" name="pajak_bayar" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->pajak_bayar) ? $val->pajak_bayar : 0; ?>" maxlength="9" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kode Billing</div>
        <div class="col-md-7">
          <input type="text" id="pajak_billing" name="pajak_billing" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->pajak_billing) ? $val->pajak_billing : '-'; ?>" maxlength="15" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal Bayar</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="pajak_tgl" name="pajak_tgl" class="validate[required] form-control datepicker" value="<?php echo isset($val->pajak_tgl) ? myDate($val->pajak_tgl, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kode NTPN</div>
        <div class="col-md-7">
          <input type="text" id="pajak_ntpn" name="pajak_ntpn" class="validate[required] form-control" value="<?php echo isset($val->pajak_ntpn) ? $val->pajak_ntpn : '-'; ?>" maxlength="16" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nomor Bukti Potong</div>
        <div class="col-md-7">
          <input type="text" id="pajak_bupot" name="pajak_bupot" class="validate[required] form-control" value="<?php echo isset($val->pajak_bupot) ? $val->pajak_bupot : '-'; ?>" maxlength="25" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tanggal Bukti Potong</div>
        <div class="col-md-7">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="pajak_tgl_bupot" name="pajak_tgl_bupot" class="validate[required] form-control datepicker" value="<?php echo isset($val->pajak_tgl_bupot) ? myDate($val->pajak_tgl_bupot, "Y-m-d", false) : date("Y-m-d"); ?>" />
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-7">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->pajak_status == 1 ? 'checked="checked"' : ''; ?> name="pajak_status" class="icheckbox validate[required]" value="1" /> Done</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->pajak_status == 0 ? 'checked="checked"' : ''; ?> name="pajak_status" class="icheckbox validate[required]" value="0" /> Progress</label>
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