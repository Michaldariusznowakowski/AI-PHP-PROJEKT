<?php
$title = "MAPA";
$scriptSrc = "..resources/js/map.js";
?>
<?php echo $DATA; ?>
<h1><?= $title ?></h1>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script src=<?= $scriptSrc?>></script>
<div id="map" class="map" style="height: 400px; width: 400px"></div>

<?php echo $BUILDING_BUTTONS; ?>

<script>
    // init map and set starting view
    const map = L.map('map').setView([0, 0], 18);
    var popupTable = [];
    var markers = [];
    // get tiles from openstreetmap
    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // add markers to map
    <?php echo $MAP_MARKERS; ?>

    // on button click
    function ButtonOnClick(id)
    {
        switch(id)
        {  
            // populate switch with cases
            <?php echo $MAP_BUTTON_CASES; ?>
            default:
                console.log("WRONG BUILDING ID");
            break;
        }
    }    

    function onPolyClick(e)
    {
    
        var LocationsArray = [];
        var buildingCount = 0;
        var buildingNames = [];
        // poberanie informacji o tym gdzie kliknęliśmy na mapie
        var x = e.latlng.lat;
        var y = e.latlng.lng;
        
        //TEST NOT WITH MVC

        //wysyłanie informacji do map.php
        var request = new XMLHttpRequest();
        var url = "http://localhost/aiproject/resources/html/map.html.php"; // url
        var params = "Function=1&x=" + x+"&y="+y; // wartosci (FUN = id funkcji w API)

        request.open('POST', url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function() {
            if (request.readyState === XMLHttpRequest.DONE) 
            {
                if (request.status === 200) 
                {
                    //var response = JSON.parse(request.response);
                    console.log(request);
                   // markers[response.ID]._popup.setContent(response.content);
                }
                console.log(request.status);
            }
        }
        request.send(params);
        //TEST END
    }
    
    // we center on first element for now ( will add centering on geolocation later)
    // WIP
    ButtonOnClick(0);
    
</script>

        <form action="index.php" method="post">
            <input type="hidden" name="page" value="Mapa">
            <input type="hidden" name="Function" value="WI2">
        <input type="submit" value="Budynek 2"> 


