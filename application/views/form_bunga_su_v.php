<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Bunga Simpanan Deposito</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div>
				<?php } ?>

		<div class="form-group">
					<?php 
					echo form_open('');
					
			echo '
			<table width="70%">';
			// <tr> 
			// 	<td>';
				// tipe bunga
				// $options = array(
				// 	'A'  => 'A: Persen Bunga dikali angsuran bln',
				// 	'B'  => 'B: Persen Bunga dikali total pinjaman'
					// 'C'  => 'C: Bunga Menurun = Persen Bunga dikali sisa pinjaman'
					// );
				// echo form_label('Tipe Pinjaman Bunga', 'pinjaman_bunga_tipe');
				// echo form_dropdown('pinjaman_bunga_tipe', $options, $pinjaman_bunga_tipe, 'id="pinjaman_bunga_tipe" class="form-control"');
				// echo '
				// </td>
				// <td>';			

			echo '
			<tr>
				<td>';
				//bunga pinjman
				$data = array(
					'name'        => 'deposito',
					'id'		  => 'deposito',
					'class'		  => 'form-control',
					'value'       => $deposito,
					'maxlength'   => '255',
					'style'       => 'width: 50%'
					);
				echo form_label('Suku Bunga Simpanan Deposito (%)', 'deposito');
				echo form_input($data);
				echo '
				</td>
			</tr>';

		echo '</table>';

					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					echo '<br>';
					echo form_button($data);
					echo form_close();

					?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
