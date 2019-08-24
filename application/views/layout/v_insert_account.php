<?php include('template/v_top.php'); ?>
	<div class="page-wrapper">
           
            <!--
            <div class="row page-titles" style="background:url(assets/images/background/user-bg.jpg) no-repeat center top">
                <div class="col-lg-12 text-center">
                    <h1 class="m-t-30">Markarn Doe</h1>
                    <h5 class="text-muted m-b-30"><i class="ti-pin"></i> Ahmedabad, India</h5>
                </div>
            </div>
            Row -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Insert</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url()?>data_kendaraan"><?=$pos_prev?></a></li>
                        <li class="breadcrumb-item active"><?=$pos_now?></li>
                    </ol>
                </div>
                <div class="">
                   
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    
                    <div class="col-12">
                        <div class="card card-body">
                            <h3 class="box-title m-b-0">Tambah Data Akun</h3>
                            <p class="text-muted m-b-30 font-13"> Pastikan semua input terisi </p>
                            <form class="form-horizontal" action="<?=base_url()?>account/insert_process" method="POST">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputID" placeholder="Username" name="username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputNP" placeholder="Password" name="password">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputNP" placeholder="Konfirmasi Password" name="confirm_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Hak Akses</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="access">
                                            <option value="0">Pilih Hak Akses</option>
                                            <option value="1">Super Admin</option>
                                            <option value="2">Admin</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <div class="checkbox checkbox-success">
                                            <input id="checkbox33" type="checkbox">
                                            <label for="checkbox33">Check me out !</label>
                                        </div>
                                    </div>
                                </div>
                               <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Submit</button>
                               <a onclick="javascript:window.location.href='<?=base_url()?>Account/insert_account'" class="btn btn-danger waves-effect waves-light" style="color:#ffffff;">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->                
            </div>
<?php include('template/v_bot.php'); ?>

