<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penarikan extends OperatorController {
	
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('penarikan_m');
		$this->load->model('general_m');
		$this->load->model('lap_kas_anggota_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Penarikan Tunai';

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
		
		//panggil data
		$this->data['kas_id'] = $this->penarikan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
        $this->data['anggota'] = $this->general_m->get_anggota();
		$this->data['isi'] = $this->load->view('penarikan_list_v', $this->data, TRUE);
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

	function get_jml_tabungan() {
		$id = isset($_POST['anggota_id']) ? $_POST['anggota_id'] : '';
		$jml= $this->penarikan_m->get_jml_simpanan($id);
		$jml_tabungan = $jml->total;
	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  	= isset($_POST['sort']) ? $_POST['sort'] : 'tgl_transaksi';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$anggota = isset($_POST['anggota']) ? $_POST['anggota'] : '';
		$user = isset($_POST['user']) ? $_POST['user'] : '';
		$cari_simpanan = isset($_POST['cari_simpanan']) ? $_POST['cari_simpanan'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		
		$search = array(
		    'kode_transaksi'    => $kode_transaksi, 
			'cari_simpanan'     => $cari_simpanan,
			'anggota'           => $anggota,
			'user'              => $user,
			'tgl_dari'          => $tgl_dari, 
			'tgl_sampai'        => $tgl_sampai
		);
		
		$offset = ($offset-1)*$limit;
		$data   = $this->penarikan_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 
		foreach ($data['data'] as $r) {
			$tgl_bayar = explode(' ', $r->tgl_transaksi);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);		

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);  
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);  

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TRK' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_transaksi'] = $r->tgl_transaksi;
			$rows[$i]['tgl_transaksi_txt'] = $txt_tanggal;
			$rows[$i]['anggota_id'] = $r->anggota_id;
			//$rows[$i]['anggota_id_txt'] = 'AG' . sprintf('%04d', $r->anggota_id) . '';
			$rows[$i]['anggota_id_txt'] = $anggota->identitas;
			$rows[$i]['nama'] = $anggota->nama;
			$rows[$i]['departement'] = $anggota->departement;
			$rows[$i]['jenis_id'] = $r->jenis_id;
			$rows[$i]['jenis_id_txt'] =$nama_simpanan->jns_simpan;
			$rows[$i]['no_rek']	= $r->no_rek;
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$rows[$i]['ket'] = $r->keterangan;
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['kas_id'] = $r->kas_id;
			$rows[$i]['nama_penyetor'] = $r->nama_penyetor;
			$rows[$i]['no_identitas'] = $r->no_identitas;
			$rows[$i]['alamat'] = $r->alamat;
			$rows[$i]['detail'] ='<a href="'.site_url('cetak_penarikan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function get_jenis_simpanan() {
		$this->load->model('lap_kas_anggota_m');
		$jenis_id = $this->input->post('jenis_id');
		$anggota_id = $this->input->post('anggota_id');
		$tot_simpn = $this->lap_kas_anggota_m->get_jml_simpanan($jenis_id, $anggota_id);
		$tot_tarik = $this->lap_kas_anggota_m->get_jml_penarikan($jenis_id, $anggota_id);
		echo number_format($tot_simpn->jml_total - $tot_tarik->jml_total);
		exit();
	}

    	function get_no_rek() {
	    $anggota_id = isset($_POST['anggota_id']) ? $_POST['anggota_id'] : '';
		$jenis_id = $this->input->post('jenis_id');
		$no_rek = $this->penarikan_m->get_no_rek($anggota_id, $jenis_id);
        echo json_encode($no_rek);
		exit();
	}
	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		$jenis_id = $this->input->post('jenis_id', true);
		$anggota_id = $this->input->post('anggota_id', true);
		$tot_simpn = $this->lap_kas_anggota_m->get_jml_simpanan($jenis_id, $anggota_id);
		$tot_tarik = $this->lap_kas_anggota_m->get_jml_penarikan($jenis_id, $anggota_id);
		$saldo = ($tot_simpn->jml_total - $tot_tarik->jml_total) - $this->input->post('jumlah');
		if($this->penarikan_m->create($saldo)){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}

		if($this->penarikan_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		}	else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Data Gagal Diubah, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function delete() {
		if(!isset($_POST)) {
			show_404();
		}

		$id = intval(addslashes($_POST['id']));
		if($this->penarikan_m->delete($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
	    $sort  	= isset($_GET['sort']) ? $_GET['sort'] : 'tgl_transaksi';
		$order  = isset($_GET['order']) ? $_GET['order'] : 'desc';
		
	    $kode_transaksi = isset($_GET['kode_transaksi']) ? $_GET['kode_transaksi'] : '';
		$anggota = isset($_GET['anggota']) ? $_GET['anggota'] : '';
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		$cari_simpanan = isset($_GET['cari_simpanan']) ? $_GET['cari_simpanan'] : '';
		$tgl_dari = isset($_GET['tgl_dari']) ? $_GET['tgl_dari'] : '';
		$tgl_sampai = isset($_GET['tgl_sampai']) ? $_GET['tgl_sampai'] : '';
		
		$search = array(
		    'kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'anggota' => $anggota,
			'user' => $user,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai
		);
		
		$penarikan = $this->penarikan_m->lap_data_penarikan($search,$sort,$order);
		if($penarikan == FALSE) {
			//redirect('penarikan');
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai']; 

		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'Legal', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('P');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {font-size: 7pt; background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 6pt; font-style: arial;}
			.txt_print {font-size: 6pt; font-style: arial; text-align: right;}
			.ttd_kiri {font-size: 7pt; text-align: letf; font-weight: bold;}
			.ttd_kanan {font-size: 7pt; text-align: right; font-weight: bold;}
			.ttd {font-size: 12pt; text-align: letf; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Penarikan Simpanan <br></span>
			<span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).'</span> 
			', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="4" border="0" border-collapse= "collapse">
			<tr class="header_kolom">
				<th class="h_tengah" style="width:4%;"> No. </th>
			    <th class="h_tengah" style="width:8%;"> No.Trans</th>
			    <th class="h_tengah" style="width:9%;"> Tanggal </th>
		    	<th class="h_tengah" style="width:10%;"> Rek Lama </th>
		    	<th class="h_tengah" style="width:18%;"> Nama Anggota </th>
		    	<th class="h_tengah" style="width:20%;"> Alamat </th>
		    	<th class="h_tengah" style="width:10%;"> Jenis</th>
		    	<th class="h_tengah" style="width:10%;"> Jumlah  </th>
		    	<th class="h_tengah" style="width:10%;"> User </th> 
			</tr>';

			$no =1;
			$jml_penarikan = 0;
			foreach ($penarikan as $row) {
				$anggota= $this->penarikan_m->get_data_anggota($row->anggota_id);
				$jns_simpan= $this->penarikan_m->get_jenis_simpan($row->jenis_id);

				$tgl_bayar = explode(' ', $row->tgl_transaksi);
				$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');
				$jml_penarikan += $row->jumlah;

				// AG'.sprintf('%04d', $row->anggota_id).'
				$html .= '
				<tr class="txt_content" >
				    <td class="h_tengah" >'.$no++.'</td>
				    <td class="h_tengah"> '.'TRK'.sprintf('%05d', $row->id).'</td>
				    <td class="h_tengah"> '.$txt_tanggal.'</td>
				    <td class="h_tengah"> '.$anggota->nik.'</td>
				    <td class="h_kiri"> '.$anggota->nama.'</td>
				    <td class="h_kiri"> '.$anggota->alamat.'</td>
				
				    <td> '.$jns_simpan->jns_simpan.'</td>
				    <td class="h_kanan"> '.number_format($row->jumlah).'</td>
				    <td class="h_kanan"> '.$row->user_name.'</td>
				</tr>';
			}
			$html .= '
			<tr class="header_kolom">
				<td colspan="7" class="h_tengah"><strong> Jumlah Total </strong></td>
				<td class="h_kanan"> '.number_format($jml_penarikan).'</td>
				<td></td>
			</tr>
			<br>
	    	<br>
	    	<br>
	    	<table class="h_tengah" width="80%">
		    	<tr>
		    		<td class="ttd_kiri" height="60px"><strong>PENYETOR</strong></td>
		    		<td class="ttd_kanan" height="60px"><strong>PENERIMA</strong></td>
	    		</tr>
			
		    	<tr>
		    	</tr>
                <tr>
	    		</tr>
			
	    		<tr>
	    			<td class="ttd"><u>'.$row->user_name.'</u></td>
		    		<td class="h_kanan"><u><strong>(KASIR)</strong></u></td>
                </tr>
	    	</table>
	    		
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('trans_sk'.date('Ymd_His') . '.pdf', 'I');
	}
}