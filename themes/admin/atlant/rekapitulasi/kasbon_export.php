<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Laporan_Data_Rekap_Kasbon.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
}
$judul = "LAPORAN DATA REKAPITULASI KASBON";
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $judul; ?></title>
	<style type="text/css">
		html {
			font-family: Lexend; /*Montserrat;*/
			font-size: 12px;
		}

		.table {
			border-collapse: collapse;
		}

		.table thead tr th {
			padding: 5px;
		}

		.table tbody tr td {
			padding: 5px;
		}

		.str {
			mso-number-format: \@;
		}
	</style>
</head>

<body>
	<center>
		<h3>
			<?php echo $judul; ?><br>
			<?php echo cfg('app_name'); ?>
		</h3>
		<h4>
			<?php echo cfg('app_alamat'); ?>, <?php echo cfg('app_kota'); ?><br>
			<?php echo cfg('app_prov'); ?>, <?php echo cfg('app_telp'); ?>
		</h4>
	</center>
	<table class="table" border="1">
		<thead style="background-color: #33414E;text-align: center;color:#fff;">
			<tr>
				<th>No</th>
				<th>Cicilan</th>
				<th>Tanggal Bayar</th>
				<th>Jumlah Bayar</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody style="text-align: center;">
			<?php
			if (count($data) > 0) {
				$no = 0;
				$kasbon = "";
				foreach ($data as $r) {
			?>
					<?php if ($kasbon != $r->kasbon_id) { ?>
						<tr>
							<td colspan="6" style="text-align: left;">
								<b>Nama : <?php echo $r->karyawan_nama; ?> |
									Tanggal : <?php echo myDate($r->kasbon_tgl, "d F Y", false); ?> |
									Jumlah : <?php echo myNum($r->kasbon_nominal); ?> |
									Keterangan : <?php echo $r->kasbon_uraian; ?>
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
					</tr>
			<?php }
			} ?>
		</tbody>
	</table>
	<script>
		window.print();
	</script>
</body>

</html>