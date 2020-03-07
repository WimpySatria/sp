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
?>

<!-- Data Grid -->
<table id="dg" 
class="easyui-datagrid"
title="Data Transaksi Setoran Tunai" 
style="width:auto; height: auto;" 
url="<?php echo site_url('simpanan/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_transaksi" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<?php if($level == 'admin' OR $level == 'cs') { ?>
		<th data-options="field:'id_txt', width:'12', halign:'center', align:'center'">Kode Trans</th>
		<th data-options="field:'no_rek', width:'15', halign:'center', align:'center'">No Rek.</th>
		<?php } ?>
		<th data-options="field:'tgl_transaksi_txt', width:'20', halign:'center', align:'center'">Tanggal Transaksi</th>
		<th data-options="field:'anggota_id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'anggota_id_txt', width:'15', halign:'center', align:'center'" hidden="true">ID Anggota</th>
		<th data-options="field:'nama', width:'30',halign:'center', align:'left'">Nama Anggota</th>
		<th data-options="field:'jenis_id',halign:'center', align:'center'">Jenis</th>
		<th data-options="field:'jenis_id_txt', width:'20',halign:'center', align:'left'" hidden="true">Simpanan</th>
		<th data-options="field:'jumlah', halign:'center', align:'right'">Jumlah</th>
		<?php if($level == 'admin' OR $level == 'cs') { ?>
		<th data-options="field:'ket', halign:'center', align:'left'">Keterangan</th>
		<?php } ?>
		<th data-options="field:'user', width:'8', halign:'center', align:'center'">Marketing </th>
		<th data-options="field:'kas_id',halign:'center', align:'center'" hidden="true">Jenis Kas</th>
		<th data-options="field:'nama_penyetor',halign:'center', align:'center'" hidden="true">Nama Penyetor</th>
		<th data-options="field:'no_identitas',halign:'center', align:'center'" hidden="true">No. Identitas</th>
		<th data-options="field:'alamat',halign:'center', align:'center'" hidden="true">alamat</th>
		<th data-options="field:'nota', halign:'center', align:'center'">Cetak Nota</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 40px;">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="create()"> </a>
	<?php if($level == 'admin' OR $level == 'cs') { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()"></a>
	<?php } ?>	
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tgl</span></span>
				<i class="fa fa-caret-down"></i>
			</button> 
		</div>
		<select id="cari_simpanan" name="cari_simpanan" style="width:145px; height:27px" >
			<option value=""> -- Pilih Jenis Simpanan --</option>			
			<?php	
			foreach ($jenis_id as $row) {
				if ($row->id == 3101) {
					echo '<option value="'.$row->id.'">Bunga Deposito</option>';
				} else {
					echo '<option value="'.$row->id.'">'.$row->jns_simpan.'</option>';
				}
			}
			?>
		</select>
		<select id="anggota" name="anggota" style="width:140px; height:27px" >
			<option value=""> -- Pilih Anggota --</option>			
			<?php	
			foreach ($anggota as $row) {
				echo '<option value="'.$row->id.'" style="text-transform: uppercase;">'.$row->nama.'</option>';
			}
			?>
		</select>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="20" style="line-height:25px;border:1px solid #ccc;" placeholder="kode trans/no. rekening">
		<span>Marketing :</span>
		<input name="user" id="user" size="8" style="line-height:25px;border:1px solid #ccc;" placeholder="marketing">
		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<?php if($level == 'admin' OR $level == 'cs') { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()"> Laporan</a>
	    <?php } ?>	
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetakKoran()">Rekening Koran</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:480px; height:520px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
	<table style="height:200px" >
			<tr>
				<td>
					<table>
						<tr style="height:35px" <?php if($level == 'admin' OR $level == 'cs') { echo "";}else{ echo "hidden='true'";}?>>
							<td>Tanggal Transaksi </td>
							<td>:</td>
							<td>
								<div class="input-group date dtpicker col-md-5" style="z-index: 9999 !important;">
									<input type="text" name="tgl_transaksi_txt" id="tgl_transaksi_txt" style="width:150px; height:25px" required="true" readonly="readonly" />
									<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" />
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
							</td>	
						</tr>
					
						<tr style="height:40px">
							<td colspan="2"><label for="type">Identitas Penyetor</label></td>
						</tr>
						<tr style="height:35px">
							<td>Nama Anggota</td>
							<td>:</td>
							<td>
								<input id="anggota_id" name="anggota_id" style="width:195px; height:25px" class="easyui-combogrid" class="easyui-validatebox" required="true" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Jenis Simpanan</td>
							<td>:</td>
							<td>
								<select id="jenis_id" name="jenis_id" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Simpanan --</option>
									<?php	
									foreach ($jenis_id as $row) {
										if ($row->id == 3101) {
											echo '<option value="'.$row->id.'">Bunga Deposito</option>';
										} else {
											echo '<option value="'.$row->id.'">'.$row->jns_simpan.'</option>';
										}
									}
									?>
								</select>
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Nomor Rekening</td>
							<td>:</td>
							<td>
								<select id="no_rek" name="no_rek" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Nomor Rekening --</option>
									?>
								</select>
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Jumlah Simpanan</td>
							<td>:</td>
							<td>
								<input class="easyui-numberbox" id="jumlah" name="jumlah" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" class="easyui-validatebox" required="true" style="width:195px; height:25px"  />
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Terbilang</td>
							<td>:</td>
							<td>
								<!-- <input id="ket" name="ket" style="width:190px; height:20px"> -->
								<!-- ni 1 -->
								<textarea id="ket" rows="2" style="width: 100%" readonly></textarea>
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Simpan Ke Kas</td>
							<td>:</td>
							<td>
								<select id="kas" name="kas_id" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value=""> -- Pilih Kas --</option>			
									<?php	
									foreach ($kas_id as $row) {
										echo '<option value="'.$row->id.'" selected>'.$row->jns_simpan.'</option>';
									}
									?>
								</select>
							</td>
						</tr>
				</table>
				</td>
				<td width="10px"></td><td valign="bottom"> Photo : <br> <div id="anggota_poto" style="height:120px; width:90px; border:1px solid #ccc"> </div></td>
			</tr>
		</table>
	</form>
