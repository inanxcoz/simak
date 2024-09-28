<?php
$type = isset($_GET['type'])?trim($this->input->get('type')):'html';
if( $type == 'excel'){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Laporan_Data_User.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Data User</title>
	<style type="text/css">
        html{
          font-family: Montserrat;
          font-size: 13px;
        }
		.table{
			border-collapse: collapse;
		}
        .table thead tr th{
            padding:5px;
        }
        .table tbody tr td{
            padding:5px;
        }
        .str{
        	mso-number-format:\@;
        }
	</style>
</head>
<body>
<center>
	<h2>
		LAPORAN DATA USER<br>
		<?php echo cfg('app_name');?>
  	</h2>
  	<h4>
    	<?php echo cfg('app_alamat');?>, <?php echo cfg('app_kota');?><br>
    	<?php echo cfg('app_prov');?>, <?php echo cfg('app_telp');?>
  	</h3>
</center>
 <table class="table" border="1">
	   <thead>
	    <tr>
	        <th width="30px">No</th>
            <th width="50px">Photo</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No. Telp</th>
            <th>Role</th>
            <th>Status</th>
	    </tr>
	    </thead>
	   <tbody>
	   	<?php 
        if(count($data) > 0){
            foreach($data as $r){
                    $role = array();
                    $get_role = get_role($r->user_id);
                    foreach ((array)$get_role as $key => $value) {
                        $role[] = $value->ag_group_name;
                    }
                ?>
                <tr>
                    <td><?php echo ++$no;?></td>
                    <td>
                        <a href="<?php echo get_image(base_url()."assets/collections/user/".$r->user_photo);?>" title="Photo <?php echo $r->user_name;?>" class="act_modal" rel="600|350">
                            <img alt="" src="<?php echo get_image(base_url()."assets/collections/user/".$r->user_photo);?>" class="img-polaroid" style="height:30px;width:30px">
                        </a>
                    </td>
                    <td><?php echo $r->user_name;?></td>
                    <td><?php echo $r->user_fullname;?></td>
                    <td><?php echo $r->user_email;?></td>
                    <td class="str"><?php echo $r->user_telp;?></td>
                    <td><?php echo count($role)>0?implode(",",$role):'';?></td>
                    <td><?php echo ($r->user_status==1)?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                </tr>
        <?php } 
        }
        ?>
	    </tbody>
	</table>
<script>
    window.print();
</script>
</body>
</html>