<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suku_bunga_SU extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Bunga Simapanan Deposito';
		$this->data['judul_utama'] = 'Bunga';
		$this->data['judul_sub'] = 'Parameter Bunga';

		$this->load->helper('form');
		$out = array ();
		$out['tersimpan'] = '';
		$this->load->model('bunga_su_m');
		if ($this->input->post('submit')) {
			if($this->bunga_su_m->simpan()) {
				$out['tersimpan'] = 'Y';
			} else {
				$out['tersimpan'] = 'N';
			}
		}
		$opsi_val_arr = $this->bunga_su_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->data['isi'] = $this->load->view('form_bunga_su_v', $out, TRUE);

		$this->load->view('themes/layout_utama_su_v', $this->data);
	}
}
