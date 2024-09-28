<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="karyawan_id" id="karyawan_id" value="<?php echo isset($val->karyawan_id) ? $val->karyawan_id : ''; ?>">
  <div class="row">
    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">NIP & NIK</div>
        <div class="col-md-4">
          <input type="text" id="karyawan_nip" name="karyawan_nip" class="validate[required] form-control" value="<?php echo isset($val->karyawan_nip) ? $val->karyawan_nip : ''; ?>" maxlength="6" autocomplete="off" placeholder="NIP">
        </div>
        <div class="col-md-4">
          <input type="text" id="karyawan_nik" name="karyawan_nik" class="validate[required] form-control" value="<?php echo isset($val->karyawan_nik) ? $val->karyawan_nik : ''; ?>" maxlength="17" autocomplete="off" placeholder="NIK">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Karyawan</div>
        <div class="col-md-8">
          <input type="text" id="karyawan_nama" name="karyawan_nama" class="validate[required] form-control" value="<?php echo isset($val->karyawan_nama) ? $val->karyawan_nama : ''; ?>" maxlength="100" autocomplete="off" placeholder="Nama Karyawan">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Tempat & Tanggal Lahir</div>
        <div class="col-md-4">
          <input type="text" id="karyawan_tempat_lahir" name="karyawan_tempat_lahir" class="validate[required,custom[onlyLetterSp]] form-control" value="<?php echo isset($val->karyawan_tempat_lahir) ? $val->karyawan_tempat_lahir : ''; ?>" maxlength="40" autocomplete="off" placeholder="Tempat Lahir">
        </div>
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            <input type="text" id="karyawan_tgl_lahir" name="karyawan_tgl_lahir" class="validate[required] form-control datepicker" value="<?php echo isset($val->karyawan_tgl_lahir) ? myDate($val->karyawan_tgl_lahir, "Y-m-d", false) : date("Y-m-d"); ?>">
          </div>
        </div>
      </div>      
      <div class="row form-group">
        <div class="col-md-4 control-label">Jenis Kelamin & Agama</div>
        <div class="col-md-4">
          <select name="karyawan_gender" id="karyawan_gender" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('jenis_kelamin') as $k1 => $v1) {
              $slc = isset($val) && trim($val->karyawan_gender) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <select name="karyawan_agama" id="karyawan_agama" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('agama') as $k1 => $v1) {
              $slc = isset($val) && trim($val->karyawan_agama) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Perkawinan & NPWP</div>
        <div class="col-md-4">
          <select name="karyawan_kawin" id="karyawan_kawin" class="validate[required] form-control select">
            <option value=""> - Pilih - </option>
            <?php
            foreach ((array)cfg('perkawinan') as $k1 => $v1) {
              $slc = isset($val) && trim($val->karyawan_kawin) == $k1 ? 'selected="selected"' : '';
              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" id="karyawan_npwp" name="karyawan_npwp" class="validate[required] form-control" value="<?php echo isset($val->karyawan_npwp) ? $val->karyawan_npwp : ''; ?>" maxlength="20" autocomplete="off" placeholder="NPWP">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">No. BPJS-TK & No. BPJS-JKN</div>
        <div class="col-md-4">
          <input type="text" id="karyawan_bpjstk" name="karyawan_bpjstk" class="validate[required] form-control" value="<?php echo isset($val->karyawan_bpjstk) ? $val->karyawan_bpjstk : ''; ?>" maxlength="12" autocomplete="off" placeholder="No. BPJS-TK">
        </div>
        <div class="col-md-4">
          <input type="text" id="karyawan_bpjs" name="karyawan_bpjs" class="validate[required] form-control" value="<?php echo isset($val->karyawan_bpjs) ? $val->karyawan_bpjs : ''; ?>" maxlength="14" autocomplete="off" placeholder="No. BPJS-JKN">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Handphone</div>
        <div class="col-md-4">
          <input type="text" id="karyawan_telp" name="karyawan_telp" class="validate[required] form-control" value="<?php echo isset($val->karyawan_telp) ? $val->karyawan_telp : ''; ?>" maxlength="13" autocomplete="off" placeholder="Handphone">
        </div>
        
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Email</div>
        <div class="col-md-4">
          <input type="email" id="karyawan_email" name="karyawan_email" class="validate[required,custom[email]] form-control" value="<?php echo isset($val->karyawan_email) ? $val->karyawan_email : ''; ?>" maxlength="50" autocomplete="off" placeholder="Email 1">
        </div>
        <div class="col-md-4">
          <input type="email" id="karyawan_email2" name="karyawan_email2" class="validate[required,custom[email]] form-control" value="<?php echo isset($val->karyawan_email2) ? $val->karyawan_email2 : ''; ?>" maxlength="50" autocomplete="off" placeholder="Email 2">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Nama Ibu Kandung</div>
        <div class="col-md-8">
          <input type="text" id="karyawan_ibu_kandung" name="karyawan_ibu_kandung" class="validate[required] form-control" value="<?php echo isset($val->karyawan_ibu_kandung) ? $val->karyawan_ibu_kandung : ''; ?>" maxlength="100" autocomplete="off" placeholder="Nama Ibu Kandung">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File KTP</div>
        <div class="col-md-8">
          <input type="file" id="karyawan_file_ktp" class="fileinput btn-primary" name="karyawan_file_ktp" />
          <?php if (isset($val->karyawan_file_ktp) && trim($val->karyawan_file_ktp) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $val->karyawan_file_ktp); ?>" title="File <?php echo $val->karyawan_file_ktp; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File NPWP</div>
        <div class="col-md-8">
          <input type="file" id="karyawan_file_npwp" class="fileinput btn-primary" name="karyawan_file_npwp" />
          <?php if (isset($val->karyawan_file_npwp) && trim($val->karyawan_file_npwp) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $val->karyawan_file_npwp); ?>" title="File <?php echo $val->karyawan_file_npwp; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File BPJS-TK</div>
        <div class="col-md-8">
          <input type="file" id="karyawan_file_bjpstk" class="fileinput btn-primary" name="karyawan_file_bjpstk" />
          <?php if (isset($val->karyawan_file_bjpstk) && trim($val->karyawan_file_bjpstk) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $val->karyawan_file_bjpstk); ?>" title="File <?php echo $val->karyawan_file_bjpstk; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="row form-group">
        <div class="col-md-4 control-label">Alamat Domisili</div>
        <div class="col-md-8">
          <textarea id="karyawan_domisili" rows="4" name="karyawan_domisili" class="validate[required] form-control"><?php echo isset($val->karyawan_domisili) ? $val->karyawan_domisili : ''; ?></textarea>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Alamat KTP</div>
        <div class="col-md-8">
          <input type="text" id="karyawan_alamat" name="karyawan_alamat" class="validate[required] form-control" value="<?php echo isset($val->karyawan_alamat) ? $val->karyawan_alamat : ''; ?>" maxlength="255" autocomplete="off" placeholder="Alamat">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Rt/Rw</div>
        <div class="col-md-4">
          <input type="text" id="karyawan_rt" name="karyawan_rt" class="validate[required] form-control" value="<?php echo isset($val->karyawan_rt) ? $val->karyawan_rt : ''; ?>" maxlength="3" autocomplete="off" placeholder="Rt">
        </div>
        <div class="col-md-4">
          <input type="text" id="karyawan_rw" name="karyawan_rw" class="validate[required] form-control" value="<?php echo isset($val->karyawan_rw) ? $val->karyawan_rw : ''; ?>" maxlength="3" autocomplete="off" placeholder="Rw">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Provinsi</div>
        <div class="col-md-8">
          <select class="validate[required] form-control select" name="karyawan_prov_id" id="karyawan_prov_id">
            <option value="">- Pilih -</option>
            <?php foreach ((array)get_provinsi() as $m) {
              $s = isset($val) && $val->karyawan_prov_id == $m->propinsi_id ? 'selected="selected"' : '';
              echo "<option value='" . $m->propinsi_id . "' $s >" . $m->propinsi_nama . "</option>";
            } ?>
          </select>
        </div>
      </div>
     <div class="row form-group">
        <div class="col-md-4 control-label">Kabupaten/Kota</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="karyawan_kab_id" class="validate[required] form-control" id="karyawan_kab_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Kecamatan</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="karyawan_kec_id" class="validate[required] form-control" id="karyawan_kec_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>
       <div class="row form-group">
        <div class="col-md-4 control-label">Kelurahan</div>
        <div class="col-md-8" style="margin-left:0px;">
          <select name="karyawan_kel_id" class="validate[required] form-control" id="karyawan_kel_id">
            <option value="">- Pilih -</option>
          </select>
        </div>
      </div>      
      <div class="row form-group">
        <div class="col-md-4 control-label">File BPJS-JKN</div>
        <div class="col-md-8">
          <input type="file" id="karyawan_file_bjps" class="fileinput btn-primary" name="karyawan_file_bjps" />
          <?php if (isset($val->karyawan_file_bjps) && trim($val->karyawan_file_bjps) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $val->karyawan_file_bjps); ?>" title="File <?php echo $val->karyawan_file_bjps; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">File Photo</div>
        <div class="col-md-8">
          <input type="file" id="karyawan_file_photo" class="fileinput btn-primary" name="karyawan_file_photo" />
          <?php if (isset($val->karyawan_file_photo) && trim($val->karyawan_file_photo) != "") { ?>
            <a href="<?php echo get_image(base_url() . 'assets/collections/karyawan/' . $val->karyawan_file_photo); ?>" title="File <?php echo $val->karyawan_file_photo; ?>" class="act_modal btn btn-info" rel="700|400">
              File
            </a>
          <?php } ?>
          <div class="help-block">Max File 5Mb, File Support (Jpg,Png,Pdf,Zip)</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 control-label">Status</div>
        <div class="col-md-8">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->karyawan_status == 1 ? 'checked="checked"' : ''; ?> name="karyawan_status" class="icheckbox validate[required]" value="1"> Pegawai</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->karyawan_status == 0 ? 'checked="checked"' : ''; ?> name="karyawan_status" class="icheckbox validate[required]" value="0"> Bukan Pegawai</label>
        </div>
      </div>
    </div>
  </div>
  <br>
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
      get_kab_city(<?php echo $val->karyawan_prov_id; ?>, <?php echo $val->karyawan_kab_id; ?>);
      get_kec_city(<?php echo $val->karyawan_prov_id; ?>, <?php echo $val->karyawan_kab_id; ?>, <?php echo $val->karyawan_kec_id; ?>);
      get_kel_city(<?php echo $val->karyawan_prov_id; ?>, <?php echo $val->karyawan_kab_id; ?>, <?php echo $val->karyawan_kec_id; ?>, <?php echo $val->karyawan_kel_id; ?>);
    <?php } ?>

    $('#karyawan_prov_id').change(function() {
      get_kab_city($(this).val(), "")
      get_kec_city($(this).val(), "")
      get_kel_city($(this).val(), "")
    });

    $('#karyawan_kab_id').change(function() {
      get_kec_city($('#karyawan_prov_id').val(), $(this).val(), "", "")
      $('#karyawan_kel_id').html('<option value="">- Pilih -</option>')
    });

    $('#karyawan_kec_id').change(function() {
      get_kel_city($('#karyawan_prov_id').val(), $('#karyawan_kab_id').val(), $(this).val(), "")
      //console.log($('#karyawan_prov_id').val());
    });
  });

  function get_kab_city(prov, kab) {
    kab = (typeof kab == "undefined") ? "" : kab;
    $.post("<?php echo site_url('ajax/data/kabupaten'); ?>", {
      prov: prov,
      kab: kab
    }, function(o) {
      $('#karyawan_kab_id').html(o);
    });
  }

  function get_kec_city(prov, kab, kec) {
    kec = (typeof kec == "undefined") ? "" : kec;
    $.post("<?php echo site_url('ajax/data/kecamatan'); ?>", {
      prov: prov,
      kab: kab,
      kec: kec
    }, function(o) {
      $('#karyawan_kec_id').html(o);
    });
  }

  function get_kel_city(prov, kab, kec, kel) {
    kel = (typeof kel == "undefined") ? "" : kel;
    $.post("<?php echo site_url('ajax/data/kelurahan'); ?>", {
      prov: prov,
      kab: kab,
      kec: kec,
      kel: kel      
    }, function(o) {
      $('#karyawan_kel_id').html(o);
    });
  }
</script>