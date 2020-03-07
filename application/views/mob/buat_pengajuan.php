
<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/html"></script>

<?php 
foreach($css_files as $file) { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php } ?>


<link href="<?php echo base_url(); ?>assets/theme_admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />	

<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />	

<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/jqClock.min.js" type="text/javascript"></script>

<?php foreach($js_files as $file) { ?>
    <script src="<?php echo $file; ?>"></script>
<?php } ?>

<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/theme_admin/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- Waktu -->
<script type="text/javascript">
$(document).ready(function(){    
  $(".jam").clock({"format":"24","calendar":"false"});
});    
</script>

<style>
#nav {
    background: #B0C4DE;
}
#footer{
    background:#341f97;
    position:absolute;
    bottom:0;width :100%;
    text-align:center;
    color:#808080;
}
</style>

<head>
<title>Bayar Angsuran</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
</head><body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<img src="<?php echo base_url().'assets/theme_admin/img/logo2.png'; ?>" alt="">
			</div>
		</div>
	</nav>

	<div class="container" >
    <div class="row" style="margin-bottom:10px;">
        <h3><?= $judul_utama; ?></h3>
    </div>
		<div class="row">
        <div class="col-md-6">
            <div class="box box-primary"></div>
                <p style="font-weight: bold; color:blue;"> Identitas Peminjam </p>
                <div class="box box-primary"></div>
        
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="anggota_id" class="control-label">Nama Nasabah</label>
                        <input type="text" id="anggota_id" name="anggota_id" class="form-control" style="height:40px;">
                    </div>

                    <div class="form-group">
                        <label for="nik" class="control-label">NIK</label>
                        <input type="text" id="nik" name="nik" class="form-control" readonly="true">
                    </div>

                <div class="form-group">
                    <label for="alamat" class="control-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" readonly="true">
                </div>

                <div class="form-group">
                    <label for="wali" class="control-label">Wakil</label>
                    <input type="text" id="wakil" name="wakil" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="jenis_usaha" class="control-label">Jenis Usaha</label>
                    <input type="text" id="jenis_usaha" name="jenis_usaha" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="tempat_usaha" class="control-label">Tempat Usaha</label>
                    <input type="text" id="tempat_usaha" name="tempat_usaha" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="omset_usaha" class="control-label">Omset Perbulan</label>
                    <input type="text" class="easyui-numberbox form-control" id="omset_usaha" name="omset_usaha" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>                </div>

                <div class="form-group">
                    <label for="biaya_hidup" class="control-label">Biaya Hidup</label>
                    <input type="text" class="easyui-numberbox form-control" id="biaya_hidup" name="biaya_hidup" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
                </div>

                <div class="box box-primary"></div>
                <p style="font-weight: bold; color:blue;"> Pinjaman </p>
                <div class="box box-primary"></div>

                <div class="form-group">
                <label for="jenis" class="control-label">Jenis Pinjaman</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="Biasa">Biasa</option>
                        <option value="Darurat">Darurat</option>
                        <option value="Barang">Barang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nominal" class="control-label">Nominal</label>
                    <input type="text" class="easyui-numberbox form-control" id="nominal" name="nominal" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
                </div>

                <div class="form-group">
                    <label for="lama_angsuran" class="control-label">Lama Angsuran</label>
                    <input type="number" name="lama_angsuran" id="lama_angsuran" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="bunga" class="control-label"> Bunga Pinjaman</label>
                    <select name="bunga" id="bunga" class="form-control">
                        <option value="">Tetapkan Bunga</option>
                        <?php foreach($this->db->get_where('suku_bunga',['opsi_key' => 'bg_pinjam'])->result() as $b): ?>
                        <option value="<?=$b->opsi_val?>"><?=$b->opsi_val?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="control-label">Alasan Peminjaman</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-control" required="true">
                </div>

                <input type="hidden" id="surveyor" name="surveyor" value="<?php echo $u_name; ?>">
    
                <div class="box box-primary"></div>
                    <p style="font-weight: bold; color:blue;">Pilih Jaminan 
                    <select name="anggunan" id="pilih-jaminan" class="form-control">

                        <option value="">pilih</option>
                        <option value="kendaraan">Kendaraan</option>
                        <option value="shm">SHM</option>
                    </select></p>
                <div class="box box-primary"></div>

                <div id="form-jaminan">
                <div id="form-kendaraan">                                              

                    <div class="form-group">
                        <label for="jenis_bpkb" class="control-label">Jenis BPKB</label>
                        <select name="jenis_bpkb" id="jenis_bpkp" class="form-control">
                            
                            <option value="">Pilih</option>
                            <option value="mobil">Mobil</option>
                            <option value="sepeda motor">Sepeda Motor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="merek" class="control-label">Merek Kendaraan</label>
                        <input type="text" id="merek" name="merek" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="no_bpkb" class="control-label">No BPKB</label>
                        <input type="text" id="no_bpkb" name="no_bpkb" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="no_mesin" class="control-label">No Mesin</label>
                        <input type="text" id="no_mesin" name="no_mesin" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="no_rangka" class="control-label">No Rangka</label>
                        <input type="text" id="no_rangka" name="no_rangka" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="warna" class="control-label">Warna</label>
                        <input type="text" id="warna" name="warna" class="form-control">
                    </div>

                    
                    <div class="form-group">
                        <label for="atas_nama" class="control-label">Atas Nama</label>
                        <input type="text" id="atas_nama" name="atas_nama" class="form-control">
                    </div>

                    
                    <div class="form-group">
                        <label for="no_polisi" class="control-label">No Polisi</label>
                        <input type="text" id="no_polisi" name="no_polisi" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="harga_taksiran" class="control-label">Harga Taksiran</label>
                        <input type="number" id="harga_taksiran" name="harga_taksiran_kendaraan" class="form-control">
                    </div>
                </div>

                <div id="form-shm">
                    <div class="form-group">
                        <label for="no_shm" class="control-label">No SHM</label>
                        <input type="text" id="no_shm" name="no_shm" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="atas_nama_shm" class="control-label">Atas Nama SHM</label>
                        <input type="text" id="atas_nama_shm" name="atas_nama_shm" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="luas_shm" class="control-label">Luas SHM</label>
                        <input type="text" id="luas_shm" name="luas_shm" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat_shm" class="control-label">Alamat SHM</label>
                        <input type="text" id="alamat_shm" name="alamat_shm" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="kec_shm" class="control-label">Kec SHM</label>
                        <input type="text" id="kec_shm" name="kec_shm" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="kab_shm" class="control-label">Kab SHM</label>
                        <input type="text" id="kab_shm" name="kab_shm" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prov_shm" class="control-label">Prov SHM</label>
                        <input type="text" id="prov_shm" name="prov_shm" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl_ukut" class="control-label">Tanggal Ukur SHM</label>
                        <input type="text" id="tgl_ukut" name="tgl_ukut" class="form-control">
                    </div>

					<div class="form-group">
                        <label for="harga_taksiran" class="control-label">Harga Taksiran</label>
                        <input type="number" id="harga_taksiran" name="harga_taksiran_shm" class="form-control">
                    </div>
                </div>

                <div class="form-group tombol-simpan">
                        <button type="submit" name="buat_pengajuan" class="btn btn-primary">Kirim Pengajuan</button>
                        <a href="<?=base_url('mob_marketing')?>" class="btn btn-danger">Batal</a>
                </div> 
             </form>
        </div>
    </div>
