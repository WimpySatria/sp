<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class spk_m extends CI_Model {

    public function create($data)
    {
        if($data['no_rek'] === ''){
            return false;
        }else{
            return $this->db->insert('tbl_anggota_spk', $data);
        }
    }

    function get_pengajuan_spk() {

        $this->load->helper('fungsi');
		//$user_id = $this->session->userdata('u_name');

		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		
		$fr_jenis = isset($_POST['fr_jenis']) ? $_POST['fr_jenis'] : array();
		$fr_status = isset($_POST['fr_status']) ? $_POST['fr_status'] : array();
		$fr_bulan = isset($_POST['fr_bulan']) ? $_POST['fr_bulan'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		
		//$where = " AND anggota_id = " . $user_id;
		$where = "";
		if($fr_bulan != '') {
			$bln_dari = date("Y-m-d", strtotime($fr_bulan . "-01 -1 month"));
			$bln_dari = substr($bln_dari, 0, 7) . '-21';
			$bln_samp = $fr_bulan . '-20';
			$where .=" AND DATE(tgl_input) >= '".$bln_dari."' ";
			$where .=" AND DATE(tgl_input) <= '".$bln_samp."' ";			
		} else {
			if($tgl_dari != '' && $tgl_sampai != '') {
				$where .=" AND DATE(tgl_input) >= '".$tgl_dari."' ";
				$where .=" AND DATE(tgl_input) <= '".$tgl_sampai."' ";
			}
		}

		if($this->session->userdata('level') == 'operator') {
			$where .= " AND (a.status = '1' OR a.status = '3') ";
		}

		//
		if (! empty($fr_jenis) ) {
			$where .= " AND (";
			$no = 1;
			foreach ($fr_jenis as $fr) {
				if($no > 1) {
					$where .= " OR ";
				}
				$where .= " a.jenis = '".$fr."' ";
				$no++;
			}
			$where .= ") ";
		}

		//
		if (! empty($fr_status) ) {
			$where .= " AND (";
			$no = 1;
			foreach ($fr_status as $fr) {
				if($no > 1) {
					$where .= " OR ";
				}
				$where .= " a.status = '".$fr."' ";
				$no++;
			}
			$where .= ") ";
		}

		//$order_by = " ORDER BY tgl_input DESC";
		if ( isset($_POST['sort']) && isset($_POST['order']) ) {
			$order_by = " ORDER BY ".$_POST['sort']." ".$_POST['order']." ";
		}
		$sql_limit = " LIMIT ".$offset.",".$limit." ";
		
		$sql_tampil = "SELECT 
			a.id AS id, a.anggota_id AS anggota_id, a.ketua_id AS ketua_id, a.tgl_daftar AS tgl_daftar, a.jml_pinjam AS jml_pinjam, a.lama_ags AS lama_ags, a.alasan AS alasan, a.status AS status,  a.user_name as user, 
			b.alamat AS alamat, b.nama AS nama
			FROM tbl_anggota_spk AS a
			LEFT JOIN tbl_anggota AS b ON b.id = a.anggota_id
		 	WHERE 1=1 ".$where." ".$order_by." ".$sql_limit."";
		$query = $this->db->query($sql_tampil);
		$data_list = $query->result();

		$sql_total = "SELECT id FROM tbl_pengajuan AS a WHERE 1=1 ".$where." ";
		$query = $this->db->query($sql_total);
		$total = $query->num_rows();

		// 
		$data_list_i = array();
		foreach ($data_list as $key => $val) {
			$tgl_arr = explode(' ', $val->tgl_daftar);
			$tgl = $tgl_arr[0];
			$val->tgl_input_txt = jin_date_ina($tgl);
			$val->tgl_input = substr($val->tgl_daftar);
			$val->ketua = $val->nama;
			$val->no_rek = $val->no_rek;
			$val->jml_pinjam = number_format($val->jml_pinjam);
			$val->user_name = $val->user;
			$val->anggota = $val->nama;

			// sisa pinjaman
			// $sisa_p = $this->get_sisa_pinjaman($val->anggota_id);
			// $val->sisa_jml = number_format($sisa_p['sisa_jml']);
			// $val->sisa_tagihan = number_format($sisa_p['sisa_tagihan']);
			// $val->sisa_ags = number_format($sisa_p['sisa_ags']);

			$data_list_i[$key] = $val;
		} 

		$out = $data_list_i;
		return $out;

	}

	


}