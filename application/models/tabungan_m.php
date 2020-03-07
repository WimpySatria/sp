<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tabungan_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	#panggil data kas
	function get_data_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif', 'Y');
		$this->db->where('tmpl_simpan', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data simpanan untuk laporan 
	function lap_data_simpanan() {
		$kode_transaksi = isset($_REQUEST['kode_transaksi']) ? $_REQUEST['kode_transaksi'] : '';
		$cari_simpanan = isset($_REQUEST['cari_simpanan']) ? $_REQUEST['cari_simpanan'] : '';
		$anggota = isset($_REQUEST['anggota']) ? $_REQUEST['anggota'] : '';
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		
		$sql = '';
		$sql = "SELECT `tabungan`.*, `jns_simpan`.*, `tbl_anggota`.`nama`  FROM `tabungan`,`jns_simpan`,`tbl_anggota` WHERE `tabungan`.`anggota_id`= `tbl_anggota`.`id` AND `tabungan`.`jenis_id` = `jns_simpan`.`id`";
		$q = array('kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'user' => $user,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
		    if($q['kode_transaksi'] != '') {
				$sql .=" AND `tabungan`.`no_rek` LIKE '%".$q['kode_transaksi']."%'";
			} 
			if($q['cari_tabungan'] != '') {
				$sql .=" AND `tabungan`.`jenis_id` = '".$q['cari_tabungan']."%' ";
			}
            if($q['anggota'] != '') {
				$sql .=" AND `tabungan`.`anggota_id` = '".$q['anggota']."' ";
			}
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tabungan`.`tgl_pembuatan`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tabungan`.`tgl_pembuatan`) <= '".$q['tgl_sampai']."' ";
			} 
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data anggota
	function get_data_anggota($id) {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data jenis simpan
	function get_jenis_simpan($id) {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//hitung jumlah total simpanan
	function get_jml_simpanan() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','D');
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT `tabungan`.*, `jns_simpan`.*, `tbl_anggota`.`nama`  FROM `tabungan`,`jns_simpan`,`tbl_anggota` WHERE `tabungan`.`anggota_id`= `tbl_anggota`.`id` AND `tabungan`.`jenis_id` = `jns_simpan`.`id`";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$sql .=" AND `tabungan`.`no_rek` LIKE '%".$q['kode_transaksi']."%'";
			} 
			if($q['cari_tabungan'] != '') {
				$sql .=" AND `tabungan`.`jenis_id` = '".$q['cari_tabungan']."%' ";
			}
            if($q['anggota'] != '') {
				$sql .=" AND `tabungan`.`anggota_id` = '".$q['anggota']."' ";
			}
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tabungan`.`tgl_pembuatan`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tabungan`.`tgl_pembuatan`) <= '".$q['tgl_sampai']."' ";
			} 
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		$sql = "SELECT no_rek FROM `tabungan`";
		$jum = $this->db->query($sql)->num_rows();
		$jum++;
		$no_urut = sprintf('%05s',$jum);
		
		$jenis_id = $this->input->post('jenis_id');
		$anggota_id = $this->input->post('anggota_id');
		$koperasi_id = '03';
		$no_rekening = $jenis_id.'-'.$no_urut.'-'.$koperasi_id;
		
		$data = array(			
			'anggota_id'			=>	$this->input->post('anggota_id'),
			'jenis_id'				=>	$jenis_id,
			'no_rek'				=>	$no_rekening,
		);
		return $this->db->insert('tabungan', $data);
	}

	public function update($no_rek)
	{
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('no_rek', $no_rek);
		return $this->db->update('tabungan',array(
			'anggota_id'    =>	$this->input->post('anggota_id'),
			'jenis_id'      =>	$this->input->post('jenis_id'),
			));
	}

	public function delete($no_rek) {
		return $this->db->delete('tabungan', array('no_rek' => $no_rek)); 
	}
}