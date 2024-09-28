<?php
$type = isset($_GET['type']) ? trim($this->input->get('type')) : 'html';
if ($type == 'excel') {
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Laporan_Data_Invoice_Aplika.xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
}
$judul = "LAPORAN DATA REKAPITULASI INVOICE";
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
				<th>NSFP</th>
				<th>No. Kontrak</th>
				<th>Tanggal</th>
				<th>No. Invoice</th>
				<th>Tertagih</th>
				<th>NPWP</th>
				<th>Perihal</th>
				<th>Nominal</th>
				<th>Status</th>
				<th>Tgl. Kirim</th>
				<th>Tgl. Bayar</th>
				<th>PPN</th>
				<th>PPH 23</th>
				<!-- <th>PPH 28 / 4(2)</th> -->
				<th>Payment</th>
				<th>Kode Billing</th>
				<th>NTPN</th>
				<th>Tgl. NTPN</th>
				<th>Nomor E-BUPOT</th>
				<th>Tgl. E-BUPOT</th>
			</tr>
		</thead>
		<tbody style="text-align: center;">
			<?php
			if (count($data) > 0) {
				$invoice = "";
				$no = 0;
				$ppn = 0.11;
				$pph = 0.02;
				$subppn = 0;
				$subpph = 0;
				$subpph_final = 0;
				$subTotal = 0;
				$subPayment = 0;
				foreach ($data as $r) {
					$byr_ppn = $r->inv_nominal * $ppn;
					$byr_pph = $r->inv_nominal * $pph;
					$byr_pph_final = $r->inv_nominal * $r->inv_pph;
					$payment = $r->inv_nominal + $byr_ppn - $byr_pph;
					$subTotal += $r->inv_nominal;
					$subppn += $byr_ppn;
					$subpph += $byr_pph;
					$subpph_final += $byr_pph_final;
					$subPayment += $payment;
			?>
					<?php if ($invoice != $r->inv_tahun) { ?>
						<tr>
							<td colspan="20" style="text-align: left;"><b>Tahun Invoice : <?php echo $r->inv_tahun; ?></b></td>
						</tr>
					<?php }
					$invoice = $r->inv_tahun; ?>
					<tr valign="top">
						<td><?php echo ++$no; ?></td>
						<td><?php echo $r->nsfp_nomor; ?></td>
						<td><?php echo $r->inv_spk; ?></td>
						<td><?php echo myDate($r->inv_tgl, "d M Y", false); ?></td>
						<td><?php echo $r->inv_nomor; ?></td>
						<td><?php echo $r->client_nama; ?></td>
						<td><?php echo $r->client_npwp; ?></td>
						<td style="text-align: left;"><?php echo $r->inv_perihal; ?></td>
						<?php
						if ($r->inv_status == 0) {
							$color = "style='text-align: right;background-color: #FEA223'";
						} else if ($r->inv_status == 1) {
							$color = "style='text-align: right;background-color: #95B75D'";
						} else if ($r->inv_status == 2) {
							$color = "style='text-align: right;background-color: #B64645'";
						} else if ($r->inv_status == 3) {
							$color = "style='text-align: right;background-color: #3FBAE4'";
						}
						?>
						<td <?= $color ?>><?php echo myNum($r->inv_nominal); ?></td>
						<td align="center"><?php echo get_status_data_html($r->inv_status); ?></td>
						<td><?php echo myDate($r->inv_tgl_kirim, "d M Y", false); ?></td>
						<td><?php echo myDate($r->inv_tgl_byr, "d M Y", false); ?></td>
						<td style="text-align: right;background-color: yellow;"><?php echo myNum($byr_ppn); ?></td>
						<td style="text-align: right;background-color: #90B456"><?php echo myNum($byr_pph); ?></td>
						<!-- <td style="text-align: right;background-color: #FEA223;"><?php echo myNum($byr_pph_final); ?></td> -->
						<td style="text-align: right;background-color: #B64645"><?php echo myNum($payment); ?></td>
						<td class="str"><?php echo $r->pajak_billing; ?></td>
						<td class="str"><?php echo $r->pajak_ntpn; ?></td>
						<td><?php echo myDate($r->pajak_tgl, "d M Y", false); ?></td>
						<td class="str"><?php echo $r->pajak_bupot; ?></td>
						<td><?php echo myDate($r->pajak_tgl_bupot, "d M Y", false); ?></td>
					</tr>
			<?php }
			} ?>
			<tr style="background-color: #33414E;text-align: center;color:#fff;">
				<td colspan="8"><b>GRAND TOTAL</b></td>
				<td><b><?php echo myNum($subTotal); ?></b></td>
				<td colspan="3"></td>
				<td><b><?php echo myNum($subppn); ?></b></td>
				<td><b><?php echo myNum($subpph); ?></b></td>
				<!-- <td><b><?php echo myNum($subpph_final); ?></b></td> -->
				<td><b><?php echo myNum($subPayment); ?></b></td>
				<td colspan="5"></td>
			</tr>
		</tbody>
	</table>
	<!-- <script>
    window.print();
</script> -->
</body>

</html>