</div>

      
 
<script type="text/javascript">
    $(document).ready(function() {


        $('#form-jaminan').hide();
            $('#pilih-jaminan').on('change', function(){
                const jaminan = $('#pilih-jaminan').val();
                if(jaminan === 'kendaraan'){
                    $('#form-jaminan').show();
                    $('#form-kendaraan').show();
                    $('#form-shm').hide();
                    $('.tombol-simpan').show();
                }else if(jaminan === 'shm') {
                    $('#form-jaminan').show();
                    $('#form-kendaraan').hide();
                    $('#form-shm').show();
                    $('.tombol-simpan').show();
                }else{
                    $('#form-jaminan').hide(); 
                }
            });



    	
    	$('#anggota_id').combogrid({
    		panelWidth:400,
    		url: '<?php echo site_url('simpanan/list_anggota'); ?>',
    		idField:'id',
    		valueField:'id',
    		textField:'nama',
    		mode:'remote',
    		fitColumns:true,
    		columns:[[
    		{field:'photo',title:'Photo',align:'center',width:5},
    		{field:'id',title:'ID', hidden: true},
    		{field:'kode_anggota', title:'ID', align:'center', width:15},
    		{field:'nama',title:'Nama Anggota',align:'left',width:15},
    		{field:'kota',title:'Kota',align:'left',width:10}
    		]],
    		onSelect: function(record){
			$("#anggota_poto").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
			var val_anggota_id = $('input[name=anggota_id]').val();
			$.ajax({
				url: '<?php echo base_url(  ); ?>mob_marketing/get_anggota_by_id',
				method: 'POST',
				dataType: 'json',
				data: {id: val_anggota_id},
			})
			.done(function(result) {
				$('#nik').val(result.ktp);
				$('#alamat').val(result.alamat);
				
			})
			.fail(function() {
				alert('keneksi gagal silakan coba lagi ')
			});
		}
    	});

        $('#nominal ~ span input').keyup(function(){
    		
    		$('#nominal').numberbox('setValue', $(this).val()); 
        });
        $('#biaya_hidup ~ span input').keyup(function(){
    		
    		$('#biaya_hidup').numberbox('setValue', $(this).val()); 
        });
        $('#omset_usaha ~ span input').keyup(function(){
    		
    		$('#omset_usaha').numberbox('setValue', $(this).val()); 
        });    
        
    }); // ready
</script>

</body>

</html>