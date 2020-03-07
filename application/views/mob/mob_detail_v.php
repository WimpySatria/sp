

<!DOCTYPE html>
<html>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>

    <link href="<?php echo base_url();?>assets/mobile/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url();?>assets/mobile/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?php echo base_url();?>assets/mobile/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<style>
    a:hover {
        text-decoration:none;
    }
    a{
      color:black;
    }

    
    .menu{
      float:right;
      margin-top: 10px;
      margin-bottom: 10px;
      margin-right: 100px;
	  display: block;
    }

    .menu a{
      padding:10px;
    }

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
    
<head>
    <title>Detail transaksi Nasabah</title>
</head>
<body>

 <div class="container-fluid">
 <div class="row"> 
	<div class="col-md-12 col-sm-12 text-center" style="margin-top:50px; margin">
		<h5>DETAIL TRANSAKSI</h5>
	</div>
 </div>

<div class="container-fluid">
	<div class="row">

		<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		Detail Peminjam
		</button>

  <div class="collapse" id="collapseExample">
	<div class="card card-body">
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
				</tr>
				<tr>
			</table>
			<table width="100%" style="font-size: 12px;">
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
				<tr>
					<td> Pokok Pinjaman</td>
					<td> : </td>
					<td class="h_kanan"><?php echo number_format(nsi_round($row_pinjam->jumlah))?></td>
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

			<table width="100%" style="font-size: 20px;">
				<tr>
					<td> Status Pelunasan : <span id="ket_lunas"> <?php echo $row_pinjam->lunas; ?> </span> </td>
				
			</tr>
		</table>
	</div>
  </div>
</div>

<div class="row mt-2">
<h4 class="text-green"> Detail Transaksi Pembayaran </h4>
		<table  class="table table-bordered small table-striped">
			<tr class="header_kolom">
				<th style="width:12%; vertical-align: middle"> Kode</th>
				<th style="width:13%; vertical-align: middle"> Tanggal</th>
				<th style="width:5%; vertical-align: middle">Ke </th>
				<!-- <th style="width:15%; vertical-align: middle"> Jenis Pembayaran </th> -->
				<th style="width:15%; vertical-align: middle;"> B Pokok</th>
				<th style="width:15%; vertical-align: middle"> B Bunga</th>
				
				<th style="width:10%; vertical-align: middle"> Denda  </th>
				<th style="width:15%; vertical-align: middle"> Jumlah</th>
				<th style="width:10%; vertical-align: middle"> User  </th>
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
	}
}
	?>

	<?php 

		$mulai=1;
		$jml_tot = 0;
		$byr_tot = 0;

		$jml_denda = 0;


if(empty($angsuran)) {
	echo '<code> Tidak Ada Transaksi Pembayaran</code>';
} else {

	foreach ($angsuran as $row) {
		

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
		<tr>
			<td class="h_tengah"> <a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.'TBY'.sprintf('%05d', $row->id).'</a></td>
			<td class="h_tengah"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.$txt_tanggal.'</a></td>
			<td class="h_tengah"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.$row->angsuran_ke.'</a></td>
			
			<td class="h_kanan" style="text-align:right;"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.number_format(nsi_round($row->bayar_pokok)).'</a></td>
			<td class="h_kanan" style="text-align:right;"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.number_format(nsi_round($row->bayar_bunga)).'</a></td>
			
			<td class="h_kanan" style="text-align:right;"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.number_format(nsi_round($row->denda_rp)).'</a></td>
			<td class="h_kanan" style="text-align:right;"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.number_format(nsi_round($row->bayar_pokok + $row->bayar_bunga)).'</a></td>
			<td class="h_tengah"><a href=" '.base_url('cetak_angsuran/cetak/'.$row->id).'" target="_blank">'.$row->user_name.'</a></td>


		</tr>';
		/*<td class="h_kanan">'.number_format(nsi_round($row->jumlah_bayar)).'</td>*/
		
	}
	echo '<tr bgcolor="#eee">
		<td class="h_tengah" colspan="3"><strong>Jumlah Total</strong></td>
		<td class="h_kanan"><strong>'.number_format(nsi_round($byr_pokok)).'</strong></td>
		<td class="h_kanan"><strong>'.number_format(nsi_round($byr_bunga)).'</strong></td>
		<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
		<td class="h_kanan"><strong>'.number_format(nsi_round($byr_tot1)).'</strong></td>
		</tr>';
	echo '<tr bgcolor="#eee">
		<td class="h_tengah" colspan="3"><strong>Sisa Pinjaman</strong></td>
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
</div>
</div>
      

</body>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/mobile/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/mobile/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/mobile/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/mobile/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/mobile/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/mobile/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo base_url();?>mobile/js/demo/datatables-demo.js"></script>







<script type="text/javascript">
  $('#data_penarikan').DataTable();
</script>

</html>