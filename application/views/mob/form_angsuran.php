
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

<?php foreach($js_files2 as $file) { ?>
    <script src="<?php echo $file; ?>"></script>
<?php } ?>
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
</head>
<body>
    <div class="container">
	<div class="row"  style="margin-top:50px; margin-bottom:10px;">
        <h3 class="text-center">BAYAR ANGSURAN</h3>
	</div>
		<div class="row">
			<!-- Dialog form+ input anguran -->
        <table >
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><span id="nasabah"><?php echo $data_anggota->nama; ?></span></td>
            </tr>
            <tr>
                <td>Angsuran Ke</td>
                <td>:</td>
                <td><span id="angsuran_ke" class="inputform"></span></td>
            </tr>
            <tr>
                <td>Sisa Angsuran</td>
                <td>:</td>
                <td><span id="sisa_ags" class="inputform"></span></td>
            </tr>
            <tr>
                <td>Denda</td>
                <td>:</td>
                <td><span id="denda" class="inputform"></span></td>
            </tr>
            <tr>
                <td>No Pinjaman</td>
                <td>:</td>
                <td><span class="inputform"><?php echo 'TPJ' . sprintf('%05d', $master_id) . '' ?></span></td>
            </tr>
            <tr>
            <?php $date = date('Y-m-d h:i'); ?>
                <td>Tanggal Transaksi</td>
                <td>:</td>
                <td><span><?= $date; ?></span></td>
            </tr>
        </table>
        <form action="" method="POST">
        <input type="hidden" id="denda_val" name="denda_val"/>
		<input type="hidden" id="pinjam_id" name="pinjam_id" value="<?php echo  $master_id; ?>" readonly="true" />
        <input type="hidden" name="tgl_transaksi"  value="<?= $date; ?>" readonly="true" />	

        <div style="height:2px; background-color:blue; width:100%; margin-top:10px;"></div>
        <br>
        <div class="col-md-6">
            <div class="form-group">
                <label for="bayar_pokok" class="control-label">Bayar Pokok</label>
                <input type="text" class="easyui-numberbox form-control" id="bayar_pokok" name="bayar_pokok" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;" required="true"/>
            </div>

            <div class="form-group">
                <label for="bayar_bunga" class="control-label">Bayar Bunga</label>
                <input type="text" class="easyui-numberbox form-control" id="bayar_bunga" name="bayar_bunga" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;" required="true" />
            </div>

            <div class="form-group">
                <label for="kas_id" class="control-label">Simpan Ke Kas</label>
                <select id="kas_id" name="kas_id" class="easyui-validatebox form-control">
                    <?php
                        foreach ($kas_id as $row) {
                            echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                            }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="simpan_angsuran" class="btn btn-success">Bayar</button>
                <a href="<?php echo base_url('mob_marketing/data_pinjaman')?>" class="btn btn-warning">Batal</a>
            </div>	
        </form>
    </div>
</div>
</div>


<script type="text/javascript">
	/////// READY-START
	$(document).ready(function() {
		create();
		$(".dtpicker").datetimepicker({
			language:  'id',
			weekStart: 1,
			autoclose: true,
			todayBtn: true,
			todayHighlight: true,
			pickerPosition: 'bottom-right',
			format: "dd MM yyyy - hh:ii",
			linkField: "tgl_transaksi",
			linkFormat: "yyyy-mm-dd hh:ii"
		}).on('changeDate', function(ev){
			hitung_denda();
		});

		$("#kode_transaksi").keyup(function(event){
			if(event.keyCode == 13){
				$("#btn_filter").click();
			}
		});

		$("#kode_transaksi").keyup(function(e){
			var isi = $(e.target).val();
			$(e.target).val(isi.toUpperCase());
		});
		fm_filter_tgl();
	});
	/////// READY-END




// ////////////total angsuran
// 	$("body").on("keyup", ".input_bayar", function(){
//     	sum_angsuran();
// 	})

// 	function sum_angsuran(){
//     var val_pokok = parseInt($("#bayar_pokok").val())

//     var val_bunga = parseInt($("#bayar_bunga").val())

//     if (val_pokok != '' && val_bunga != ''){
//       var total = val_pokok + val_bunga
//       $("#angsuran").val(total)
//     }

