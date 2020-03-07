<!-- Styler -->
<style type="text/css">
td, div {
	font-family: "Arial","​Helvetica","​sans-serif";
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
</style>

<?php 
	// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];

	// $query = 'SELECT `tbl_trans_sp`.`no_rek`,`tbl_trans_sp`.`anggota_id`,`tbl_trans_sp`.`jenis_id`, `tbl_trans_sp`.`saldo`, MAX(`tbl_trans_sp`.`saldo`)
	// 				FROM `tbl_trans_sp`, `tabungan`
	// 				WHERE `tbl_trans_sp`.`no_rek` = `tabungan`.`no_rek` AND `tbl_trans_sp`.`jenis_id` = 3103 GROUP BY `tbl_trans_sp`.`no_rek`
	// 				';
	// 	$result = $this->db->query($query)->result();
	// 	var_dump($result);die();



?>

<!-- Data Grid -->




<?= $this->session->flashdata('success') ?>
<?= $this->session->flashdata('gagal') ?>
<div id="pesan"></div>
<table   id="dg" 
class="easyui-datagrid"
title="Perhitugan Bunga Simpanan Umum" 
style="width:auto; height: auto;" 
url="<?= base_url('hitung_bunga/ajax_list');?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_transaksi" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<!-- <th data-options="field:'id_txt', width:'20', halign:'center', align:'center'">Kode Trans</th> -->
		<th data-options="field:'tgl_transaksi', width:'20', halign:'center', align:'center'">Tgl Transaksi.</th>
		<th data-options="field:'no_rek', width:'20', halign:'center', align:'center'">No Rek.</th>
		<!--<th data-options="field:'tgl_transaksi_txt', width:'25', halign:'center', align:'center'">Tanggal Transaksi</th>-->
		<th data-options="field:'anggota_id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'anggota_id_txt', width:'15', halign:'center', align:'center'" hidden="true">ID Anggota</th>
		<th data-options="field:'nama', width:'30',halign:'center', align:'left'">Nama Anggota</th>
		<!--<th data-options="field:'jenis_id',halign:'center', align:'center'">Jenis</th>-->
		<th data-options="field:'jenis_id_txt', width:'30',halign:'center', align:'left'">Simpanan</th>
		<th data-options="field:'jumlah', width:'40', halign:'center', align:'right'">Saldo Terendah</th>
		<th data-options="field:'bunga', width:'15', halign:'center', align:'right'">Bunga</th>
		<th data-options="field:'hasil', width:'40', halign:'center', align:'right'">Hasil</th>
		<th data-options="field:'user', width:'20', halign:'center', align:'center'">User </th>
		
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div class="pull-left" style="vertical-align: middle;">
	<table widht="100%">
	<tr>
		<td>
	
		<div class="input-group date dtpicker col-md-1">
			<input type="text" name="tgl_mulai" id="tgl_mulai" placeholder="Dari tanggal" style="height:25px;" required="true" readonly="readonly" />
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
		</td>
		<td width="10"></td>
		<td>
		<div class="input-group date dtpicker col-md-1">
		<input type="text" name="tgl_sampai" id="tgl_sampai" placeholder="Sampai tanggal" style="height:25px;" required="true" readonly="readonly" />
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
		</td>
		<td>
			<select name="bunga" id="bunga_val" style="height:30px; width:150px;">
			<option value="0">---Tentukan bunga---</option>
			<?php foreach ($this->db->get_where('suku_bunga_umum',['opsi_key' => 'bg_pinjam' ])->result() as $bg): ?>
				<option value="<?=$bg->opsi_val?>"><?=$bg->opsi_val?></option>
			<?php endforeach; ?>
			</select>
		</td>
				
		<td>
		<a href="#" style="height:32px; color:white;" id="mulai_hitung" class="easyui-linkbutton btn btn-warning" plain="false" >   Mulai Perhitungan   </a>
		</td>
		
		<td>
		
		<td>
		<a href="javascript:void(0)" style="height:32px; color:white;" class="easyui-linkbutton btn btn-primary" iconCls="icon-edit" plain="false" onclick="update()">Edit</a>
		</td>
		<td>
		<a href="<?= base_url('hitung_bunga/clear')?>" style="height:32px; color:white;" class="easyui-linkbutton btn btn-danger" iconCls="icon-clear" plain="false" onclick="return confirm('Apakah anda yakin akan menghapus semua data ?')">Bersihkan</a>
		</td>
		<td style="align:right; width:1000px;">
		<a href="<?= base_url('hitung_bunga/pelimpahan_bunga')?>" style="height:32px; color:white;" class="easyui-linkbutton btn btn-success text-white pull-right" style="vertical-align: middle;" iconCls="icon-add" plain="false" onclick="return confirm('Apakah anda yakin akan melakukan pelimpahan bunga ?')">Mulai Pelimpahan</a>
		</td>
	</tr>
</table>
</div>

	<div class="pull-right" style="vertical-align: middle;">
		
	</div>


<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style=" padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
		<table>
			<tr>
				<td>
					<table>
						<tr>
							<td>Bunga</td>
							<td>:</td>
							<td>
							<input id="bunga" name="bunga" style="width:195px; height:25px"  class="easyui-validatebox" required="true" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Hasil</td>
							<td>:</td>
							<td>
								<input class="easyui-numberbox" id="hasil" name="hasil" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" class="easyui-validatebox" style="width:195px; height:25px" readonly="true" />
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Saldo</td>
							<td>:</td>
							<td>
								<input class="easyui-numberbox" id="jumlah" name="jumlah" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" class="easyui-validatebox" style="width:195px; height:25px" readonly="true" />

								<input type="hidden" name="no_rek" id="no_rek">
							</td>	

						</tr>
						
		</table>
	</form>
</div>

<!-- Dialog Button -->
<div id="dialog-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="edit()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>






<script type="text/javascript">
$(document).ready(function() {
	$(".dtpicker").datetimepicker({
		language:  'en',
		weekStart: 1,
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
		pickerPosition: 'bottom-right',
		format: "dd MM yyyy",
		linkField: "tgl_transaksi",
		linkFormat: "yyyy-mm-dd"
	});	

	$('#mulai_hitung').on('click', function(){
		let tgl_mulai = $('#tgl_mulai').val();
		let tgl_sampai = $('#tgl_sampai').val();
		let bunga = $('#bunga_val').val();
		
		if(tgl_mulai === '' || tgl_sampai === '' ){
			alert('Mohon isikan tanggal mulai dan tanggal sampai');
		} else if ( bunga === 0 ){
			alert('Tentukan bunga terlebih dahulu !')
		}else{
			$.ajax({
				url : "<?=base_url('hitung_bunga/data_sementara')?>",
				method : "POST",
				dataType : "JSON",
				data : {
					tgl_mulai : tgl_mulai,
					tgl_sampai : tgl_sampai,
					bunga : bunga
				},
				
				success : function(data){
					if(data.status === 'oke'){
						$('#pesan').html('<div class="alert alert-success">' + data.pesan + '</div>');
						$('#dg').datagrid('reload');
					}else{
						$('#pesan').append('<div class="alert alert-danger">' + data.pesan + '</div>>');
					}
					
				}
			})
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
				url: '<?php echo site_url(); ?>simpanan/get_anggota_by_id/' + val_anggota_id,
				type: 'POST',
				dataType: 'html',
				data: {anggota_id: val_anggota_id},
			})
			.done(function(result) {
				$('#anggota_poto').html(result);
			})
			.fail(function() {
				alert('Koneksi error, silahkan ulangi.')
			});
		}
	});

	$("#kolom_cari").keyup(function(event){
		if(event.keyCode == 13){
			$("#btn_filter").click();
		}
	});

	$("#kolom_cari").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});


	$('#bunga').on('keyup', function(){
		const saldoRendah = $('#jumlah').val();
		const bunga = $(this).val();
		const hasil = (saldoRendah * bunga) / 100;
		$('#hasil ~span input').val(hasil);
		
		
	})
	

