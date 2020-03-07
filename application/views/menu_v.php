<!-- search form -->

<!-- /.search form -->

<ul class="sidebar-menu">
<li class="<?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>
<!-- Menu Transaksi -->
<?php if($level != 'pelayanan') { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('pemasukan_kas','pengeluaran_kas', 'transfer_kas');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/transaksi.png'; ?>">
		<span>Transaksi Kas</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
 
<!-- Pwmilihan akses controller baru -->

<!-- end -->
		<li class="<?php if ($this->uri->segment(1) == 'pemasukan_kas') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pemasukan_kas"> <i class="fa fa-folder-open-o"></i> Pemasukan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'pengeluaran_kas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pengeluaran_kas"> <i class="fa fa-folder-open-o"></i> Pengeluaran </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'transfer_kas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>transfer_kas"> <i class="fa fa-folder-open-o"></i> Transfer </a></li>
	</ul>
</li>
<?php } ?>
<!-- Menu Tabungan -->
<?php if($level != 'pelayanan') { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('tabungan');
	 if(in_array($this->uri->segment(1), $menu_data_anggota)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>Buka Tabungan </span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'tabungan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>tabungan"> <i class="fa fa-folder-open-o"></i> Buat </a></li>
	</ul>
</li>
<?php } ?>

<!-- Menu Simpanan -->
<li  class="treeview <?php 
	 $menu_trans_arr= array('simpanan','penarikan','sisa');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>Simpanan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>simpanan"> <i class="fa fa-folder-open-o"></i> Setoran Tunai </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'penarikan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>penarikan"> <i class="fa fa-folder-open-o"></i> Penarikan Tunai</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'sisa') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>sisa"> <i class="fa fa-folder-open-o"></i> Transkip </a></li>
	</ul>
</li>

<!-- Menu Simpanan Deposito-->
<?php if($level == 'admin' OR $level == 'cs') { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('simpanan_d','penarikan_d');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>Simpanan Deposito</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>simpanan_d"> <i class="fa fa-folder-open-o"></i> Setoran Tunai </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'penarikan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>penarikan_d"> <i class="fa fa-folder-open-o"></i> Penarikan Tunai</a></li>
	</ul>
</li>
<?php } ?>
<!-- menu pinjaman spk -->
<?php if($level == 'admin' OR $level == 'cs') { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('list_spk','penarikan_spk','setoran_spk');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>SPK</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'Spk') { echo 'active'; } ?>">  <a href="<?php echo base_url('Spk'); ?>"> <i class="fa fa-folder-open-o"></i> Pendaftaran SPK </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'Spk') { echo 'active'; } ?>">  <a href="<?php echo base_url('Spk/pengajuan_spk'); ?>"> <i class="fa fa-folder-open-o"></i> Data Pengajuan SPK </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'Spk') { echo 'active'; } ?>">  <a href="<?php echo base_url('Spk/setoran_spk'); ?>"> <i class="fa fa-folder-open-o"></i> Setoran SPK </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'Spk') { echo 'active'; } ?>"><a href="<?php echo base_url('Spk/penarikan_spk'); ?>"> <i class="fa fa-folder-open-o"></i> Penarikan Tabungan</a></li>
	</ul>
</li>
<?php } ?>



<!-- end menu spk -->
<!-- menu pinjaman -->
<li  class="treeview <?php 
$menu_pinjam_arr= array( 'buat pengajuan','pengajuan','pinjaman','bayar','pelunasan', 'angsuran','angsuran_detail','angsuran_lunas','lap_tempo');
if(in_array($this->uri->segment(1), $menu_pinjam_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/pinjam.png'; ?>">
	<span>Pinjaman</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<?php if($level != 'pelayanan') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'buat pengajuan' || $this->uri->segment(1) == 'buat pengajuan'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pengajuan/buat_pengajuan"> <i class="fa fa-folder-open-o"></i> Buat Pengajuan </a></li>
	<?php } ?>

	<?php if($level != 'pelayanan') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'pengajuan' || $this->uri->segment(1) == 'pengajuan'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pengajuan"> <i class="fa fa-folder-open-o"></i> Data Pengajuan </a></li>
	<?php } ?>

	<li class="<?php if ($this->uri->segment(1) == 'pinjaman' || $this->uri->segment(1) == 'angsuran_detail'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pinjaman"> <i class="fa fa-folder-open-o"></i> Data Pinjaman </a></li> 

	<li class="<?php if ($this->uri->segment(1) == 'bayar' || $this->uri->segment(1) == 'angsuran') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>bayar"> <i class="fa fa-folder-open-o"></i> Bayar Angsuran</a></li> 

	<?php if($level != 'pelayanan') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'lap_tempo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_tempo"><i class="fa fa-folder-open-o"></i> Jatuh Tempo </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'pelunasan' || $this->uri->segment(1) == 'angsuran_lunas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pelunasan"> <i class="fa fa-folder-open-o"></i> Pinjaman Lunas </a></li>
	<?php } ?>
