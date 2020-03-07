<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Sisa extends OperatorController {
	public function __construct() {
			parent::__construct();	
			$this->load->helper('fungsi');
			$this->load->model('general_m');
			$this->load->model('sisa_m');
		}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Kas Anggota';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

			#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
 
		$config = array();
		$config["base_url"] = base_url() . "sisa/index/halaman";
		$jumlah_row = $this->sisa_m->get_jml_data_anggota();
		if(isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
			$jumlah_row = 1;
		}
		$config["total_rows"] = $jumlah_row; // banyak data
		$config["per_page"] = 100;
		$config["uri_segment"] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($offset > 0) {
			$offset = ($offset * $config['per_page']) - $config['per_page'];
		}
		$this->data["data_anggota"] = $this->sisa_m->get_data_anggota($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["data_jns_simpanan"] = $this->sisa_m->get_jenis_simpan(); // panggil seluruh data simpanan1
		
		$this->data['isi'] = $this->load->view('sisa_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
    
    function detail($anggota_id) {
        $this->data['judul_browser'] = 'Transkip';
		$this->data['judul_utama'] = 'Transkip';
		$this->data['judul_sub'] = 'Detail';

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
        
        $this->data['anggota_id'] = $anggota_id;
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();
		$this->data['no_rek'] = $this->sisa_m->get_no_rek($anggota_id);
		
		$this->data['isi'] = $this->load->view('sisa_detail_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
    } 
    
    function ajax_list($anggota_id) {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  	= isset($_POST['sort']) ? $_POST['sort'] : 'tgl_transaksi';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$no_rek         = isset($_POST['no_rek']) ? $_POST['no_rek'] : '';
		$jenis_id       = isset($_POST['jenis_id']) ? $_POST['jenis_id'] : '';
		$tgl_dari       = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai     = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		
		$search = array(
		    'kode_transaksi'    => $kode_transaksi, 
		    'no_rek'            => $no_rek,
			'jenis_id'          => $jenis_id,
			'tgl_dari'          => $tgl_dari, 
			'tgl_sampai'        => $tgl_sampai
		);
		
		$offset = ($offset-1)*$limit;
		$data   = $this->sisa_m->get_data_transaksi_ajax($anggota_id, $offset,$limit,$search,$sort,$order);
		$rows   = array(); 
        
		foreach ($data['data'] as $key => $r) {
			$tgl_bayar = explode(' ', $r->tgl_transaksi);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);		

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);  
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);  
            
            $rows[$key]['no'] = ($key+1);
			$rows[$key]['id'] = $r->id;
			if($r->jenis_id == '3103') {
			    $kode_transaksi ='TRD' . sprintf('%05d', $r->id) . '';    
			} elseif($r->jenis_id == '3102') {
			    $kode_transaksi ='TRK' . sprintf('%05d', $r->id) . '';    
			}
			$rows[$key]['kode_transaksi'] = $kode_transaksi;
			$rows[$key]['tgl_transaksi'] = $r->tgl_transaksi;
			$rows[$key]['tgl_transaksi_txt'] = $txt_tanggal;
			$rows[$key]['jenis_id'] = $r->jenis_id;
			$rows[$key]['jenis_id_txt'] =$nama_simpanan->jns_simpan;
			$rows[$key]['no_rek']	= $r->no_rek;
			if($r->jenis_id == '3102' || $r->jenis_id == '3103') {
			    if(!$r->jumlah){
			        $jumlah = 0;    
			    } else {
			        $jumlah = number_format($r->jumlah);    
			    }
			}
			$rows[$key]['jumlah'] = $jumlah;
			$rows[$key]['ket'] = $r->akun;
			$rows[$key]['user'] = $r->user_name;
			$rows[$key]['kas_id'] = $r->kas_id;
			$rows[$key]['nama_penyetor'] = $r->nama_penyetor;
			$rows[$key]['no_identitas'] = $r->no_identitas;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function cetak_laporan() {
		$anggota = $this->sisa_m->lap_data_anggota();
		$data_jns_simpanan = $this->sisa_m->get_jenis_simpan();

		if($anggota == FALSE) {
			redirect('sisa');
			exit();
		}
     $this->load->library('Pdf');
     $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
     $pdf->set_nsi_header(TRUE);
     $pdf->AddPage('P');
     $html = '';
     $html .= '
         <style>
             .h_tengah {text-align: center;}
             .h_kiri {text-align: left;}
             .h_kanan {text-align: right;}
             .txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
             .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
         </style>
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Saldo Kas Anggota <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
         <table width="100%" cellspacing="0" cellpadding="0" border="0" nobr="true">
         <tr class="header_kolom">
         	<th style="width:5%;" > No </th>
         	<th style="width:15%;"> Tanggal </th>
         	<th style="width:15%;"> No.Rek </th>
            <th style="width:20%;"> Nama </th>
            <th style="width:15%;"> Debet </th>
            <th style="width:15%;"> Kredit </th>
            <th style="width:15%;"> Saldo</th>
         </tr>';
			$no =1;
			$batas = 1;
			foreach ($anggota as $row) {
				if($batas == 0) {
					$html .= '
					<tr class="header_kolom" pagebreak="false">
		            <th style="width:5%;" > No </th>
		            <th style="width:20%;"> Identitas  </th>
		            <th style="width:25%;"> Simpanan </th>
		            <th style="width:25%;"> Pinjaman </th>
		            <th style="width:25%;"> Keterangan </th>
	            </tr>';
	            $batas = 1;
				}
				$batas++;
			
		

		
         $html .= '
         <tr nobr="true">
				<td class="h_tengah" style="vertical-align: middle ">'.$no++.' </td>
				
				<td> 
				<table>
					<tr>
						<td> '.$txt_tanggal.'</td>
					</tr>
				</table>
				</td>
				<td> 
				<table>
					<tr>
						<td> '.$row->no.rek.'</td>
					</tr>
				</table>
				</td>
				<td> 
				<table>
					<tr>
						<td> '.$row->nama.'</td>
					</tr>
				</table>
				</td>
				<td> 
					<table width="100%">';
					$simpanan_arr = array();
					$simpanan_row_total = 0; 
					foreach ($data_jns_simpanan as $jenis) {
						$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
						$nilai_s = $this->sisa_m->get_jml_simpanan($jenis->id, $row->id);
						$nilai_p = $this->sisa_m->get_jml_penarikan($jenis->id, $row->id);	
						$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
						$simpanan_row_total += $simpanan_row;
						$simpanan_tot += $simpanan_row_total;
						}
		$html.='<tr>
						
						<td class="h_kanan"> '.number_format($simpanan_row_total).'</td>
					</tr>
					</table>
				</td> 
				<td>
					<table> 
					<tr>
						
						<td class="h_kanan">  '.number_format(nsi_round($sisa_tagihan)).'
						</td>
					</tr>
				</table>

			</td>
		</tr>'; 
		}     
      $html .= '
      				<tr bgcolor="#EEEEEE">
      					<td colspan="5">
      					</td>
      				</tr>
					<tr bgcolor="#FFFEEE">
						<td class="h_tengah" colspan="4"> Total Saldo</td>
						<td class="h_kanan" colspan="1"><strong>'.number_format(nsi_round($simpanan_tot - $sisa_tot)).'</strong></td>
						
					</tr>
					</table>';
      $pdf->nsi_html($html);
      $pdf->Output('lap_kas_agt'.date('Ymd_His') . '.pdf', 'I');
	} 
	
	function cetak_laporan_detail() {
		$sort  	= isset($_GET['sort']) ? $_GET['sort'] : 'tgl_transaksi';
		$order  = isset($_GET['order']) ? $_GET['order'] : 'desc';
		
	    $kode_transaksi     = isset($_GET['kode_transaksi']) ? $_GET['kode_transaksi'] : '';
		$anggota_id         = isset($_GET['anggota_id']) ? $_GET['anggota_id'] : '';
		$no_rek             = isset($_GET['no_rek']) ? $_GET['no_rek'] : '';
		$cari_simpanan      = isset($_GET['cari_simpanan']) ? $_GET['cari_simpanan'] : '';
		$tgl_dari           = isset($_GET['tgl_dari']) ? $_GET['tgl_dari'] : '';
		$tgl_sampai         = isset($_GET['tgl_sampai']) ? $_GET['tgl_sampai'] : '';
		
		$search = array(
		    'kode_transaksi'    => $kode_transaksi, 
			'cari_simpanan'     => $cari_simpanan,
			'anggota_id'        => $anggota_id,
			'no_rek'            => $no_rek,
			'tgl_dari'          => $tgl_dari, 
			'tgl_sampai'        => $tgl_sampai
		);
		// $no_rek = $search['no_rek'];
		$sql = "SELECT * FROM tbl_trans_sp WHERE no_rek = '$no_rek' ORDER BY tgl_transaksi ASC";
		$simpanan = $this->db->query($sql)->result();
		
		 
		if($simpanan == FALSE) {
			//redirect('simpanan');
			$this->session->set_flashdata('kosong','<div class="alert alert-danger">Maaf, tidak ada transaksi pada rekening yang dipilih !</div>');
			redirect('sisa/detail/'.$anggota_id);
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai'];
// 		$user = $_REQUEST['user']; 

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
		'.$pdf->nsi_box($text = '<span class="txt_judul">TRANSAKSI TABUNGAN <br></span>
			<span> '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).'</span> ', 
			$width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center');
			
		$anggota = $this->general_m->get_data_anggota($anggota_id);
		$html .= '<table class="h_tengah">
			<tr>
				<td class="h_kiri" width="10%"><strong>Nama</strong></td>
				<td class="h_kiri" width="20%"><strong>'.$anggota->nama.'</strong></td>
			</tr>
        </table>';	
		$html .= '<table width="100%" cellspacing="0" cellpadding="4" border="0" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:4%;"> No. </th>
			<th class="h_tengah" style="width:15%;"> Kode Trans</th>
			<th class="h_tengah" style="width:10%;"> Tanggal Transaksi </th>
			<th class="h_tengah" style="width:15%;"> No. Rekening </th>
			<th class="h_kiri" style="width:20%;"> Setoran </th>
			<th class="h_kiri" style="width:20%;"> Penarikan </th>
			<th class="h_kiri" style="width:20%;"> Saldo </th>
			<th class="h_tengah" style="width:10%;"> Keterangan </th>
		</tr>';
		
		$jml_simpanan = 0;
		$total_setoran = $total_penarikan = 0;
		$no = 1;
		foreach ($simpanan as $row) {
// 			$anggota= $this->simpanan_m->get_data_anggota($row->anggota_id);
// 			$jns_simpan= $this->simpanan_m->get_jenis_simpan($row->jenis_id);
            $kode_transaksi = "";
            $jumlah_setoran = 0;
	        $jumlah_penarikan = 0;
	        $saldo = 0;
	        
			$tgl_bayar = explode(' ', $row->tgl_transaksi);
			$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');
			
			$nama_simpanan = $this->general_m->get_jns_simpanan($row->jenis_id); 
			if($row->dk == 'K') {
			    $kode_transaksi ='TRK' . sprintf('%05d', $row->id); 
			    $jumlah_penarikan = $row->jumlah;
			    $total_penarikan += $row->jumlah;
		        $saldo = $jml_simpanan-$jumlah_penarikan;
		        $data[$key]['saldo'] = $saldo;
			} elseif($row->dk == 'D') {
			    $kode_transaksi ='TRD' . sprintf('%05d', $row->id);    
			    $jumlah_setoran = $row->jumlah;
			    $total_setoran += $row->jumlah;
		        $saldo = $jml_simpanan+$jumlah_setoran;
			}
            if($saldo == 0) {
                $jml_simpanan = $jml_simpanan;
            } else {
                $jml_simpanan = $saldo;
            }

			$html .= '
			<tr class="txt_content">
				<td class="h_tengah">'.$no++.'</td>
				<td class="h_tengah"> '.$kode_transaksi.'</td>
				<td class="h_tengah"> '.$txt_tanggal.'</td>
				<td class="h_tengah"> '.$row->no_rek.'</td>';
				if($row->dk == "D"){ 
					$html .= '<td class="h_kiri">Rp. '. number_format($jumlah_setoran).'</td><td class="h_kiri">0</td>'; 
				}else{ 
					$html .= '<td class="h_kiri">0</td><td class="h_kiri">Rp. '. number_format($jumlah_penarikan).'</td>'; 
				}
			$html .= '<td class="h_kiri">Rp. '. number_format($saldo).'</td>
				<td class="h_tengah"> '.$row->akun.'</td>
			</tr>';
		}
		    $html .= '
		<tr class="header_kolom">
			<td colspan="4" class="h_kiri"><strong> Jumlah Data '.  ($key+1)  .' </strong></td>
			<td class="h_kiri"> <strong>Rp. '. number_format($total_setoran).'</strong></td>
			<td class="h_kiri"> <strong>Rp. '. number_format($total_penarikan).'</strong></td>
			<td class="h_kiri" colspan="2"> <strong>Rp. '. number_format($jml_simpanan).'</strong></td>
			
		</tr>
		</table>';
//         <br>
// 		<br>
// 		<br>
// 		<table class="h_tengah" width="80%">
// 			<tr>
// 				<td class="ttd_kiri" height="60px"><strong>PENYETOR</strong></td>
// 				<td class="ttd_kanan" height="60px"><strong>PENERIMA</strong></td>
// 			</tr>
			
// 			<tr>
// 			</tr>
// 			<tr>
// 			</tr>
			
// 			<tr>
// 				<td class="ttd"><u>'.$row->user_name.'</u></td>
// 				<td class="h_kanan"><u><strong>(KASIR)</strong></u></td>
// 			</tr>
// 		</table>
// 		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('trans_sp'.date('Ymd_His') . '.pdf', 'I');
	} 
}