fm_filter_tgl();
}); // ready

function fm_filter_tgl() {
	$('#daterange-btn').daterangepicker({
// 		ranges: {
// 			'Hari ini': [moment(), moment()],
// 			'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
// 			'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
// 			'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
// 			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
// 			'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
// 			'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
// 			'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
// 		},
		showDropdowns: true,
		format: 'YYYY-MM-DD',
		startDate: moment().startOf('year').startOf('month'),
		endDate: moment().endOf('year').endOf('month')
	},

	function(start, end) {
		$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
		doSearch();
	});
}
</script>

<script type="text/javascript">
var url;



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

// JS terbilang
function terbilang(bilangan) {

	 bilangan    = String(bilangan);
	 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
	 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
	 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

	 var panjang_bilangan = bilangan.length;

	 /* pengujian panjang bilangan */
	 if (panjang_bilangan > 15) {
	   kaLimat = "Diluar Batas";
	   return kaLimat;
	 }

	 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
	 for (i = 1; i <= panjang_bilangan; i++) {
	   angka[i] = bilangan.substr(-(i),1);
	 }

	 i = 1;
	 j = 0;
	 kaLimat = "";


	 /* mulai proses iterasi terhadap array angka */
	 while (i <= panjang_bilangan) {

	   subkaLimat = "";
	   kata1 = "";
	   kata2 = "";
	   kata3 = "";

	   /* untuk Ratusan */
	   if (angka[i+2] != "0") {
	     if (angka[i+2] == "1") {
	       kata1 = "Seratus";
	     } else {
	       kata1 = kata[angka[i+2]] + " Ratus";
	     }
	   }

	   /* untuk Puluhan atau Belasan */
	   if (angka[i+1] != "0") {
	     if (angka[i+1] == "1") {
	       if (angka[i] == "0") {
	         kata2 = "Sepuluh";
	       } else if (angka[i] == "1") {
	         kata2 = "Sebelas";
	       } else {
	         kata2 = kata[angka[i]] + " Belas";
	       }
	     } else {
	       kata2 = kata[angka[i+1]] + " Puluh";
	     }
	   }

	   /* untuk Satuan */
	   if (angka[i] != "0") {
	     if (angka[i+1] != "1") {
	       kata3 = kata[angka[i]];
	     }
	   }

	   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
	   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
	     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
	   }

	   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
	   kaLimat = subkaLimat + kaLimat;
	   i = i + 3;
	   j = j + 1;

	 }

	 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
	 if ((angka[5] == "0") && (angka[6] == "0")) {
	   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
	 }

	 return kaLimat + "Rupiah";
}
// js hapus tande koma di inputan jumlah supaye terbilang nye ndak error kyak kmaren ade undifed
function del_koma(bilangan) {
	var data = bilangan.replace(/,\s?/g, "");
	return data;
}

