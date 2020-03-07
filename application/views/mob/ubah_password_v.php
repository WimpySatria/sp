<!DOCTYPE html>
<html>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/html"></script>
 
    <?php 
	foreach($css_files as $file) { ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php } ?>
	
	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />	

	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jqClock.min.js" type="text/javascript"></script>

	<?php foreach($js_files as $file) { ?>
		<script src="<?php echo $file; ?>"></script>
	<?php } ?>

	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/AdminLTE/app.js" type="text/javascript"></script>

	<?php foreach($js_files2 as $file) { ?>
		<script src="<?php echo $file; ?>"></script>
	<?php } ?>
	<!-- Waktu -->
	<script type="text/javascript">
    $(document).ready(function(){    
      $(".jam").clock({"format":"24","calendar":"false"});
    });    
  </script>

    <style>
    #nav {
        background: #B0C4DE;
    }
    #footer{
        background:#341f97;
        position:absolute;
        bottom:0;width :100%;
        text-align:center;
        color:#808080;
    }
    </style>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?= $judul_browser; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<img src="<?php echo base_url().'assets/theme_admin/img/logo2.png'; ?>" alt="">
			</div>
		</div>
	</nav>

	<div class="container">

    <div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Ubah Password</h3>
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
						Password berhasil diubah.
					</div>
				</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
				<div class="box-body">
					<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-warning"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Maaf Password lama salah, silakan coba lagi.
					</div>
				</div>
				<?php } ?>

				<div class="form-group">
					<?php 
					echo form_open('');
					//password lama
					$data = array(
						'name'       => 'password_lama',
						'id'			=> 'password_lama',
						'class'		=> 'form-control',
						'value'      => '',
						'maxlength'  => '255',
						'style'      => 'width: 250px'
						);
					echo form_label('Password Lama', 'password_lama');
					echo form_password($data);
					echo form_error('password_lama', '<p style="color: red;">', '</p>');
					echo '<br>';

					//password baru
					$data = array(
						'name'       => 'password_baru',
						'id'			=> 'password_baru',
						'class'		=> 'form-control',
						'value'      => '',
						'maxlength'  => '255',
						'style'      => 'width: 250px'
						);
					echo form_label('Password Baru', 'password_baru');
					echo form_password($data);
					echo form_error('password_baru', '<p style="color: red;">', '</p>');
					echo '<br>';


					//ulangi password baru
					$data = array(
						'name'       => 'ulangi_password_baru',
						'id'			=> 'ulangi_password_baru',
						'class'		=> 'form-control',
						'value'      => '',
						'maxlength'  => '255',
						'style'      => 'width: 250px'
						);
					echo form_label('Ulangi Password Baru', 'ulangi_password_baru');
					echo form_password($data);
					echo form_error('ulangi_password_baru', '<p style="color: red;">', '</p>');
					echo '<br>';
					if (!empty($pesan)) {
						echo '<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-warning"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						' . $pesan . '.
						</div>';
					}

                    // submit
                    echo '<div class="form-group">';
					$data = array(
						'name' 		=> 'submit',
						'id' 		=> 'submit',
						'class' 	=> 'btn btn-primary',
						'value'		=> 'true',
						'type'	 	=> 'submit',
						'content' 	=> 'Ubah Password'
						);
					
					echo form_button($data);

                    echo form_close();
                    
                    echo '<a href="'.base_url().'mob_marketing" class="btn btn-danger" style="margin-left:5px;">Kembali</a></div>';

					?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>



</div>


 

</body>

</html>