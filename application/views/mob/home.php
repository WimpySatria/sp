<!DOCTYPE html>
<html>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>

    <style>
    button {
    margin-right: 20px;
    margin-left: 10px;
    width: 40%;
    height: 90px;
    font-size: 20px;
    border-radius: 50%;
    }
    h4 {
    margin-right: 20px;
    margin-left: 10px; 
    width: 80%;
    font-size: 20px;
    }
    #header {
        padding: 0px;
        text-align: center;
        background: #F5F5F5;
        font-color: #FFFFFF ;
        font-size: 100px;

    }
    #bg {
        background: url('assets/theme_admin/img/b.jpg');
        background-size: 100%;

    }

    #footer{
        background:#4169E1;
        position:absolute;
        bottom:0;
        width:100%;
        text-align:center;
        color:#FFFFFF;
    }
    </style>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Home Page Marketing</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body id="bg">

    <nav class="navbar navbar-default">
        <div class="container">
            <div id ="header" class="navbar-header">
                <img src="<?php echo base_url().'assets/theme_admin/img/logo2.png'; ?>" alt="">
            </div>

            


            <ul  class="nav navbar-nav navbar-right">
            <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-user"></i>
							<span><?php echo $u_name; ?> <i class="caret"></i></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('mob_marketing/ubah_password');?>"> <i class="fa fa-key"></i>Ubah Password</a></li>
							<li><a href="<?php echo base_url();?>login/logout"> <i class="fa fa-sign-out"></i>Logout</a></li>
						</ul>
					</li>
            </ul>
        </div>
    </nav>
<h5 align="center">
    Selamat Datang Di Aplikasi, <?php echo $this->data['u_name'];?>
    
</h5>

    <div class="container">
        <div class="row">
        <?= $this->session->flashdata('success');?>
        <?= $this->session->flashdata('gagal');?>
        
            <center><h4>Menu</h4></center>

            <center>
                <a href="<?php echo base_url();?>mob_marketing/setoran" href="javascript:void(0)" onclick="create()">
                    <button type="button" class="btn btn-primary" widht="40">
                        <img height="40" width="40" src="<?php echo base_url().'assets/theme_admin/img/setor.png'; ?>">
                        <br>SETORAN
                    </button>
                </a>

                <a href="<?php echo base_url();?>mob_marketing/data_s" >
                    <button type="button" class="btn btn-primary" >
                        <img height="40" width="40" src="<?php echo base_url().'assets/theme_admin/img/task.png'; ?>" >
                        <br>DATA SETOR
                    </button>
                </a>
            </center><br>
            
            <center>
                <a href="<?php echo base_url();?>mob_marketing/penarikan" >
                    <button type="button" class="btn btn-primary">
                        <img height="40" src="<?php echo base_url().'assets/theme_admin/img/bank.png'; ?>">
                        <br>PENARIKAN
                    </button>
                </a>
                <a href="<?php echo base_url();?>mob_marketing/data_p" >
                    <button type="button" class="btn btn-primary">
                        <img height="40" src="<?php echo base_url().'assets/theme_admin/img/task.png'; ?>">
                        <br>DATA TARIK
                    </button>
                </a>
            </center> 
            <br>
            
            <center>
                <a href="<?php echo base_url();?>mob_marketing/pengajuan" >
                    <button type="button" class="btn btn-primary">
                        <img height="40" src="<?php echo base_url().'assets/theme_admin/img/payment.png'; ?>">
                        <br>PENGAJUAN
                            <br>PINJAM
                    </button>
                 <a href="<?php echo base_url();?>mob_marketing/data_pinjaman" >
                    <button type="button" class="btn btn-primary">
                        <img height="40" src="<?php echo base_url().'assets/theme_admin/img/report.png'; ?>"> 
                        <br>DATA
                            <br>PINJAM
                    </button>
            </center>
        </div>

        <div class="row" style="margin-top: 15px;" >
            <footer class="page-footer font-small" style="background-color: blue; position: relative; bottom: 0;">
                <div class="'footer-copyright text-center py-3" style="color: white; font-size: 15px;">
                    Tim IT USP Minatani <?php echo date('Y')?>
                </div>
                
            </footer>
        </div>
            
    </div>
    

<script>
function create(){
        $('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
        $('#form').form('clear');
        $('#anggota_id ~ span span a').show();
        $('#anggota_id ~ span input').removeAttr('disabled');
        $('#anggota_id ~ span input').focus();
        
        $('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');
        $('#tgl_transaksi').val('<?php echo $tanggal;?>');
        $('#kas option[value="1"]').prop('selected', true);
        $('#jenis_id option[value="0"]').prop('selected', true);
        $('#no_rek option[value="0"]').prop('selected', true);
        $("#anggota_poto").html('');
        $('#jumlah ~ span input').keyup(function(){
            var val_jumlah = $(this).val();
            // ni js klau jumlah di input mka js terbilang aktif dan masuk ke text area (ket)
            $('#ket').val(terbilang(del_koma(val_jumlah)));
            $('#jumlah').numberbox('setValue', number_format(val_jumlah));
        });
    
        url = '<?php echo site_url('simpanan/create'); ?>';
    }
</script>



</body>
</html>