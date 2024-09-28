<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=Laporan_AccessControl.xls");  //File name extension was wrong
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Laporan Access Control</title>
  <style type="text/css">
    html {
      font-family: Lexend; /*Montserrat;*/
      font-size: 12px;
    }

    .table {
      border-collapse: collapse;
    }

    .table thead tr th {
      padding: 5px;
    }

    .table tbody tr td {
      padding: 5px;
    }

    .str {
      mso-number-format: \@;
    }
  </style>
</head>

<body>
  <center>
    <h3>
      LAPORAN DATA BANK<br>
      <?php echo cfg('app_name'); ?>
    </h3>
    <h4>
      <?php echo cfg('app_alamat'); ?>, <?php echo cfg('app_kota'); ?><br>
      <?php echo cfg('app_prov'); ?>, <?php echo cfg('app_telp'); ?>
    </h4>
  </center>
  <table class="table" border="1">
    <thead style="background-color: #33414E;text-align: center;color:#fff;">
      <tr>
        <th>acc_id</th>
        <th>acc_group</th>
        <th>acc_menu</th>
        <th>acc_group_controller</th>
        <th>acc_controller_name</th>
        <th>acc_access_name</th>
        <th>acc_description</th>
        <th>acc_by_order</th>
        <th>app_id</th>
        <th>acc_css_class</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (count($data) > 0) {
        $no = 0;
        foreach ($data as $r) { ?>
          <tr valign="top">
            <td><?php echo $r->acc_id; ?></td>
            <td><?php echo $r->acc_group; ?></td>
            <td><?php echo $r->acc_menu; ?></td>
            <td><?php echo $r->acc_group_controller; ?></td>
            <td><?php echo $r->acc_controller_name; ?></td>
            <td><?php echo $r->acc_access_name; ?></td>
            <td><?php echo $r->acc_description; ?></td>
            <td><?php echo $r->acc_by_order; ?></td>
            <td><?php echo $r->app_id; ?></td>
            <td><?php echo $r->acc_css_class; ?></td>
          </tr>
      <?php }
      } ?>
    </tbody>
  </table>
  <script>
    window.print();
  </script>
</body>

</html>