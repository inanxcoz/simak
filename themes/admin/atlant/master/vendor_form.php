<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo isset($val->vendor_id) ? $val->vendor_id : ''; ?>" />
  <div class="row">
    <div class="col-md-6">
      <!-- <div class="row form-group">  
          <div class="col-md-3 control-label">Photo</div>               
          <div class="col-md-8">
            <input type="file" id="vendor_photo" class="fileinput btn-primary" name="vendor_photo" />
              <?php // if( isset($val->vendor_photo) && trim($val->vendor_photo)!="" ){
              ?>
              <a href="<?php // echo get_image(base_url()."assets/collections/vendor/".$val->vendor_photo);?>" title="Image Photo" class="act_modal" rel="700|400">
                <img alt="" src="<?php // echo get_image(base_url()."assets/collections/vendor/".$val->vendor_photo);?>" style="height:25px;width:25px" class="img-polaroid">
              </a>
              <?php // } 
              ?>
          </div>              
      </div> -->
      <div class="row form-group">
        <div class="col-md-3 control-label">Kode Vendor</div>
        <div class="col-md-8">
          <!--<?php
              /*$koneksi = mysqli_connect('localhost','root','','db_payment');
            $query = mysqli_query($koneksi, "SELECT MAX(vendor_kode) as kodeTerbesar FROM app_vendor");
            $data = mysqli_fetch_array($query);
            $kodeBarang = $data['kodeTerbesar'];
            $urutan = (int) substr($kodeBarang, 4, 3);1
            $urutan++;
            $huruf = "VAMN";
            $kodeBarang = $huruf . sprintf("%03s", $urutan);*/
              ?>-->
          <!-- <input type="text" id="vendor_kode" name="vendor_kode" class="validate[required] form-control" value="<?php //echo $kodeBarang;?>" maxlength="7" /> -->
          <input type="text" id="vendor_kode" name="vendor_kode" class="validate[required] form-control" value="<?php echo isset($val->vendor_kode) ? $val->vendor_kode : 'VAMN'; ?>" maxlength="7" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Nama Vendor</div>
        <div class="col-md-8">
          <input type="text" id="vendor_nama" name="vendor_nama" class="validate[required] form-control" value="<?php echo isset($val->vendor_nama) ? $val->vendor_nama : ''; ?>" maxlength="50" autocomplete="off" />
        </div>
      </div>
      <!-- <div class="row form-group">  
        <div class="col-md-3 control-label">Handphone</div>               
        <div class="col-md-4">
          <input type="text" id="vendor_hp" name="vendor_hp" class="validate[required,custom[number]] form-control" value="<?php // echo isset($val->vendor_hp)?$val->vendor_hp:'';?>" maxlength="12" />
        </div>              
      </div>  -->
      <!-- <div class="row form-group">  
        <div class="col-md-3 control-label">Email</div>               
        <div class="col-md-5">
          <input type="email" id="vendor_email" name="vendor_email" class="validate[required,custom[email]] form-control" value="<?php // echo isset($val->vendor_email)?$val->vendor_email:'';?>" maxlength="30" />
        </div>              
      </div> -->
    </div>
    <div class="col-md-6">
      <!-- <div class="row form-group">  
        <div class="col-md-3 control-label">Alamat</div>               
        <div class="col-md-8">
          <textarea id="vendor_alamat" name="vendor_alamat" class="validate[required] form-control" rows="4"><?php // echo isset($val->vendor_alamat)?$val->vendor_alamat:'';?></textarea>
        </div>              
      </div> -->
      <div class="row form-group">
        <div class="col-md-3 control-label">Nomor Rekening</div>
        <div class="col-md-5">
          <input type="text" id="vendor_norek" name="vendor_norek" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->vendor_norek) ? $val->vendor_norek : ''; ?>" maxlength="15" autocomplete="off" />
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Bank</div>
        <div class="col-md-5">
          <select class="validate[required] form-control select" name="vendor_bank_id" id="vendor_bank_id">
            <option value=""> - Pilih - </option>
            <?php
            $bank = get_bank(array());
            if (count($bank) > 0) {
              foreach ($bank as $key => $value) {
                $sc = isset($val->vendor_bank_id) ? $val->vendor_bank_id : '';
                $se = ($sc == $value->bank_id) ? 'selected="selected"' : '';
                echo "<option value='" . $value->bank_id . "' $se >" . $value->bank_nama . "</option>";
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-3 control-label">Status</div>
        <div class="col-md-8">
          <label class="check"><input type="radio" <?php echo isset($val) && $val->vendor_status == 1 ? 'checked="checked"' : ''; ?> name="vendor_status" class="icheckbox validate[required]" value="1" /> Aktif</label>&nbsp &nbsp &nbsp
          <label class="check"><input type="radio" <?php echo isset($val) && $val->vendor_status == 0 ? 'checked="checked"' : ''; ?> name="vendor_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
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