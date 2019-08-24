<?php include('template/v_top.php'); ?>
	<div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Edit</h3>
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
                            <h3 class="box-title m-b-0">Edit Data</h3>
                            <p class="text-muted m-b-30 font-13"> Pastikan semua input terisi </p>
                            <?php 
                                foreach ($vehicle as $row) {                        
                            ?>
                            <form class="form-horizontal" action="<?=base_url()?>data_kendaraan/edit_process" method="POST">
                                <input type="hidden" name="hiddenID" value="<?=$row->id_mobil?>">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">ID Mesin</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputID" placeholder="ID Mesin" name="inputID" value="<?=$row->no_mesin?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">No Plat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputNP" placeholder="No Plat" name="inputNP" value="<?=$row->no_plat?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Tipe Mobil</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputTipe" placeholder="Tipe" name="inputTipe" value="<?=$row->tipe_mobil?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 text-right control-label col-form-label">Merk</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputMerk" placeholder="Merk" name="inputMerk" value="<?=$row->nama_mobil?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword4" class="col-sm-3 text-right control-label col-form-label">Tahun Keluaran</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputTahun" placeholder="Tahun" name="inputTahun"
                                        value="<?=$row->tahun_keluaran?>">
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
                               <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Edit</button>
                               <a onclick="javascript:window.location.href='<?=base_url()?>data_kendaraan/edit_page/<?=$row->id_mobil?>'" class="btn btn-danger waves-effect waves-light" style="color:#ffffff;">Cancel</a>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->                
            </div>
<?php include('template/v_bot.php'); ?>

