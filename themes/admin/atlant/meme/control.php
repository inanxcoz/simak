<?php getFormSearch();
$rumus = cfg('tipe_rumus');
?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Access Control</h3>
            <span>Data Access Control dari <?php echo cfg('app_name'); ?> (<?php echo $cRec; ?>)</span>
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
                        <th width="30px">acc_id</th>
                        <th>acc_group</th>
                        <th>acc_menu</th>
                        <th>acc_group_controller</th>
                        <th>acc_controller_name</th>
                        <th>acc_access_name</th>
                        <!-- <th>acc_description</th> -->
                        <th>acc_by_order</th>
                        <!-- <th>app_id</th> -->
                        <th>acc_css_class</th>
                        <th width="85">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($data) > 0) {
                        foreach ($data as $r) { ?>
                            <tr>
                                <td><?php echo $r->acc_id; ?></td>
                                <td><?php echo $r->acc_group; ?></td>
                                <td><?php echo $r->acc_menu; ?></td>
                                <td><?php echo $r->acc_group_controller; ?></td>
                                <td><?php echo $r->acc_controller_name; ?></td>
                                <td><?php echo $r->acc_access_name; ?></td>
                                <!-- <td><?php echo $r->acc_description; ?></td> -->
                                <td><?php echo $r->acc_by_order; ?></td>
                                <!-- <td><?php echo $r->app_id; ?></td> -->
                                <td><?php echo $r->acc_css_class; ?></td>
                                <td align="right"><?php link_action($links_table_item, "?_id=" . _encrypt($r->acc_id)); ?></td>
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