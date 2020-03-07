<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public $data = array ('pesan' => '');
	
	public function __construct () {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Login_m','login', TRUE);
	}
	
	public function index() {
		// $tanggal_mulai = "2020-02-11";
		// $tanggal_sampai = "2020-02-16";
		// $marketing = "admin";
		// $sql = "SELECT * FROM tbl_trans_sp  WHERE tgl_transaksi between '$tanggal_mulai' AND '$tanggal_sampai' AND `user_name` = '$marketing' ORDER BY id DESC";
		// $this->db->select_max('anggota_id');
		// $sql = $this->db->get('tabungan')->row();
		// var_dump(sprintf('%05s',$sql->anggota_id + 1)); die();



		// status user login = BENAR, pindah ke halaman home
		if ($this->session->userdata('login') == TRUE && 
			$this->session->userdata('level') == 'admin' OR 
			$this->session->userdata('level') == 'cs' OR
			$this->session->userdata('level') == 'pinjaman') 
		{
			redirect('home');
		}
		else if($this->session->userdata('login') == TRUE && 
				$this->session->userdata('level') == 'pelayanan') {
				redirect('mob_marketing');
		}
		else {
			// status login salah, tampilkan form login
			// validasi sukses
			if($this->login->validasi()) {
				// cek di database sukses
				if($this->login->cek_user()) {
					if ($this->session->userdata('level') == 'pelayanan') {
						redirect('mob_marketing');
					}
					else {
						redirect('home');
					}
				} else {
					// cek database gagal
					$this->data['pesan'] = 'Username atau Password salah.';
				}
			} else {
				// validasi gagal
         }
         $this->data['jenis'] = 'admin';
         $this->load->view('themes/login_form_v', $this->data);
		}
	}

	public function logout() {
		$this->login->logout();
		redirect('login');
	}
}