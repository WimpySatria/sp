<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_tabungan_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//panggil data tabungan
	function get_data_jenis_tabungan($limit, $start) {
		$this->db->select('*');
		$this->db->from('jns_tabungan');
		$this->db->where('tampil','Y');
		$this->db->order_by('id', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}


	function get_jml_data_tabungan() {
		$this->db->where('tampil', 'Y');
		return $this->db->count_all_results('jns_tabungan');
	}

	//menghitung jumlah tabungan
	function get_jml_tabungan($jenis) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_tb');
		$this->db->where('dk','D');
		$this->db->where('jenis_id', $jenis);

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

//panggil data jenis tabungan untuk laporan
	function lap_jenis_tabungan() {
		$this->db->select('*');
		$this->db->from('jns_tabungan');
		$this->db->where('tampil','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//menghitung jumlah penarikan sesuai jenis
	function get_jml_penarikan($jenis) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_tb');
		$this->db->where('dk','K');
		$this->db->where('jenis_id', $jenis);

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');
		
		$query = $this->db->get();
		return $query->row();
	}
}