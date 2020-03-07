<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hitung_bunga extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('hitung_bunga_m');
		$this->load->model('general_m');
		$this->load->model('simpanan_m');
		$this->load->model('lap_kas_anggota_m');
		$this->load->model('hitung_bunga_m');
	}	

	public function index() {
		// $tgl_mulai = '2020-01-01';
		// $tgl_sampai = '2020-01-31';

		// $sql = 'SELECT `tbl_trans_sp`.`no_rek`, `tbl_trans_sp`.`dk`,`tbl_trans_sp`.`anggota_id`,`tbl_trans_sp`.`jenis_id`, `tbl_trans_sp`.`jumlah`, `tbl_trans_sp`.`tgl_transaksi`, MIN(`tbl_trans_sp`.`saldo`) FROM `tbl_trans_sp`, `tabungan` WHERE `tbl_trans_sp`.`no_rek` = `tabungan`.`no_rek` AND `tbl_trans_sp`.`dk` = "D" AND `tbl_trans_sp`.`jenis_id` = 3103  AND `tbl_trans_sp`.`tgl_transaksi` BETWEEN "2020-01-01" AND "2020-01-03" GROUP BY `tbl_trans_sp`.`no_rek` '; 
		// $tanggal = $this->db->query($sql)->result();
		// var_dump($tanggal);die();
		// foreach($tanggal as $t){
		// 	echo $t->tgl_transaksi. '<br>';
		// }

		// die();


		$this->data['judul_browser'] = 'Master Data - Hitung Bunga';
		$this->data['judul_utama'] = 'Master Data';
		$this->data['judul_sub'] = 'Hitung Bunga';

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

		// $this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();

		$this->data['isi'] = $this->load->view('hitung_bunga_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
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

	function get_anggota_by_id() {
		$id = isset($_POST['anggota_id']) ? $_POST['anggota_id'] : '';
		$r   = $this->general_m->get_data_anggota($id);
		$out = '';
		$photo_w = 3 * 30;
		$photo_h = 4 * 30;
		if($r->file_pic == '') {
			$out ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />'
			.'<br> ID : '.'AG' . sprintf('%04d', $r->id) . '';
		} else {
			$out = '<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />'
			.'<br> ID : '.'AG' . sprintf('%04d', $r->id) . '';
		}
		echo $out;
		exit();
	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  	= isset($_POST['sort']) ? $_POST['sort'] : 'tgl_transaksi';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$cari_simpanan = isset($_POST['cari_simpanan']) ? $_POST['cari_simpanan'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array('kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->db->query('SELECT * FROM hitung_bunga ORDER BY tgl_transaksi ASC')->result();
		// var_dump($data);die();
		
		$i	= 0;
		$rows   = array(); 

		foreach ($data as $r) {

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);  
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);  
			$rows[$i]['tgl_transaksi'] = $r->tgl_transaksi;
			$rows[$i]['no_rek'] = $r->no_rek;
			$rows[$i]['nama'] = $anggota->nama;
			$rows[$i]['departement'] = $anggota->departement;
			$rows[$i]['jenis_id'] = $r->jenis_id;
			$rows[$i]['jenis_id_txt'] =$nama_simpanan->jns_simpan;
			// $rows[$i]['saldo']	= number_format($r->saldo);
			$rows[$i]['jumlah'] = number_format($r->saldo_terendah);
			$rows[$i]['bunga'] =  $r->bunga .' %';
			$rows[$i]['hasil'] = number_format(round($r->hitungan_bunga));
			$rows[$i]['user'] = 'Sistem';
			$i++;
		}

		// var_dump(count($rows));die();
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	public function data_sementara(){
		
		
		$tgl1 = date_create($this->input->post('tgl_mulai',true));
		$tgl2 = date_create($this->input->post('tgl_sampai',true));
		$tgl_mulai = date_format($tgl1,'Y-m-d');
		$tgl_sampai = date_format($tgl2,'Y-m-d');
		$bunga = $this->input->post('bunga');
		$data = $this->hitung_bunga_m->get_saldo($tgl_mulai,$tgl_sampai);
		
        foreach($data['data'] as $row ){
			$hasil = ($row['MIN(`tbl_trans_sp`.`saldo`)'] * $bunga) / 100;
            $entries[] = array(
                'id'				=>'',
                'tgl_transaksi'		=>$row['tgl_transaksi'],
                'no_rek'			=>$row['no_rek'],
                'anggota_id'		=>$row['anggota_id'],
                'jenis_id'			=>$row['jenis_id'],
                'saldo_terendah'	=>$row['MIN(`tbl_trans_sp`.`saldo`)'],
                'bunga'				=>$bunga,
                'hitungan_bunga'	=>$hasil
                );
        }
        $insert = $this->db->insert_batch('hitung_bunga', $entries); 
		if($insert){
			$hasil = $this->db->affected_rows($insert);
			echo json_encode(array('status' => 'oke', 'pesan' => 'Berhasil melakukan perhitungan sebanyak <b>'. $hasil.'</b> data' ));
		}else{
			echo json_encode(array('status' => 'gagal', 'pesan' => "Gagal melakukan perhitungan bunga"));
		}
	}

	public function pelimpahan_bunga()
	{
		$data = $this->db->get('hitung_bunga')->result();
		
        foreach($data as $row ){
			// $hasil = ($row->saldo_terendah * $row->bunga) / 100;
			$tot_simpn = $this->lap_kas_anggota_m->get_jml_simpanan($row->jenis_id, $row->anggota_id);
			$tot_tarik = $this->lap_kas_anggota_m->get_jml_penarikan($row->jenis_id, $row->anggota_id);
			$saldo = ($tot_simpn->jml_total - $tot_tarik->jml_total) + $row->hitungan_bunga;
            $transaksi[] = array(
                'id'				=>'',
                'tgl_transaksi'		=> date('Y-m-d H:i'),
                'anggota_id'		=>$row->anggota_id,
                'no_rek'			=>$row->no_rek,
                'kode'				=>'',
                'jenis_id'			=>$row->jenis_id,
                'jumlah'			=>$row->hitungan_bunga,
                'saldo'				=>$saldo,
                'jumlah_sebenarnya'	=>0,
                'lama'				=>0,
                'jpenarikan'		=>0,
				'keterangan'		=>'Pembungaan SU',
                'akun'				=>'Setoran',
                'dk'				=>'D',
                'kas_id'			=>4,
                'update_data'		=>'',
                'user_name'			=>'Sistem',
                'nama_penyetor'		=>'',
                'no_identitas'		=>'',
                'alamat'			=>''
                );
        }
		$insert = $this->db->insert_batch('tbl_trans_sp', $transaksi);
		$this->db->empty_table('hitung_bunga');
		if($insert){
			$this->session->set_flashdata('success','<div class="alert alert-success"> Berhasil pelimpahan bunga sebanyak '. $this->db->affected_rows($insert).' data</div>');
			redirect('hitung_bunga');
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-danger">Gagal Melakukan transaksi pelimpahan bunga !</div>');
			redirect('hitung_bunga');

		}
	}

	function get_jenis_simpanan() {
		$id = $this->input->post('jenis_id');
		$jenis_simpanan = $this->general_m->get_id_simpanan();
		foreach ($jenis_simpanan as $row) {
			if($row->id == $id) {
				echo number_format($row->jumlah);
			}
		}
		exit();
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


	public function delete() {
		if(!isset($_POST))	 {
			show_404();
		}
		$id = intval(addslashes($_POST['id']));
		if($this->simpanan_m->delete($id))
		{
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
		$simpanan = $this->simpanan_m->lap_data_simpanan();
		if($simpanan == FALSE) {
			//redirect('simpanan');
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai']; 

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 6pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Simpanan Anggota <br></span>
			<span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="4" border="0" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:5%;" > No. </th>
			<th class="h_tengah" style="width:8%;"> No Transaksi</th>
			<th class="h_tengah" style="width:12%;"> Tanggal </th>
			<th class="h_tengah" style="width:25%;"> Nama Anggota </th>

			<th class="h_tengah" style="width:18%;"> Jenis Simpanan </th>
			<th class="h_tengah" style="width:13%;"> Jumlah  </th>
			<th class="h_tengah" style="width:10%;"> User </th>
		</tr>';

		$no =1;
		$jml_simpanan = 0;
		foreach ($simpanan as $row) {
			$anggota= $this->simpanan_m->get_data_anggota($row->anggota_id);
			$jns_simpan= $this->simpanan_m->get_jenis_simpan($row->jenis_id);

			$tgl_bayar = explode(' ', $row->tgl_transaksi);
			$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');

			$jml_simpanan += $row->jumlah;

			// '.'AG'.sprintf('%04d', $row->anggota_id).'
			$html .= '
			<tr>
				<td class="h_tengah" >'.$no++.'</td>
				<td class="h_tengah"> '.'TRD'.sprintf('%05d', $row->id).'</td>
				<td class="h_tengah"> '.$txt_tanggal.'</td>
				<td class="h_kiri"> '.$anggota->nama.'</td>
				
				<td> '.$jns_simpan->jns_simpan.'</td>
				<td class="h_kanan"> '.number_format($row->jumlah).'</td>
				<td> '.$row->user_name.'</td>
			</tr>';
		}
		$html .= '
		<tr>
			<td colspan="5" class="h_tengah"><strong> Jumlah Total </strong></td>
			<td class="h_kanan"> <strong>'.number_format($jml_simpanan).'</strong></td>
		</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('trans_sp'.date('Ymd_His') . '.pdf', 'I');
	}

	public function edit(){
		if(!isset($_POST)){
			show_404();
		}
		if($this->hitung_bunga_m->update($this->input->post('no_rek'))){
			echo json_encode(array('ok' => true, 'msg'  => '<div class="text-green"><i class="fa fa-check"></i> data berhasil berhasil di ubah </div>'));
		}else{
			echo json_encode(array('ok' => false, 'msg'  => '<divFF><i class="fa fa-check"></i> data berhasil gagal di ubah </div>'));

		}
		
	}
	
	public function clear(){
		$this->db->empty_table('hitung_bunga');
		redirect('hitung_bunga');
	}
}