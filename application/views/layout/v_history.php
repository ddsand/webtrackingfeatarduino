<?php include ('template/v_top.php'); ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
              <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$pos_now?></a></li>
                        
                    </ol>
                </div>
                <div class="">
                  
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- Row -->
            
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="margin-bottom: -3%;">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="min-height: 400px;">
                                <h4 class="card-title"><?=$live_track?></h4>
                                <form class="form-material m-t-40 row" style="margin-top:-12px;" action="<?=base_url()?>maps/show_route" method ="POST">
                                    <div class="form-group col-md-4 m-t-20">
                                        <label for="recipient-name" class="control-label">Mobil :</label>
                                        <select class="form-control required custom-select" name="vehicle">
                                            <option value="Default">No Plat</option>
                                            <?php foreach($vehicle as $row){?>
                                            <option value="<?=$row->id_mobil?>"><?=$row->no_plat?></option>   
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 m-t-20">
                                        <label for="recipient-name" class="control-label">Cari Waktu :</label>
                                        <input type="text" name="daterange" id="my_date" class="form-control" value="2018/01/01 1:30 PM - 2018/01/01 2:00 PM" />
                                    </div>
                                    <div class="form-group col-md-4 m-t-20">
                                        <div class="offset-sm-3 col-sm-9" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="markermap" class="gmaps"></div>
                            </div>
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
    
<?php include('template/v_bot.php'); ?>
           