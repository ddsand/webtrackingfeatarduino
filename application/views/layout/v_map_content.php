<script type="text/javascript">
    var con = {
        url: "<?= base_url()?>/assets/car.svg", // url
        scaledSize: new google.maps.Size(30, 30), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(15, 15) // anchor
    };
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
        icon:con,
        title: 'Marker with InfoWindow',
        infoWindow: {   
          content: '<h5>Info</h5><p>No Plat : <?=$row->no_plat?></p><p>Waktu : <?=date('h:i',strtotime($row->waktu_update))?></p>'
        }
    });
    <?php } ?>         
</script>