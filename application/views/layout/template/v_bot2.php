 <<!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2018 By CE 2015 A Resource From .... </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
       <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>/assets/plugins/jquery/jquery.min.js"></script>    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url()?>/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?=base_url()?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url()?>/assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url()?>/assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url()?>/assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?=base_url()?>/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?=base_url()?>/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url()?>/assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>/assets/plugins/skycons/skycons.js"></script>
    <!-- chartist chart -->
    <script src="<?=base_url()?>/assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="<?=base_url()?>/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?=base_url()?>/assets/js/dashboard3.js"></script>
     <!-- google maps api -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCUBL-6KdclGJ2a_UpmB2LXvq7VOcPT7K4&sensor=true"></script>
    <script src="<?=base_url()?>assets/plugins/gmaps/gmaps.js"></script>
    <script src="<?=base_url()?>/assets/plugins/gmaps/gmaps.min.js"></script>    
    <!-- This is data table -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->

    <!-- Plugin JavaScript -->
    
    <script src="<?=base_url()?>assets/plugins/moment/moment.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>   
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            var Minutes = 60*1000;           
            setInterval(function(){
                $.ajax({
                    url: "<?=base_url()?>Maps/map_content", 
                    success: function(result){
                        $("#markermap").html(result);
                    }
                }); 
            }, 5*Minutes);                                      
            console.log(refreshed_content);                                      
            return false; 
        });
    </script>

    <script>    
        // Daterange picker         
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                "timePicker": true,
                "timePicker24Hour": true,
                "applyLabel": "Pilih",
                "cancelLabel": "Batal",
                locale: {
                    format: 'YYYY/MM/DD hh:mm'
                }
            });
        });   
    </script>

    <script>
            // Data Table
            $(document).ready(function() {
                $('#myTable').DataTable();
                $(document).ready(function() {
                    var table = $('#example').DataTable({
                        "columnDefs": [{
                            "visible": false,
                            "targets": 2
                        }],
                        "order": [
                            [2, 'asc']
                        ],
                        "displayLength": 25,
                        "drawCallback": function(settings) {
                            var api = this.api();
                            var rows = api.rows({
                                page: 'current'
                            }).nodes();
                            var last = null;
                            api.column(2, {
                                page: 'current'
                            }).data().each(function(group, i) {
                                if (last !== group) {
                                    $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                    last = group;
                                }
                            });
                        }
                    });
                    // Order by the grouping
                    $('#example tbody').on('click', 'tr.group', function() {
                        var currentOrder = table.order()[0];
                        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                            table.order([2, 'desc']).draw();
                        } else {
                            table.order([2, 'asc']).draw();
                        }
                    });
                });
            });
            $('#example23').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        </script>
    <script>
        <?php if($live_track == "Live") { ?> 
        map = new GMaps({
            el: '#markermap',
            lat: -7.169972,
            lng: 112.648172
            
        }); 
        <?php
            foreach ($information as $row){          
        ?>
            map.addMarker({
                lat: <?=$row->lat?>,
                lng: <?=$row->lon?>,
                title: 'Marker with InfoWindow',
                infoWindow: {   
                  content: '<h5>Info</h5><p>No Plat : <?=$row->no_plat?></p><p>Waktu : <?=date('h:i',strtotime($row->waktu_update))?></p>'
                }
            });
        <?php }}else{?>
            var start_lat = new Array();
             var end_lon = new Array();  
             var waypts = new Array(); 
             var no = new Array();
             var waktu = new Array();
             //var i = 0;          
             map_r = new GMaps({
                el: '#markermap',
                lat: -7.169972,
                lng: 112.648172
                
            });
           
           
            var myRoute = new google.maps.Polygon({
              paths: waypts,
              strokeColor: '#000000',
              strokeOpacity: 0.2,
              strokeWeight: 5,
              fillColor: '#000000',
              fillOpacity: 0.1
            });
            myRoute.setMap(map_r);
            /*map_r.drawRoute({
                origin: [<?=$start_lat?> , <?=$start_lon?>],
                destination: [<?=$end_lat?> , <?=$end_lon?>],             
                //waypoints: waypts,
                travelMode: 'driving',                
                optimizeWaypoints: true,
                strokeColor: '#131540',
                strokeOpacity: 0.6,
                strokeWeight: 6
            });*/
            
           


        <?php }?>
    </script>
    <style type="text/css">
    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10;
        background-color: #000;
    }
    </style>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>