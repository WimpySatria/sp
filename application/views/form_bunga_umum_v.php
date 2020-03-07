 <div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Bunga Simpanan Umum</h3>
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
        					
            // 			echo '
            // 			<table width="70%">
            //     			<tr> 
            //     				<td>';
            //     				// tipe bunga
            //     				$options = array(
            //     					'A'  => 'A: Anggota',
            //     					'B'  => 'B: Umum'
            //     					// 'C'  => 'C: Bunga Menurun = Persen Bunga dikali sisa pinjaman'
            //     					);
            //     				echo form_label('Tipe Pinjaman Bunga', 'simpanan_umum_tipe');
            //     				echo form_dropdown('simpanan_umum_tipe', $options, $simpanan_umum_tipe, 'id="pinjaman_bunga_tipe" class="form-control"');
            //     				echo '
            //     				</td>
            //     			</tr>';
            
            			echo '
                			<tr> 
                				<td>';
                				//dana cadangan
                				$data = array(
                					'name'        	=> 'simpanan_umum',
            					    'id'            => 'simpanan_umum',
                					'class'			=> 'form-control',
                					'value'       	=> $simpanan_umum,
                					'maxlength'   	=> '255',
                					'style'       	=> 'width: 50%'
                					);
                				echo form_label('Suku Bunga Simpanan Umum (%)', 'simpanan_umum');
                				echo form_input($data);
                				echo '
                				</td>
                		    </tr>
            		    </table>';
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