<div class="row">
  <table class="table table-hover table-bordered table-striped">
    <tbody>
      <tr>
        <td colspan="3"><b>INFO LOGIN</b></td>
      </tr>
      <tr>
        <td width="150">Username</td>
        <td width="5">:</td>
        <td><?php echo $data->user_name; ?></td>
      </tr>
      <tr>
        <td width="150">Password</td>
        <td width="5">:</td>
        <td>********** &rarr;<a href="<?php echo site_url('meme/me/change_password'); ?>">Ganti Password</a></td>
      </tr>
      <tr>
        <td colspan="3"><b>INFO USER</b></td>
      </tr>
      <tr>
        <td colspan="3">
          <a href="<?php echo get_image(base_url() . "assets/collections/user/" . $data->user_photo); ?>" title="Photo <?php echo $data->user_name; ?>" class="act_modal" rel="600|350">
            <img alt="" src="<?php echo get_image(base_url() . "assets/collections/user/" . $data->user_photo); ?>" class="img-polaroid" style="height:100px;width:100px">
          </a>
        </td>
      </tr>
      <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><?php echo $data->user_fullname; ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td>:</td>
        <td><?php echo $data->user_email; ?></td>
      </tr>
      <tr>
        <td>No Tlp</td>
        <td>:</td>
        <td><?php echo $data->user_telp; ?></td>
      </tr>
      <tr>
        <td>Role</td>
        <td>:</td>
        <td><?php
            $role = array();
            $get_role = get_role($data->user_id);
            foreach ((array)$get_role as $key => $value) {
              $role[] = $value->ag_group_name;
            }
            ?>
          <?php echo count($role) > 0 ? implode(",", $role) : ''; ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<br />
<div class="panel-footer">
  <div class="pull-left">
    <button type="button" onclick="document.location='<?php echo $own_links; ?>'" class="btn btn-warning btn-cons">Cancel</button>
  </div>
  <div class="pull-right">
    <a href="<?php echo site_url('meme/me/edit_profile'); ?>" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Update Profile</a>
  </div>
</div>