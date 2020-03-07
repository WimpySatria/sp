<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_angsuran extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('angsuran_m');
		$this->load->model('general_m');
		$this->load->model('setting_m');
		$this->load->library('terbilang'); 
	}	

	function cetak($id) {
		$angsuran = $this->angsuran_m->get_data_pembayaran_by_id($id);
		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->load->library('Struk');
		$pdf = new Struk('P','58mm',true, 'UTF-8', false);
		$pdf->set_nsi_header(false);
		$resolution = array(50,70);
		$pdf->AddPage('P', $resolution);
		$html = '<style>
		.h_tengah {text-align: center;}
		.h_kiri {text-align: left;}
		.h_kanan {text-align: right;}
		.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
		.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		.txt_content {font-size: 5pt; text-align: left; font-weight: bold;}
		.spacing {margin: 0px;}
		.txt_size {font-size: 10pt;}
	</style>';
	$html .= ''.$pdf->nsi_box($text =' <table width="100%">
		<tr>
			<td rowspan="1"><strong>'.$out['nama_lembaga'].'</strong></td>
		</tr>
		<tr>
			<td width="100%"><strong>BUKTI SETORAN ANGSURAN KREDIT</strong>
				<hr width="100%">
			</td>
		</tr>
		
	</table>', $width = '100%', $spacing = '0', $padding = '0', $border = '0', $align = 'center').'';
	$no =1;
	foreach ($angsuran as $row) {
		$pinjaman= $this->general_m->get_data_pinjam($row->pinjam_id);

		$anggota_id = $pinjaman->anggota_id;
		$anggota= $this->general_m->get_data_anggota($anggota_id);

		$hitung_denda = $this->general_m->get_jml_denda($row->pinjam_id);
		$jml_denda=$hitung_denda->total_denda;

		$hitung_dibayar = $this->general_m->get_jml_bayar($row->pinjam_id);
		$hitung_pokok = $this->general_m->get_jml_pokok($row->pinjam_id);
		$hitung_bunga = $this->general_m->get_jml_bayar($row->pinjam_id);
		$dibayar = $hitung_dibayar->total;
		$dipokok = $hitung_pokok->total;
		$dibunga = $hitung_bunga->total;
		$tagihan = $pinjaman->ags_per_bulan * $pinjaman->lama_angsuran;
		$sisa_bayar = $tagihan - $dibayar ;

		$total_dibayar = $sisa_bayar + $jml_denda;

		$tgl_bayar = explode(' ', $row->tgl_bayar);
		$txt_tanggal = jin_date_ina($tgl_bayar[0]);
		$txt_tanggal .= ' / ' . substr($tgl_bayar[1], 0, 5);    

		$jumlah_p = $pinjaman->jumlah;
		
		$sisa_pokok = $jumlah_p - $dipokok ;
		$sisa_bunga = $jumlah_p - $dibayar;

		//AG'.sprintf('%04d', $anggota_id).'
		$html .='<table width="100%">
		<tr>
			<td width="50%" text-align="h_kiri"> Tgl Transaksi</td>
				
			<td width="0%" class="h_kiri">'.$txt_tanggal.'</td>
		</tr>
		<tr>
			<td width="50%" text-align="h_kiri"> Tgl Cetak:</td>
				
			<td width="48%" class="h_kiri">'.jin_date_ina(date('Y-m-d')).' / '.date('H:i').'</td>
		</tr>

		<tr>
			<td width="100%">No.Trans = '.'TRD'.sprintf('%05d', $row->id).' /
			'.'TPJ'.sprintf('%05d', $pinjaman->id).'</td>
		</tr>
		
		
		
		<tr>
			<td width="100%" text-align="h_kiri">Simulasi Tagihan</td>
		</tr>

		<tr>
			<td width="100%"> ------------------------------</td>
		</tr>
		<tr>
			<td width="50%" text-align="h_kiri">Angsuran Pokok</td>
				
			<td width="0%" class="h_kiri">'.number_format($pinjaman->pokok_angsuran).'</td>
		</tr>
		
		<tr>
			<td width="50%" text-align="h_kiri">Angsuran Bunga</td>
				
			<td width="0%" class="h_kiri">'.number_format($pinjaman->bunga_pinjaman).'</td>
		</tr>


		



		<tr>
			<td width="50%" text-align="h_kiri">Pinjaman</td>
				
			<td width="48%" class="h_kiri">'.number_format(nsi_round($pinjaman->jumlah)).'</td>
		</tr>

	<tr>
	<td width="100%"> ------------------------------</td>
	</tr>

		<tr>
			<td width="50%" text-align="h_kiri">Angsuran Ke</td>
				
			<td width="48%" class="h_kiri">'.$row->angsuran_ke.'</td>
		</tr>

		<tr>
			<td width="50%" text-align="h_kiri">Angsuran Pokok </td>
				
			<td width="0%" class="h_kiri">'.number_format(nsi_round($row->bayar_pokok)).'</td>
		</tr>
		<tr>
			<td width="50%" text-align="h_kiri">Angsuran Bunga</td>
				
			<td width="0%" class="h_kiri">'.number_format(nsi_round($row->bayar_bunga)).'</td>
		</tr>

		<tr>
			<td width="50%" text-align="h_kiri">Total Angsuran</td>
				
			<td width="48%" class="h_kiri">'.number_format(nsi_round($row->bayar_pokok + $row->bayar_bunga)).'</td>
		</tr>
		
		<tr>
			<td width="100%"> ------------------------------</td>
		</tr>

		<tr>
			<td width="50%" text-align="h_kiri">Sisa Pokok PJM</td>
				
			<td width="48%" class="h_kiri">'.number_format(nsi_round($sisa_pokok)).'</td>
		</tr>


		<tr>
			<td width="50%" text-align="h_kiri">User Akun</td>
				
			<td width="48%" class="h_kiri">'.$row->user_name.'</td>
		</tr>





		';
	}
	$html .= '</table>
	<p class="txt_content" width="100%">Ref. '.date('Ymd_His').'<br> 
		Informasi Hub Call Center : '.$out['telepon'].'
		<br>
		
	</p>';

	$pdf->nsi_html($html);
	$pdf->Output(date('Ymd_His') . '.pdf', 'I');

} 

}

