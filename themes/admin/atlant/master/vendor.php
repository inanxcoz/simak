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
                        <!-- <th>Photo</th> -->
                        <th>Kode Vendor</th>
                        <th>Nama Vendor</th>
                        <th>No. Rekening</th>
                        <th>Bank</th>
                        <th>Status</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php
                    if (count($data) > 0) {
                        foreach ($data as $r) { ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <!-- <td>
                              <a href="<?php echo get_image(base_url() . "assets/collections/dokter/" . $r->vendor_photo); ?>" title="<?php echo $r->vendor_nama; ?>" class="act_modal" rel="600|350">
                              <img alt="" src="<?php echo get_image(base_url() . "assets/collections/dokter/" . $r->vendor_photo); ?>" class="img-polaroid" style="height:30px;width:30px">
                              </a>
                          </td> -->
                                <td><?php echo strtoupper($r->vendor_kode); ?></td>
                                <td style="text-align: left;"><?php echo strtoupper($r->vendor_nama); ?></td>
                                <td><?php echo $r->vendor_norek; ?></td>
                                <td><?php echo $r->bank_nama; ?></td>
                                <td><?php echo ($r->vendor_status == 1) ? '<span class="label label-info">Aktif</span>' : '<span class="label label-warning">Tidak Aktif</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->vendor_id)); ?></td>
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