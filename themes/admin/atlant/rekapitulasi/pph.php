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
                        <th>Masa Pajak</th>
                        <th>Jenis Pajak dan Setoran</th>
                        <th>Perihal</th>
                        <th>Nominal</th>
                        <th>Kode Billing</th>
                        <th>Tanggal Bayar</th>
                        <th>Kode NTPN</th>
                        <!-- <th>Nomor EBUPOT</th> -->
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php
                    if (count($data) > 0) {
                        $pajak = "";
                        foreach ($data as $r) {
                    ?>
                            <?php if ($pajak != $r->pajak_tahun) { ?>
                                <tr>
                                    <td colspan="12" style="text-align: left;"><b>Tahun Pajak : <?php echo $r->pajak_tahun; ?></b></td>
                                </tr>
                            <?php }
                            $pajak = $r->pajak_tahun; ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <td><?php echo get_bulan_data_html($r->pajak_masa); ?></td>
                                <td><?php echo get_pajak_data_html($r->pajak_jenis); ?></td>
                                <td><?php echo $r->pajak_perihal; ?></td>
                                <?php
                                if ($r->pajak_status == 0) {
                                    $color = "style='text-align: right;background-color: #FEA223'";
                                } else if ($r->pajak_status == 1) {
                                    $color = "style='text-align: right;background-color: #3FBAE4'";
                                }
                                ?>
                                <td <?= $color ?>><?php echo myNum($r->pajak_bayar); ?></td>
                                <td><?php echo $r->pajak_billing; ?></td>
                                <td><?php echo myDate($r->pajak_tgl, "d M Y", false); ?></td>
                                <td><?php echo $r->pajak_ntpn; ?></td>
                               <!--  <td><?php echo $r->pajak_bupot; ?></td> -->
                                <td><?php if (isset($r->pajak_file) && trim($r->pajak_file) != "") { ?>
                                        <a href="<?php echo get_image(base_url() . 'assets/collections/pph/' . $r->pajak_file); ?>" target="_blank" title="<?php echo $r->pajak_file; ?>" class="label label-default">
                                            File
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><?php echo ($r->pajak_status == 1) ? '<span class="label label-info">Done</span>' : '<span class="label label-warning">Progress</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->pajak_id)); ?></td>
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