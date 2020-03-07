<style type="text/css">
	.modal-body { background-color: #fff;}
	.img-rounded { border: 1px solid #ccc !important;}
	.center-block { float: none; }
	td.bs-checkbox {vertical-align: middle !important;}
	.btn {margin-top: 2px; margin-bottom: 2px;}
	.select2-choices {
		min-height: 150px;
		max-height: 150px;
		overflow-y: auto;
	}
	p{
		font-size:20px;
	}
</style>   
	<div class="row">
		<div class="box box-primary">
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Formulir Pengajuan </p>
        </div>
        <br>
</div>

<!-- form inputan -->


<div class="row">
    <div class="col-md-5">
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
                <label for="wakil" class="control-label">Wakil</label>
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
                <!-- <label for="omset_usaha" class="control-label">Omset Perbulan</label> -->
                <label for="omset_usaha" class="control-label">Omset Perbulan</label>
                <input type="text" class="easyui-numberbox form-control" id="omset_usaha" name="omset_usaha" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
            </div>
            <div class="form-group">
                <label for="biaya_hidup" class="control-label">Biaya Hidup</label>
				<input type="text" class="easyui-numberbox form-control" id="biaya_hidup" name="biaya_hidup" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
            </div>

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
                <label for="nominal" class="control-label">Nominal Pinjaman</label>
				<input type="text" class="easyui-numberbox form-control" id="nominal" name="nominal" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" style="height:40px;"/>
            </div>

            <div class="form-group">
                <label for="lama_angsuran" class="control-label">Lama Angsuran</label>
				<input type="number" name="lama_angsuran" id="lama_angsuran" class="form-control" required="true">
            </div>

			<div class="form-group">
				<label for="bunga" class="control-label">Tentukan Bunga</label>
				<select name="bunga" id="bunga" class="form-control">
					<option value="">Tentukan Bunga</option>
				<?php foreach($this->db->get_where('suku_bunga',['opsi_key' => 'bg_pinjam'])->result() as $b ): ?>
					<option value="<?= $b->opsi_val ?>"><?= $b->opsi_val ?></option>
				<?php endforeach; ?>
				</select>
			</div>

            <div class="form-group">
                <label for="keterangan" class="control-label">Alasan Pinjam</label>
                <input type="text" id="keterangan" name="keterangan" class="form-control">
            </div>
                <input type="hidden" id="surveyor" name="surveyor" value="<?php echo $u_name; ?>">
    </div>


    <div class="col-md-5">
        
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
                        <select id="jenis_bpkp" name="jenis_bpkb" class="form-control">
						<option value="">Pilih</option>
                            <option value="mobil">Mobil</option>
                            <option value="sepeda motor">Sepeda Motor</option>
                        </select>
                    </div>

					<div class="form-group">
                        <label for="merek" class="control-label">Merek</label>
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
						<input type="number" name="harga_taksiran_kendaraan" id="harga_taksiran_kendaraan" class="form-control">
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
                        <input type="text" id="kab_shm" name="kab_shm" class="form-control" >
                    </div>

					<div class="form-group">
                        <label for="prov_shm" class="control-label">Prov SHM</label>
                        <input type="text" id="prov_shm" name="prov_shm" class="form-control" >
                    </div>

					<div class="form-group">
                        <label for="tgl_ukut" class="control-label">Tanggal Ukur SHM</label>
                        <input type="text" id="tgl_ukut" name="tgl_ukut" class="form-control" >
                    </div>

					<div class="form-group">
                        <label for="harga_taksiran" class="control-label">Harga Taksiran</label>
						<input type="number" name="harga_taksiran_shm" id="harga_taksiran_shm" class="form-control">
                    </div>
                </div>
                <div class="form-group tombol-simpan">
                        <button type="submit" name="pengajuan" class="btn btn-primary">Simapn Pengajuan</button>
                </div>
                </form>
    </div>
    
    </div>

</div>      


    <script>
        $(function(){
            
            $('#form-jaminan').hide();
            $('#pilih-jaminan').on('change', function(){
                const jaminan = $(this).val();
                if(jaminan === "kendaraan"){
                    $('#form-jaminan').show();
                    $('#form-kendaraan').show();
                    $('#form-shm').hide();
                    $('.tombol-simpan').show();
                }else if(jaminan === "shm"){
                    $('#form-jaminan').show();
                    $('#form-kendaraan').hide();
                    $('#form-shm').show();
                    $('.tombol-simpan').show();
                }else{
					$('#form-jaminan').hide();
				}
            });

            // anggota grid

        $('#anggota_id').combogrid({
		panelWidth:400,
		url: '<?php echo site_url('penarikan/list_anggota'); ?>',
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
				url: '<?php echo base_url(  ); ?>pengajuan/get_anggota_by_id',
				method: 'POST',
				dataType: 'json',
				data: {id: val_anggota_id},
			})
			.done(function(result) {
				$('#nik').val(result.ktp);
				$('#alamat').val(result.alamat);
				
			})
			.fail(function() {
				alert('Koneksi error, silahkan ulangi.')
			});
		}
	});

		$('#omset_usaha ~ span input').keyup(function(){
    		var val_omset = $(this).val();
    		$('#omset_usaha').numberbox('setValue', val_omset);
    	});
		$('#nominal ~ span input').keyup(function(){
    		var nominal = $(this).val();
    		$('#nominal').numberbox('setValue', nominal);
    	});
		$('#harga_taksiran_kendaraan ~ span input').keyup(function(){
    		var harga_taksiran_kendaraan = $(this).val();
    		$('#harga_taksiran_kendaraan').numberbox('setValue', harga_taksiran_kendaraan);
    	});
		$('#harga_taksiran_shm ~ span input').keyup(function(){
    		var harga_taksiran_shm = $(this).val();
    		$('#harga_taksiran_shm').numberbox('setValue', harga_taksiran_shm);
    	});
		$('#biaya_hidup ~ span input').keyup(function(){
    		var biaya_hidup = $(this).val();
    		$('#biaya_hidup').numberbox('setValue', biaya_hidup);
    	});

        });


    </script>
            

           

           

            

            

           

            
            

            
           

            
            
    </div>