function doSearch(){
$('#dg').datagrid('load',{
	kolom_cari: $('#kolom_cari').val(),
	tgl_dari: 	$('input[name=daterangepicker_start]').val(),
	tgl_sampai: $('input[name=daterangepicker_end]').val()
});
}

function clearSearch(){
	location.reload();
}

// function create(){
// 	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
// 	$('#form').form('clear');
// 	$('#anggota_id ~ span span a').show();
// 	$('#anggota_id ~ span input').removeAttr('disabled');
// 	$('#anggota_id ~ span input').focus();
	
// 	$('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');
// 	$('#tgl_transaksi').val('<?php echo $tanggal;?>');
// 	$('#kas option[value="0"]').prop('selected', true);
// 	$('#jenis_id option[value="0"]').prop('selected', true);
// 	$("#anggota_poto").html('');
// 	$('#jumlah ~ span input').keyup(function(){
// 		var val_jumlah = $(this).val();
// 		// ni js klau jumlah di input mka js terbilang aktif dan masuk ke text area (ket)
// 		$('#ket').val(terbilang(del_koma(val_jumlah)));
// 		$('#jumlah').numberbox('setValue', number_format(val_jumlah));
// 	});

// 	url = '';
// }

function edit() {



	var string = $("#form").serialize();
	//validasi teks kosong
	
		$.ajax({
			type	: "POST",
			url: "<?php echo site_url('hitung_bunga/edit'); ?>",
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
					//clearSearch();
					$('#dg').datagrid('reload');
				}
			}
		});
}
function update(){
    	var row = jQuery('#dg').datagrid('getSelected');
    	if(row){
    		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data');
    		jQuery('#form').form('load',row);
    		url = '<?php echo site_url('hitung_bunga/update'); ?>/' + row.no_rek;
    		
    		
    	} else {
    		$.messager.show({
    			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
    			timeout:2000,
    			showType:'slide'
    		});
    	}
    }

// function hapus(){ 
// 	var row = $('#dg').datagrid('getSelected');  
// 	if (row){ 
// 		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode transaksi : <code>' + row.id_txt + '</code> ?',function(r){  
// 			if (r){  
// 				$.ajax({
// 					type	: "POST",
// 					url		: "<?php echo site_url('simpanan/delete'); ?>",
// 					data	: 'id='+row.id,
// 					success	: function(result){
// 						var result = eval('('+result+')');
// 						$.messager.show({
// 							title:'<div><i class="fa fa-info"></i> Informasi</div>',
// 							msg: result.msg,
// 							timeout:2000,
// 							showType:'slide'
// 						});
// 						if(result.ok) {
// 							$('#dg').datagrid('reload');
// 						}
// 					},
// 					error : function (){
// 						$.messager.show({
// 							title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
// 							msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
// 							timeout:2000,
// 							showType:'slide'
// 						});
// 					}
// 				});  
// 			}  
// 		}); 
// 	}  else {
// 		$.messager.show({
// 			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
// 			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
// 			timeout:2000,
// 			showType:'slide'
// 		});	
// 	}
// 	$('.messager-button a:last').focus();
// }

function cetak () {
	var cari_simpanan 	= $('#cari_simpanan').val();
	var kode_transaksi 	= $('#kode_transaksi').val();
	var tgl_dari			= $('input[name=daterangepicker_start]').val();
	var tgl_sampai			= $('input[name=daterangepicker_end]').val();
	
	var win = window.open('<?php echo site_url("simpanan/cetak_laporan/?cari_simpanan=' + cari_simpanan + '&kode_transaksi=' + kode_transaksi + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}

function cetakKoran () {
	var cari_simpanan 	= $('#cari_simpanan').val();
	var kode_transaksi 	= $('#kode_transaksi').val();
	var tgl_dari			= $('input[name=daterangepicker_start]').val();
	var tgl_sampai			= $('input[name=daterangepicker_end]').val();
	
	var win = window.open('<?php echo site_url("simpanan/cetak_laporan/?cari_simpanan=' + cari_simpanan + '&kode_transaksi=' + kode_transaksi + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>

