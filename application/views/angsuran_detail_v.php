<!-- Styler -->
<style type="text/css">
	.panel * {
		font-family: "Arial","​Helvetica","​sans-serif";
	}
	.fa {
		font-family: "FontAwesome";
	}
	.datagrid-header-row * {
		font-weight: bold;
	}
	.messager-window * a:focus, .messager-window * span:focus {
		color: blue;
		font-weight: bold;
	}
	.daterangepicker * {
		font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
		box-sizing: border-box;
	}
	.glyphicon	{font-family: "Glyphicons Halflings"}
	.form-control {
		height: 20px;
		padding: 4px;
	}	

	th {
		text-align: center; 
		background: #4834d4;
		height: 30px;
		border-width: 1px;
		border-style: solid;
		color :#ffffff;
	}
</style>
<!-- Styler -->
<style type="text/css">
	.panel * {
		font-family: "Arial","​Helvetica","​sans-serif";
	}
	.fa {
		font-family: "FontAwesome";
	}
	.datagrid-header-row * {
		font-weight: bold;
	}
	.messager-window * a:focus, .messager-window * span:focus {
		color: blue;
		font-weight: bold;
	}
	.daterangepicker * {
		font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
		box-sizing: border-box;
	}
	.glyphicon	{font-family: "Glyphicons Halflings"}
	.form-control {
		height: 20px;
		padding: 4px;
	}	

	th {
		text-align: center;
		background: #4834d4;
		height: 30px;
		border-width: 1px;
		border-style: solid;
		color :#ffffff;
	}
</style>

<!-- buaat tanggal sekarang -->
<?php 
$tagihan = $row_pinjam->ags_per_bulan * $row_pinjam->lama_angsuran;
$dibayar = $hitung_dibayar->total;
$jml_denda=$hitung_denda->total_denda;
$sisa_bayar = $tagihan - $dibayar;
$total_bayar = $sisa_bayar + $jml_denda;
?> 

<!-- menu atas -->
<?php
echo '<a href="'.site_url().'/pinjaman" class="btn btn-sm btn-danger" title="Kembali"> <i class="glyphicon glyphicon-circle-arrow-left"></i> Kembali </a>

<a href="'.site_url('cetak_pinjaman_detail').'/cetak/' . $row_pinjam->id . '"  title="Cetak Detail" class="btn btn-sm btn-success" target="_blank"> <i class="glyphicon glyphicon-print"></i> Cetak Detail</a>
<a href="'.site_url('angsuran/index').'/'.$row_pinjam->id . '"  title="Bayar" class="btn btn-sm btn-primary"> <i class="fa fa-money"></i> Bayar Angsuran</a>'
;
	echo ' <a href="'.site_url('angsuran_lunas').'/index/'.$row_pinjam->id.'" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Validasi Lunas</a>';
