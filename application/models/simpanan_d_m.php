<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan_d_m extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->cek_bunga();
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
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		$sql = '';
		$sql = "SELECT tbl_trans_depo.*, tabungan.no_rek,tabungan.tgl_pembuatan FROM tbl_trans_depo JOIN tabungan ON tbl_trans_depo.`anggota_id` = tabungan.`anggota_id` AND tbl_trans_depo.dk='D' ";
		$q = array('kode_transaksi' => $kode_transaksi, 
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
	
				// ni ade kode yg di hapus kmaren
				$sql .=" AND tabungan.no_rek LIKE '%".$q['kode_transaksi']."%'";
			} else {

				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(tbl_trans_depo.tgl_transaksi) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(tbl_trans_depo.tgl_transaksi) <= '".$q['tgl_sampai']."' ";
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
		$sql = "SELECT * FROM `tbl_trans_depo` WHERE `dk`='D'";
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
		$tgl_transaksi = $this->input->post('tgl_transaksi', true);
		$lama = $this->input->post('lama',true);
		$tgl_tempo = date('Y-m-d', strtotime('+'. $lama .'months', strtotime($tgl_transaksi)));
		$tgl_update = date('Y-m-d', strtotime('+ 1 months', strtotime($tgl_transaksi)));
		$data = array(			
			'tgl_transaksi'			=>	$tgl_transaksi,
			'anggota_id'			=>	$this->input->post('anggota_id'),
			'jenis_id'				=>	'3101',
			'jumlah'				=>	str_replace(',', '', $this->input->post('jumlah')),
			'jumlah_sebenarnya'		=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=>  $this->input->post('keterangan'),
			'no_rek'                => $this->input->post('no_rek'),
			'no_rek_bunga'          => $this->input->post('no_rek_bunga'),
			'akun'					=>	'Setoran',
			'dk'					=>	'D',
			'kas_id'				=>	$this->input->post('kas_id'),
			'user_name'				=>  $this->data['u_name'],
			'nama_penyetor'			=>  $this->input->post('nama_penyetor'),
			'no_identitas'			=>  $this->input->post('no_identitas'),
			'alamat'				=>  $this->input->post('alamat'),
			'lama'					=>  $lama,
			'jatuh_tempo'			=>  $tgl_tempo,
			'tgl_update_jumlah'		=>  $tgl_update
			);
		return $this->db->insert('tbl_trans_depo', $data);
	}

	public function update($id)
	{
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		return $this->db->update('tbl_trans_sp',array(
			'tgl_transaksi'		=>	$this->input->post('tgl_transaksi'),
			'jenis_id'			=>	$this->input->post('jenis_id'),
			'jumlah'			=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'		=>  $this->input->post('ket'),
			'kas_id'			=>	$this->input->post('kas_id'),
			'update_data'		=> $tanggal_u,
			'user_name'			=> $this->data['u_name'],
			'nama_penyetor'		=> $this->input->post('nama_penyetor'),
			'no_identitas'		=> $this->input->post('no_identitas'),
			'alamat'			=> $this->input->post('alamat')
		));
	}

	private function jml_simpanan($no_rek){
		$this->db->select('SUM(jumlah)');
		$this->db->from('tbl_trans_sp');
		$this->db->where('no_rek',$no_rek);
		$this->db->where('dk','D');
		$query = $this->db->get()->row_array();
		return intval($query['SUM(jumlah)']);
	}

	private function jml_penarikan($no_rek){
		$this->db->select('SUM(jumlah)');
		$this->db->from('tbl_trans_sp');
		$this->db->where('no_rek',$no_rek);
		$this->db->where('dk','K');
		$query = $this->db->get()->row();
		return intval($query->juml['SUM(jumlah)']);
	}
	public function cek_bunga()
	{
		$sql = "SELECT * FROM tbl_trans_depo";
		$data = $this->db->query($sql)->result();
		$bunga = $this->db->get_where('suku_bunga_su',['opsi_status' => 'deposito'])->row();
		$bunga = intval($bunga->opsi_val);
		// Kondisi jika tanggal 1 maka proses deposito bunga berjalan
		foreach ($data as $key => $value) {
			$update = date('Y-m-d', strtotime('+ 1 months', strtotime($value->tgl_update_jumlah)));
			
			if (date('Y-m-d') === $value->tgl_update_jumlah AND $value->tgl_update_jumlah <= $value->jatuh_tempo ) {
				// cek apakah tanggal update kurang dari tanggal tempo
				$total_bunga = ($value->jumlah_sebenarnya * $bunga)/100;
				$jumlah = $value->jumlah + $total_bunga;
				$simpanan = $this->jml_simpanan($value->no_rek_bunga);
				$penarikan = $this->jml_penarikan($value->no_rek_bunga);
				$saldo = ($simpanan - $penarikan) + $total_bunga;	
				$this->db->where('id', $value->id);
				$this->db->update('tbl_trans_depo',array(
					'tgl_update_jumlah'	=>	$update,
					'jumlah'			=>	$jumlah
				));

				$data = array(	 		 
					'tgl_transaksi'         =>	date('Y-m-d h:i'),
					'anggota_id'			=>	$value->anggota_id,
					'jenis_id'				=>	3103,
					'jumlah'                =>	$total_bunga,
					'saldo'     			=>	$saldo,
					'jumlah_sebenarnya'     =>	$value->jumlah_sebenarnya,
					'lama'     				=>	'',
					'keterangan'			=> 'Bunga deposito ('.$value->no_rek.')',
					'no_rek'                => $value->no_rek_bunga,
					'akun'					=>	'Setoran',
					'dk'                    =>	'D',
					'kas_id'                =>	1,
					'user_name'				=> 'sistem',
					'nama_penyetor'			=> '',
					'no_identitas'			=> '',
					'alamat'                => ''
					);
				$this->db->insert('tbl_trans_sp', $data);
				return true;
			}else{
				return false;
		}
			
		}
		
		// print_r($data_bunga[0]->opsi_val);
	}

	public function delete($id) {
		return $this->db->delete('tbl_trans_sp', array('id' => $id)); 
	}

	public function get_norek_bunga($id)
	{

		$sql = "SELECT `no_rek` FROM `tabungan` WHERE `anggota_id` =$id AND `jenis_id` != 3101";
		return $this->db->query($sql)->result();

	}
}