/*

<tr>
			<td> ID Anggota </td>
			<td>:</td>
			<td>'.$anggota->identitas.' / '.strtoupper($anggota->nama).'</td>

			<td> Status </td>
			<td colspan="2">: SUKSES</td>
		</tr>


<tr>
			<td> Dept </td>
			<td>:</td>
			<td class="h_kiri">'.$anggota->departement.'</td>
		</tr>

<tr>
			<td> Nomor Kontrak </td>
			<td >:</td>
			<td class="h_kiri">'.'TPJ'.sprintf('%05d', $pinjaman->id).'</td>
		</tr>
		<tr>
			<td> Angsuran Ke </td>
			<td>: </td>
			<td class="h_kiri">'.$row->angsuran_ke.' / '.$pinjaman->lama_angsuran.'</td>
		</tr>


////////////angsuran awal/////////////////////
<tr>
			<td width="50%" text-align="h_kiri">Angsuran Ke</td>
				
			<td width="48%" class="h_kiri">'.$row->angsuran_ke.' / '.$pinjaman->lama_angsuran.'</td>
		</tr>




</table>
	<table width="100%">
		<tr>
			<td width="20%"> Angsuran Pokok </td>
			<td width="5%">: Rp. </td>
			<td width="15%"  class="h_kanan">'.number_format($pinjaman->pokok_angsuran).'</td>

			<td width="17%"></td>
			<td width="16.5%">Total Denda </td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($jml_denda)).'</td>
		</tr>
		<tr>
			<td> Bunga Angsuran</td>
			<td width="5%">: Rp. </td>
			<td class="h_kanan">'.number_format($pinjaman->bunga_pinjaman).'</td>

			<td width="17%"> </td>
			<td width="16.5%">Sisa Pinjman</td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($sisa_bayar)).'</td>
		</tr>
		<tr>
			<td> Biaya Admin </td>
			<td>: Rp. </td>
			<td class="h_kanan">'.number_format(nsi_round($pinjaman->biaya_adm)).'</td>

			<td width="17%"></td>
			<td width="16.5%">Total Tagihan </td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($total_dibayar)).'</td>
		</tr>
		<tr>
			<td> Jumlah Angsuran </td>
			<td>: Rp.</td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($row->jumlah_bayar)).'</strong></td>
		</tr>
		<tr>
			<td> Terbilang </td>
			<td colspan="4">: '.$this->terbilang->eja(nsi_round($row->jumlah_bayar)).' RUPIAH</td>
		</tr>';
	}
	$html .= '</table>
	<p class="txt_content">Ref. '.date('Ymd_His').'<br> 
		Informasi Hubungi Call Center : '.$out['telepon'].'
		<br>
		atau dapat diakses melalui : '.$out['web'].'
		'.$out['alamat'].'
	</p>';

	$pdf->nsi_html($html);
	$pdf->Output(date('Ymd_His') . '.pdf', 'I');
*/