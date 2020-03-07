

<!DOCTYPE html>
<html>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- font Awesome -->




    <link href="<?php echo base_url();?>assets/mobile/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url();?>assets/mobile/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?php echo base_url();?>assets/mobile/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<style>
    a:hover {
        text-decoration:none;
    }
    a{
      color:black;
    }
  
    .menu{
      float:right;
      margin-top: 10px;
      margin-bottom: 10px;
      margin-right: 100px;
    }

    .menu a{
      padding:10px;
    }

</style>

    
<head>
    <title>Data Pengajuan Pinjaman</title>
    <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>  
        <div class="container-fluid mt-4">
		<div class="row mb-3 mt-3 ">
      <div class="col-md-12 col-sm-12 text-center text-dark">    
			  <h5 >DATA PENGAJUAN PINJAMAN</h5>
      </div>
		</div>

       <?php echo $this->session->flashdata('success') ?>
       <?php echo $this->session->flashdata('gagal') ?>

        <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped small" id="data_pengajuan" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Jumlah</th>
                      <th>Status</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($pengajuan as $p) :
                    $tanggal = date('Y-m-d H:i');
                    $tanggal_arr = explode(' ',$p->tgl_transaksi);
                    $txt_tanggal = jin_date_ina($tanggal_arr[0]);
                    $txt_tanggal .= '-'. $tanggal_arr[1];
                    ?>
                    <tr>
                      <td class="text-dark"><?=$p->nama; ?></a></td>
                      <td class="text-dark"><?=$p->alamat;?></a></td>
                      <td  style="text-align:right;" class="text-dark"><?=number_format($p->nominal); ?></a></td>
                      <td>
					  	<?php if($p->status == 0){
							  echo ' <span class="text-primary"><i class="fa fa-question"></i></span> Menunggu';
						  }elseif($p->status == 1 ){
							  echo ' <span class="text-success"><i class="fa fa-check-circle"></i> Disetujui ';
						  }elseif($p->status == 2 ){
							  echo '<span class="text-danger"><i class="fa fa-times-circle"></i> Ditolak';
						  }elseif( $p->status == 3){
							  echo '<span class="text-success"><i class="fa fa-rocket"></i> Terlaksana';
						  }else{
							  echo '<span class="text-warning"><i class="fa fa-trash"></i> Batal';
						  } ?>
					  </td>
                      <td><a href="<?php echo base_url('mob_marketing/hapus_pengajuan/'. $p->id)?>" onclick="return confirm('anda yakin akan menghapus data ?')" class="btn btn-danger btn-sm">Hapus</a></td>
                    </tr>
                    
                  <?php endforeach;?>
                   </tbody>
			</table>
        </div>
        <!-- row 3: Footer -->
     </div>
</body>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/mobile/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/mobile/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/mobile/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/mobile/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/mobile/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/mobile/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo base_url();?>mobile/js/demo/datatables-demo.js"></script>







<script type="text/javascript">
  $('#data_pengajuan').DataTable();
</script>

</html>