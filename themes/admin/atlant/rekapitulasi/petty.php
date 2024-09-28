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
                        <th>Perihal</th>
                        <th>Nota</th>
                        <th width="100">Tanggal</th>
                        <!-- <th>Jumlah</th> -->
                        <th>Nominal</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <!-- <th>Saldo</th> -->
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th width="70">Action</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php
                    if (count($data) > 0) {
                        $petty       = "";
                        $Debet       = 0;
                        $Saldo       = 0;
                        $TotalDebet  = 0;
                        $TotalKredit = 0;
                        $TotalSaldo  = 0;
                        foreach ($data as $r) {
                            $Debet       = $r->petty_qty * $r->petty_debet;
                            $Kredit      = $r->petty_kredit;
                            $Saldo       += $Debet + $Kredit;
                            $TotalDebet  += $Debet;
                            $TotalKredit += $Kredit;
                            $TotalSaldo  += $Saldo;
                    ?>
                            <?php if ($petty != myDate($r->petty_tgl, "F", false)) { ?>
                                <tr>
                                    <td colspan="11" style="text-align: left;"><b>Tahun : <?php echo $r->petty_tahun; ?> | Bulan : <?php echo myDate($r->petty_tgl, "F", false); ?></b></td>
                                </tr>
                            <?php }
                            $petty = myDate($r->petty_tgl, "F", false); ?>
                            <tr valign="top">
                                <td><?php echo ++$no; ?></td>
                                <td style="text-align: left;"><?php echo $r->petty_perihal; ?></td>
                                <td><?php echo $r->petty_nota; ?></td>
                                <td><?php echo myDate($r->petty_tgl, "d M Y", false); ?></td>
                                <!-- <td><?php echo myNum($r->petty_qty); ?></td> -->
                                <td style="text-align: right;"><?php echo myNum($r->petty_debet); ?></td>
                                <td style="text-align: right;background-color: #36B7E3;"><?php echo myNum($Debet); ?></td>
                                <td style="text-align: right;background-color: #FEA223;"><?php echo myNum($r->petty_kredit); ?></td>
                                <!-- <td style="text-align: right;"><?php echo myNum($Saldo); ?></td> -->
                                <td><?php if (isset($r->petty_file) && trim($r->petty_file) != "") { ?>
                                        <a href="<?php echo get_image(base_url() . 'assets/collections/petty/' . $r->petty_file); ?>" title="<?php echo $r->petty_file; ?>" class="label label-default" target="_blank">
                                            File
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><?php echo ($r->petty_status == 1) ? '<span class="label label-info">Done</span>' : '<span class="label label-warning">Progress</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->petty_id)); ?></td>
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