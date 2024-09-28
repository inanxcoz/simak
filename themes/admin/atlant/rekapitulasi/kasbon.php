<?php getFormSearch(); ?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel <?php echo isset($title) ? $title : ''; ?></h3>
            <span>Data <?php echo isset($title) ? $title : ''; ?> dari <?php echo cfg('app_name'); ?> (<?php echo $cRec; ?>) </span>
        </div>
        <ul class="panel-controls" style="margin-top: 2px;">
            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
            <li><a href="<?php echo current_url(); ?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
        </ul>
    </div>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Cicilan</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php
                    if (count($data) > 0) {
                        $kasbon = "";
                        foreach ($data as $r) {
                    ?>
                            <?php if ($kasbon != $r->kasbon_id) { ?>
                                <tr>
                                    <td colspan="6" style="text-align: left;">
                                        <b>Nama Peminjam : <?php echo $r->karyawan_nama; ?> |
                                            Tanggal Pinjam : <?php echo myDate($r->kasbon_tgl, "d F Y", false); ?> |
                                            Jumlah Pinjam : <?php echo myNum($r->kasbon_nominal); ?> |
                                            Keterangan : <?php echo $r->kasbon_uraian; ?> |
                                            Status : <?php echo get_status_data_html($r->kasbon_status); ?>
                                        </b>
                                    </td>
                                </tr>
                            <?php }
                            $kasbon = $r->kasbon_id; ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <td><?php echo $r->cicilan_nama; ?></td>
                                <td><?php echo myDate($r->kd_tgl, "d F Y", false); ?></td>
                                <td><?php echo myNum($r->kd_nominal); ?></td>
                                <td><?php
                                    if ($r->kd_status == 1) {
                                      echo "<span class='label label-warning'>" . $r->status_nama . "</span>";
                                    } else if ($r->kd_status == 2) {
                                      echo "<span class='label label-success'>" . $r->status_nama . "</span>";
                                    } else if ($r->kd_status == 3) {
                                      echo "<span class='label label-danger'>" . $r->status_nama . "</span>";
                                    } else if ($r->kd_status == 4) {
                                      echo "<span class='label label-info'>" . $r->status_nama . "</span>";
                                    }
                                    ?>
                                </td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->kasbon_id)); ?></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="pull-right">
    <?php echo isset($paging) ? $paging : ''; ?>
</div>