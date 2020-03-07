<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sisa_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}


	//menghitung jumlah simpanan umum
	function get_jml_simpanan_umum($jenis, $id) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('anggota_id',$id);
		$this->db->where('jenis_id','3103');
		$this->db->where('jenis_id',$jenis);  
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah simpanan
	function get_jml_simpanan($jenis = false, $anggota_id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_transaksi >=' => $tgl_mulai, 'tgl_transaksi <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where($array);
// 		$this->db->where('dk','D');
		if($jenis) {
		    $this->db->where('jenis_id', $jenis);   
		}
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data jenis simpan
	function get_jenis_simpan() {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//menghitung jumlah penarikan
	function get_jml_penarikan($jenis = false, $anggota_id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_transaksi >=' => $tgl_mulai, 'tgl_transaksi <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
// 		$this->db->where('dk','K');
		$this->db->where($array);
		if($jenis) {
		    $this->db->where('jenis_id', $jenis);   
		}
		$query = $this->db->get();
		return $query->row();
	}

	function get_data_anggota($limit, $start, $q='') {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$sql = '';
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$q = array('anggota_id' => $anggota_id);
		if (is_array($q)){
			if($q['anggota_id'] != '') {
				$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
				$sql .=" AND (id LIKE '".$q['anggota_id']."' OR nama LIKE '".$q['anggota_id']."') ";
			}
		}
		$sql .= " ORDER BY nama";
		$sql .= " LIMIT ".$start.", ".$limit." ";
		//$this->db->limit($limit, $start);
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}
	
	//panggil data anggota
	function lap_data_anggota() {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$sql = '';
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$q = array('anggota_id' => $anggota_id);
		if (is_array($q)){
			if($q['anggota_id'] != '') {
				$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
				$sql .=" AND (id LIKE '".$q['anggota_id']."') ";
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_jml_data_anggota() {
		$this->db->where('aktif', 'Y');
		return $this->db->count_all_results('tbl_anggota');
	}

    //ambil data pinjaman header berdasarkan ID peminjam
	function get_data_pinjam($anggota_id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_pinjam >=' => $tgl_mulai, 'tgl_pinjam <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where($array);
		$this->db->where('lunas','Belum');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return array();
		}
	}


	function get_peminjam_lunas($anggota_id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_pinjam >=' => $tgl_mulai, 'tgl_pinjam <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Lunas');
		$this->db->where($array);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_peminjam_tot($anggota_id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_pinjam >=' => $tgl_mulai, 'tgl_pinjam <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where($array);
		$query = $this->db->get();
		return $query->num_rows();
	}

	//menghitung jumlah yang sudah dibayar
	function get_jml_pinjaman($anggota_id, $tgl_mulai, $tgl_selesai) {
	   if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('anggota_id' => $anggota_id, 'tgl_pinjam >=' => $tgl_mulai, 'tgl_pinjam <=' => $tgl_selesai);
	    } else {
	        $array = array('anggota_id' => $anggota_id);
	    }
		$this->db->select('SUM(jumlah) AS total');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah yang sudah dibayar
	function get_jml_tagihan($id) {
		$this->db->select('SUM(tagihan) AS total');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		return $query->row();
	}


	//menghitung jumlah yang sudah dibayar
	function get_jml_bayar($id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('pinjam_id' => $id, 'tgl_bayar >=' => $tgl_mulai, 'tgl_bayar <=' => $tgl_selesai);
	    } else {
	        $array = array('pinjam_id' => $pinjam_id);
	    }
		$this->db->select('SUM(jumlah_bayar) AS total');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah denda harus dibayar
	function get_jml_denda($id, $tgl_mulai, $tgl_selesai) {
	    if($tgl_mulai != '' && $tgl_selesai != '') {
    	    $array = array('pinjam_id' => $id, 'tgl_bayar >=' => $tgl_mulai, 'tgl_bayar <=' => $tgl_selesai);
	    } else {
	        $array = array('pinjam_id' => $pinjam_id);
	    }
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_data_transaksi_ajax($anggota_id, $offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT * FROM `tbl_trans_sp` WHERE `anggota_id`=".$anggota_id;
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
		        $q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('TRK', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND `id` LIKE '".$q['kode_transaksi']."'";
		    }
		    if($q['cari_simpanan'] != '') {
				$sql .=" AND `jenis_id` = '".$q['cari_simpanan']."%' ";
			} elseif($q['cari_simpanan'] == '') {
			    $sql .=" AND `jenis_id` NOT IN (3101)";
			} 
			if($q['no_rek'] != '') {
				$sql .=" AND `no_rek` LIKE '%".$q['kode_transaksi']."%'";
			} 
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
			} 
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}
	
	function get_no_rek($anggota_id,$jenis_id=false) {
		$this->db->select('*');
		$this->db->from('tabungan');
		$this->db->where('anggota_id',$anggota_id);
		if($jenis_id) {
		    $this->db->where('jenis_id',$jenis_id);
		}
		$query = $this->db->get();
		if($query->num_rows()>0){
// 			$out = $query->row();
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function get_data_cetak($q='', $sort, $order) {
		$sql = "SELECT * FROM `tbl_trans_sp` WHERE `anggota_id` = '".$q['anggota_id']."'";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
		        $q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('TRK', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND `id` LIKE '".$q['kode_transaksi']."'";
		    }
		    if($q['cari_simpanan'] != '') {
				$sql .=" AND `jenis_id` = '".$q['cari_simpanan']."%' ";
			} elseif($q['cari_simpanan'] == '') {
			    $sql .=" AND `jenis_id` NOT IN (3101)";
			} 
// 			if($q['anggota_id'] != '') {
// 				$sql .=" AND `anggota_id` = '".$q['anggota_id']."' ";
// 			}
			if($q['no_rek'] != '') {
				$sql .=" AND `no_rek` LIKE '%".$q['kode_transaksi']."%'";
			} 
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
			} 
		}
		$sql .=" ORDER BY {$sort} {$order} ";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
// 		return $q;
	}

}

