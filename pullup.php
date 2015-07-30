 <!DOCTYPE HTML>
 <head>
	 <title>um, xxcalendar thing</title>
   <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
   <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
   <link rel="stylesheet" href="leaflet-routing-machine.css" />
   <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
   <link rel="stylesheet" href="leaflet-routing-machine.css" />
   <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
   <script src="leaflet-routing-machine.js"></script>
   <?php
   if (isset($_GET["d"]) && is_numeric($_GET["d"])) {
     $evdate = $_GET["d"];
   }
   if (isset($_GET["evname"])) {
     $evname = $_GET["evname"];
   }
   if (isset($_GET["evloc"])) {
     $evloc = $_GET["evloc"];
   }
   if (isset($_GET["evstart"])) {
     $evstart = $_GET["evstart"];
   }
   if (isset($_GET["evend"])) {
     $evend = $_GET["evend"];
   }
   if (isset($_GET["evlat"])) {
     $evlat = $_GET["evlat"];
   }
   if (isset($_GET["evlong"])) {
     $evlong = $_GET["evlong"];
   }

     $n = 1438441200; // 10d
     $n = 1438462800; // 02n
     $n = 1438527600; // 03d
     $n = 1438462899; // 02n 99 seconds off
     $n = 1438236000; // 10d
     $n = 1438238000; // 10d 2000 seconds off
     // START OF FUNCTION
   function parseweather($n){
     global $iconday;
     $url = 'http://api.openweathermap.org/data/2.5/forecast?lat=52.48&lon=-1.87';
     // For repetitive testing
     $url = 'C:/xampp/htdocs/Myapp/php/forecast.json';
     // PLEASE MIND THE GAP
     // http://www.ietf.org/rfc/rfc4627.txt
     // JSON text SHALL be encoded in Unicode.  The default encoding is UTF-8.
     // http://uk.php.net/manual/en/function.file-get-contents.php
     $page = file_get_contents($url, false, NULL, -1, 100000);

     preg_match_all('/"dt":(\d+),.*?"description":"([^"]+?)".*?"icon":"(\d+[dn])"/', $page, $matches);

     // print_r($matches);
     // var_dump($matches);

     $result = 'none';
     $first = 'none';

     // $matches[0] = all the parts that matched (not used)
     // $matches[1] = all the dt values in order
     // $matches[2] = all the description values in the same order
     // $matches[3] = all the icon values in the same order
     foreach ($matches[1] as $key => $value) {
       // within 1.5 hours
       if (abs($value - $n) < 90 * 60) {
         $result = $matches[2][$key];
         $iconday = $matches[3][$key];
       }
       if ($first == 'none') {
         $first = $matches[2][$key];
         $iconday = $matches[3][$key];
       }
     }
     if ($result == 'none') { return $first; }
     return $result;
   }

   // END OF FUCTION

   $n = date_timestamp_get(date_create('2015-08-'.$evdate.'T'.$evstart));
   $icon = parseweather($n);
   $filename = str_replace(' ', '', $icon) . '' . 'png';

   if (substr_count($iconday, 'd')== 1) {
     $day = 'd';
   }
   else {
   $day = 'n';
   }
   $nend = date_timestamp_get(date_create('2015-08-'.$evdate.'T'.$evend));
   $iconend = parseweather($nend);
   if (substr_count($iconday, 'd')== 1) {
     $dayend = 'd';
   }
   else {
   $dayend = 'n';
   }
   ?>
</head>
<body>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<main>
<section id = "sect1">
	<div id = "info">
    <div id='backdiv'><a id='backlink' href='index.php'>Back<br> to<br> Calendar</a></div>
		<span id="date">On the:<br><?php echo date('d F', $n); ?></span>
		<span id="title">You have:<br><?php echo $evname ; ?></span>
		<span id="location">At:<br> <?php echo $evloc ; ?></span>
	</div>
	<div id = "weather">
		<div id="weatherinfo">
			weather
		</div>
		<div id="weatherdata">
			<ul>
				<li class="weathertime"><!--12:00   <img src ="images/clouds.png" height="42px" width="42px">--><?php echo date('H:i', $n) ?>: <?php if ($icon == 'none') {
          echo "No forecast";
        }
        else {
           echo $icon;
           $filename = str_replace(' ', '', $icon) . $day . '.png';
           // echo ' ' . $filename;
           echo '<img src="images/'.$filename.'" height="42" width="42">';
        }
        ?></li>
				<li class="weathertime"><?php echo date('H:i', $nend) ?>: <?php if ($icon == 'none') {
          echo "No forecast";
        }
        else {
           echo $iconend;
           $filename = str_replace(' ', '', $iconend) . $day . '.png';
           // echo ' ' . $filename;
           echo '<img src="images/'.$filename.'" height="42" width="42">';
        }
        ?></li>
			</ul>
		</div>
	</div>
</section>
<section>
  <div id = "share">
		<div class="fb-like" data-href="https://www.facebook.com/pages/Cweather-Ultd/400981636759682" data-width="225" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	</div>
</section>
<section id = "sect2">
	<div id="maps">
    MAP
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script src="leaflet-routing-machine.js"></script>
    <div id="map" class="map"><script>
  var map = L.map('map');

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.Routing.control({
    waypoints: [
        L.latLng(<?php echo $evlat; ?>, <?php echo $evlong ?>),
        L.latLng(52.478779,-1.910645)
    ],
    routeWhileDragging: true
}).addTo(map);
</script>

    </script></div>
    <div id="Routing"></div>
	</div>
</section>
</main>
<!--<script>
  var map = L.map('map').setView([51.505, -0.09], 13);
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ}', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'bigboy1271.d02976aa',
    accessToken: 'pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ'
}).addTo(map);
</script>-->
</body>
