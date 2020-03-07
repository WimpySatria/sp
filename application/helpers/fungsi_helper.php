<?php
if (!function_exists('jin_date_ina')) {
	function jin_date_ina($date_sql, $tipe = 'full', $time = false) {
		$date = '';
		if($tipe == 'full') {
			$nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		} else {
			$nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		}
		if($time) {
			$exp = explode(' ', $date_sql);
			$exp = explode('-', $exp[0]);
			if(count($exp) == 3) {
				$bln = $exp[1] * 1;
				$date = $exp[2].' '.$nama_bulan[$bln].' '.$exp[0];
			}		
			$exp_time = $exp = explode(' ', $date_sql);
			$date .= ' jam ' . substr($exp_time[1], 0, 5);
		} else {
			$exp = explode('-', $date_sql);
			if(count($exp) == 3) {
				$bln = $exp[1] * 1;
				if($bln > 0) {
					$date = $exp[2].' '.$nama_bulan[$bln].' '.$exp[0];
				}
			}
		}
		return $date;
	}
}

if (!function_exists('jin_nama_bulan')) {
	function jin_nama_bulan($bln, $tipe='full') {
		$bln = $bln * 1;
		if($tipe == 'full') {
			$nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		} else {
			$nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		}
		return $nama_bulan[$bln];
	}
}

if (!function_exists('nsi_round')) {
	function nsi_round($x) {
		//$x = ceil($x / 100) * 100;
		return $x;
	}
}

// if (!function_exists('cek_bunga')) {
//  	function cek_bunga()
// 	{
// 		$tanggal_update = date('Y-m-d');

// 		$sql = "SELECT * FROM tbl_trans_depo";
// 		$data = $this->db->query($sql)->result();
// 		$sql_bunga = "SELECT * FROM suku_bunga_su WHERE opsi_key='bg_pinjam'";
// 		$data_bunga = $this->db->query($sql_bunga)->result();
// 		$bunga = $data_bunga[0]->opsi_val;
// 		// Kondisi jika tanggal 1 maka proses deposito bunga berjalan
// 		// if (date('d') == '01') {
// 			foreach ($data as $key => $value) {
// 				$jumlah = $value->jumlah + (($value->jumlah*$bunga)/100);
// 				$this->db->where('id', $value->id);
// 				$this->db->update('tbl_trans_depo',array(
// 					'tgl_update_jumlah'	=>	$tanggal_update,
// 					'jumlah'			=>	$jumlah,
// 				));
// 				echo $jumlah;
// 			}
// 		// }
// 		// print_r($data_bunga[0]->opsi_val);
// 	}
// }




