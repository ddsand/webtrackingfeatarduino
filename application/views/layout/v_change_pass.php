<?php include ('template/v_top.php'); ?>
    <div class="page-wrapper">        
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Form Basic</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item">Change Password</li>
                    
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
                        <h3 class="box-title m-b-0">Ubah Password</h3>
                        
                        <form class="form-horizontal" action="<?=base_url()?>Account/change_process" method="POST">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="old_pass" placeholder="Password" name="new_pass">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Masukkan Password lagi: </label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="new_pass" placeholder="Password Baru" name="confirm_pass">
                                </div>
                            </div>
                           
                           <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                           <a class="btn btn-inverse waves-effect waves-light" href="<?=base_url()?>">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
<?php include('template/v_bot.php'); ?>