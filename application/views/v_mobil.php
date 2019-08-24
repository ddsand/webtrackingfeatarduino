<html>
    <head>
        <title>Belajaphp.net - Codeigniter Datatable</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h3>DATA KARYAWAN</h3>
            <table id="table" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr><th>No Mesin</th><th>No Plat</th><th>Tipe Mobil</th><th>Tahun Keluaran</th><th>Jenis BBM</th></tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript">
 
            var save_method; //for save method string
            var table;
 
            $(document).ready(function() {
                //datatables
                table = $('#table').DataTable({ 
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": '<?php echo site_url('mobil/json'); ?>',
                        "type": "GET"
                    },
                    //Set column definition initialisation properties.
                    "columns": [
                        {"data": "no_mesin",width:170},
                        {"data": "no_plat",width:100},
                        {"data": "tipe_mobil",width:100},
                        {"data": "tahun_keluaran",width:100},
                        {"data": "jenis_bbm",width:100}
                    ],
 
                });
 
            });
        </script>
 
    </body>
</html>