</ul>
</li>


<!-- Hilang nasabah -->



<!-- Menu Nasabah -->
<?php if($level == 'admin' OR $level == 'cs') { ?>
<li  class="treeview <?php 
	 $menu_data_anggota= array('anggota','lap_kas_anggota');
	 if(in_array($this->uri->segment(1), $menu_data_anggota)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/anggota.png'; ?>">
		<span>Nasabah</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">

		<li class="<?php if ($this->uri->segment(1) == 'anggota') { echo "active"; } ?>"><a href="<?php echo base_url(); ?>anggota"> <i class="fa fa-folder-open-o"></i> Master Nasabah</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_kas_anggota') { echo "active"; } ?>"> <a href="<?php echo base_url(); ?>lap_kas_anggota"><i class="fa fa-folder-open-o"></i> Data Nasabah</a></li>
	</ul>
</li>
<?php } ?>

<!-- end  -->

<!-- Menu Data Nasabah -->


<!-- Menu Data Inventaris -->
<?php if($level == 'admin' OR $level == 'cs') { ?>
<li  class="treeview <?php 
	 $menu_data_barang= array('data_barang');
	 if(in_array($this->uri->segment(1), $menu_data_barang)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/inventory.png'; ?>">
		<span>Data Inventaris</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'data_barang') { echo"active"; } ?>"><a href="<?php echo base_url(); ?>data_barang"> <i class="fa fa-folder-open-o"></i> Data Inventaris</a></li>
	</ul>
</li>
<?php } ?>


<!-- laporan -->
<?php if($level == 'admin' OR $level == 'cs') { ?>
<li  class="treeview <?php 
	 $menu_lap_arr= array('lap_simpanan','lap_kas_pinjaman','lap_macet','lap_trans_kas','lap_buku_besar','lap_neraca','lap_saldo','lap_laba','lap_shu');
	 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">


	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/laporan.png'; ?>">
		<span>Laporan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
		<!-- <li class="<?php if ($this->uri->segment(1) == 'lap_kas_anggota') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_anggota"> <i class="fa fa-folder-open-o"></i> Kas Anggota </a></li> -->
	
	
		<li class="<?php if ($this->uri->segment(1) == 'lap_tempo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_tempo"><i class="fa fa-folder-open-o"></i> Jatuh Tempo </a></li> 

		<li class="<?php if ($this->uri->segment(1) == 'lap_macet') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_macet"><i class="fa fa-folder-open-o"></i> Kredit Macet</a></li> 

		<li class="<?php if ($this->uri->segment(1) == 'lap_trans_kas') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_trans_kas"><i class="fa fa-folder-open-o"></i> Transaksi Kas</a></li>
		
		<li class="<?php if ($this->uri->segment(1) == 'lap_buku_besar') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_buku_besar"><i class="fa fa-folder-open-o"></i> Buku Besar</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_neraca"><i class="fa fa-folder-open-o"></i> Neraca Saldo</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_simpanan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_simpanan"> <i class="fa fa-folder-open-o"></i> Kas Simpanan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_kas_pinjaman') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_pinjaman"> <i class="fa fa-folder-open-o"></i> Kas Pinjaman </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_saldo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_saldo"><i class="fa fa-folder-open-o"></i> Saldo Kas </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_laba') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_laba"><i class="fa fa-folder-open-o"></i> Laba Rugi </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_shu') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_shu"><i class="fa fa-folder-open-o"></i> SHU </a></li>
		
	</ul>
</li>
<?php } ?>