</div>
<!-- end form inputan -->

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
			//doSearch();
		});
	}

	function nominal_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a id="nominal_'+row.id+'" href="javascript:void(0);" class="" data-type="text" data-name="nominal" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Masukan Nominal baru">'+value+'</a>';

				$('#nominal_'+row.id).editable({
						success: function(response, newValue) {
							if(!response) return 'Error';
							return {newValue: response}
						}
				});

	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function keterangan_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a href="javascript:void(0);" class="editable" data-type="text" data-name="keterangan" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Masukan Keterangan baru">'+value+'</a>';
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function sisa_ft(value, row, index) {
		var nsi_out = '';
		if(row.jenis != 'Darurat') {
			nsi_out += '<span class="text-muted">Sisa Jml Pinjaman:</span> '+row.sisa_jml;
			nsi_out += '<br><span class="text-muted">Sisa Jml Angsuran:</span> '+row.sisa_ags;
			nsi_out += '<br><span class="text-muted">Sisa Tagihan:</span> '+row.sisa_tagihan;
		}
		return nsi_out;
	}

	function status_ft(value, row, index) {
		var nsi_out = '';
		if(value == 0) {
			nsi_out += '<span class="text-primary"><i class="fa fa-question-circle"></i> Menunggu Konfirmasi';
		}
		if(value == 1) {
			nsi_out += '<span class="text-success"><i class="fa fa-check-circle"></i> Disetujui';
			nsi_out += '<br>Cair: ' + row.tgl_cair_txt;
		}
		if(value == 2) {
			nsi_out += '<span class="text-danger"><i class="fa fa-times-circle"></i> Ditolak';
		}
		if(value == 3) {
			nsi_out += '<span class="text-success"><i class="fa fa-rocket"></i> Terlaksana';
		}
		if(value == 4) {
			nsi_out += '<span class="text-warning"><i class="fa fa-trash-o"></i> Batal';
		}
		nsi_out += '</span>';
		return  nsi_out;
	}

	function anggota_ft(value, row, index) {
		nsi_out = '';
		nsi_out += '<a title="Lihat History Pinjaman Anggota" href="<?php echo site_url('lap_kas_anggota'); ?>/?anggota_id='+row.anggota_id+'">'+row.identitas+'</a><br>';
		nsi_out += '<strong>'+row.nama+'</strong><br>';
		nsi_out += row.departement;
		return nsi_out;
	}

	function lama_ags_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a id="lama_ags_'+row.id+'" href="javascript:void(0);" class="editable" data-type="select" data-name="lama_ags" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Pilih Lama Angsuran baru">'+value+'</a>';
	    	$('#lama_ags_'+row.id).editable({
	    		value: value,
	    		source: [
		    		<?php 
		    		$no = 1;
		    		foreach ($jenis_ags as $row) {
		    			if($no > 1) { echo ','; }
			    		echo '{value: '.$row->ket.', text: \''.$row->ket.'\'}';
			    		$no++;
		    		} ?>
	    		]
	    	});
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}
	function tgl_input_ft(value, row, index) {
		return '<span title="'+row.tgl_input+'">'+row.tgl_input_txt+'</span>';
	}
	function tgl_update_ft(value, row, index) {
		return '<span title="'+row.tgl_update+'">'+row.tgl_update_txt+'</span>';
	}

	function aksi_ft(value, row, index) {
		var nsi_out = '';
		<?php if($this->session->userdata('level') != 'operator') { ?>
			var link_diterima = '<a data-data_aksi="Setuju" data-data_id="'+row.id+'" class="a_diterima btn btn-sm btn-success" href="javascript:void(0);"><i class="fa fa-check-circle"></i> Setujui</a>';
			var link_ditolak = '<a data-data_aksi="Tolak" data-data_id="'+row.id+'" class="a_ditolak btn btn-sm btn-warning" href="javascript:void(0);"><i class="fa fa-times-circle"></i> Tolak</a>';
			var link_pending = '<a data-data_aksi="Pending" data-data_id="'+row.id+'" class="a_dipending btn btn-sm btn-primary" href="javascript:void(0);"><i class="fa fa-question-circle"></i> Pending</a>';
			var link_batal = '<a data-data_aksi="Batal" data-data_id="'+row.id+'" class="a_dibatal btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-trash-o"></i> Batal</a>';

			if(row.status == 0) {
				nsi_out += link_diterima + ' ' + link_ditolak;
			}
			if(row.status == 1) {
				nsi_out += link_ditolak + ' ' + link_pending;
			}
			if(row.status == 2) {
				nsi_out += link_diterima + ' ' + link_pending;
			}
			if(row.status != 4 && row.status == 0) {
				nsi_out += ' ' + link_batal;
			}
		<?php } ?>
		<?php if($this->session->userdata('level') != 'pinjaman') { ?>
			var link_terlaksana = ' <a data-data_aksi="Terlaksana" data-data_id="'+row.id+'" class="a_dilaksanakan btn btn-sm btn-info" href="javascript:void(0);"><i class="fa fa-rocket"></i> Sudah Dilaksanakan</a>';
			var link_belum = ' <a data-data_aksi="Belum" data-data_id="'+row.id+'" class="a_belum btn btn-sm btn-default" href="javascript:void(0);"><i class="fa fa-rocket"></i> Belum Dilaksanakan</a>';
			if(row.status == 1) {
				nsi_out += link_terlaksana;
			}
			if(row.status == 3) {
				nsi_out += link_belum;
			}
		<?php } ?>
		<?php if($this->session->userdata('level') == 'admin') { ?>
			nsi_out += ' <a data-data_aksi="Hapus" data-data_id="'+row.id+'" class="a_hapus btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times-circle"></i> Hapus</a>';
		<?php } ?>
		nsi_out += ' <a href="<?php echo site_url('cetak_pengajuan/cetak');?>/'+row.id+'" target="_blank" class="btn btn-sm bg-purple"><i class="fa fa-print"></i> Cetak</a>';
		return  nsi_out;
	}


	$(function() {

		$('#fr_bulan').datepicker({
			format: "yyyy-mm",
			weekStart: 1,
			startView: 1,
			minViewMode: 1,
			language: "id",
			autoclose: true,
			clearBtn: true,
			todayHighlight: true
		});

		var $table = $('#tablegrid');

		$table.on('load-success.bs.table', function(event) {
			$('.editable').editable();
		});

		$table.on('click', '.a_diterima, .a_ditolak, .a_dipending, .a_hapus, .a_dilaksanakan, .a_belum, .a_dibatal', function(event) {
			var data_id = $(this).data('data_id');
			var data_aksi = $(this).data('data_aksi');

			$('#link_konfirmasi').show();
			$('#link_konfirmasi_batal').text('Batal');
			$('.modal_hasil').html('Apakah Yakin Ingin <strong>'+data_aksi+'</strong> Ajuan ini?');
			var fm_tgl_cair = '';
			if(data_aksi == 'Setuju') {
				data_default_tgl_cair = '<?php echo date('Y-m-d'); ?>';
				fm_tgl_cair = '<div id="div_tgl_cair" class="form-group">'+
										'<label>Tanggal Pencairan:</label>'+
										'<div class="input-group">'+
											'<div class="input-group-addon">'+
												'<i class="fa fa-calendar"></i>'+
											'</div>'+
											'<input name="tgl_cair" id="tgl_cair" type="text" class="datepicker form-control" style="width:100px;" value="'+data_default_tgl_cair+'">'+
										'</div>'+
									'</div>';
			}
			if(data_aksi == 'Hapus' || data_aksi == 'Batal' || data_aksi == 'Terlaksana' || data_aksi == 'Belum') {
				$('#div_tgl_cair').remove();
				$('#div_alasan_input').remove();
			} else {
				$('#div_alasan').show();
				$('#div_alasan').html('<div id="div_alasan_input" class="form-group"><label>Alasan:</label><input type="text" name="alasan" id="alasan" class="form-control" value=""></input></div>' + fm_tgl_cair);
			}
			$('#modal_aksi').modal('show');
			
			$('.modal-backdrop.fade.in').css('z-index', '1039');
			$('.modal-backdrop.fade.in').css('background-color', '#000');
			$('#link_konfirmasi').data('data_id', data_id);
			$('#link_konfirmasi').data('data_aksi', data_aksi);
			$('#link_konfirmasi').text('OK '+data_aksi);
			$('.datepicker').datepicker({
				format: "yyyy-mm-dd",
				weekStart: 1,
				language: "id",
				calendarWeeks: true,
				autoclose: true,
				todayHighlight: true
			});
		});


		$('#link_konfirmasi').click(function(event) {
			var data_id = $(this).data('data_id');
			var data_aksi = $(this).data('data_aksi');
			var data_alasan = $('#alasan').val();
			var data_tgl_cair = $('#tgl_cair').val();
			$.ajax({
				url: '<?php echo site_url('pengajuan/aksi'); ?>',
				type: 'POST',
				dataType: 'html',
				data: {id: data_id, aksi: data_aksi, tgl_cair: data_tgl_cair, alasan: data_alasan},
			})
			.done(function(data) {
				if(data == 'OK') {
					$('.modal_hasil').html('<div class="alert alert-success">Pengajuan Telah Sukses <strong>' + data_aksi + '</strong></div>');
					$('#link_konfirmasi').hide('slow');
					$('#div_alasan').hide('fast');
					$('#link_konfirmasi_batal').text('Tutup');
					$table.bootstrapTable('refresh');
				} else {
					$('.modal_hasil').html('<div class="alert alert-danger">Gagal, silahkan ulangi kembali. Kemungkinan data error atau sudah tidak ada.</div>');
				}
			})
			.fail(function() {
				alert('Error, Silahkan ulangi');
			});
		});

		// $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		fm_filter_tgl();
		$('.select2_jenis').select2({
			placeholder: "Semua Jenis"
		});
		$('.select2_status').select2({
			placeholder: "Semua Status"
		});
		$('#fm_filter').click(function(event) {
			$table.bootstrapTable('refresh');
		});
	});

	function queryParams(params) {
		//console.log(params);
		return {
 			"limit"		: params.limit,
 			"offset"		: params.offset,
 			//"search"		: params.search,
 			"sort"		: params.sort,
 			"order"		: params.order,
 			"fr_jenis"	: $('#fr_jenis').val(),
 			"fr_status"	: $('#fr_status').val(),
 			"fr_bulan"	: $('#fr_bulan').val(),
			"tgl_dari"	: $('input[name=daterangepicker_start]').val(),
			"tgl_sampai": $('input[name=daterangepicker_end]').val()		
		}
	}

	function cetak_laporan () {
		var fr_jenis	= $('#fr_jenis').val();
		var fr_status	= $('#fr_status').val();
		var fr_bulan	= $('#fr_bulan').val();
		var tgl_dari	= $('input[name=daterangepicker_start]').val();
		var tgl_sampai	= $('input[name=daterangepicker_end]').val();

		if(fr_jenis == null) { fr_jenis = '';}
		if(fr_status == null) { fr_status = '';}
		
		var win = window.open('<?php echo site_url("cetak_pengajuan/laporan/?fr_jenis=' + fr_jenis + '&fr_status=' + fr_status + '&fr_bulan=' + fr_bulan + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}

</script>