?>
<p></p>
<!-- detail data anggota -->
<div class="box box-solid box-primary">
	<div class="box-header" title="Detail Pinjaman" data-toggle="" data-original-title="Detail Pinjaman">
		<h3 class="box-title"> Detail Pinjaman </h3> 
		<div class="box-tools pull-right">
			<button class="btn btn-primary btn-xs" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<table style="font-size: 13px; width:100%">
			<tr>
				<td style="width:10%; text-align:center;">
					<?php
					$photo_w = 3 * 30;
					$photo_h = 4 * 30;
					if($data_anggota->file_pic == '') {
						echo '<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
					} else {
						echo '<img src="'.base_url().'uploads/anggota/' . $data_anggota->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
					}
					?>
				</td> 
				<td>
					<table style="width:100%">
						<tr>
							<td><label class="text-green">Data Anggota</label></td>
						</tr>
						<?php //echo 'AG' . sprintf('%04d', $row_pinjam->anggota_id) . '' ?>
						<tr>
							<td> ID Anggota</td>
							<td> : </td>
							<td> <?php echo $data_anggota->identitas; ?></td>
						</tr>
						<tr>
							<td> Nama Anggota </td>
							<td> : </td>
							<td> <?php echo $data_anggota->nama; ?></td>
						</tr>
						<tr>
							<td> Dept </td>
							<td> : </td>
							<td> <?php echo $data_anggota->departement; ?></td>
						</tr>
						<tr>
							<td> Tempat, Tanggal Lahir  </td>
							<td> : </td>
							<td> <?php echo $data_anggota->tmp_lahir .', '. jin_date_ina ($data_anggota->tgl_lahir); ?></td>
						</tr>
						<tr>
							<td> Kota Tinggal</td> 
							<td> : </td>
							<td> <?php echo $data_anggota->kota; ?></td>
						</tr>
					</table>
				</td>
				<td>
					<table style="width:100%">
						<tr>
							<td><label class="text-green">Data Pinjaman</label></td>
						</tr>
						<tr>
							<td> Kode Pinjam</td>
							<td> : </td>
							<td> <?php echo 'TPJ' . sprintf('%05d', $row_pinjam->id) . '' ?> </td>
						</tr>
						<tr>
							<td> Tanggal Pinjam</td>
							<td> : </td>
							<td> <?php 
								$tanggal_arr = explode(' ', $row_pinjam->tgl_pinjam);
								$txt_tanggal_p = jin_date_ina($tanggal_arr[0], 'full');
								echo  $txt_tanggal_p; 
								?>
							</td>
						</tr>
						<tr>
							<td> Tanggal Tempo</td>
							<td> : </td>
							<td> <?php 
								$tanggal_arr = explode(' ', $row_pinjam->tempo);
								$txt_tanggal_t = jin_date_ina($tanggal_arr[0], 'full');
								echo  $txt_tanggal_t; 
								?>
							</td>
						</tr>
						<tr>
							<td> Lama Pinjaman</td> 
							<td> : </td>
							<td> <?php echo $row_pinjam->lama_angsuran; ?> Bulan</span></td>
						</tr>
					</table>
				</td>
				<td>
					<table style="width:100%">
						<tr>
							<td>
								<label></label>
							</td>
						</tr>
						<tr>
							<td> Pokok Pinjaman</td>
							<td> : </td>
							<td class="h_kanan"> <?php echo number_format(nsi_round($row_pinjam->jumlah))?></td>
						</tr>
						<tr>
							<td> Angsuran Pokok </td>
							<td> : </td>
							<td class="h_kanan"> <?php echo number_format($row_pinjam->pokok_angsuran); ?></td>
						</tr>
						<tr>
							<td> Angsuran Bunga</td>
							<td> : </td>
							<td class="h_kanan"> <?php echo number_format(($row_pinjam->biaya_adm) + ($row_pinjam->bunga_pinjaman)); ?></td>
						</tr>
						<tr>
							<td> Jumlah Angsuran </td> 
							<td> : </td>
							<td class="h_kanan"><?php echo number_format(nsi_round($row_pinjam->ags_per_bulan)); ?></td>
						</tr>
					</table>
				</td>			
			</tr>
		</table>
	</div>

	<div class="box box-solid bg-light-blue">
		<table width="100%" style="font-size: 12px;">
			<tr>
				<td><strong> Detail Pembayaran </strong> &raquo; </td>
				<td> Sisa Angsuran : <span id="det_sisa_ags"> <?php echo $row_pinjam->lama_angsuran - $sisa_ags; ?> </span> Bulan </td>

				<td> Dibayar : Rp. <span id="det_sudah_bayar"> <?php echo number_format(nsi_round($dibayar)); ?></span> </td>



<!-- edit -->
<!--  -->
<!-- edit -->


				



				<td> Denda : Rp. <span id="det_jml_denda"> <?php echo  number_format(nsi_round($jml_denda)); ?> </span> </td>
				<td> Sisa Tagihan Rp. <span id="total_bayar"> <?php echo  number_format(nsi_round($total_bayar)); ?> </span> </td>
				<td> Status Pelunasan : <span id="ket_lunas"> <?php echo $row_pinjam->lunas; ?> </span> </td>
			</code>
		</tr>
	</table>
</div>
</div>

<label class="text-green"> Simulasi Tagihan :</label>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:10%; vertical-align: middle"> Bln ke</th>
		<th style="width:15%; vertical-align: middle"> Angsuran Pokok</th>
		<th style="width:15%; vertical-align: middle"> Angsuran Bunga</th>
		<th style="width:15%; vertical-align: middle"> Denda</th>
		<th style="width:30%; vertical-align: middle"> Jumlah Angsuran</th>
		<th style="width:20%; vertical-align: middle"> Tanggal Tempo</th>
	</tr>


