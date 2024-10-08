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
                        <th>Nomor Seri Faktur Pajak</th>
                        <th>Status</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php
                    if (count($data) > 0) {
                        $tahun = "";
                        foreach ($data as $r) { ?>
                            <?php if ($tahun != $r->nsfp_tahun_id) { ?>
                                <tr>
                                    <td colspan="5" style="text-align: left;"><b>Tahun : <?php echo $r->nsfp_tahun_id; ?></b></td>
                                </tr>
                            <?php }
                            $tahun = $r->nsfp_tahun_id; ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <td><?php echo $r->nsfp_nomor; ?></td>
                                <td><?php echo ($r->nsfp_status == 1) ? '<span class="label label-info">Digunakan</span>' : '<span class="label label-warning">Tidak Digunakan</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->nsfp_id)); ?></td>
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