<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Laporan_Data_Payment_Request_Aplika.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
}
$judul = "LAPORAN DATA REKAPITULASI PAYMENT REQUEST";
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $judul; ?></title>
	<style type="text/css">
		html {
			font-family: Lexend; /*Montserrat;*/
			font-size: 12px;
			color: #000;
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
		<thead style="background-color: #33414E;color:#fff;">
			<tr>
				<th>No</th>
				<th width="80">Date</th>
				<th>Rekening</th>
				<th width="110">Account</th>
				<th>Description</th>
				<th>Amount</th>
				<th>Tax</th>
				<th>Payment</th>
				<th>Status</th>
				<th>Dokumen</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (count($data) > 0) {
				$no = 0;
				$payment = "";
				$subTotal = 0;
				foreach ($data as $r) {
					$subAmount = $r->pb_qty * $r->pb_amount;
					$Tax = $subAmount * $r->pb_tax;
					$Total = $subAmount - $Tax;
					$subTotal += $Total;
			?>
				  <?php if ($payment != $r->payment_id) { ?>
	                <tr>
	                  <td colspan="10" style="text-align: left;"><b>Tahun : <?php echo $r->payment_tahun; ?> |
	                  	<?php echo $r->payment_kode; ?> |
	                  	<?php echo get_reference_data_html($r->payment_reference); ?> |
	                  	<?php echo strtoupper($r->vendor_nama); ?> |
	                  	<?php echo myDate($r->payment_dateentry, "d M", false); ?> - <?php echo myDate($r->payment_datepayment, "d M Y", false); ?> |
	                  	Status : <?php echo get_status_data_html($r->payment_status); ?></b></td>
	                </tr>
	              <?php }
	              $payment = $r->payment_id; ?>
					<tr valign="top" style="text-align: center;">
						<td><?php echo ++$no; ?></td>
						<td><?php echo myDate($r->pb_tgl, "d M Y", false); ?></td>
						<td class="str"><?php echo $r->pb_norek; ?></td>
						<td><?php echo $r->bank_nama; ?></td>
						<td style="text-align: left;"><?php echo $r->pb_text; ?></td>
						<?php if ($r->pb_status == 1) {
							$color = "style='text-align: center;background-color: #FEA223'";
						} else if ($r->pb_status == 2) {
							$color = "style='text-align: center;background-color: #95B75D'";
						} else if ($r->pb_status == 3) {
							$color = "style='text-align: center;background-color: #B64645'";
						} else if ($r->pb_status == 4) {
							$color = "style='text-align: center;background-color: #3FBAE4'";
						}
						?>
						<td style="text-align: right;"><?php echo myNum($r->pb_amount); ?></td>
						<td style="text-align: right;"><?php echo myNum($Tax); ?></td>
						<td style="text-align: right;"><?php echo myNum($Total); ?></td>
						<td <?= $color ?>>
							<?php if ($r->pb_status == 1) {
								echo "<span class='label label-warning'>" . $r->status_nama . "</span>";
							} else if ($r->pb_status == 2) {
								echo "<span class='label label-success'>" . $r->status_nama . "</span>";
							} else if ($r->pb_status == 3) {
								echo "<span class='label label-danger'>" . $r->status_nama . "</span>";
							} else if ($r->pb_status == 4) {
								echo "<span class='label label-info'>" . $r->status_nama . "</span>";
							}
							?>
						</td>
						 <td><?php if (isset($r->pb_file) && trim($r->pb_file) != "") { ?>
		                    <a href="<?php echo get_image(base_url() . 'assets/collections/payment/' . $r->pb_file); ?>" title="<?php echo $r->pb_file; ?>" class="act_modal btn btn-primary" rel="700|400" target="_blank">
		                      File
		                    </a>
		                  <?php } ?>
		                </td>
						<!--<td><?php //echo get_status_data_html($r->payment_status); 
								?></td>-->
					</tr>
			<?php }
			} ?>
			<tr style="background-color: #33414E;text-align: center;color:#fff;">
				<td colspan="7"><b>GRAND TOTAL</b></td>
				<td><b><?php echo myNum($subTotal); ?></b></td>
				<td colspan="2"></td>
			</tr>
		</tbody>
	</table>
	<!-- <script>
    window.print();
</script> -->
</body>

</html>