<?php include ('template/v_top.php'); ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
              <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center" id="ref">
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
            <div class="container-fluid" style="margin-bottom: -2%;">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="min-height: 400px;">
                                <div id="oke"><h4 class="card-title"><?=$pos_now?></h4></div>
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
           