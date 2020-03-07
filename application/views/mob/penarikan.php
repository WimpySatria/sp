<!DOCTYPE html>
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
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Tambah Setoran</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<img src="<?php echo base_url().'assets/theme_admin/img/logo2.png'; ?>" alt="">
			</div>
			
		</div>
	</nav>

	<div class="container">
	<div class="row">
		<h2 class="text-center text-primary mb-2">Penarikan</h2>
	</div>
		<div class="row">
			<form action="" class="form-horizontal col-sm-2" method="POST">
			<div class="form-group">
					<?php
						$tgl = date('Y-m-d H:i');
						$tanggal_arr = explode(' ', $tanggal);
                        $txt_tanggal = jin_date_ina($tanggal_arr[0]);
                        $txt_tanggal .= ' - ' . $tanggal_arr[1];
					?>
					<label class="control-label " for="tgl_transaksi">Tanggal Transaksi:</label>
					
							<input type="text" name="tgl_transaksi" class="form-control" id="tgl_transaksi" value="<?php echo $tgl?>" readonly />
							
				</div> 
			

				<div class="form-group">
				<label class="control-label" for="email">Nama Nasabah:</label>
					
								<input type="text" id="anggota_id" name="anggota_id" class="form-control" style="height:40px;" >
							
					<!-- <input type="text" id="buah" name="buah" placeholder="Nama Buah" value="">
                	<input type="text" id="nama_anggota" name="anggota_id"> -->
				
                
            </div>

			<div class="form-group">
                <label class="control-label" for="email">Jenis Simpanan:</label>
                
                <select id="jenis_id" name="jenis_id" style="width:100%; height:40px" class="easyui-validatebox" required="true">
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
               
            </div>


			  <div class="form-group">
                <label class="control-label " for="email">Nomor Rekekning:</label>
                
                <select id="no_rek" name="no_rek" style="width:100%; height:40px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Nomor Rekening --</option>
									?>
								</select>
              
            </div> 


			<div class="form-group">
                <label class="control-label " for="email">Jumlah Penarikan:</label>

				<input type="text" class="easyui-numberbox form-control" id="jumlah" name="jumlah" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
              
            </div>

			<div class="form-group">
                <label class="control-label" for="email">Simpan ke Kas:</label>
                
                <select id="kas" name="kas_id" style="width:100%; height:40px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Kas --</option>			
									<?php	
									foreach ($kas_id as $row) {
										echo '<option value="'.$row->id.'" selected>'.$row->nama.'</option>';
									}
									?>
								</select>
               
            </div>

			<div id="dialog-buttons" class="form-group">
			<!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a> -->
			<button type="submit" name="penarikan" class="btn btn-primary">Simpan</button>
			<a href="<?= base_url('mob_marketing') ?>" class="btn btn-danger">Batal</a>
            </div>
		</div>
	</div>
            
</form> 

<script type="text/javascript">
    $(document).ready(function() {
    	$('#no_rek').on('change keyup', function(){
    		val_jenis_id = $('#jenis_id').val();
    		val_no_rek = $('#no_rek').val();
			val_anggota_id = $('input[name=anggota_id]').val();
    		$.ajax({
    			url: '<?php echo site_url()?>penarikan/get_jenis_simpanan',
    			type: 'POST',
    			dataType: 'html',
    			data: {jenis_id: val_jenis_id, anggota_id: val_anggota_id},
    		})
    		.done(function(result) {
    		    $('#jumlah').numberbox('setValue', result);
    		})
    		.fail(function() {
    			alert('Kesalahan Konekasi, silahkan ulangi beberapa saat lagi.');
    		});		
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
    	
    
    
    	

		$('#jumlah ~ span input').keyup(function(){
    		
    		$('#jumlah').numberbox('setValue', $(this).val()); 
        }); 
    
        fm_filter_tgl();
    }); // ready
</script>

</body>

</html>