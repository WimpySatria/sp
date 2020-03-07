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
    <title><?= $judul_browser; ?></title>
</head>
<body>-->
        <?php
        
            $sql = "SELECT  nama,alamat,jumlah,`tbl_pinjaman_h`.`id` FROM tbl_anggota
            INNER JOIN tbl_pinjaman_h ON anggota_id=`tbl_anggota`.`id` ";

            $penarikan = $this->db->query($sql)->result();
            $no = 1;
           
        
        ?>
        <div class="container-fluid mt-10">

        <div class="row">
          <div class="col-md-12 col-sm-12 text-center">
            <h5 class="text-center text-primary">DATA PINJAMAN</h5>
          </div>
        </div>
       
        <div class="row mb-3 mt-3 float-right">
          <a href="<?= base_url('mob_marketing/data_pengajuan')?>" class="btn btn-primary">Data pengajuan</a>
        </div>
        <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped small" id="data_setoran" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Jumlah</th>
                      <th>Aksi</th>    
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($penarikan as $p) :
                    $tanggal = date('Y-m-d H:i');
                    $tanggal_arr = explode(' ',$p->tgl_transaksi);
                    $txt_tanggal = jin_date_ina($tanggal_arr[0]);
                    $txt_tanggal .= '-'. $tanggal_arr[1];
                    ?>
                    <tr>
                      <td><a href="<?=base_url().'mob_marketing/detail/'.$p->id;?>" ><?=$p->nama;?>></a></td>
                      <td><a href="<?=base_url().'mob_marketing/detail/'.$p->id;?>" ><?=$p->alamat;?></a></td>
                      <td  style="text-align:right;"><a href="<?=base_url().'mob_marketing/detail/'.$p->id;?>"><?=number_format($p->jumlah); ?></a></td>
                      <td><a href="<?=base_url().'mob_marketing/angsuran/'.$p->id;?>" class="btn btn-primary btn-sm">Bayar</a></td>
                    </tr>
                    
                  <?php endforeach;?>
                   </body>
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
  $('#data_setoran').DataTable();
</script>

</html>