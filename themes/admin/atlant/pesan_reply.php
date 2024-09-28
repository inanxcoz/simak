<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post">
  <div class="row col-md-12">
    <div class="row form-group">
      <div class="col-md-2 control-label">Tujuan Pesan</div>
      <div class="col-md-3">
        <select class="form-control select" name="tujuan_pesan" id="tujuan_pesan">
          <?php foreach ((array)get_user_chat() as $p) {
            $slc = $to == $p->user_id ? 'selected="selected"' : '';
            echo "<option value='" . $p->user_id . "' $slc >[" . $p->user_name . "] " . $p->user_fullname . "</option>";
          } ?>
        </select>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-2 control-label">Pesan</div>
      <div class="col-md-6">
        <textarea class="validate[required] form-control" name="isi_pesan"></textarea>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-2">
        <a href="<?php echo $own_links . "/message"; ?>">&larr; Kembali Ke Daftar Pesan</a>
      </div>
      <div class="col-md-6">
        <button type="submit" name="btn_kirim" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Kirim Pesan</button>
      </div>
    </div>
    <h4 class="heading-form">Isi Percakapan</h4>
    <table class="table table-hover table-bordered table-striped">
      <tbody>
        <?php
        foreach ((array)$list as $key => $value) {
          $tl = $value->msg_from_id != $this->jCfg['user']['id'] ? 'info' : 'warning';
        ?>
          <tr>
            <td <?php echo $value->msg_from_id != $this->jCfg['user']['id'] ? 'align="right"' : ''; ?>>
              <span style="font-size: 11px;"><span class="label label-<?php echo $tl; ?>"><?php echo $value->msg_from_name; ?></span>| <i style="font-size: 10px;color:#aaa;"><?php echo myDate($value->msg_date, "d M Y H:i:s"); ?></i></span>
              <p style="font-size: 13px;"><?php echo $value->msg_text; ?></p>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tujuan_pesan').change(function() {
      document.location = '<?php echo $own_links . "/message_reply/"; ?>' + $(this).val();
    });
  });
</script>