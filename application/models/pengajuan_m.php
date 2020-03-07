<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan_m extends CI_Model {
        
    public function create()
    {
		$omset = str_replace(',', '', $this->input->post('omset_usaha'));
		$biaya_hidup = str_replace(',', '', $this->input->post('biaya_hidup'));
		$keuntungan = $omset - $biaya_hidup;
		
        $taksiran = $this->input->post('harga_taksiran_kendaraan');
		if($taksiran === ''){
			$taksiran = $this->input->post('harga_taksiran_shm');
		}
		if($this->input->post('bunga') === '' OR $this->input->post('anggota_id') === ''){
			return false;
		}

		
		$no = $this->db->query('SELECT max(no_ajuan) FROM tbl_pengajuan')->row_array();
		
		$id = $no["max(no_ajuan)"]; 
		$int = intval($id);
		
		$no_ajuan = $int + 1;
		

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
			'wakil'			=> $this->input->post('wakil'),
			'tgl_input'		=> date('y-m-d h:i' ),
			'jenis'			=> $jenis,
			'nominal'		=> str_replace(',', '', $this->input->post('nominal')),
			'lama_ags'		=> $this->input->post('lama_angsuran'),
			'bunga'			=> $this->input->post('bunga'),
			'keterangan'	=> $this->input->post('keterangan'),
			'status'		=> 0,
			'alasan'		=>'',
			'tgl_cair'		=>'',
			'tgl_update'	=>'',
			'jenis_usaha'	=> $this->input->post('jenis_usaha'),
			'tempat_usaha'	=> $this->input->post('tempat_usaha'),
			'omzet_perbulan'	=> $omset,
			'biaya_hidup'	=> $biaya_hidup, 
			'keuntungan'	=> $keuntungan, 
			'anggunan'		=> $this->input->post('anggunan'), 
			'harga_taksiran'=> $taksiran, 
			'surveyor'	=> $this->input->post('surveyor'), 
			'jenis_bpkb'	=> $this->input->post('jenis_bpkb'), 
			'merek_kendaraan'	=> $this->input->post('merek'), 
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
			'kab_shm'	=> $this->input->post('kab_shm'), 
			'prov_shm'	=> $this->input->post('prov_shm'), 
			'tgl_ukut'	=> $this->input->post('tgl_ukut') 

		];

        $input = $this->db->insert('tbl_pengajuan',$data);
        return $this->db->affected_rows($input);
	}
	
	public function get_pengajuan()
	{
		$this->load->helper('fungsi');
		
		$sql = "SELECT  nama,alamat,nominal,`tbl_pengajuan`.`status`,`tbl_pengajuan`.`id` FROM tbl_pengajuan
            INNER JOIN tbl_anggota ON anggota_id=`tbl_anggota`.`id` ";
		return $this->db->query($sql)->result();
	}

	}