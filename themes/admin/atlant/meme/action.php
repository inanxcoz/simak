<?php getFormSearch();
$rumus = cfg('tipe_rumus');
?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Access Control Action</h3>
            <span>Data Access Control Action dari <?php echo cfg('app_name'); ?> (<?php echo $cRec; ?>)</span>
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
                        <th width="30px">aca_id</th>
                        <th>aca_access_id</th>
                        <th>aca_action_id</th>
                        <th>app_id</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($data) > 0) {
                        foreach ($data as $r) { ?>
                            <tr>
                                <td><?php echo $r->aca_id; ?></td>
                                <td><?php echo $r->aca_access_id; ?> = <?php echo $r->acc_menu; ?></td>
                                <td><?php echo $r->aca_action_id; ?> = <?php echo get_action_data_html($r->aca_action_id); ?></td>
                                <td><?php echo $r->app_id; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->aca_id)); ?></td>
                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="pull-right">
    <?php echo isset($paging) ? $paging : ''; ?>
</div>