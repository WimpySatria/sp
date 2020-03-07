<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafik extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('home_m');	
	}	
	
	public function grafik_simpanan() {
        $this->data['judul_browser'] = 'Grafik Simpanan';
		$this->data['judul_utama'] = 'Grafik';
		$this->data['judul_sub'] = 'Grafik Simpanan';
        
        $this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';


        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/mobile/vendor/chart.js/Chart.min.js';
		// $this->data['js_files'][] = base_url() . 'assets/asset/mobile/js/demo/chart-bar-demo.js';
		$this->data['js_files'][] = base_url() . 'js/demo/chart-pie-demo.js';
		$this->data['js_files'][] = base_url() . 'js/demo/chart-area-demo.js';
        $this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

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

		$this->data['isi'] = $this->load->view('grafik_simpanan_v', $this->data, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function grafik_marketing()
	{

		$this->data['judul_browser'] = 'Grafik Marketing';
		$this->data['judul_utama'] = 'Grafik';
		$this->data['judul_sub'] = 'Grafik Marketing';
        
        $this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';


        $this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/mobile/vendor/chart.js/Chart.min.js';
		// $this->data['js_files'][] = base_url() . 'assets/asset/mobile/js/demo/chart-bar-demo.js';
		$this->data['js_files'][] = base_url() . 'js/demo/chart-pie-demo.js';
		$this->data['js_files'][] = base_url() . 'js/demo/chart-area-demo.js';
        $this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

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

		$this->data['isi'] = $this->load->view('grafik_marketing_v', $this->data, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);

	}

	public function get_grafik_marketing()
	{
		$this->load->model('Grafik_m');
		echo json_encode($this->Grafik_m->get_data_marketing($_POST['jenis_id']));
		
	}
}