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
<table  id="dg" 
class="easyui-datagrid"
title="Data Rekening Nasabah" 
style="width:auto; height: auto;" 
url="<?php echo site_url('tabungan/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_pembuatan" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'no_rek', width:'25', halign:'center', align:'center'">No Rekening</th>
		<th data-options="field:'tgl_pembuatan_txt', width:'25', halign:'center', align:'center'">Tanggal Pembuatan</th>
		<th data-options="field:'nama', width:'25', halign:'center', align:'left'"> Nama Anggota</th>
		<th data-options="field:'jenis_simpan',halign:'center', align:'left'"> Jenis Simpanan </th>
		<!--<th data-options="field:'user', width:'15', halign:'center', align:'center'"> User </th>-->
		<th data-options="field:'nota', halign:'center', align:'center'"> Cetak Nota </th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton"  iconCls="icon-add" plain="true" onclick="create()">Tambah </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()">Edit</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()">Hapus</a>
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tanggal</span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>
		<select id="cari_tabungan" name="cari_tabungan" style="width:170px; height:27px" >
			<option value=""> -- Pilih Jenis Simpanan --</option>			
			<?php	
			foreach ($jenis_id as $row) {
				echo '<option value="'.$row->id.'">'.$row->jns_simpan.'</option>';
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
		<input name="kode_transaksi" id="kode_transaksi" size="22" style="line-height:25px;border:1px solid #ccc;" placeholder="Ketik No. Rekening">

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:480px; height:520px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
	<table style="height:200px" >
			<tr>
				<td>
					<table>
						<tr style="height:35px">
							<td>Tanggal Pembuatan </td>
							<td>:</td>
							<td>
								<div class="input-group date dtpicker col-md-5" style="z-index: 9999 !important;">
									<input type="text" name="tgl_pembuatan_txt" id="tgl_pembuatan_txt" style="width:150px; height:25px" required="true" readonly="readonly" />
									<input type="hidden" name="tgl_pembuatan" id="tgl_pembuatan" />
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Nama Anggota</td>
							<td>:</td>
							<td>
								<input id="anggota_id" name="anggota_id" style="width:195px; height:25px" class="easyui-combogrid" class="easyui-validatebox" required="true" >
								<input id="nama" name="nama" style="width:195px; height:25px" class="easyui-validatebox">
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Jenis tabungan</td>
							<td>:</td>
							<td>
								<select id="jenis_id" name="jenis_id" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih tabungan --</option>
									<?php	
									foreach ($jenis_id as $row) {
										echo '<option value="'.$row->id.'">'.$row->jns_simpan.'</option>';
									}
									?>
								</select>
							</td>	
						</tr>
					</table>
				</td>
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
    
    function doSearch(){
        $('#dg').datagrid('load',{
        	cari_tabungan   : $('#cari_tabungan').val(),
        	kode_transaksi  : $('#kode_transaksi').val(),
        	anggota         : $('#anggota').val(),
        	tgl_dari        : $('input[name=daterangepicker_start]').val(),
            tgl_sampai      : $('input[name=daterangepicker_end]').val()
        });
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
    	
    	$('#nama').hide();
    	$('#nama').css('display','none');
    	
    	$('#tgl_pembuatan_txt').val('<?php echo $txt_tanggal;?>');
    	$('#tgl_pembuatan').val('<?php echo $tanggal;?>');
    	$('#kas option[value="0"]').prop('selected', true);
    	$('#jenis_id option[value="0"]').prop('selected', true);
    	$("#anggota_poto").html('');
    	$('#jumlah ~ span input').keyup(function(){
    		var val_jumlah = $(this).val();
    		$('#jumlah').numberbox('setValue', number_format(val_jumlah));
    	});
    
    	url = '<?php echo site_url('tabungan/create'); ?>';
    }
    
    function save() {
    	var string = $("#form").serialize();
    	//validasi teks kosong
    	var jenis_id = $("#jenis_id").val();
    	if(jenis_id == 0) {
    		$.messager.show({
    			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
    			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Jenis tabungan belum dipilih.</div>',
    			timeout:2000,
    			showType:'slide'
    		});
    		$("#jenis_id").focus();
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
    		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Tabungan');
    		jQuery('#form').form('load',row);
    		
			
    		url = '<?php echo site_url('tabungan/update'); ?>/' + row.id;
    		console.log(row);
    		
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
    		$.messager.confirm('Konfirmasi','Apakah	 Anda akan menghapus data Nomor Rekening : <code>' + row.no_rek + '</code> ?',function(r){  
    			if (r){  
    				$.ajax({
    					type	: "POST",
    					url		: "<?php echo site_url('tabungan/delete'); ?>/"+ row.no_rek,
    					data	: 'no_rek='+row.no_rek,
    					success	: function(result){
    					    console.log(result);
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
    
    function cetak () {
    	var cari_tabungan 	= $('#cari_tabungan').val();
    	var kode_transaksi 	= $('#kode_transaksi').val();
    	var anggota         = $('#anggota').val();
    	var tgl_dari        = $('input[name=daterangepicker_start]').val();
        var tgl_sampai      = $('input[name=daterangepicker_end]').val();
    	
    	var win = window.open('<?php echo site_url("tabungan/cetak_laporan/?cari_tabungan=' + cari_tabungan + '&kode_transaksi=' + kode_transaksi + '&anggota=' + anggota + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
    	if (win) {
    		win.focus();
    	} else {
    		alert('Popup jangan di block');
    	}
    }
    
    $(document).ready(function() {

    	$("#cari_tabungan").change(function(){
    		doSearch();
    	});
    	
    	$("#anggota").change(function(){
    		doSearch();
    	});
    
    	$('#anggota_id').combogrid({
    		panelWidth:400,
    		url: '<?php echo site_url('tabungan/list_anggota'); ?>',
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
    				url: '<?php echo site_url(); ?>tabungan/get_anggota_by_id/' + val_anggota_id,
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
    }); // ready
</script>



