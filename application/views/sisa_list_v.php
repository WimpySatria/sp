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
</style>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Cetak Data Akhir</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<table>
			<tr>
				<td> Pilih ID Anggota </td>
				<td>
				    <form id="fmCari">
				        <input id="anggota_id" name="anggota_id" value="" style="width:200px; height:25px" class="">
				        <input id="tgl_mulai" name="tgl_mulai" value="" type="hidden">
            		    <input id="tgl_selesai" name="tgl_selesai" value="" type="hidden">
				     </form>



				<td>
					<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Lihat Laporan</a>
					<!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>-->
					<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="box box-primary">
	<div class="box-body">
	<p></p>
	<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Riwayat Setoran Nasabah </p>
	<table  class="table table-bordered">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Identitas </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Alamat </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Setoran </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Penarikkan </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Saldo Akhir </th>
		    <th style="width:10%; vertical-align: middle; text-align:center"> Detail </th>
		</tr>
	<?php
	$tgl_mulai      = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
	$tgl_selesai    = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';
	//$no = $offset + 1;

	$mulai=1;
	if (!empty($data_anggota)) {

		foreach ($data_anggota as $key => $row) {
    		if(($no % 2) == 0) {$warna="#EEEEEE"; } 
    		else {$warna="#FFFFFF";}
    		echo '<tr>';
    		    //  Nomor
    		    echo '<td>'.($key+1).'</td>';
    		    //  Nama
    		    echo '<td style="width:15%;">'.strtoupper($row->nama).'</td>';
    		    //  Alamat
    		    echo '<td style="width:35%;">'.$row->alamat.'</td>';
    		    $setoran_total = 0;
		        
    		   foreach ($data_jns_simpanan as $jenis) {
					//  Data Setoran
					
    		        $data_setoran =  $this->sisa_m->get_jml_simpanan();
    		        $setoran = $data_setoran->jml_total;
    		        $setoran_total += $setoran;
    		        //  Data Penarikan
    		        $data_penarikan =  $this->sisa_m->get_jml_penarikan();
    		        $penarikan = $data_penarikan->jml_total;
    		        $penarikan_total += $penarikan;
    		        
    		        $jumlah_total = $setoran_total - $penarikan_total;
    		   }
    		    //  Setoran
    		    echo '<td style="width:10%;"><strong>Rp. '.number_format($setoran_total).'</strong></td>'; 
    		    //  Penarikan
    		    echo '<td style="width:10%;"><strong>Rp. '.number_format($penarikan_total).'</strong></td>';
    		    //  Saldo
    		    echo '<td style="width:10%;"><strong>Rp. '.number_format($jumlah_total).'</strong></td>';
    		    //  Detail
    		    echo '<td class="h_tengah"><a href=" '.base_url().'sisa/detail/'.$row->id.'" class="easyui-linkbutton"  iconCls="icon-search" plain="false">Lihat </a></td>';
    		echo '</tr>';
		}
	} else {
		echo '<tr>
				<td colspan="100" >
					<code> Tidak Ada Data <br> </code>
				</td>
			</tr>';
	}
	echo '</table>';
	echo '<div class="box-footer">'.$halaman.'</div>';
	?>
</div>
</div>
	
<script type="text/javascript">
	$(document).ready(function() {

    	$('#anggota_id').combogrid({
    		panelWidth:300,
    		url: '<?php echo site_url('lap_shu_anggota/list_anggota'); ?>' ,
    		idField:'id',
    		valueField:'id',
    		textField:'id_nama',
    		mode:'remote',
    		fitColumns:true,
    		columns:[[
    			{field:'photo',title:'Photo',align:'center',width:5},
    			{field:'id',title:'ID', hidden: true},
    			{field:'id_nama', title:'IDNama', hidden: true},
    			{field:'kode_anggota', title:'ID', align:'center', width:15},
    			{field:'nama',title:'Nama Anggota',align:'left',width:20}
    		]]
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

        fm_filter_tgl();
    }); // ready

    function clearSearch(){
    	window.location.href = '<?php echo site_url("sisa"); ?>';
    }

    function cetak () {
    	<?php 
    		if(isset($_REQUEST['anggota_id'])) {
    			echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
    		} else {
    			echo 'var anggota_id = $("#anggota_id").val();';
    		}
    		
    		if(isset($_REQUEST['tgl_mulai'])) {
    			echo 'var tgl_mulai = "'.$_REQUEST['tgl_mulai'].'";';
    		} else {
    			echo 'var tgl_mulai = "";';
    		}
    		
    		if(isset($_REQUEST['tgl_selesai'])) {
    			echo 'var tgl_selesai = "'.$_REQUEST['tgl_selesai'].'";';
    		} else {
    			echo 'var tgl_selesai = "";';
    		}
    	?>
    	var win = window.open('<?php echo site_url("sisa/cetak_laporan/?anggota_id=' + anggota_id +'&tgl_mulai=' + tgl_mulai +'&tgl_selesai=' + tgl_selesai +'"); ?>');
    	if (win) {
    		win.focus();
    	} else {
    		alert('Popup jangan di block');
    	}
    	//$('#fmCari').attr('action', '<?php echo site_url('sisa/cetak_laporan'); ?>');
    	//$('#fmCari').submit();
    }

    function doSearch() {
    	$('#fmCari').submit();
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
    		$("input[name=tgl_mulai]").val(start.format('YYYY-MM-DD'));
    		$("input[name=tgl_selesai]").val(end.format('YYYY-MM-DD'));
    		doSearch();
    	});
    }
</script>