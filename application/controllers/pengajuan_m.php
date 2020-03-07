<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan_m extends CI_Model {
        
    public function create()
    {
		
        $taksiran = $this->input->post('harga_taksiran_kendaraan');
		if($this->input->post('harga_taksiran_kendaraan') == ""){
			$taksiran = $this->input->post('harga_taksiran_shm');
		}

		
		$no = $this->db->query('SELECT no_ajuan FROM tbl_pengajuan')->result_array();
		
		$id = intval($no);
		$row = max($id) + 1;
		$no_ajuan = $row + 1;
		

		// ajuan_id
		$jenis = $this->input->post('jenis');
		$ajuan_id = '';
		if($jenis == 'Biasa') {
			$ajuan_id .= 'B';
		}
		if($jenis == 'Darurat') {
			$lama_ags = '';
			$ajuan_id .= 'D';
		}
		if($jenis == 'Barang') {
			$ajuan_id .= 'BR';
		}
		if(date("d") >= 21) {
			$ajuan_id .= '.' . substr(date("Y", strtotime("+1 month")), 2, 2);
			$ajuan_id .= '.' . date("m", strtotime("+1 month"));
		} else {
			$ajuan_id .= '.' . substr(date("Y"), 2, 2);
			$ajuan_id .= '.' . date("m");
		}
		$ajuan_id .= '.' . sprintf("%03d", $no_ajuan);

		// menyiapkan data
		$data = [
			'id' 			=> '',
			'no_ajuan'		=> $no_ajuan,
			'ajuan_id'		=> $ajuan_id,
			'anggota_id'	=> $this->input->post('anggota_id'),
			'tgl_input'		=> date('y-m-d h:i' ),
			'jenis'			=> $jenis,
			'nominal'		=> $this->input->post('nominal'),
			'lama_ags'		=> $this->input->post('lama_angsuran'),
			'keterangan'	=> $this->input->post('keterangan'),
			'status'		=> 0,
			'alasan'		=>'',
			'tgl_cair'		=>'',
			'tgl_update'	=>'',
			'jenis_usaha'	=> $this->input->post('jenis_usaha'),
			'tempat_usaha'	=> $this->input->post('tempat_usaha'),
			'omzet_perbulan'	=> $this->input->post('omset_usaha'),
			'biaya_hidup'	=> $this->input->post('biaya_hidup'), 
			'keuntungan'	=> $this->input->post('keuntungan'), 
			'anggunan'		=> $this->input->post('anggunan'), 
			'harga_taksiran'	=> $taksiran, 
			'surveyor'	=> $this->input->post('surveyor'), 
			'jenis_bpkb'	=> $this->input->post('jenis_bpkb'), 
			'no_bpkb'	=> $this->input->post('no_bpkb'), 
			'no_mesin'	=> $this->input->post('no_mesin'), 
			'no_rangka'	=> $this->input->post('no_rangka'), 
			'warna'	=> $this->input->post('warna'), 
			'atas_nama'	=> $this->input->post('atas_nama'), 
			'no_polisi'	=> $this->input->post('no_polisi'), 
			'no_shm'	=> $this->input->post('no_shm'), 
			'an_shm'	=> $this->input->post('atas_nama_shm'), 
			'luas_shm'	=> $this->input->post('luas_shm'), 
			'alamat_shm'	=> $this->input->post('alamat_shm'), 
			'kec_shm'	=> $this->input->post('kec_shm'), 
			'kab_shm'	=> $this->input->post('kab_shm') 

		];

        $input = $this->db->insert('tbl_pengajuan',$data);
        return $this->db->affected_rows($input);
    }

	}