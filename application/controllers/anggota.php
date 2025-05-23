<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends OperatorController {
 
	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Data';
		$this->data['judul_utama'] = 'Data';
		$this->data['judul_sub'] = 'Anggota <a href="'.site_url('anggota/import').'" class="btn btn-sm btn-success">Import Data</a>';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png');
		$crud->set_table('tbl_anggota');
		$crud->set_subject('Data Anggota');

		$crud->columns('file_pic','id_anggota','nik','ktp','identitas','nama','jk','alamat','kota','jabatan_id','departement','tgl_daftar','aktif');
		$crud->fields('nik','ktp','nama','identitas','jk', 'tmp_lahir','tgl_lahir','status','departement','pekerjaan','agama','alamat','kota','notelp','tgl_daftar', 'jabatan_id','pass_word','aktif','file_pic');

		$crud->display_as('id_anggota','ID Anggota');
		$crud->display_as('nik','No Rek lama');
		$crud->display_as('ktp','No.Identitas (NIK)');
		$crud->display_as('identitas','Username');
		$crud->display_as('nama','Nama Lengkap');
		$crud->display_as('tmp_lahir','Tempat Lahir');
		$crud->display_as('tgl_lahir','Tanggal Lahir');
		$crud->display_as('notelp','Nomor Telepon / HP');
		$crud->display_as('tgl_daftar','Tanggal Registrasi');
		$crud->display_as('jabatan_id','Jabatan');
		$crud->display_as('departement','Departement');
		$crud->display_as('pass_word','Password');
		$crud->display_as('file_pic','Photo');
		$crud->display_as('aktif','Aktif Keanggotaan');

		$crud->set_field_upload('file_pic','uploads/anggota');
		$crud->callback_after_upload(array($this,'callback_after_upload'));
		$crud->callback_column('file_pic',array($this,'callback_column_pic'));

		$crud->required_fields('nama','identitas','tmp_lahir','tgl_lahir','jk','alamat','kota','jabatan_id','tgl_daftar','aktif');
		$crud->unset_texteditor('alamat');
		$crud->field_type('no_rek','invisible'); 
		
		// Dropdown 
		$crud->field_type('jk','dropdown',
			array('L' => 'Laki-laki','P' => 'Perempuan'));
		$crud->display_as('jk','Jenis Kelamin');
		
		$crud->field_type('status','dropdown',
			array('Belum Kawin' => 'Belum Kawin',
				'Kawin' => 'Kawin',
				'Cerai Hidup' => 'Cerai Hidup',
				'Cerai Mati' => 'Cerai Mati',
				'Lainnya' => 'Lainnya'));

		$crud->field_type('agama','dropdown',
			array('Islam' => 'Islam',
				'Katolik' => 'Katolik',
				'Protestan' => 'Protestan',
				'Hindu' => 'Hindu',
				'Budha' => 'Budha',
				'Lainnya' => 'Lainnya'
			));

		// DEPARTEMENT
		$crud->field_type('departement','dropdown',
			array(
				'' 						=> '',
				'Produksi BOPP' 		=> 'Produksi BOPP',
				'Produksi Slitting' 	=> 'Produksi Slitting',
				'WH' 						=> 'WH',
				'QA' 						=> 'QA',
				'HRD' 					=> 'HRD',
				'GA' 						=> 'GA',
				'Purchasing' 			=> 'Purchasing',
				'Accounting' 			=> 'Accounting',
				'Engineering' 			=> 'Engineering'
			));

		$this->db->select('id_kerja,jenis_kerja');
		$this->db->from('pekerjaan');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$result = $query->result();
			foreach ($result as $val) {
				$kerja[$val->jenis_kerja] = $val->jenis_kerja;
			}
		} else {
			$kerja = array('' => '-');
		}
		$crud->field_type('pekerjaan','dropdown',$kerja);
		
		$crud->field_type('jabatan_id','dropdown',
			array('2' => 'Anggota',
				'1' => 'Pengurus'));
		$crud->display_as('jabatan_id','Jabatan');
		
		$crud->field_type('aktif','dropdown',
			array('Y' => 'Aktif','N' => 'Non Aktif'));


		//Pemangggilan field
		$crud->callback_column('id_anggota',array($this, '_kolom_id_cb'));
		$crud->callback_column('alamat',array($this, '_kolom_alamat'));
		
		$crud->callback_edit_field('pass_word',array($this,'_set_password_input_to_empty'));
		$crud->callback_add_field('pass_word',array($this,'_set_password_input_to_empty'));

		$crud->callback_before_insert(array($this,'_encrypt_password_callback'));
		$crud->callback_before_update(array($this,'_encrypt_password_callback'));

		$crud->unset_read();
		
		$output = $crud->render();

		$out['output'] = $this->data['judul_browser'];
		$this->load->section('judul_browser', 'default_v', $out);
		$out['output'] = $this->data['judul_utama'];
		$this->load->section('judul_utama', 'default_v', $out);
		$out['output'] = $this->data['judul_sub'];
		$this->load->section('judul_sub', 'default_v', $out);
		$out['output'] = $this->data['u_name'];
		$this->load->section('u_name', 'default_v', $out);
		$out['level'] = $this->data['level'];

		$this->load->view('default_v', $output);

	}


	function import() {
		$this->data['judul_browser'] = 'Import Data';
		$this->data['judul_utama'] = 'Import Data';
		$this->data['judul_sub'] = 'Anggota <a href="'.site_url('anggota').'" class="btn btn-sm btn-success">Kembali</a>';

		$this->load->helper(array('form'));

		if($this->input->post('submit')) {
			$config['upload_path']   = FCPATH . 'uploads/temp/';
			$config['allowed_types'] = 'xls|xlsx';
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('import_anggota')) {
				$this->data['error'] = $this->upload->display_errors();
			} else {
				// ok uploaded
				$file = $this->upload->data();
				$this->data['file'] = $file;

				$this->data['lokasi_file'] = $file['full_path'];

				$this->load->library('excel');

				// baca excel
				$objPHPExcel = PHPExcel_IOFactory::load($file['full_path']);
				$no_sheet = 1;
				$header = array();
				$data_list_x = array();
				$data_list = array();
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					if($no_sheet == 1) { // ambil sheet 1 saja
						$no_sheet++;
						$worksheetTitle = $worksheet->getTitle();
						$highestRow = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

						$nrColumns = ord($highestColumn) - 64;
						//echo "File ".$worksheetTitle." has ";
						//echo $nrColumns . ' columns';
						//echo ' y ' . $highestRow . ' rows.<br />';

						$data_jml_arr = array();
						//echo 'Data: <table width="100%" cellpadding="3" cellspacing="0"><tr>';
						for ($row = 1; $row <= $highestRow; ++$row) {
						   //echo '<tr>';
							for ($col = 0; $col < $highestColumnIndex; ++$col) {
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								$val = $cell->getValue();
								$kolom = PHPExcel_Cell::stringFromColumnIndex($col);
								if($row === 1) {
									if($kolom == 'A') {
										$header[$kolom] = 'Nama';
									} else {
										$header[$kolom] = $val;
									}
								} else {
									$data_list_x[$row][$kolom] = $val;
								}
							}
						}
					}
				}

				$no = 1;
				foreach ($data_list_x as $data_kolom) {
					if((@$data_kolom['A'] == NULL || trim(@$data_kolom['A'] == '')) ) { continue; }
					foreach ($data_kolom as $kolom => $val) {
						if(in_array($kolom, array('E', 'K', 'L')) ) {
							$val = ltrim($val, "'");
						}
						$data_list[$no][$kolom] = $val;
					}
					$no++;
				}

				//$arr_data = array();
				$this->data['header'] = $header;
				$this->data['values'] = $data_list;
				/*
				$data_import = array(
					'import_anggota_header'		=> $header,
					'import_anggota_values' 	=> $data_list
					);
				$this->session->set_userdata($data_import);
				*/
			}
		}


		$this->data['isi'] = $this->load->view('anggota_import_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function import_db() {
		if($this->input->post('submit')) {
			$this->load->model('Member_m','member', TRUE);
			$data_import = $this->input->post('val_arr');
			if($this->member->import_db($data_import)) {
				$this->session->set_flashdata('import', 'OK');
			} else {
				$this->session->set_flashdata('import', 'NO');
			}
			//hapus semua file di temp
			$files = glob('uploads/temp/*');
			foreach($files as $file){ 
				if(is_file($file)) {
					@unlink($file);
				}
			}
			redirect('anggota/import');
		} else {
			$this->session->set_flashdata('import', 'NO');
			redirect('anggota/import');
		}
	}

	function import_batal() {
		//hapus semua file di temp
		$files = glob('uploads/temp/*');
		foreach($files as $file){ 
			if(is_file($file)) {
				@unlink($file);
			}
		}
		$this->session->set_flashdata('import', 'BATAL');
		redirect('anggota/import');
	}

	function _set_password_input_to_empty() {
		return "<input type='password' name='pass_word' value='' /><br />Kosongkan password jika tidak ingin ubah/isi.";
	}

	function _encrypt_password_callback($post_array) {
		if(!empty($post_array['pass_word'])) {
			$post_array['pass_word'] = sha1('nsi' . $post_array['pass_word']);
		} else {
			unset($post_array['pass_word']);
		}
		return $post_array;
	}

	function _kolom_id_cb ($value, $row) {
		$value = '<div style="text-align:center;">CIB' . sprintf('%04d', $row->id) . '</div>';
		return $value;
	}
	function _kolom_alamat($value, $row) {
		$value = wordwrap($value, 35, "<br />");
		return nl2br($value);
	}

	function callback_column_pic($value, $row) {
		if($value) {
			return '<div style="text-align: center;"><a class="image-thumbnail" href="'.base_url().'uploads/anggota/' . $value .'"><img src="'.base_url().'uploads/anggota/' . $value . '" alt="' . $value . '" width="30" height="40" /></a></div>';
		} else {
			return '<div style="text-align: center;"><img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="30" height="40" /></div>';
		}
	}

	function callback_after_upload($uploader_response,$field_info, $files_to_upload) {
		$this->load->library('image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
		$this->image_moo->load($file_uploaded)->resize(250,250)->save($file_uploaded,true);
		return true;
	}



}
