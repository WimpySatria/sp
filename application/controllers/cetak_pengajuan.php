<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_pengajuan extends OPPController {

	public function __construct() {
		parent::__construct();

		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
		$this->load->model('setting_m');
        // angka
		$this->load->library('terbilang');
	}

	function laporan() {
		$data_ajuan = $this->pinjaman_m->get_pengajuan_cetak();
		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value) {
			$out[$key] = $value;
		}

		//var_dump($data_ajuan);
		//exit();
		if($data_ajuan['total'] == 0) {
			echo 'Data Kosong';
			exit();
		}
		$list = $data_ajuan['rows'];

		$fr_jenis = isset($_REQUEST['fr_jenis']) ? explode(',', $_REQUEST['fr_jenis']) : array();
		$fr_status = isset($_REQUEST['fr_status']) ? explode(',', $_REQUEST['fr_status']) : array();		
		
		$fr_jenis = array_diff($fr_jenis, array(NULL)); // NULL / FALSE / ''
		$fr_status = array_diff($fr_status, array(NULL)); // NULL / FALSE / ''

		$fr_bulan = isset($_REQUEST['fr_bulan']) ? $_REQUEST['fr_bulan'] : '';
		
		if($fr_bulan != '') {
			$bln_dari = date("Y-m-d", strtotime($fr_bulan . "-01 -1 month"));
			$tgl_dari = substr($bln_dari, 0, 7) . '-21';
			$tgl_sampai = $fr_bulan . '-20';
		} else {
			$tgl_dari = $_REQUEST['tgl_dari']; 
			$tgl_sampai = $_REQUEST['tgl_sampai'];
		}	


		//$fr_jenis = explode(',', $fr_jenis);
		//$fr_status = explode(',', $fr_status);

		if(! empty($fr_jenis)) {
			$txt_jenis = implode(', ', $fr_jenis);
		} else {
			$txt_jenis = "Semua";
		}
		$status_arr = array(0 => 'Menunggu Konfirmasi', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Sudah Terlaksana', 4 => 'Batal');
		if(! empty($fr_status)) {
			$status_rep = str_replace(
				array('0', '1', '2', '3', '4'), 
				array('Menunggu Konfirmasi', 'Disetujui', 'Ditolak', 'Sudah Terlaksana', 'Batal'), 
				$fr_status);
			$txt_status = implode(', ', $status_rep);
			//echo $txt_status; exit();
		} else {
			$txt_status = "Semua";
		}
		//echo $txt_status; exit();
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
			.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Pengajuan <br></span> <span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).' | Jenis: '.$txt_jenis.' | Staus: '.$txt_status.' </span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1">
			<tr class="header_kolom" pagebreak="false">
				<th style="width:3%;" >No</th>
				<th style="width:8%;">ID Ajuan</th>
				<th style="width:10%;">NIK</th>
				<th style="width:25%;">Nama</th>
				<th style="width:10%;">Dept</th>
				<th style="width:8%;">Tanggal</th>
				<th style="width:10%;">Nominal</th>
				<th style="width:10%;">Pelunasan</th>
				<th style="width:3%;">Bln</th>
				<th style="width:12%;">Status</th>
			</tr>';
		$no =1;
		$total_nominal = 0;
		$total_sisa_arr = array();
		foreach ($list as $row) {
			$sisa_tagihan = '-';
			if($row->jenis != 'Darurat') {
				$sisa_tagihan = $row->sisa_tagihan;
				$total_sisa_arr[$row->anggota_id] = str_replace(',', '', $row->sisa_tagihan);
			}
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.$row->ajuan_id.'</td>
				<td class="h_tengah">'.$row->identitas.'</td>
				<td>'.$row->nama.'</td>
				<td>'.$row->departement.'</td>
				<td class="h_tengah">'.$row->tgl_input_txt.'</td>
				<td class="h_kanan">'.$row->nominal.'</td>
				<td class="h_kanan">'.$sisa_tagihan.'</td>
				<td class="h_tengah">'.$row->lama_ags.'</td>
				<td>'.$status_arr[$row->status].'</td>
			</tr>
			';
			$total_nominal += str_replace(',', '', $row->nominal);
		}
		$total_sisa = 0;
		foreach ($total_sisa_arr as $val) {
			$total_sisa += $val;
		}

		$html .= '
		<tr>
			<td colspan="6" class="h_kanan"> <strong> Total </strong> </td>
			<td class="h_kanan"><strong> '.number_format(nsi_round($total_nominal)).' </strong></td>
			<td class="h_kanan"><strong> '.number_format(nsi_round($total_sisa)).' </strong></td>
			<td colspan="2"></td>
		</tr>';
		$html .= '</table>';

		$html .= '
		<br><br>
		<table width="97%">
		<tr>
			<td class="h_tengah" height="50px" width="40%">Dibuat oleh,</td>
			<td class="h_tengah" width="60%"> '.$out['kota'].', '.jin_date_ina(date('Y-m-d')).'</td>
		</tr>
		<tr>
			<td class="h_tengah"> BENDAHARA </td>
			<td class="h_tengah"> KETUA </td>
		</tr>
		</table>';

		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');       
	}

	function cetak($id) {
		

		$row = $this->pinjaman_m->get_data_pengajuan($id);
		
		$tgl_input  = substr($row->tgl_input, 0, 10);
		

		
		$tgl_tempo = date('Y-m-d', strtotime('+'. $row->lama_ags.' month', strtotime( $tgl_input ))); //tambah tanggal sebanyak 7 bulan
		$tgl = explode(' ', $tgl_tempo);
		$txt_tgl_t = jin_date_ina($tgl[0]);
		// var_dump($txt_tgl_t);die();
		$angsuran_pokok = $row->nominal / $row->lama_ags;
		$bunga = ($row->nominal * $row->bunga) / 100;

		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->load->library('Pdf');
		$pdf = new pdf('P', 'cm', 'Legal', true, 'UTF-8', false);
		$pdf->set_nsi_header(false);
		$pdf->SetTopMargin(30);
        $pdf->SetRightMargin(20);
        $pdf->SetLeftMargin(20);
		$resolution = array(355, 215);
		$pdf->AddPage('P', $resolution);
		

		$html = '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 7pt; text-align: center;}
		</style>';
		$html .= ''.$pdf->nsi_box($text ='
			<table width="100%">
				<tr>
					<td colspan="2" class="h_kiri" class="txt_judul"><strong>'.$out['nama_lembaga'].'</strong>
					</td>
					<td colspan="2" class="h_kanan"> cabang
					</td> 
				</tr>
				<tr>
					<td class="h_kiri" width="100%"><strong>No. Badan Hukum 4716/BH/XVI.10/PAD/II/2009</strong></td>
					</tr>
				<tr>
					<td class="h_kiri" width="100%">'.$out['alamat'].' Tel. '.$out['telepon'].'
						<hr width="100%"></td>
					</tr>
				</table>
				', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $margin ='30', $align = 'left').'';

		$anggota= $this->general_m->get_data_anggota($row->anggota_id);

		$tgl_input = explode(' ', $row->tgl_input);
		$txt_tanggal = jin_date_ina($tgl_input[0]);

		$tgl_cair = explode(' ', $row->tgl_cair);
		$tgl_cair = jin_date_ina($tgl_cair[0]);

		$status_arr = array(0 => 'Menunggu Konfirmasi', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Sudah Terlaksana', 4 => 'Batal');

		$html .='<div class="h_tengah"><strong>BUKTI PERJANJIAN KREDIT</strong>
		<br class="h_tengah">
		No:...../ADM/SP-KUD/...../....</br>
		</div>
		


		<table width="100%">      
			<tr>
				<p style="font-size: 10px;" text-align="justify">Pada hari ini tanggal <strong> '.$txt_tanggal.' </strong> kami yang bertandatangan dibawah ini: </p>
				<p style="font-size: 10px;" text-align="justify">I. Unit Simpan Pinjam KUD Minatani Kec.Brondong Kab.Lamongan, Suatu badan hukum koperasi No.4716/BH/XVI.10/PAD/II/2009, berkedudukan di Kec.Brondong dalam hal ini diwakili oleh
				[Manager] yang bertindak dalam kapasitasnya sekalu Manajer Unit Simpan Pinjam KUD Minatani Kec.Brondong dari dan oleh karenanya bertindak atas nama serta kepentingan KUD Minatani Kec.Brondong, Selanjutnya disebut sebagai PIHAK PERTAMA </p>
			</tr>
			<tr>
				<p style="font-size: 10px;" text-align="justify">II.<strong> '.strtoupper($row->nama).' </strong> bertempat tinggal di <strong> '.$row->alamat.' </strong> Pemegang KTP No. <strong>'.$row->ktp.'</strong> dalam perbuatan hukum ini telah mendapat persetujuan dari NY/TN: <b> '.strtoupper($row->wakil).' </b> selaku Istri/Suami yang dibuat di bawah tangan sebagaimana dokumen terlampir, selanjutnya disebut sebagai PIHAK KEDUA. </p>
				<p style="font-size: 10px;" text-align="justify">PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama selanjutnya disebut <strong>PARA PIHAK.</strong></p>
				<p style="font-size: 10px;" text-align="justify"> kedua pihak telah bersepakat melaksanakan perjanjian pembiayaan dengan ketentuan-ketentuan yang tercantum pada pasal-pasal sebagai berikut :</p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 1</strong>
				<br><strong>LANDASAN</strong></p>
				<p style="font-size: 10px;" text-align="justify">Perjanjian kredit ini dilandasi oleh saling percaya, dan rasa tanggung jawab </p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 2</strong>
				<br> <strong> JUMLAH KREDIT</strong></p>
				<p style="font-size: 10px;" text-align="left">PARA PIHAK sepakat bahwa PIHAK KEDUA akan menerima kredit dari PIHAK PERTAMA sebesar <b>Rp '.number_format($row->nominal).'</b> yang pembayarannya dilakukan secara langsung dan dibayarkan melalui rekening simpanan koperasi yang dimiliki oleh PIHAK KEDUA</p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 3</strong>
				<br> <strong> PENGGUNAAN</strong></p>
				<p style="font-size: 10px;" text-align="justify"> Bahwa dana tersebut dalam pasal 2 oleh PIHAK KEDUA akan dipergunakan sebenar-benarnya untuk : <b>'. strtoupper($row->keterangan) .'</b></p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 4</strong>
				<br> <strong> JANGKA WAKTU</strong></p>
				<p style="font-size: 10px;" text-align="justify"> Pembiayaan ini diberikan untuk jangka waktu <b>'. $row->lama_ags.' Bulan </b>
				Terhitung sejak tanggal : <b>'. $txt_tanggal .'</b> sampai dengan tanggal <b>'.$txt_tgl_t.'</b>            </p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 5</strong>
				<br> <strong> BIAYA-BIAYA</strong></p>
				<p style="font-size: 10px;" text-align="justify"> Atas pemberian kredit menurut akta ini PIHAK KEDUA diwajibkan membayar kepada PIHAK KESATU :<br>
				a. Sebelum Kredit di realisasikan :<br>
				- Provisi dan Jasa Administrasi <br>
				- Jasa Pelayanan<br>
				- Bea Materai<br>
				- Biaya Pembuatan Akta Notaris<br>
				- Simpanan<br>
				- Asuransi Kredit</p>
				b. Biaya Penagihan
				<br>Manakalah PIHAK KEDUA lalai membayar segala apa yang harus dibayar menurut akta ini, maka semua biaya penagihan termasuk biaya peringatan, biaya pengadilan, biaya lelang. Biaya pengacara serta ongkos-ongkos lainnya, menjadi beban dan harus dibayar oleh PIHAK KEDUA, dan disetujui diperhitungkan 100% dari jumlah tagihan ditambah biaya resmi berdasarkan tanda bukti yang dikeluarkan instansi yang bersangkutan.
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 6</strong>
				<br> <strong> SUKU BUNGA KREDIT </strong></p>
				<p style="font-size: 10px;" text-align="justify"> PIHAK KEDUA wajib memebayar ]bunga kepada PIHAK PERTAMA sebayar '. $row->bunga .' % per bulan dengan perhitungan angsuran pokok sebesar: <b>Rp ' . number_format($angsuran_pokok) . '</b> dan bunga sebesar: <b> Rp ' . number_format($bunga) . ' </b></p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 7</strong>
				<br> <strong> DENDA </strong></p>
				<p style="font-size: 10px;" text-align="justify"> Jika penerima kredit lalai memebayar segala sesuatu yang harus dibayar olehnya kepada PIHAK PERTAMA, hal mana cukup dibuktikan lewatnya waktu tanggal pembayaran akan cukup membuktikan kelalaian penerima kredit, sehingga tidak diperlukan pemberitahuan (somasi) terlebih dahulu, kepada penerima kredit diwajibkan membayar denda kepada PIHAK PERTAMA sebesar 3% setiap bulannya dari angsuran yang tertunggak. </p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 8</strong>
				<br> <strong> JAMINAN </strong></p>
				<p style="font-size: 10px;" text-align="justify"> Untuk membayar kembali pokok pinjaman berikut bunganya PIHAK KEDUA selaku Peminjam, sesuai dengan perjanjian diatas maka PIHAK KEDUA memberikan kuasa kepada PIHAK PERTAMA untuk memindahkan hak dalam bentuk apapun baik di muka umum maupun dibawah tangan atas surat berharga yang dijaminkan berupa:';
				if($row->anggunan === "kendaraan" ){
					$html .= '</p>
					<p>1. Sebuah Kendaraan Bermotor
					</p>
					<table width="80%" colspan="4">
						<tr>
							<td class="h_kiri" > Jenis </td>
							<td class="h_kiri" > :  '. $row->jenis_bpkb .'</td>
							<td class="h_kiri" > Merek </td>
							<td class="h_kiri" > : ' .$row->merek_kendaraan. ' </td>
						</tr>
						<tr>
							<td class="h_kiri" > Warna </td>
							<td class="h_kiri" > : ' . $row->warna . '</td>
							<td class="h_kiri" > No.Ranka </td>
							<td class="h_kiri" > : ' . $row->no_rangka . '</td>
						</tr>
						<tr>
							<td class="h_kiri" > No.Mesin</td>
							<td class="h_kiri" > : ' . $row->no_mesin . ' </td>
							<td class="h_kiri" > No.Polisi </td>
							<td class="h_kiri" > : ' . $row->no_polisi . ' </td>
						</tr>
						<tr>
							<td class="h_kiri" > No. BPKB </td>
							<td class="h_kiri" > : ' . $row->no_bpkb . '</td>
							<td class="h_kiri" > Atas Nama </td>
							<td class="h_kiri" > : ' . $row->atas_nama . ' </td>
						</tr>
					</table>';
				}else{
					$html .= '<p>1. Sebidang Tanah Hak
					</p>
					<table width="80%" colspan="4">
						<tr>
							<td class="h_kiri" > SHM No. </td>
							<td class="h_kiri" > : '.$row->no_shm.'</td>
							<td class="h_kiri" > Terletak di : </td>
							<td class="h_kiri" > : '.$row->alamat_shm.' </td>
						</tr>
						<tr>
							<td class="h_kiri" > Propinsi </td>
							<td class="h_kiri" > : '.$row->prov_shm.' </td>
							<td class="h_kiri" > Kodya/Kab. </td>
							<td class="h_kiri" > : '.$row->kab_shm.'</td>
						</tr>
						<tr>
							<td class="h_kiri" > Kecamatan</td>
							<td class="h_kiri" > : '.$row->kec_shm.'</td>
							<td class="h_kiri" > Kelurahan </td>
							<td class="h_kiri" > : '.$row->alamat_shm.'</td>
						</tr>
						<tr>
							<td class="h_kiri" > Seluas </td>
							<td class="h_kiri" > : '.$row->luas_shm.'</td>
							<td class="h_kiri" > Diuraikan dalam surat ukut tertanggal  </td>
							<td class="h_kiri" > : '.$row->tgl_ukut.'</td>
						</tr>
						<tr>
							<td class="h_kiri" > Atas Nama </td>
							<td class="h_kiri" > : '.$row->an_shm.'</td>
					
						</tr>
					</table>';
				} 
				$html .= '<p> PIHAK KEDUA menjamin bahwa barang yang dijaminkan ini tidak dijaminkan kepada pihak lain, tidak dalam keadaan sengketa serta bebas dari sitaan. Tidak dalam keadaan disewakan serta tidak terikat dengan pihak lain karena sebab perjanjian ataupun apapun karena Undang-undang.
				</p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 9</strong>
				<br> <strong> KUASA PENJUALAN </strong></p>
				<p style="font-size: 10px;" text-align="justify"> PIHAK KEDUA dengan ini memberikan Kuasa penuh kepada PIHAK PERTAMA untuk atas nama PIHAK KEDUA menjual barang jaminan tersebut kepada siapapun dan dengan harga yang dianggap baik oleh PIHAK serta mempergunakan hasil penjualan barang jaminan tersebut guna pelunasan hutang pokok berikut bunganya.
				<br> Dalam hal ini hasil penjualan barang jaminan belum mencukupi untuk membayar hutang pokok berikut bunganya PIHAK KEDUA dengan ini menyatakan sanggup untuk membayar kekurangan pelunasan hutang pokok berikut bunga tersebut.
				</p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 10</strong>
				<br> <strong> PENYELESAIAN HUTANG </strong></p>
				<p style="font-size: 10px;" text-align="justify"> Jika perjanjian ini berakhir baik karena jatuh tempo atau sebab lainnya, maka semua hutang PIHAK KEDUA kepada PIHAK PERTAMA atas dasar perjanjian kredit ini berikut Denda, biaya penagihan dan biaya-biaya lainnya, harus dibayar oleh PIHAK KEDUA dengan seketika dan sekaligus dengan perhitungan seperti tersebut dalam pasal-pasal diatas.
				</p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>

				<p style="font-size: 10px;" class="h_tengah"> <strong> Pasal 11</strong>
				<br> <strong> LAIN - LAIN </strong></p>
				<p style="font-size: 10px;" text-align="justify"> Bilamana PIHAK KEDUA meninggal dunia maka semua hutang dan kewajiban PIHAK KEDUA kepada PIHAK PERTAMA yang timbul berdasarkan perjanjian kredit ini berlaku semua perubahan perpanjangan tetap merupakan suatu kesatuan huatang dari para ahli waris dari PIHAK KEDUA atau penanggung (jika ada) yang tidak dapat dibagi-bagi tapi apabila pada saat akad kredit PIHAK KEDUA membayar asuransi kredit maka hutang PIHAK KEDUA dianggap lunas. PIHAK PERTAMA sewaktu-waktu dapat memutuskan hubungan secara sepihak dan meminta pelunasan seketika, bilamana PIHAK KEDIA selama 3 (tiga) kali berturut-turut melaliakan kewajibannya membayar pokok bunga maupun kewajiban lainnya. 
				</p>

				<tr>
				Dalam pelaksanaan pembiayaan ini apabila terjadi permasalahan kedua belah pihak setuju meneyelesaikan dengan cara musyawarah untuk mufakat dan menurut peraturan atau prosedur yang ada di Unit Simpan Pinjam KUD Minatani Kec.Brondong dan putusanyamerupakan keputusan akhiryang mengikat.
				
				
				<p>
				Demikian perjanjian ini dibuat dan ditandatangani dengan sebenar-benarnya, tanpa ada unsur paksaan dari pihak mananpun.</p>
				</tr>
			

			
		
		<br><br>
		TERBILANG = '.$this->terbilang->eja(nsi_round($row->nominal)).' RUPIAH
		<p></p>
		<table width="100%">
			<tr>
				<td class="h_kiri" height="80px"><strong>PIHAK PERTAMA</strong></td>
				<td class="h_tengah" height="80px"><strong>PIHAK KEDUA</strong></td>
			</tr>
			
			<tr>
			</tr>
			<tr>
			</tr>
			
			<tr>
				<td class="h_kiri"><u>'.$out['nama_ketua'].'</u>
				<br font-size="10">Manager USP</td>
				<td class="h_tengah"><u>'.strtoupper($row->nama).'</u></td>
			</tr>
			<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>

		<table width="100%" cellspacing="0" cellpadding="2" border="1" nobr="true">
			<tr>
				<td class="h_kiri"><strong>UNIT SIMPAN PINJAM</strong>
				<br class="h_kiri"><strong>KUD MINATANI KEC.BRONDONG</strong>
				<br class="h_kiri">No. Badan Hukum 4716/BH/XVI.10/PAD/II/2009
				<br>
				</td>
			</tr>
			<tr bgcolor="#fffac7">
				<td></td>
			</tr>
			<tr> 
				<td width="100%"> Hari / Tanggal </td>
			</tr>
			<tr> 
				<td height="100%"> Tempat </td>
			</tr>
			<tr> 
				<td height="100%"> Pimpinan Komite </td>
			</tr>
			<tr bgcolor="#fffac7">
				<td class="h_tengah"> <strong>KEPUTUSAN KOMITE PEMBIAYAAN</strong></td>
			</tr>
			<tr> 
				<td height="40px"> Menurut hasil analisa kelayakan dan survey dilapangan, maka dengan ini Komite Pembiayaan memutuskan :
				<br> Nama - nama berikut ini, </td>
			</tr>
			<tr> 
				<td width="50%"> 1. NAMA 	: </td>
				<td width="50%"> ' . $row->nama . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 2. Jumlah Pengajuan 	: </td>
				<td width="50%"> ' . number_format($row->nominal) . '</td>
				

			</tr>
			<tr> 
				<td width="50%"> 3. Agunan/Jaminan 	: </td>
				<td width="50%"> ' . $row->anggunan . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 4. Tujuan Penggunaan 	: </td>
				<td width="50%"> ' . $row->keterangan . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 5. Surveyor 	: </td>
				<td width="50%"> ' . $row->surveyor . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 6. Koord.Marketing 	: </td>
				<td width="50%"> SUBAKRAN </td>
				

			</tr>
			<tr bgcolor="#c9ceff"> 
				<td width="33%" class="h_tengah">(....) Disetujui </td>
				<td width="33%" class="h_tengah">(....) Ditolak </td>
				<td width="34%" class="h_tengah">(....) Ditunda </td>
				
				

			</tr>
			<tr> 
				<td width="50%"> 7. Realisasi 	: </td>
				<td width="50%">  </td>
				

			</tr>
			<tr> 
				<td width="50%"> 8. Bunga 	: </td>
				<td width="50%"> ' . $row->bunga . ' % </td>
				

			</tr>
			<tr> 
				<td width="50%"> 9. Harga Taksiran 	: </td>
				<td width="50%"> ' . number_format($row->harga_taksiran) . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 10. Akad	: </td>
				<td width="50%"> ' . $row->anggunan . ' </td>
				

			</tr>
			<tr> 
				<td width="50%"> 11. Droping Tanggal 	: </td>
				<td width="50%"> </td>
				

			</tr>
			<tr bgcolor="#fffac7">
				<td class="h_tengah" width="100%"> <strong>KOLOM OPINI</strong></td>
			</tr>


			<tr> 
				<td width="100%" height="150px"> Manager : </td>
			</tr>

			<tr bgcolor="#fffac7">
				<td class="h_tengah" width="100%"> <strong>TANDA TANGAN PENGESAHAN</strong></td>
			</tr>


			<tr width="100%">
				<td class="h_tengah" height="80px" width="50%"><strong> Manager </strong></td>
				<td class="h_tengah" height="80px" width="50%"><strong> Koord.Marketing </strong></td>
			</tr>
			
			
			
			<tr>
				<td class="h_tengah" width="50%"><strong><u>'.$out['nama_ketua'].'</u></strong></td>
				<td class="h_tengah" width="50%"><strong><u>SUBAKRAN</u></strong></td>
			</tr>
			</table>







			<table width="100%" cellspacing="1" cellpadding="0" border="0" nobr="true">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td class="h_tengah"><strong>LEMBAR PEMERIKSAAN PINJAMAN</strong>
				<hr>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			
			<tr>
				<td></td>
			</tr>
			<tr> 
				<td width="100%"> Yang Bertanda-tangan dibawah ini: </td>
			</tr>
			<tr> 
				<td width="35%"> Nama</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$out['nama_ketua'].'</td>
			</tr>
			<tr> 
				<td width="35%"> Jabatan</td>
				<td width="5%"> :</td>
				<td width="60%">  </td>
			</tr>
			<tr>
				<td>
				</td>
			</tr>
			<tr> 
				<td width="80%"> Menerangakan Bahwa untuk menindaklanjut permohonan pinjaman nomer: </td>
				<td class="h_kanan" width="20%">'.$txt_tanggal.'</td>
			</tr>
			<tr> 
				<td width="35%"> Atas Nama</td>
				<td width="5%"> :</td>
				<td width="60%"> '.strtoupper($row->nama).' </td>
			</tr>
			<tr> 
				<td width="35%"> Alamat</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->alamat.' </td>
			</tr>
			<tr> 
				<td width="35%"> Pekerjaan</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->pekerjaan.' </td>
			</tr>
			
			<tr> 
				<td width="100%"> Telah dilakukan pemeriksaan lapangan terhadap tempat tinggal, usaha, keadaan keuangan, dan angsuran Ybs.
				<br> dengan penjelasan sebagai berikut :</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr> 
				<td width="35%"> 1.Jenis Usaha</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->jenis_usaha.' </td>
			</tr>
			<tr> 
				<td width="35%"> 2.Temapat Usaha</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->tempat_usaha.' </td>
			</tr>
			<tr> 
				<td width="35%"> 3.Omzet Perbulan</td>
				<td width="5%"> :</td>
				<td width="60%" class="h_kanan"> '.number_format($row->omzet_perbulan).' </td>
			</tr>
			<tr> 
				<td width="35%"> 4.Biaya Hidup Perbulan</td>
				<td width="5%"> :</td>
				<td width="60%" class="h_kanan"> '.number_format($row->biaya_hidup).' 
				<hr></td>
			</tr>
			<tr> 
				<td width="35%"> 5.Keuntungan bersih yang diperoleh 
				<br> per-bulan (rata-rata) </td>
				<td width="5%"> :</td>
				<td width="60%" class="h_kanan"> '.number_format($row->keuntungan).'</td>
			</tr>
			<tr> 
				<td width="35%"> 6.Anggunan yang diserahkan</td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->anggunan.' </td>
			</tr>
			<tr> 
				<td></td>
			</tr>

			<tr> 
				<td width="100%">Atas dasar hasil pemeriksaan tersebut diatas serta disertai peryataan/ kesanggupan Ybs, untuk membayar kembali pinjaman yang akan diterimanya, dengan ini kami usulkan bahwa Ybs, layak diberikan pinjaman</td>
			</tr>
			<tr> 
				<td width="35%"> sebesar Rp. '.number_format($row->nominal).',- </td>
				<td width="5%"> </td>
				<td width="60%"><strong> '.$this->terbilang->eja(nsi_round($row->nominal)).' RUPIAH </strong></td>
			</tr>
			<tr> 
				<td></td>
			</tr>

			<tr> 
				<td width="35%"> Untuk Keperluan </td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->keterangan.' </td>
			</tr>
			<tr> 
				<td width="35%"> Jangka Waktu </td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->lama_ags.' Bulan </td>
			</tr>
			<tr> 
				<td width="35%"> Suku Bunga </td>
				<td width="5%"> :</td>
				<td width="60%">  ' . $row->bunga . ' %	/ 	Bulan </td>
			</tr>
			<tr> 
				<td width="35%"> Angsuran </td>
				<td width="5%"> :</td>
				<td width="60%"> Rp '.number_format($angsuran_pokok).'</td>
			</tr>
			<tr> 
				<td></td>
			</tr>
			<tr> 
				<td></td>
			</tr>
			<tr> 
				<td></td>
			</tr>

			
				

			
			<tr>
				<td class="h_tengah" width="100%"> <strong>PUTUSAN PINJAMAN</strong></td>
			</tr>


			<tr> 
				<td width="100%">Berdasarkan keputusan / hasil analisa tersebut diatas dengan mempertimbangakan segala resiko yang akan Timbul, dengan ini permohonan pinjaman sebagaimana keterangan diatas dapat/tidak dapat disetujui dengan ketentuan sebagai berikut : </td>
			</tr>
			<tr> 
				<td></td>
			</tr>

			<tr> 
				<td width="35%"> Besar Pinjaman</td>
				<td width="5%"> :</td>
				<td width="30%"><strong> Rp. '.number_format($row->nominal).',- </strong></td>
				<td width="30%"><strong> '.$this->terbilang->eja(nsi_round($row->nominal)).' RUPIAH </strong></td>
			</tr>
			<tr> 
				<td width="35%"> Peminjam</td>
				<td width="5%"> :</td>
				<td width="60%"> '.strtoupper($row->nama).' </td>
			</tr>
			<tr> 
				<td width="35%"> Jangka Waktu </td>
				<td width="5%"> :</td>
				<td width="60%"> '.$row->lama_ags.' Bulan </td>
			</tr>
			<tr> 
				<td width="35%"> Suku Bunga </td>
				<td width="5%"> :</td>
				<td width="60%"> ' . $row->bunga . '% / Bulan </td>
			</tr>
			<tr> 
				<td width="35%"> Angsuran </td>
				<td width="5%"> :</td>
				<td width="60%"> Rp '.number_format($angsuran_pokok).' </td>
			</tr>

			
			<tr> 
				<td></td>
			</tr>

			<tr> 
				<td></td>
			</tr>
			<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				<p></p>
				


			<tr width="100%">
				<td class="h_kiri" height="80px" width="50%"><strong> Diperiksa oleh :</strong></td>
				<td class="h_kanan" height="80px" width="50%"><strong> Diperiksa oleh :</strong></td>
			</tr>
			
			
			
			<tr>
				<td class="h_kiri" width="50%"><strong><u>'.$out['nama_ketua'].'</u></strong></td>
				<td class="h_kanan" width="50%"><strong><u>'.$out['nama_ketua'].'</u></strong></td>
			</tr>


		</table>';
		
		




		$pdf->nsi_html($html);
		$pdf->Output(date('Ymd_His') . '.pdf', 'I');
	} 
}
/*'.$row->identitas.' 
<tr>
				
				<td>:</td>
				<td>'.strtoupper($anggota->nama).'</td>
			</tr>
			<tr>
				<td> Departement </td>
				<td>:</td>
				<td>'.($row->departement).'</td>
			</tr>
			<tr>
				<td> Alamat </td>
				<td>:</td>
				<td>'.$anggota->alamat.'</td>
			</tr>

			<tr>
				<td colspan="3"><br><br> <span style="font-size: 12px;">Rincian Pengajuan</span> </td>
			</tr>
			<tr>
				<td> Tanggal Pengajuan </td>
				<td>:</td>
				<td>'.$txt_tanggal.'</td>
			</tr>
			<tr>
				<td> Jumlah Pinjaman </td>
				<td>:</td>
				<td>Rp '.number_format($row->nominal).',-</td>
			</tr>
			<tr>
				<td> Status Ajuan </td>
				<td>:</td>
				<td>'.$status_arr[$row->status].'</td>
			</tr>

			<tr>
				<td> Tanggal Pencairan </td>
				<td>:</td>
				<td>'.$tgl_cair.'</td>
			</tr>
			<tr>
				<td> Lama Angsuran </td>
				<td>:</td>
				<td>'.$row->lama_ags.' Bulan</td>
			</tr>
		</table>
		<br><br>
		TERBILANG = '.$this->terbilang->eja(nsi_round($row->nominal)).' RUPIAH
		<p></p>
		<table width="90%">
			<tr>
				<td height="50px"></td>
				<td class="h_tengah">'.$out['kota'].', '.jin_date_ina(date('Y-m-d')).'</td>
			</tr>
			<tr>
				<td class="h_tengah"> '.strtoupper($this->data['u_name']).'</td>
				<td class="h_tengah">'.strtoupper($anggota->nama).'</td>
			</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output(date('Ymd_His') . '.pdf', 'I');
	} 


*/