<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hitung_bunga_m extends CI_Model {

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
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		$sql = '';
		$sql = "SELECT `tbl_trans_sp`.*, `tabungan`.`no_rek`, `tabungan`.`tgl_pembuatan` FROM `tbl_trans_sp` LEFT JOIN `tabungan` ON `tbl_trans_sp`.`jenis_id` = `tabungan`.`jenis_id` AND `tbl_trans_sp`.`dk`='D'";
		$q = array('kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND (`tbl_trans_sp`.`id` LIKE '".$q['kode_transaksi']."' OR `tbl_trans_sp`.`anggota_id` LIKE '".$q['kode_transaksi']."') ";
			} else {
				if($q['cari_simpanan'] != '') {
					$sql .=" AND `tbl_trans_sp`.`jenis_id` = '".$q['cari_simpanan']."%' ";
				}
				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(`tbl_trans_sp`.`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(`tbl_trans_sp`.`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
				}
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

	public function get_saldo($tgl_mulai,$tgl_sampai){

		
		$sql = 'SELECT `tbl_trans_sp`.`no_rek`, `tbl_trans_sp`.`dk`,`tbl_trans_sp`.`anggota_id`,`tbl_trans_sp`.`jenis_id`, `tbl_trans_sp`.`jumlah`, `tbl_trans_sp`.`tgl_transaksi`, MIN(`tbl_trans_sp`.`saldo`) FROM `tbl_trans_sp`, `tabungan` WHERE `tbl_trans_sp`.`no_rek` = `tabungan`.`no_rek` AND `tbl_trans_sp`.`dk` = "D" AND `tbl_trans_sp`.`jenis_id` = 3103  AND `tbl_trans_sp`.`tgl_transaksi` BETWEEN "'.$tgl_mulai.'" AND "'.$tgl_sampai.'" GROUP BY `tbl_trans_sp`.`no_rek` ';
		$result['data'] = $this->db->query($sql)->result_array();
		return $result;


	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT `tbl_trans_sp`.*, `tabungan`.`no_rek`, `tabungan`.`tgl_pembuatan` FROM `tbl_trans_sp` LEFT JOIN `tabungan` ON `tbl_trans_sp`.`jenis_id` = `tabungan`.`jenis_id` AND `tbl_trans_sp`.`dk`='D'";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
	
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				// ni ade kode yg di hapus kmaren
				$sql .=" AND `tbl_trans_sp`.`anggota_id` LIKE '".$q['kode_transaksi']."'";
			} else {
				if($q['cari_simpanan'] != '') {
					$sql .=" AND `tbl_trans_sp`.`jenis_id` = '".$q['cari_simpanan']."%' ";
				} 

				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(`tbl_trans_sp`.`tgl_transaksi`) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(`tbl_trans_sp`.`tgl_transaksi`) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}		
		$data = array(			 
			'tgl_transaksi'		=>	$this->input->post('tgl_transaksi'),
			'anggota_id'			=>	$this->input->post('anggota_id'),
			'jenis_id'				=>	$this->input->post('jenis_id'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=> $this->input->post('ket'),
			'akun'					=>	'Setoran',
			'dk'						=>	'D',
			'kas_id'					=>	$this->input->post('kas_id'),
			'user_name'				=> $this->data['u_name'],
			'nama_penyetor'			=> $this->input->post('nama_penyetor'),
			'no_identitas'			=> $this->input->post('no_identitas'),
			'alamat'					=> $this->input->post('alamat')
			);
		return $this->db->insert('tbl_trans_sp', $data);
	}

	public function update($no_rek)
	{

		$this->db->where('no_rek', $no_rek);
		return $this->db->update('hitung_bunga',array(
			'bunga'				=>	$this->input->post('bunga'),
			'hitungan_bunga'	=>	$this->input->post('hasil')
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_trans_sp', array('id' => $id)); 
	}
}