<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($val->user_id)?$val->user_id:'';?>" />
        <div class="row">
          <div class="col-md-5">


             <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Lengkap</div>
              <div class="col-md-7">
                <input type="text" id="user_fullname" name="user_fullname" class="validate[required,custom[onlyLetterSp]] form-control" maxlength="50" value="<?php echo isset($val->user_fullname)?$val->user_fullname:'';?>" autocomplete="off"/>
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Email</div>
              <div class="col-md-7">
                <input type="text" id="user_email" name="user_email" class="validate[required,custom[email]] form-control" maxlength="50" value="<?php echo isset($val->user_email)?$val->user_email:'';?>" autocomplete="off"/>
              </div> 
            </div> 

            <div class="row form-group">  
              <div class="col-md-5 control-label">No. Telp</div>
              <div class="col-md-7">
                <input type="text" id="user_telp" name="user_telp" class="validate[required,custom[number]] form-control" maxlength="12" value="<?php echo isset($val->user_telp)?$val->user_telp:'';?>" autocomplete="off"/>
              </div>
            </div>

            

            <div class="row form-group">
              <div class="col-md-5 control-label">Photo</div>
              <div class="col-md-7">
                  <input type="file" id="user_photo" class="fileinput btn-primary" name="user_photo" />
                  <?php if( isset($val->user_photo) && trim($val->user_photo)!="" ){?>
                  <a href="<?php echo get_image(base_url()."assets/collections/user/".$val->user_photo);?>" title="Image Photo" class="act_modal" rel="700|400">
                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/user/".$val->user_photo);?>" style="height:25px;width:25px" class="img-polaroid">
                  </a>
                  <?php } ?>
              </div> 
            </div>

            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                <label class="check"><input type="radio" <?php echo isset($val)&&$val->user_status==1?'checked="checked"':'';?> name="user_status" class="icheckbox validate[required]" value="1"/> Aktif</label>&nbsp &nbsp &nbsp
                 <label class="check"><input type="radio" <?php echo isset($val)&&$val->user_status==0?'checked="checked"':'';?> name="user_status" class="icheckbox validate[required]" value="0" /> Tidak Aktif</label>
              </div> 
            </div>

          </div> 

          <div class="col-md-6">

            <div class="row form-group">
              <div class="col-md-5 control-label">Role</div>
              <div class="col-md-7" style="margin-left:0px;">

                  <select name="user_group" class="form-control validate[required] select" id="user_group">
                    <option value=""> - pilih -</option>
                  <?php
                  foreach($group as $r){
                    $tmp = isset($role)&&count($role)>0?$role:array(0);
                    $s = in_array($r->ag_id, $tmp)?"selected='selected'":'';
                    if($this->jCfg['user']['is_all'] == 1){
                        echo "<option value='".$r->ag_id."' $s >".$r->ag_group_name."</option>";
                    }else{
                      //if( trim($r->ag_id)!=1 & trim($r->ag_id)!=4){
                      if( trim($r->ag_id)!=1){
                        echo "<option value='".$r->ag_id."' $s >".$r->ag_group_name."</option>";
                      }
                    }
                  }
                  ?>
                  </select>

              </div> 
            </div>

           <div class="row form-group">
              <div class="col-md-5 control-label">Username</div>
                <div class="col-md-7">
                    <?php if(!isset($val->user_name)){?>
              <input type="text" id="user_name" name="user_name" 
              class="validate[required,length[0,15]] form-control" maxlength="20"
              size="40" value="<?php echo isset($val->user_name)?$val->user_name:'';?>" autocomplete="off"/>
              <div class="help-block"><i>* Jangan menggunakan spasi</i></div>
            <?php }else{ 
              ?>
              <input type="text" class="validate[required,length[0,15]] form-control" value="<?php echo isset($val->user_name)?$val->user_name:'';?>" readonly="true" style="background-color: #fff;border:none;color:#333;font-weight: bold;" name="user_name" autocomplete="off"/>
              <?php
            }?>

                </div> 
              </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Password</div>
              <div class="col-md-7">

                   <input type="password" id="user_password" name="user_password" class="<?php echo isset($val->user_password)?']':'validate[required,length[6,20]]';?> form-control" value="" autocomplete="off"/>

              </div> 
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Confirm Password</div> 
              <div class="col-md-7">

                   <input type="password" id="user_password2" name="user_password2" class="<?php echo isset($val->user_password)?'validate[equals[user_password]]':'validate[required,equals[user_password]]';?> form-control"  value="" autocomplete="off"/>

              </div> 
            </div> 


          </div>       
        </div>
        <br />
        
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-warning btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
          </div>
        </div>

</form>

<!-- <script type="text/javascript">

$(document).ready(function(){
  
  <?php if( isset($val) ){?>
    get_kabupaten(<?php echo $val->user_propinsi;?>,<?php echo $val->user_kabupaten;?>);
  <?php } ?>

  $('#user_propinsi').change(function(){
    get_kabupaten($(this).val(),"")
  });

});

function get_kabupaten(prop,kab){
  kab = (typeof kab == "undefined")?"":kab;
  $.post("<?php echo site_url('ajax/data/kota');?>",{prop:prop,kab:kab},function(o){
    $('#user_kabupaten').html(o);
  });
}

</script> -->