//   }

	function hitung_denda() {
		$('#denda').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#denda_val').val('0');
		val_tgl_bayar 	= $('#tgl_transaksi').val();
		val_aksi  		= $('#aksi').val();
		val_id_bayar 	= $('#id_bayar').val();
		$.ajax({
			type	: "POST",
			url	: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			data 	: { tgl_bayar : val_tgl_bayar, id_bayar : val_id_bayar},
			success	: function(result){
				var result = eval('('+result+')');
				$('#denda').text(result.denda);
				$('#denda_val').val(result.denda);
			}
		});
	}

	function fm_filter_tgl() {
		$('#daterange-btn').daterangepicker({
			ranges: {
				'Hari ini': [moment(), moment()],
				'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
				'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
				'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
				'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
				'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
				'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
				'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
			},
			showDropdowns: true,
			format: 'YYYY-MM-DD',
			startDate: moment().subtract('days', 1),
			endDate: moment()
		},
		function(start, end) {
			$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
			doSearch();
		});
	}
	function alur(){
		jQuery('#alur').dialog('open').dialog('setTitle',' <i class="fa  fa-book"></i> Cara Pembayaran');
	}


	function create() {
		$('#aksi').val('add');
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Form Pembayaran Angsuran');
		jQuery('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');

		// bayar pokok dan bunga
			// jQuery('#bayar_pokok').val('<?php echo $bayar_pokok;?>');
			// jQuery('#bayar_bunga').val('<?php echo $bayar_bunga;?>');
		// bayar pokok dan bung


		jQuery('#tgl_transaksi').val('<?php echo $tanggal;?>');
		jQuery('#pinjam_id').val('<?php echo  $master_id; ?>');
// 		jQuery('#angsuran').val('<?php echo number_format(($row_pinjam->ags_per_bulan)); ?>');



		  // bayar pokok bungan

		$('#bayar_pokok ~ span input').keyup(function(){
    		var val_jumlah_pokok = $(this).val();
    		$('#bayar_pokok').numberbox('setValue', val_jumlah_pokok);
    	});

    	$('#bayar_bunga ~ span input').keyup(function(){
    		var val_jumlah_bunga = $(this).val();
    		$('#bayar_bunga').numberbox('setValue', val_jumlah_bunga);
    	});
    	//bayar pokok bunga



    	$('#angsuran ~ span input').keyup(function(){
    		var val_jumlah = $(this).val();
    		$('#angsuran').numberbox('setValue', val_jumlah);
    	});


		jQuery('#kas_id option[value="0"]').prop('selected', true);
		url = '<?php echo site_url('angsuran/create'); ?>';
		$("#angsuran_ke").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');

		// Bayar Pokok dan Bunga
		// $("#bayar_pokok").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');

		// $("#bayar_pokok").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');



/////////// mengartur lama pembayaran

		$("#sisa_ags").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$("#sisa_tagihan").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			success	: function(result){
				var result = eval('('+result+')');
				if((result.sisa_ags == 0) || (result.total_tagihan == 0)) {
					$('#dialog-form').dialog('close');
					$.messager.show({
						title:'<div><i class="fa fa-warning"></i> Perhatian ! </div>',
						msg: '<div class="text-blue"><i class="fa fa-warning"></i> Klik <code> Validasi Lunas </code> untuk Pelunasan dan membayar Tagihan Denda</div>',
					});
				} else {
					$('#angsuran_ke').text(result.ags_ke);
					$('#sisa_ags').text(result.sisa_ags);

					$('#sisa_tagihan').text(result.sisa_tagihan);
					$('#jml_bayar').val(result.sisa_pembayaran);
					$('#jml_kas').val(result.total_tagihan);
				}
			},
			error : function() {
				alert('Terjadi Kesalahan Kneksi');
			}
		});
		hitung_denda();
	}

	function save(){
		//validasi teks kosong
		var tgl_bayar_txt = $("#tgl_bayar_txt").val();
		var string = $("#form").serialize();
		if(tgl_bayar_txt == 0){
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Tanggal harus diisi </div>',
				timeout:2000,
				showType:'slide'
			});
			$("#tgl_bayar_txt").focus();
			return false;
		}

		var kas_id = $("#kas_id").val();

		// Bayar Pokok dan Bunga
		var bayar_pokok = $("#bayar_pokok").val();
		var bayar_bunga = $("#bayar_bunga").val();
		// Bayar Pokok dan Bunga


		var string = $("#form").serialize();
		if(kas_id == 0){
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Anda belum memilih kas </div>',
				timeout:2000,
				showType:'slide'
			});
			$("#kas_id").focus();
			return false;
		} else {
			$.ajax({
				type	: "POST",
				url: url,
				data	: string,
				success	: function(result){
					var result = eval('('+result+')');
					$.messager.show({
						title:'<div><i class="fa fa-info"></i> Informasi</div>',
						msg: result.msg,
						timeout:2000,
						showType:'slide'
					});
					if(result.ok) {
						jQuery('#dialog-form').dialog('close');
						$('#dg').datagrid('reload');
						det_update();
					}
				}
			});
		}
	}

	function det_update() {
		$('#det_sudah_bayar').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_sisa_tagihan').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_jml_denda').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_sisa_ags').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#total_bayar').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#ket_lunas').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');

		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			success	: function(result){
				var result = eval('('+result+')');
				$('#det_sudah_bayar').text(result.sudah_bayar_det);
				$('#det_sisa_tagihan').text(result.sisa_tagihan_det);
				$('#det_jml_denda').text(result.jml_denda_det);
				$('#det_sisa_ags').text(result.sisa_ags_det);
				$('#total_bayar').text(result.total_bayar_det);
				$('#ket_lunas').text(result.status_lunas);
			},
			error: function() {
				alert('Terjadi Kesalahan Koneksi');
			}
		});
	}

	function update(){
		$('#aksi').val('edit');
		var row = $('#dg').datagrid('getSelected');
		if(row) {
			url = '<?php echo site_url('angsuran/update'); ?>/' + row.id;

			$.ajax({
				url: '<?php echo site_url();?>angsuran/cek_sebelum_update',
				type: 'POST',
				dataType: 'json',
				data: {id_bayar: row.id, master_id: <?php echo $master_id; ?>}
			})
			.done(function(result) {
				if(result.success == '1') {
					$('#dialog-form').dialog('open').dialog('setTitle','Edit Data Angsuran');
					$('#form').form('load',row);
					$('#id_bayar').val(row.id);
					$('#tgl_transaksi_txt').val(row.tgl_bayar_txt);
					$('#tgl_transaksi').val(row.tgl_bayar);
					$('#angsuran_ke').text(row.angsuran_ke);
					$('#sisa_ags').text(result.sisa_ags);
					$('#sisa_tagihan').text(result.sisa_tagihan);
					var denda_txt = row.denda;
					var denda_num = denda_txt.replace(',', '');
					$('#denda_val').val(denda_num);
					$('#denda').html(denda_txt);
				} else {
					$.messager.show({
						title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
						msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Hanya data transaksi terakhir saja yang boleh diubah (silahkan cek juga list Pelunasan jika ada). </div>',
						timeout:2000,
						showType:'slide'
					});
				}
			})
			.fail(function() {
				alert("Kesalahan koneksi, silahkan ulangi (refresh).");
			});
		} else {
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout:2000,
				showType:'slide'
			});
		}
	}


