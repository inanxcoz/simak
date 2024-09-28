<div class="col-md-12">
  <a href="<?php echo $own_links . "/message_reply"; ?>" class="btn btn-success pull-right"><i class="fa fa-envelope"></i> Kirim Pesan </a>
  <div style="clear:both;"></div>
  <h4 class="heading-form">Isi Percakapan</h4>
  <table class="table table-hover table-bordered table-striped" s>
    <tbody>
      <?php
      foreach ((array)$data as $key => $value) {
        $reply_to = $value->msg_from_id;
        if ($this->jCfg['user']['id'] == $value->msg_from_id) {
          $reply_to = $value->msg_to_id;
        }
      ?>
        <tr <?php echo $value->msg_is_read == 0 ? 'style="color:red;"' : ''; ?>>
          <td width="150"><u><?php echo word_limiter($value->msg_from_name, 2, '..'); ?></u> <br />to <u><?php echo word_limiter($value->msg_to_name, 2, '..'); ?></u></td>
          <td width="100"><?php echo myDate($value->msg_date, "d M Y H:i:s"); ?></td>
          <td><?php echo $value->msg_text; ?></td>
          <td width="100"><a href="<?php echo $own_links . "/message_reply/" . $reply_to; ?>" class="btn btn-info"><i class="fa fa-reply"></i> Balas</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php echo isset($paging) ? $paging : ''; ?>
</div>