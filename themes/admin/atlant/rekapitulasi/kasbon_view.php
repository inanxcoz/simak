  <div class="row">
    <h2 class="heading-form" style="text-align: center;"><b>KASBON</b></h2>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Nama Peminjam</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo isset($val) ? get_karyawan_name($val->kasbon_nama_id) : ''; ?></b></td>
          </tr>
          <tr>
            <td>Tanggal Pinjam</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo myDate($val->kasbon_tgl, "d F Y", false); ?></b></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Jumlah Pinjam</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo myNum($val->kasbon_nominal); ?></b></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td style="text-align: center;">:</td>
            <td><b><?php echo $val->kasbon_uraian; ?></b></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-4">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <tr>
            <td>Status</td>
            <td style="text-align: center;">:</td>
            <td><?php echo get_status_data_html($val->kasbon_status); ?></td>
          </tr>
          <tr>
            <td>Action</td>
            <td style="text-align: center;">:</td>
            <td><span class='label label-danger'><a onclick="print()" style="color:white;font-size: 14px;">PRINT</a></span></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <h2 class="heading-form">Detail Kasbon</h2>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <tr>
            <th>Angsuran</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody style="text-align: center;">
          <?php
          if (isset($cicilan)) {
            $subTotal = 0;
            foreach ((array)$cicilan as $k => $v) {
              $subTotal += $v->kd_nominal;
              $subSisa = $val->kasbon_nominal - $subTotal;
          ?>
              <tr>
                <td><?php echo isset($val) ? get_cicilan_name($v->kd_cicilan_id) : ''; ?>
                <td><?php echo myDate($v->kd_tgl, "d F Y", false); ?></td>
                <td><?php echo isset($val) ? get_status_name($v->kd_status) : ''; ?></td>
                <td><?php echo myNum($v->kd_nominal); ?></td>
              </tr>
          <?php }
          } ?>
          <tr>
            <td colspan="3"><b>Total Bayar</b></td>
            <td><b><?php echo myNum($subTotal); ?></b></td>
          </tr>
          <tr>
            <td colspan="3"><b>Sisa Bayar</b></td>
            <td><b><?php echo myNum($subSisa); ?></b></td>
          </tr>
          <tr>
            <td colspan="3"><b>Status Bayar</b></td>
            <td><?php if ($subSisa == 0) {
                  $status = 'LUNAS';
                } else {
                  $status = 'BELUM LUNAS';
                } ?>
              <b><?php echo $status; ?></b>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- <script>
    window.print();
</script> -->