<h1>Mapa</h1>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script src=<?= $scriptSrc?>></script>
<div id="map" class="map col-12" style="height: 400px;"></div>
<?php echo $BUILDING_BUTTONS; ?>

<script>
    var BuildingsLoc = <?php echo $BUILDINGS_LOCATIONS; ?>;
    var BuildingsData =<?php echo $BUILDINGS_DATA; ?>;

    // init map and set starting view
    const map = L.map('map').setView([0, 0], 17);
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
        // poberanie informacji o tym gdzie kliknęliśmy na mapie
        var x = e.latlng.lat;
        var y = e.latlng.lng;
        var precision = 0.0000000001;

        for(let i = 0; i < BuildingsLoc.length; ++i)
        {
            if ( (Math.abs(BuildingsLoc[i][0] - x) <= precision) && (Math.abs(BuildingsLoc[i][1] - y) <= precision) )
            {
                let name = BuildingsData[i][0];
                let adress = BuildingsData[i][2];
                let number = BuildingsData[i][1];

                var content =`
                    <form action="index.php" method="post"> 
                    <input type="hidden" name="page" value="Plan">
                    <input type="hidden" name="numerBudynku" value="${number}">
                    ${name}
                    <p>${adress}</p>
                    <button>Plan</button>
                    </form>
                `
                markers[i]._popup.setContent(content);
            }
        }
    }
    
    //TODO
    //ADD Current Location Centering

    // we center on first element for now ( will add centering on geolocation later)
    ButtonOnClick(0);
    
</script>
