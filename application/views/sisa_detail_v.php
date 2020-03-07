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
<?= $this->session->flashdata('kosong'); ?>
<!-- Data Grid -->
<table id="dg" 
class="easyui-datagrid"
title="Data Transaksi Setoran Tunai" 
style="width:auto; height: auto;" 
url="<?php echo site_url('sisa/ajax_list/'.$anggota_id); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_transaksi" sortOrder="asc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'no', sortable:'true',halign:'center', align:'center'" hidden="true">No</th>
		<th data-options="field:'kode_transaksi', width:'12', halign:'center', align:'center'">Kode Trans</th>
		<th data-options="field:'no_rek', width:'15', halign:'center', align:'center'">No Rek.</th>
		<th data-options="field:'tgl_transaksi_txt', halign:'center', align:'center'">Tanggal Transaksi</th>
		<th data-options="field:'jenis_id',halign:'center', align:'center'">Jenis</th>
		<th data-options="field:'jenis_id_txt', width:'20',halign:'center', align:'left'">Jenis Simpanan</th>
		<th data-options="field:'jumlah', halign:'center', align:'right'">Jumlah</th>
		<th data-options="field:'ket', width:'5', halign:'center', align:'left'">Keterangan</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 40px;">
	<div class="pull-left" style="vertical-align: middle;">
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
		<select id="no_rek" name="no_rek" style="width:145px; height:27px" >
			<option value=""> -- Pilih Nomor Rekening --</option>			
			<?php	
			foreach ($no_rek as $row) {
				echo '<option value="'.$row->no_rek.'">'.$row->no_rek.'</option>';
			}
			?>
		</select>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="20" style="line-height:25px;border:1px solid #ccc;" placeholder="kode trans">
		
		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<?php if($level == 'admin' OR $level == 'cs') { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()"> Laporan</a>
	    <?php } ?>	
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Filter</a>
	</div>
</div>

<script type="text/javascript">
      function doSearch(){
        $('#dg').datagrid('load',{
        	cari_simpanan: $('#cari_simpanan').val(),
        	kode_transaksi: $('#kode_transaksi').val(),
        	no_rek: $('#no_rek').val(),
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
        fm_filter_tgl();
    });
    
    function cetak() {
        var sort = 'tgl_transaksi';
        var order = 'desc';
    	var cari_simpanan 	= $('#cari_simpanan').val();
    	var kode_transaksi 	= $('#kode_transaksi').val();
    	var no_rek 	        = $('#no_rek').val();
    	var anggota_id 	    = <?php echo $anggota_id ?>;
    	var tgl_dari	    = $('input[name=daterangepicker_start]').val();
    	var tgl_sampai      = $('input[name=daterangepicker_end]').val();
    	
    	if (!tgl_dari || tgl_dari == null || tgl_dari =="") {
    	    tgl_dari = "";
    	}
    	if (!tgl_sampai || tgl_sampai == null || tgl_sampai =="") {
    	    tgl_sampai = "";
    	}

		if(no_rek === ""){
			alert('mohon pilih no rekening terlebih dahulu !');
			exit();
		}
    	
    	var win = window.open('<?php echo site_url("sisa/cetak_laporan_detail?sort=' + sort + '&order=' + order + '&cari_simpanan=' + cari_simpanan + '&kode_transaksi=' + kode_transaksi + '&no_rek=' + no_rek + '&anggota_id=' + anggota_id +'&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
    	if (win) {
    		win.focus();
    	} else {
    		alert('Popup jangan di block');
    	}
    }
</script>