</div>

<!-- Dialog Button -->
<div id="dialog-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>

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
    
    function clearSearch(){
    	location.reload();
    }
    
    function create(){
    	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
    	$('#form').form('clear');
    	$('#anggota_id ~ span span a').show();
    	$('#anggota_id ~ span input').removeAttr('disabled');
    	$('#anggota_id ~ span input').focus();
    	
    	$('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');
    	$('#tgl_transaksi').val('<?php echo $tanggal;?>');
    	$('#kas option[value="1"]').prop('selected', true);
    	$('#jenis_id option[value="0"]').prop('selected', true);
    	$('#no_rek option[value="0"]').prop('selected', true);
    	$("#anggota_poto").html('');
    	$('#jumlah ~ span input').keyup(function(){
    		var val_jumlah = $(this).val();
    		// ni js klau jumlah di input mka js terbilang aktif dan masuk ke text area (ket)
    		$('#ket').val(terbilang(del_koma(val_jumlah)));
    		$('#jumlah').numberbox('setValue', number_format(val_jumlah));
    	});
    
    	url = '<?php echo site_url('simpanan/create'); ?>';
    }
    
    function save() {
    	var string = $("#form").serialize();
    	//validasi teks kosong
    	var jenis_id = $("#jenis_id").val();
    	if(jenis_id == 0) {
    		$.messager.show({
    			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Jenis Simpanan belum dipilih.</div>',
    			timeout:2000,
    			showType:'slide'
    		});
    		$("#jenis_id").focus();
    		return false;
    	}
        
    	var no_rek = $("#no_rek").val();
    	if(no_rek == 0) {
    		$.messager.show({
    			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Nomor Rekening belum dipilih.</div>',
    			timeout:2000,
    			showType:'slide'
    		});
    		$("#no_rek").focus();
    		return false;
    	}
        
    	var kas = $("#kas").val();
    	if(kas == 0) {
    		$.messager.show({
    			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Simpan Ke Kas belum dipilih.</div>',
    			timeout:2000,
    			showType:'slide'
    		});
    		$("#kas").focus();
    		return false;
    	}
    
    	var isValid = $('#form').form('validate');
    	if (isValid) {
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
    					//clearSearch();
    					$('#dg').datagrid('reload');
    				}
    			}
    		});
    	} else {
    		$.messager.show({
    			title:'<div><i class="fa fa-info"></i> Informasi</div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Lengkapi seluruh pengisian data.</div>',
    			timeout:2000,
    			showType:'slide'
    		});
    	}
    }
    
    function update(){
    	var row = jQuery('#dg').datagrid('getSelected');
    	if(row){
    		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Setoran');
    		jQuery('#form').form('load',row);
    		$('#anggota_id ~ span input').attr('disabled', true);
    		$('#anggota_id ~ span input').css('background-color', '#fff');
    		$('#anggota_id ~ span span a').hide();
    		url = '<?php echo site_url('simpanan/update'); ?>/' + row.id;
    		$('#jumlah ~ span input').keyup(function(){
    			var val_jumlah = $(this).val();
    			$('#jumlah').numberbox('setValue', number_format(val_jumlah));
    		});
    		
    	}else {
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
    		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode transaksi : <code>' + row.id_txt + '</code> ?',function(r){  
    			if (r){  
    				$.ajax({
    					type	: "POST",
    					url		: "<?php echo site_url('simpanan/delete'); ?>",
    					data	: 'id='+row.id,
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
    						}
    					},
    					error : function (){
    						$.messager.show({
    							title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
    							msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
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
    
    function cetak() {
        var sort = 'id';
        var order = 'desc';
    	var cari_simpanan 	= $('#cari_simpanan').val();
    	var kode_transaksi 	= $('#kode_transaksi').val();
    	var anggota 	    = $('#anggota').val();
    	var user            = $('#user').val();
    	var tgl_dari	    = $('input[name=daterangepicker_start]').val(); 
    	var tgl_sampai      = $('input[name=daterangepicker_end]').val();
    	
    	var win = window.open('<?php echo site_url("simpanan/cetak_laporan/?sort=' + sort + '&order=' + order + '&cari_simpanan=' + cari_simpanan + '&kode_transaksi=' + kode_transaksi + '&user=' + user + '&anggota=' + anggota +'&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
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
<script>
    function doSearch(){
        $('#dg').datagrid('load',{
        	cari_simpanan: $('#cari_simpanan').val(),
        	kode_transaksi: $('#kode_transaksi').val(),
        	anggota: $('#anggota').val(),
        	user: $('#user').val(),
        	tgl_dari: 	$('input[name=daterangepicker_start]').val(),
        	tgl_sampai: $('input[name=daterangepicker_end]').val()
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
    $(document).ready(function() {
    	$('#jenis_id,#no_rek').on('change keyup', function(){
    		val_jenis_id = $('#jenis_id').val();
    		val_no_rek = $('#no_rek').val();
    		$.ajax({
    			url: '<?php echo site_url()?>simpanan/get_jumlah_simpanan',
    			type: 'POST',
    			dataType: 'html',
    			data: {jenis_id: val_jenis_id, no_rek: val_no_rek},
    		})
    		.done(function(result) {
    		    $("#ket").val(terbilang(del_koma(result)));
    			$('#jumlah').numberbox('setValue', number_format(result));
    			$('#jumlah ~ span input').focus();
    			$('#jumlah ~ span input').select();	
    		})
    		.fail(function() {
    			alert('Kesalahan Konekasi, silahkan ulangi beberapa saat lagi.');
    		});		
    	});
    
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
        
        $('input[name=anggota_id],#jenis_id,#anggota_id').on("change keyup",function(){
    		val_jenis_id = $('#jenis_id').val();
    		val_anggota_id = $('input[name=anggota_id]').val();
    		$("#no_rek").empty();
    		var option = document.createElement("option");
            option.text = '-- Pilih Nomor Rekening --';
            option.value = '0';
            var select = document.getElementById("no_rek");
            select.appendChild(option);
    		$.ajax({
    			url: '<?php echo site_url()?>simpanan/get_no_rek',
    			type: 'POST',
    			dataType: 'html',
    			data: {anggota_id: val_anggota_id, jenis_id: val_jenis_id},
    		})
    		.done(function(result) {
    		    $.each(JSON.parse(result), function( index, value ) {
        		    var option = document.createElement("option");
                    option.text = value.no_rek;
                    option.value = value.no_rek;
                    var select = document.getElementById("no_rek");
                    select.appendChild(option);
                    // if (index == 0) {
                    //     $('#no_rek option[value="'+value.no_rek+'"]').prop('selected', true);
                    // }
    		    });
    		})
    		.fail(function() {
    			alert('Kesalahan Konekasi, silahkan ulangi beberapa saat lagi.');
    		});		
    	});
    	
    	$("#cari_simpanan").change(function(){
            doSearch();
    	});
    	
    	$("#anggota").change(function(){
            doSearch();
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
    	
    	$("#user").keyup(function(event){
    		if(event.keyCode == 13){
    			$("#btn_filter").click();
    		}
    	});
    
        fm_filter_tgl();
    }); // ready
</script>

