<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan_m extends CI_Model {

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
	function lap_data_simpanan($q='', $sort, $order) {
		$sql = "SELECT * FROM `tbl_trans_sp` WHERE `dk`='D'";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
		        $q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND `id` LIKE '".$q['kode_transaksi']."' OR `no_rek` LIKE '%".$q['kode_transaksi']."%' ";
		    } 
		    if($q['cari_simpanan'] != '') {
				$sql .=" AND `jenis_id` = '".$q['cari_simpanan']."%' ";
			} 
			if($q['anggota'] != '') {
				$sql .=" AND `anggota_id` = '".$q['anggota']."' ";
			} 
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
			} 
			if($q['user'] != '') {
				$sql .=" AND `user_name` LIKE '%".$q['user']."%' ";
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
	
	//panggil data nomor rekening
	function get_no_rek($anggota_id,$jenis_id) {
		$this->db->select('*');
		$this->db->from('tabungan');
		$this->db->where('anggota_id',$anggota_id);
		$this->db->where('jenis_id',$jenis_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
// 			$out = $query->row();
			return $query->result();
		} else { 
			return FALSE;
		}
	}

	//hitung jumlah total simpanan
	function get_jumlah($jenis_id,$no_rek) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','D');
		$this->db->where('jenis_id',$jenis_id);
		$this->db->where('no_rek',$no_rek);
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT * FROM `tbl_trans_sp` WHERE `dk`='D' AND jenis_id != '3101'";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
		        $q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND `id` LIKE '".$q['kode_transaksi']."' OR `no_rek` LIKE '%".$q['kode_transaksi']."%' ";
		    } 
		    if($q['cari_simpanan'] != '') {
				$sql .=" AND `jenis_id` = '".$q['cari_simpanan']."%' ";
			} 
			if($q['anggota'] != '') {
				$sql .=" AND `anggota_id` = '".$q['anggota']."' ";
			} 
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
			} 
			if($q['user'] != '') {
				$sql .=" AND `user_name` LIKE '%".$q['user']."% ' ";
			}
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	

	public function create($saldo) {
		
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0 OR $this->input->post('no_rek') == 0)  {
			return FALSE;
		}		
		$data = array(	 		 
			'tgl_transaksi'         =>	$this->input->post('tgl_transaksi'),
			'anggota_id'			=>	$this->input->post('anggota_id'),
			'jenis_id'				=>	$this->input->post('jenis_id'),
			'jumlah'                =>	str_replace(',', '', $this->input->post('jumlah')),
			'saldo'     			=>	$saldo,
			'keterangan'			=> $this->input->post('ket'),
			'no_rek'                => $this->input->post('no_rek'),
			'akun'					=>	'Setoran',
			'dk'                    =>	'D',
			'kas_id'                =>	$this->input->post('kas_id'),
			'user_name'				=> $this->data['u_name'],
			'nama_penyetor'			=> $this->input->post('nama_penyetor'),
			'no_identitas'			=> $this->input->post('no_identitas'),
			'alamat'                => $this->input->post('alamat')
			);
		return $this->db->insert('tbl_trans_sp', $data);
	}

	public function update($id)
	{
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		return $this->db->update('tbl_trans_sp',array(
			'tgl_transaksi'     =>	$this->input->post('tgl_transaksi'),
			'jenis_id'          =>	$this->input->post('jenis_id'),
			'jumlah'            =>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'        => $this->input->post('ket'),
			'no_rek'            => $this->input->post('no_rek'),
			'kas_id'            =>	$this->input->post('kas_id'),
			'update_data'       => $tanggal_u,
			'user_name'         => $this->data['u_name'],
			'nama_penyetor'		=> $this->input->post('nama_penyetor'),
			'no_identitas'      => $this->input->post('no_identitas'),
			'alamat'            => $this->input->post('alamat')
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_trans_sp', array('id' => $id)); 
	}

	public function get_nama($nama){
		$query  = "SELECT * FROM tbl_anggota WHERE nama LIKE '%$nama%' ORDER BY nama DESC";
		return $this->db->query($query);
	}
}