function hapus(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode bayar : <code>' + row.id_txt + '</code> ?',function(r){
				if (r){
					$.ajax({
						type	: "POST",
						url		: "<?php echo site_url('angsuran/delete'); ?>",
						data	: 'id='+row.id+'&master_id=<?php echo $master_id; ?>',
						success	: function(result){
							var result = eval('('+result+')');
							$.messager.show({
								title:'<div><i class="fa fa-info"></i> Informasi</div>',
								msg: result.msg,
								timeout:2000,
								showType:'slide'
							});
							if(result.ok) {
								$('#dg').datagrid('reload');
								det_update();
							}
						},
						error : function (){
							$.messager.show({
								title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
								msg: '<div class="text-red"><i class="fa fa-ban"></i> Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
								timeout:2000,
								showType:'slide'
							});
						}
					});
				}
			});
		}  else {
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout:2000,
				showType:'slide'
			});
		}
		$('.messager-button a:last').focus();
	}

	function form_select_clear() {
		$('select option')
		.filter(function() {
			return !this.value || $.trim(this.value).length == 0;
		})
		.remove();
		$('select option')
		.first()
		.prop('selected', true);
	}

	function doSearch(){
		$('#dg').datagrid('load',{
			kode_transaksi: $('#kode_transaksi').val(),
			tgl_dari: 	$('input[name=daterangepicker_start]').val(),
			tgl_sampai: $('input[name=daterangepicker_end]').val()
		});
	}

	function clearSearch(){
		location.reload();
	}



///total angsuran
	$("body").on("keyup", function(){
    	sum_angsuran();
	})

	function sum_angsuran(){
		var val_pokok = $("#bayar_pokok").val()

		var val_bunga = $("#bayar_bunga").val()

		if (val_pokok != '' && val_bunga != ''){
		var total = parseInt(val_pokok) + parseInt(val_bunga)
		$("#angsuran").val(total)
		}

  	}

</script>
</body>
</html>