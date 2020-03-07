<style type="text/css">
	
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
    }
    $amin = $this->db->get_where('tbl_trans_sp',['user_name' => 'amin'])->num_rows();
    $elmas = $this->db->get_where('tbl_trans_sp',['user_name' => 'elmas'])->num_rows();
    $habib = $this->db->get_where('tbl_trans_sp',['user_name' => 'habib'])->num_rows();
    $ummu = $this->db->get_where('tbl_trans_sp',['user_name' => 'ummu'])->num_rows();
    $admin = $this->db->get_where('tbl_trans_sp',['user_name' => 'admin'])->num_rows();
//  var_dump($ummu);die();
?>

<?php 
$total_tagihan = $jml_pinjaman->jml_total;
$total_denda = $jml_denda->total_denda;
$jml_tot_tagihan = $total_tagihan + $total_denda;
$jns_simpanan = $this->db->get('jns_simpan')->result();

?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<select name="" id="jenis_simpanan" class="form-control">
				<option value="">pilih jenis simpanan</option>
				<?php foreach($jns_simpanan as $jenis) : ?>
					<option value="<?=$jenis->id?>"><?= $jenis->jns_simpan; ?></option>
				<?php endforeach ; ?>
			</select>
		</div>
		<div class="col-md-3">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tgl</span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>
		</div>
	</div>

	<div class="row" id="grafik">
    <div class="col-md-6">
	    <canvas id="deposito"></canvas>
    </div>
	</div>
</div>

<script>
	$(function(){

        // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

        
        $('#jenis_simpanan').on('change', function(){
            const jenis_id = $(this).val();
            
            $.ajax({
                url : "<?=base_url('grafik/get_grafik_marketing')?>",
                data : {jenis_id : jenis_id},
                method : "POST",
                dataType : "JSON",
                success : function(hasil){
                    // alert(hasil.amin);
                
                // menambahkan elemen canvas setelah row

				var ctx = document.getElementById("deposito");
                    var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Amin","Elmas","Habib","Ummu"],
                        datasets: [{
                        label: "Amin",
                        backgroundColor: "black",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: [hasil.amin,hasil.elmas,hasil.habib,hasil.ummu]
                        }],
                    },
                    options: {
                        maintainAspectRatio: true,
                        layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                        },
                        scales: {
                        xAxes: [{
                            time: {
                            unit: 'month'
                            },
                            gridLines: {
                            display: true,
                            drawBorder: true
                            },
                            ticks: {
                            maxTicksLimit: 12
                            },
                            maxBarThickness: 50,
                        }],
                        yAxes: [{
                            ticks: {
                            min: 0,
                            max: 1500,
                            maxTicksLimit: 10,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                            },
                            gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: true,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                            }
                        }],
                        },
                        legend: {
                        display: true
                        },
                        tooltips: {
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: true,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp' + number_format(tooltipItem.yLabel);
                            }
                        }
                        }
                    }
                    });




            }
            }); // end ajax
                
        }); // end on change



    }) // end ready
</script>
