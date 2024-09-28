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
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat/Tgl. Lahir</th>
                        <th>Alamat KTP</th>
                        <th>No. Handphone</th>
                        <th>Email</th>
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
                                <td><?php echo strtoupper($r->karyawan_nik); ?></td>
                                <td><?php echo strtoupper($r->karyawan_nama); ?></td>
                                <td><?php echo strtoupper($r->karyawan_tempat_lahir); ?>, <?php echo myDate($r->karyawan_tgl_lahir, "d F Y", false); ?></td>
                                <!-- <td><?php echo get_jenis_kelamin($r->karyawan_gender); ?></td> -->
                                <td><?php echo strtoupper($r->karyawan_alamat); ?>
                                    RT. <?php echo strtoupper($r->karyawan_rt); ?>/RW. <?php echo strtoupper($r->karyawan_rw); ?>
                                    KEL. <?php echo strtoupper($r->kel_nama); ?>,
                                    KEC. <?php echo strtoupper($r->kec_nama); ?>,
                                    KAB. <?php echo strtoupper($r->kab_nama); ?>,
                                    PROV. <?php echo strtoupper($r->propinsi_nama); ?>
                                    Kode Pos <?php echo strtoupper($r->kel_kode_pos); ?>
                                </td>
                                <!-- <td><?php echo get_kawin($r->karyawan_kawin); ?></td> -->
                                <td><?php echo strtoupper($r->karyawan_telp); ?></td>
                                <td><?php echo $r->karyawan_email; ?></td>
                                <td><?php echo ($r->karyawan_status == 1) ? '<span class="label label-info">Pegawai</span>' : '<span class="label label-warning">Bukan Pegawai</span>'; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->karyawan_id)); ?></td>
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