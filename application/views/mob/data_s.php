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
     #bg {
        background: url('assets/theme_admin/img/b.jpg');
        background-size: 100%;

    }

</style>

    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Data Setoran Nasabah</title>
    <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>


  <div class="navbar-header text-dark text-center mt-3">
          <strong>DATA SETORAN</strong>      
  </div>
  <hr>
  <div class="box-"></div>
 <!--    <ul> -->



        
        <?php
        $tgl_sekarang = date('Y-m-d');
        
            $sql = "SELECT  no_rek,tgl_transaksi,jumlah,nama,`user_name`, `tbl_trans_sp`.`id` FROM tbl_trans_sp
            INNER JOIN tbl_anggota ON anggota_id=`tbl_anggota`.`id` AND dk='D' AND tgl_transaksi LIKE '".$tgl_sekarang." %' ORDER BY `tbl_trans_sp`.`id` DESC";

            $penarikan = $this->db->query($sql)->result();
            $no = 1;
           
        
        ?>
        <div id="bg" class="container-fluid mt-4">

       

        <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped small" id="data_setoran" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th hidden="true">no</th>
                      <th>Tanggal</th>
                      <th>No Rek</th>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Marketing</th>
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
                        <td hidden="true"><?=$p->id;?></td>
                      <td><a href="<?=base_url().'cetak_simpanan/cetak/'.$p->id;?>" target="_blank"><?=$txt_tanggal; ?></a></td>
                      <td><a href="<?=base_url().'cetak_simpanan/cetak/'.$p->id;?>" target="_blank"><?=$p->no_rek; ?></a></td>
                      <td><a href="<?=base_url().'cetak_simpanan/cetak/'.$p->id;?>" target="_blank"><?=$p->nama;?></a></td>
                      <td  style="text-align:right;"><a href="<?=base_url().'cetak_simpanan/cetak/'.$p->id;?>" target="_blank"><?=number_format($p->jumlah); ?></a></td>
                      <td><a href="<?=base_url().'cetak_simpanan/cetak/'.$p->id;?>" target="_blank"><?=$p->user_name; ?></a></td>
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
  $('#data_setoran').DataTable({
    
    "order" : [[0,'desc']]
});
</script>


</html>