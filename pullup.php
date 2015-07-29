 <!DOCTYPE HTML>
 <head>
	 <title>um, xxcalendar thing</title>
	 <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
   <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
   <script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
   <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
   <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
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
				<li class="weathertime">12:00   <img src ="images/clouds.png" height="42px" width="42px"></li>
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
