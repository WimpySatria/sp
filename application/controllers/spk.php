<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class spk extends OperatorController {
 
	public function __construct() {
        parent::__construct();
        $this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pengajuan_m');	
		$this->load->model('spk_m');	
	}	
	
    public function index() 
    {
        if(!isset($_POST['daftar'])){
			$this->load->model('pinjaman_m');
			$this->data['judul_browser'] = 'Pengajuan Pinjaman';
			$this->data['judul_utama'] = 'Pengajuan';
			$this->data['judul_sub'] = 'Pinjaman';
	
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
			$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
			$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
	
			//include tanggal
			$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
			$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
	
			//include datarange
			$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
			$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
	
			//number_format
			$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
					
		// $this->data['jenis_ags'] = $this->pinjaman_m->get_data_angsuran();

		$this->data['isi'] = $this->load->view('daftar_spk_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }else{
		$omset = $this->input->post('omset');
		$biaya = $this->input->post('biaya_hidup');
		$keuntungan = $omset - $biaya;
        $data = array(
            'id'        => '',
            'ketua_id'  => $this->input->post('ketua_id'),
            'no_rek'    => $this->input->post('no_rek'),
            'anggota_id'  => $this->input->post('anggota_id'),
            'tgl_daftar'  => date('Y-m-d'),
            'jml_pinjam'  => $this->input->post('jumlah'),
            'lama_ags'  => $this->input->post('lama_ags'),
            'no_kk'  => $this->input->post('no_kk'),
            'alasan'  => $this->input->post('alasan'),
            'status'  => 0,
            'user_name'  => $this->data['u_name'],
            'jns_usaha'  => $this->input->post('jns_usaha'),
            'tmp_usaha'  => $this->input->post('tmp_usaha'),
            'omset_perbulan'  => $omset,
            'biaya_hidup'  => $biaya,
            'keuntungan'  => $keuntungan
        );
        var_dump($data);die();
        if($this->spk_m->create($data)){
            $this->session->set_flashdata('berhasil','<div class="alert alert-success">Anggota berhasil disimpan</div>>');
            redirect('spk');
        }else{
            $this->session->set_flashdata('gagal','<div class="alert alert-danger">Anggota gagal disimpan</div>>');
            redirect('spk');

        }
    }
}


public function pengajuan_spk()
{
    $this->load->model('pinjaman_m');
		$this->data['judul_browser'] = 'Pengajuan Pinjaman';
		$this->data['judul_utama'] = 'Pengajuan';
		$this->data['judul_sub'] = 'Pinjaman';

		//table
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table.min.css';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table.min.js';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table-id-ID.js';

		//modal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-modal/css/bootstrap-modal-bs3patch.css';
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-modal/css/bootstrap-modal.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/bootstrap-modalmanager.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/bootstrap-modal.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/nsi_modal_default.js';

		// datepicker
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/datepicker/datepicker3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/datepicker/bootstrap-datepicker.js';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/datepicker/locales/bootstrap-datepicker.id.js';
		//$this->data['barang_id'] = $this->pinjaman_m->get_id_barang();

		//daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//select2
		$this->data['css_files'][] = base_url() . 'assets/extra/select2/select2.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/select2/select2.min.js';

		//editable
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap3-editable/css/bootstrap-editable.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap3-editable/js/bootstrap-editable.min.js';	

		$this->data['jenis_ags'] = $this->pinjaman_m->get_data_angsuran();

		$this->data['isi'] = $this->load->view('pengajuan_spk_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
}
    
    public function get_norek()
    {
        $id = $this->input->post('id', true);
        echo json_encode($this->db->get_where('tabungan',['anggota_id' => $id])->result_array());
    }

    public function pengajuan_ajax_list()
    {
        
		$out = $this->spk_m->get_pengajuan_spk();
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();
    }
	function list_anggota() {
		$q = isset($_POST['q']) ? $_POST['q'] : '';
		$data   = $this->general_m->get_data_anggota_ajax($q);
		$i	= 0;
		$rows   = array(); 
		foreach ($data['data'] as $r) {
			if($r->file_pic == '') {
				$rows[$i]['photo'] = '<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="30" height="40" />';
			} else {
				$rows[$i]['photo'] = '<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="30" height="40" />';
			}
			$rows[$i]['id'] = $r->id;
			$rows[$i]['kode_anggota'] = 'AG'.sprintf('%04d', $r->id) . '<br>' . $r->identitas;
			$rows[$i]['nama'] = $r->nama;
			$rows[$i]['kota'] = $r->kota. '<br>' . $r->departement;		
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}
}