<?php if($level == 'admin' OR $level == 'cs') { ?>
<!-- Master data -->
<li  class="treeview <?php 
$menu_data_arr= array('jenis_simpanan','jenis_akun','jenis_kas','jenis_angsuran','hitung_bunga','anggota','user');
if(in_array($this->uri->segment(1), $menu_data_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
	<span>Master Data</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<?php if($level != 'teller' OR $level != 'pelayanan') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'jenis_simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_simpanan"> <i class="fa fa-folder-open-o"></i> Jenis Simpanan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_akun') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_akun"> <i class="fa fa-folder-open-o"></i> Jenis Akun </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_kas') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_kas"> <i class="fa fa-folder-open-o"></i> Data Kas </a></li>   

		<li class="<?php if ($this->uri->segment(1) == 'jenis_angsuran') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_angsuran"> <i class="fa fa-folder-open-o"></i> Lama Angsuran </a></li>
	<?php } ?>
	<?php if($level != 'pelayanan') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'hitung_bunga') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>hitung_bunga"> <i class="fa fa-folder-open-o"></i> Hitung Bunga</a></li>
	<?php } ?>
	<?php if($level == 'admin') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'anggota') { echo "active"; } ?>"><a href="<?php echo base_url(); ?>anggota"> <i class="fa fa-folder-open-o"></i> Master Nasabah</a></li>
		
		<li class="<?php if ($this->uri->segment(1) == 'user') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>user"> <i class="fa fa-folder-open-o"></i> Data Pegawai </a></li> 
	<?php } ?>
</ul>
</li>


<!-- grafik -->
<?php if($level == 'admin') { ?>
<li  class="treeview <?php 
$menu_sett_arr= array('grafik_marketing','grafik_transaksi');
if(in_array($this->uri->segment(1), $menu_sett_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
	<span>Info Grafik</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>

<ul class="treeview-menu">  

	<li class="<?php if ($this->uri->segment(2) == 'grafik_simpanan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>grafik/grafik_simpanan"> <i class="fa fa-folder-open-o"></i> Grafik Simpanan </a></li>        
	<li class="<?php if ($this->uri->segment(2) == 'grafik_marketing') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>grafik/grafik_marketing"> <i class="fa fa-folder-open-o"></i> Grafik Marketing </a></li>


	<!-- <li class="<?php if ($this->uri->segment(1) == 'suku_bunga_pu') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Pinjaman Umum </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga_pk') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Pinjaman Khusus </a></li> -->
</ul>
</li>
<li  class="treeview <?php 
$menu_sett_arr= array('suku_bunga','suku_bunga_su','suku_bunga_umum','suku_bunga_pu','suku_bunga_pk');
if(in_array($this->uri->segment(1), $menu_sett_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
	<span>Parameter Bunga</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>

<ul class="treeview-menu">  

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga_umum') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>suku_bunga_umum"> <i class="fa fa-folder-open-o"></i> Simpanan Umum </a></li>        
	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga_su') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>suku_bunga_su"> <i class="fa fa-folder-open-o"></i> Simpanan Deposito </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Pinjaman </a></li>



	<!-- <li class="<?php if ($this->uri->segment(1) == 'suku_bunga_pu') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Pinjaman Umum </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga_pk') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Pinjaman Khusus </a></li> -->
</ul>
</li>
<?php } ?>


<!-- MENU Setting -->
<?php if($level == 'admin') { ?>
<li  class="treeview <?php 
$menu_sett_arr= array('profil');
if(in_array($this->uri->segment(1), $menu_sett_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
	<span>Setting</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>

<ul class="treeview-menu">          
	<li class="<?php if ($this->uri->segment(1) == 'profil') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>profil"> <i class="fa fa-folder-open-o"></i> Identitas Koperasi </a></li>

	<!-- <li class="<?php if ($this->uri->segment(1) == 'suku_bunga') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Bunga Pinjaman </a></li> -->
</ul>
</li>
<?php } ?>


<?php } ?>

</ul>