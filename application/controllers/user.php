<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Data';
		$this->data['judul_utama'] = 'Data';
		$this->data['judul_sub'] = 'User';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('tbl_user');
		$crud->set_subject('Data User');

		$crud->columns('nama','jk','departement','agama','alamat','no_telp','u_name', 'level', 'aktif');
		$crud->fields('nama','tmpt_lahir','tgl_lahir','jk','agama','alamat','no_telp','departement','u_name','pass_word', 'level', 'aktif');

		$crud->field_type('aktif','dropdown',
			array('Y' => 'Aktif','N' => 'Non Aktif'));
		$crud->field_type('jk','dropdown',
			array('L' => 'Laki-laki','P' => 'Perempuan'));
		$crud->field_type('agama','dropdown',
			array('islam' => 'Islam','kristen' => 'Kristen','hindu' => 'Hindu','budha' => 'Budha','katolik' => 'Katolik'));
		$crud->field_type('departement','dropdown',
			array(
				'' 						=> '',
				'Manager' 				=> 'Manager',
				'HRD' 					=> 'HRD',
				'GA' 						=> 'GA',
				'Purchasing' 			=> 'Purchasing',
				'Accounting' 			=> 'Accounting',
				'Marketing' 			=> 'Marketing'
			));

		$crud->display_as('u_name','Username');
		$crud->display_as('nama','Nama Pegawai');
		$crud->display_as('jk','Jenis Kelamin');
		$crud->display_as('alamat','Alamat Pegawai');
		$crud->display_as('tmpt_lahir','Tempat Lahir');
		$crud->display_as('tgl_lahir','Tanggal Lahir');
		$crud->display_as('agama','Agama');
		$crud->display_as('pass_word','Password');
		$crud->display_as('departement','Jabatan');
	

		$crud->required_fields('u_name','level','aktif');

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

		$this->load->view('default_v', $output);
		

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

}