<?php //var_dump($simulasi_tagihan); 
if(!empty($simulasi_tagihan)) {
	$no = 1;
	$row = array();
	$jml_pokok = 0;
	$jml_bunga = 0;
	$jml_ags = 0;
	$jml_adm = 0;
	$jml_denda = 0;
	foreach ($simulasi_tagihan as $row) {
		if(($no % 2) == 0) {
			$warna="#FAFAD2";
		} else {
			$warna="#FFFFFF";
		}

		$txt_tanggal = jin_date_ina($row['tgl_tempo']);
		$jml_pokok += $row['angsuran_pokok'];
		$jml_bunga += $row['bunga_pinjaman'];
		$jml_adm += $row['biaya_adm'];
		$jml_ags += $row['jumlah_ags'];
		$jml_denda += $row->denda_rp;
		$byr_pokok += $row->bayar_pokok;
		$byr_bunga += $row->bayar_bunga;

		$sisa_pokok = $jml_pokok - $byr_pokok;

		echo '
			<tr bgcolor='.$warna.'>
				<td class="h_tengah">'.$no.'</td>
				<td class="h_kanan">'.number_format(nsi_round($row['angsuran_pokok'])).'</td>
				<td class="h_kanan">'.number_format(nsi_round($row['bunga_pinjaman'])).'</td>
				<td class="h_kanan">'.number_format(nsi_round($row['biaya_adm'])).'</td>
				<td class="h_kanan">'.number_format(nsi_round($row['jumlah_ags'])).'</td>
				<td class="h_tengah">'.$txt_tanggal.'</td>
			</tr>';

		$no++;
	}
	echo '<tr bgcolor="#eee">
				<td class="h_tengah"><strong>Jumlah</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_pokok)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_bunga)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_ags)).'</strong></td>
				<td></td>
			</tr>';
	echo '<tr bgcolor="#eee">
				<td class="h_tengah"><strong>Sisa</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_pokok)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_bunga)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_ags)).'</strong></td>
				<td></td>
			</tr>
		</table>';
}
?>


<label class="text-green"> Detail Transaksi Pembayaran :</label>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle " > No. </th>
		<th style="width:12%; vertical-align: middle"> Kode Bayar</th>
		<th style="width:13%; vertical-align: middle"> Tanggal Bayar</th>
		<th style="width:5%; vertical-align: middle"> Angsuran Ke </th>
		<!-- <th style="width:15%; vertical-align: middle"> Jenis Pembayaran </th> -->
		<th style="width:15%; vertical-align: middle"> Bayar Pokok</th>
		<th style="width:15%; vertical-align: middle"> Bayar Bunga</th>
		
		<th style="width:10%; vertical-align: middle"> Denda  </th>
		<th style="width:15%; vertical-align: middle"> Jumlah Bayar</th>
		<th style="width:10%; vertical-align: middle"> User  </th>
	</tr>

	<?php 

	$mulai=1;
	$no=1;
	$jml_tot = 0;
	$byr_tot = 0;
	
	$jml_denda = 0;

	if(empty($angsuran)) {
		echo '<code> Tidak Ada Transaksi Pembayaran</code>';
	} else {

		foreach ($angsuran as $row) {
			if(($no % 2) == 0) {
				$warna="#FAFAD2";
			} else {
				$warna="#FFFFFF";
			}

			$tgl_bayar = explode(' ', $row->tgl_bayar);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);
			$jml_tot += $row->jumlah_bayar;
			$jml_denda += $row->denda_rp;

			$byr_pokok += $row->bayar_pokok;
			$byr_bunga += $row->bayar_bunga;
			$byr_tot1 = $byr_pokok + $byr_bunga;

			$sisa_pokok = $jml_pokok - $byr_pokok;
			$sisa_bunga = $jml_bunga - $byr_bunga;
			echo '
			<tr bgcolor='.$warna.'>
				<td class="h_tengah">'.$no++.'</td>
				<td class="h_tengah">'.'TBY'.sprintf('%05d', $row->id).'</td>
				<td class="h_tengah">'.$txt_tanggal.'</td>
				<td class="h_tengah">'.$row->angsuran_ke.'</td>
				
				<td class="h_kanan">'.number_format(nsi_round($row->bayar_pokok)).'</td>
				<td class="h_kanan">'.number_format(nsi_round($row->bayar_bunga)).'</td>
				
				<td class="h_kanan">'.number_format(nsi_round($row->denda_rp)).'</td>
				<td class="h_kanan">'.number_format(nsi_round($row->bayar_pokok + $row->bayar_bunga)).'</td>
				<td class="h_tengah">'.$row->user_name.'</td>


			</tr>';
			/*<td class="h_kanan">'.number_format(nsi_round($row->jumlah_bayar)).'</td>*/
			$no++;
		}
		echo '<tr bgcolor="#eee">
			<td class="h_tengah" colspan="4"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($byr_pokok)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($byr_bunga)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($byr_tot1)).'</strong></td>
			</tr>';
		echo '<tr bgcolor="#eee">
			<td class="h_tengah" colspan="4"><strong>Sisa Pinjaman</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_pokok)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_bunga)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($total_bayar)).'</strong></td>
			</tr>'; 



		'</table>';

		// <td class="h_kanan"><strong>'.number_format(nsi_round($jml_ptotal)).'</strong></td>
		// <td class="h_kanan"><strong>'.number_format(nsi_round($jml_btotal)).'</strong></td>
		
	}
?>