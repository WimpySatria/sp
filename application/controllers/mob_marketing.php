<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mob_marketing extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
        $this->load->model('home_m');
        $this->load->model('simpanan_m');
        $this->load->model('penarikan_m');
		$this->load->model('general_m');	
		$this->load->model('pengajuan_m');
		$this->load->model('angsuran_m');
		$this->load->model('pinjaman_m');
		$this->load->model('lap_kas_anggota_m');
		$this->load->library('form_validation');	
	}	
	 
	public function index() {
		

		$this->data['judul_browser'] = 'Beranda';
		$this->data['judul_utama'] = 'Beranda';
        $this->data['judul_sub'] = 'Menu Utama';
        
        $this->data['anggota_all'] = $this->home_m->get_anggota_all();
		$this->data['anggota_aktif'] = $this->home_m->get_anggota_aktif();
		$this->data['anggota_non'] = $this->home_m->get_anggota_non();

		$this->data['jml_simpanan'] = $this->home_m->get_jml_simpanan();
		$this->data['jml_penarikan'] = $this->home_m->get_jml_penarikan();

		$this->data['jml_pinjaman'] = $this->home_m->get_jml_pinjaman();
		$this->data['jml_angsuran'] = $this->home_m->get_jml_angsuran();
		$this->data['jml_denda'] = $this->home_m->get_jml_denda();
		$this->data['peminjam'] = $this->home_m->get_peminjam_bln_ini();

		$this->data['peminjam_aktif'] = $this->home_m->get_peminjam_aktif();
		$this->data['peminjam_lunas'] = $this->home_m->get_peminjam_lunas();
		$this->data['peminjam_belum'] = $this->home_m->get_peminjam_belum();

		$this->data['kas_debet'] = $this->home_m->get_jml_debet();
		$this->data['kas_kredit'] = $this->home_m->get_jml_kredit();

		$this->data['user_aktif'] = $this->home_m->get_user_aktif();
        $this->data['user_non'] = $this->home_m->get_user_non();
        
		$this->load->view('mob/home', $this->data);
	}
	
	public function get_anggota_by_id(){
		$id = $_POST['id'];
		
		echo json_encode($this->general_m->get_data_anggota($id));
		
	}
  

  ///////////////////// setoran //////////////////////////////////////////////////////////////////
    public function setoran() {

		if(!isset($_POST['setoran'])){

			$this->data['judul_browser'] = 'Transaksi';
			$this->data['judul_utama'] = 'Transaksi';
			$this->data['judul_sub'] = 'Setoran Tunai';
	
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
			$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
	
			#include tanggal
			$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
	
			#include daterange
			$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
			$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
	
			//number_format
			$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
	
	
			$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
			$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
			$this->data['anggota'] = $this->general_m->get_anggota();
			$this->load->view('mob/setoran', $this->data);
		}else{
			$jenis_id = $this->input->post('jenis_id', true);
			$anggota_id = $this->input->post('anggota_id', true);
			$tot_simpn = $this->lap_kas_anggota_m->get_jml_simpanan($jenis_id, $anggota_id);
			$tot_tarik = $this->lap_kas_anggota_m->get_jml_penarikan($jenis_id, $anggota_id);
			$saldo = ($tot_simpn->jml_total - $tot_tarik->jml_total) + $this->input->post('jumlah');
			// var_dump($saldo);die();
			if($this->simpanan_m->create($saldo)){
				$this->session->set_flashdata('success','<div class="alert alert-primary">Transaksi Setoran berhasil di simpan </div>');
				redirect('mob_marketing');
			}else{
				$this->session->set_flashdata('gagal','<div class="alert alert-danger"> Transaksi setoran gagaldi simpan </div>');
				redirect('mob_marketing');
	
			}

		}
    }

    public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->simpanan_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

    //////////////////// data setoran ///////////////////////////////////////////////////////////////

     public function data_s() {
        $this->data['judul_browser'] = 'Beranda';
		$this->data['judul_utama'] = 'Beranda';
        $this->data['judul_sub'] = 'Menu Utama';

        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['anggota'] = $this->general_m->get_anggota();
        $this->load->view('mob/data_s', $this->data);
    }



  //////////////////// penarikan /////////////////////////////////////////////////////////////////
  	 public function penarikan() {

		if(!isset($_POST['penarikan'])){
			$this->data['judul_browser'] = 'Transaksi';
			$this->data['judul_utama'] = 'Transaksi';
			$this->data['judul_sub'] = 'Setoran Tunai';
	
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
			$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
	
			#include tanggal
			$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
	
			#include daterange
			$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
			$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
	
			//number_format
			$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
	
	
			$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
			$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
			$this->data['anggota'] = $this->general_m->get_anggota();
			$this->load->view('mob/penarikan', $this->data);

		}else{
			$jenis_id = $this->input->post('jenis_id', true);
			$anggota_id = $this->input->post('anggota_id', true);
			$tot_simpn = $this->lap_kas_anggota_m->get_jml_simpanan($jenis_id, $anggota_id);
			$tot_tarik = $this->lap_kas_anggota_m->get_jml_penarikan($jenis_id, $anggota_id);
			$saldo = ($tot_simpn->jml_total - $tot_tarik->jml_total) - $this->input->post('jumlah');
			if($this->penarikan_m->create($saldo)){
				$this->session->set_flashdata('success','<div class="alert alert-primary">Transaksi penarikan berhasil disimpan </div>');
				redirect('mob_marketing');
			} else {
				$this->session->set_flashdata('gagal','<div class="alert alert-danger">Transaksi penarikan gagal disimpan</div>');
				redirect('mob_marketing');
			}

		}
		
    }


    //////////////////// data penarikan ///////////////////////////////////////////////////////////////
     public function data_p() {
        $this->data['judul_browser'] = 'Beranda';
		$this->data['judul_utama'] = 'Beranda';
        $this->data['judul_sub'] = 'Menu Utama';

        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['anggota'] = $this->general_m->get_anggota();
        $this->load->view('mob/data_p', $this->data);
	}
	
	

	public function pengajuan()
	{
	
		

		if(!isset($_POST['buat_pengajuan'])){

		$this->data['judul_browser'] = 'Buat Pengajuan';
		$this->data['judul_utama'] = 'Buat Pengajuan Baru';
		$this->data['judul_sub'] = 'Pengajuan pinjaman';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
			$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
	
			#include tanggal
			$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
	
			#include daterange
			$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
			$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
	
			//number_format
			$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
	
		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['anggota'] = $this->general_m->get_anggota();
		$this->load->view('mob/buat_pengajuan', $this->data);
		
		}else{
			
			if($this->pengajuan_m->create()){
				$this->session->set_flashdata('success','<div class="alert alert-primary">Pengajuan pinjaman berhasil di kirim !</div>');
				redirect('mob_marketing');
			}else{
				$this->session->set_flashdata('gagal','<div class="alert alert-danger">Pengajuan pinjaman gagal di kirim !</div>');
				redirect('mob_marketing');
			}
		}
	}

	public function data_pinjaman()
	{
		$this->data['judul_browser'] = 'Data Pinjaman Nasabah';

        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['anggota'] = $this->general_m->get_anggota();
        $this->load->view('mob/data_pinjaman', $this->data);
	}

	public function detail($id_anggota)

	{

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
		$this->data['master_id'] = $id_anggota;
		$row_pinjam = $this->general_m->get_data_pinjam ($id_anggota);
		$this->data['row_pinjam'] = $row_pinjam; 
		$this->data['data_anggota'] = $this->general_m->get_data_anggota ($row_pinjam->anggota_id);
		
		$this->data['kas_id'] = $this->angsuran_m->get_data_kas();
		$this->data['hitung_denda'] = $this->general_m->get_jml_denda($id_anggota);
		$this->data['hitung_dibayar'] = $this->general_m->get_jml_bayar($id_anggota);
		$this->data['sisa_ags'] = $this->general_m->get_record_bayar($id_anggota);
		$this->data['angsuran'] = $this->angsuran_m->get_data_angsuran($id_anggota);
		$this->data['simulasi_tagihan'] = $this->pinjaman_m->get_simulasi_pinjaman($id_anggota);
		
		$this->load->view('mob/mob_detail_v',$this->data);
	}

	public function angsuran($id_pinjaman)
	{
		if(!isset($_POST["simpan_angsuran"])){

			$this->data['judul_browser'] = 'Transaksi';
			$this->data['judul_utama'] = 'Transaksi';
			$this->data['judul_sub'] = 'Setoran Tunai';
	
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
			$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
	
			#include tanggal
			$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
	
			#include daterange
			$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
			$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
	
			//number_format
			$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
	
			$this->data['master_id'] = $id_pinjaman;
			$row_pinjam = $this->general_m->get_data_pinjam ($id_pinjaman);
			$this->data['row_pinjam'] = $row_pinjam; 
			$this->data['data_anggota'] = $this->general_m->get_data_anggota ($row_pinjam->anggota_id);
			$this->data['kas_id'] = $this->angsuran_m->get_data_kas();
		
			$this->data['hitung_denda'] = $this->general_m->get_jml_denda($id_pinjaman);
			$this->data['hitung_dibayar'] = $this->general_m->get_jml_bayar($id_pinjaman);
			
			$this->data['sisa_ags'] = $this->general_m->get_record_bayar($id_pinjaman);
	
			$this->load->view('mob/form_angsuran', $this->data);
		}else{
			if($this->angsuran_m->create()){
				$this->session->set_flashdata('success','<div class="alert alert-primary">Transaksi pembayaran berhasil disimpan !</div>');
				redirect('mob_marketing');
				
			} else {
				$this->session->set_flashdata('gagal','<div class="alert alert-danger">Transaksi pembayaran gagal disimpan !</div>');
				redirect('mob_marketing');
			}

		}	
	}

	public function data_pengajuan()
	{
		$this->data['judul_browser'] = 'Beranda';
		$this->data['judul_utama'] = 'Beranda';
        $this->data['judul_sub'] = 'Menu Utama';

        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
		$this->data['pengajuan'] = $this->pengajuan_m->get_pengajuan();
		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['anggota'] = $this->general_m->get_anggota();
        $this->load->view('mob/data_pengajuan', $this->data);
	}

	public function hapus_pengajuan($id)
	{
		if($this->db->delete('tbl_pengajuan',['id' => $id])){
			$this->session->set_flashdata('success','<div class="alert alert-success">Pengajuan pinjaman berhasil dihapus </div>');
			redirect('mob_marketing/data_pengajuan');
		}
		$this->session->set_flashdata('gagal','<div class="alert alert-success">Pengajuan pinjaman gagal dihapus </div>');
		redirect('mob_marketing/data_pengajuan');
	}

	public function ubah_password()
	{
		$this->data['judul_browser'] = 'Ubah Password';
		$this->data['judul_utama'] = 'Profil';
		$this->data['judul_sub'] = 'Ubah Password';
	
		$out = array ();
		$out['tersimpan'] = '';
		
		$this->load->model('profil_m');
		if ($this->input->post('submit')) {
			if($this->profil_m->validasi()) {
				if ($this->input->post('password_baru') == $this->input->post('ulangi_password_baru')) {
					if($this->profil_m->simpan()) {
						$out['tersimpan'] = 'Y';
					} else {
						$out['tersimpan'] = 'N';
					}
				} else {
					$out['pesan'] ='Password Konfirmasi Tidak Sama, Silahkan Ulangi';
				}
			}
		}
		// $this->data['isi'] = $this->load->view('form_ubah_password_v', $out, TRUE);

		$this->load->view('mob/ubah_password_v', $out);
	}


    ///---------------////

	public function no_akses() {
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';

		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';

		$this->load->view('themes/layout_utama_v', $this->data);
	}


}