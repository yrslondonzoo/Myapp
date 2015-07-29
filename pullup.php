 <!DOCTYPE HTML>
 <head>
	 <title>um, xxcalendar thing</title>
	 <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
   <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
   <script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
   <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
   <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
   <?php

     $n = 1438441200; // 10d
     $n = 1438462800; // 02n
     $n = 1438527600; // 03d
     $n = 1438462899; // 02n 99 seconds off
     $n = 1438236000; // 10d
     $n = 1438238000; // 10d 2000 seconds off
   function parseweather($n){
     $url = 'http://api.openweathermap.org/data/2.5/forecast?lat=52.48&lon=-1.87';
     // For repetitive testing
     $url = 'C:/xampp/htdocs/Myapp/php/forecast.json';

     // http://www.ietf.org/rfc/rfc4627.txt
     // JSON text SHALL be encoded in Unicode.  The default encoding is UTF-8.
     // http://uk.php.net/manual/en/function.file-get-contents.php
     $page = file_get_contents($url, false, NULL, -1, 100000);

     preg_match_all('/"dt":(\d+),.*?"icon":"(\d+[dn])"/', $page, $matches);

     // print_r($matches);
     // var_dump($matches);

     $result = 'none';
     $first = 'none';

     // $matches[0] = all the parts that matched (not used)
     // $matches[1] = all the dt values in order
     // $matches[2] = all the icon values in the same order
     foreach ($matches[1] as $key => $value) {
       // within 1.5 hours
       if (abs($value - $n) < 90 * 60) {
         $result = $matches[2][$key];
       }
       if ($first == 'none') {
         $first = $matches[2][$key];
       }
     }
     if ($result == 'none') { return $first; }
     return $result;
   }

   $n = date_timestamp_get(date_create('2015-07-29T13:14:33'));
   $n = time();
   $icon = parseweather($n);
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
		<span id="date">1st</span>
		<span id="title">Brad's Great Meetup</span>
		<span id="location">London Zoo</span>
	</div>
	<div id = "weather">
		<div id="weatherinfo">
			weather
		</div>
		<div id="weatherdata">
			<ul>
				<li class="weathertime"><!--12:00   <img src ="images/clouds.png" height="42px" width="42px">-->The weather at <?php echo date('r', $n) ?> will be [<?php if ($icon == 'none') {
          echo "No forecast";
        }
        else {
           echo $icon;
        }
        ?>]!!</li>
				<li class="weathertime">15:00   <img src="images/Lightning.png" height ="42px" width="42px"></li>
			</ul>
		</div>
	</div>
</section>
<section id = "sect2">
	<div id="maps">
    MAP
    <div id="map">
      <!--<iframe width='100%' height='250px' frameBorder='0' src='https://a.tiles.mapbox.com/v4/bigboy1271.d02976aa/attribution,zoompan,zoomwheel,geocoder,share.html?access_token=pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ'></iframe>
    --></div>
	</div>
	<div id = "share">
		<div style="width:400px, height:250px" class="fb-like" data-href="https://www.facebook.com/pages/Cweather-Ultd/400981636759682" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	</div>
</section>
</main>
<script>
L.mapbox.accessToken = 'pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ';
// Replace 'mapbox.streets' with your map id.
var mapboxTiles = L.tileLayer('https://api.mapbox.com/v4/bigboy1271.n174gho3/{z}/{x}/{y}.png?access_token=' + L.mapbox.accessToken, {
    attribution: '<a href="http://www.mapbox.com/about/maps/" target="_blank">Terms &amp; Feedback</a>'
});

var map = L.map('map')
    .addLayer(mapboxTiles)
    .locate({setView: true})
</script>
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
