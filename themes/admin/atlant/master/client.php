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
                        <th>Nama Client</th>
                        <th>NPWP</th>
                        <th>Alamat NPWP</th>
                        <th>PIC</th>
                        <th>Handphone</th>
                        <th>Alamat Kantor</th>
                        <th>Status</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($data) > 0) {
                        foreach ($data as $r) { ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <td><?php echo strtoupper($r->client_nama); ?></td>
                                <td><?php echo $r->client_npwp; ?></td>
                                <td><?php echo strtoupper($r->client_alamat); ?></td>
                                <td><?php echo strtoupper($r->client_pic); ?></td>
                                <td><?php echo $r->client_hp; ?></td>
                                <td><?php echo strtoupper($r->client_kantor); ?></td>
                                <td><?php echo ($r->client_status == 1) ? '<span class="label label-info">Aktif</span>' : '<span class="label label-warning">Tidak Aktif</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->client_id)); ?></td>
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