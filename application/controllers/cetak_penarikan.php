<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_penarikan extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('cetak_simpanan_m');
		$this->load->model('general_m');
		$this->load->model('setting_m');
		$this->load->library('terbilang');
		$this->load->model('lap_kas_anggota_m');
	}	

	function cetak($id) {
		$simpanan = $this->cetak_simpanan_m->lap_data_penarikan($id);
		$data_jns_simpanan = $this->lap_kas_anggota_m->get_jenis_simpan();
		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->load->library('Struk');
		$pdf = new Struk('P', '58mm', true, 'UTF-8', false);
		$pdf->set_nsi_header(FALSE);
		$resolution = array(50, 75);
		$pdf->AddPage('P', $resolution);
		$html = '<style>
		.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: pt; font-weight: bold; padding-bottom: 12pt;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 5pt; text-align: left; font-weight: italic;}
			.spacing {margin: 0px;}
			.txt_size {font-size: 7pt;}
		</style>';
		$html .= ''.$pdf->nsi_box($text =' <table width="100%">
			<tr>
				<td rowspan="1">'.$out['nama_lembaga'].'</td>
			</tr>
			<tr>
				<td width="100%">BUKTI PENARIKAN TUNAI
					<hr width="100%">
				</td>
			</tr>
		
	</table>', $width = '100%', $spacing = '0', $padding = '0', $border = '0', $align = 'center').'';

	$no =1;
	foreach ($simpanan as $row) {

		$anggota= $this->cetak_simpanan_m->get_data_anggota($row->anggota_id);
		$jns_simpan= $this->cetak_simpanan_m->get_jenis_simpan($row->jenis_id);

		$tgl_bayar = explode(' ', $row->tgl_transaksi);
		$txt_tanggal = jin_date_ina($tgl_bayar[0]);
		$txt_tanggal .= ' / ' . substr($tgl_bayar[1], 0, 5);

		if($row->nama_penyetor ==''){
			$penyetor = '-';
		} else {
			$penyetor = $row->nama_penyetor;
		}

		if($row->alamat ==''){
			$alamat = '-';
		} else {
			$alamat = $row->alamat;
		}
		//AG'.sprintf('%04d', $row->anggota_id).'
		$html .='<table width="100%">
		<tr>
			<td width="50%" text-align="h_kiri"> Tgl Transaksi</td>
			
			<td width="0%" class="h_kiri">'.$txt_tanggal.'</td>
		</tr>
		<tr>

			<td width="50%" text-align="h_kiri"> Tgl Cetak </td>
			
			<td width="48%" class="h_kiri">'.jin_date_ina(date('Y-m-d')).' / '.date('H:i').'</td>
		</tr>
		
		<tr>
				<td> Petugas </td>

				<td class="h_kiri">'.$row->user_name.'</td>
		</tr>

		<tr>
			<td width="50%" text-align="h_kiri"> No Transaksi </td>
			
			<td>'.'TRD'.sprintf('%05d', $row->id).'</td>		
		</tr>
		<tr>
			<td width="50%" text-align="h_kiri"> Nama Anggota </td>
		
			<td>'.strtoupper($anggota->nama).'</td>
		</tr>
				
		<tr>
			<td width="50%" text-align="h_kiri"> Jns Penarikan </td>
			
			<td>'.$jns_simpan->jns_simpan.'</td>

		</tr>
		
		<tr>
			<td width="50%" text-align="h_kiri"> Penarikkan </td>
			
			<td class="txt_size">Rp. '.number_format($row->jumlah).'</td>
		</tr>';
	}
	$html .='</table> 
	<p class="txt_content" width="100%">'.$this->terbilang->eja($row->jumlah).' RUPIAH
			</p>
	<tr>
			<td>Total Saldo</td>';
		$simpanan_arr = array();
		$simpanan_row_total = 0; 
		$simpanan_total = 0; 
		foreach ($data_jns_simpanan as $jenis) {
			$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
			$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->anggota_id);
			$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->anggota_id);
			
			$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
			$simpanan_row_total += $simpanan_row;
			$simpanan_total += $simpanan_row_total;
		}
		$html .= '<td> Rp. '.number_format($simpanan_row_total).'</td>
	</tr>
	<tr class="txt_content" width="100%">Ref. '.date('Ymd_His').
		'<br/> 
			Informasi Hubungi Call Center : '.$out['telepon'].
		'<br/>
		<p>
		</p>
		<p>
		</p>
		<tr>
		    <td >('.$row->user_name.')</td>
		    <td text-align="h_kanan">('.strtoupper($anggota->nama).')</td>
		</tr>
		    
		</tr>';
	$pdf->nsi_html($html);
	$pdf->Output(date('Ymd_His') . '.pdf', 'I');
} 
}